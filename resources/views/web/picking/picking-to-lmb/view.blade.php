@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>View Detail Picking to LMB</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('picking-to-lmb') }}">Picking To LMB</a></li>
                    <li class="breadcrumb-item active">View Detail Picking to LMB</li>
                </ol>
            </div>
        </div>
    @endcomponent

    <div class="col s12">
        <div class="container">

            <div class="section">

              <div class="card">
                <div class="card-content p-0">
                  <ul class="collapsible m-0">
                    <li class="active">
                      <div class="collapsible-header"><i class="material-icons">keyboard_arrow_right</i>Detail</div>
                      <div class="collapsible-body padding-1">
                        <h4 class="card-title">Header</h4>
                        <table class="form-table mb-1">
                          <tr>
                            <td width="100px">LMB Date</td>
                            <td width="35%">{{$lmbHeader->lmb_date}}</td>
                            <td width="100px">Expedisi</td>
                            <td>{{$lmbHeader->expedition_name}}</td>
                          </tr>
                          <tr>
                            <td>Picking No</td>
                            <td>{{$lmbHeader->picking->picking_no}}</td>
                            <td>Vehicle No</td>
                            <td>
                              <div id="vehicle_number-wrapper">
                                <span id="text-vehicle_number">{{$lmbHeader->vehicle_number}}</span>
                                {!! get_button_edit('#', 'Edit', 'btn-edit-vehicle-no') !!}
                              </div>
                              <div id="edit-vehicle_number-wrapper" class="hide">
                                <div class="input-field col s4">
                                  <input 
                                      type="text" 
                                      class="validate" 
                                      id="new_vehicle_number" 
                                      value="{{$lmbHeader->vehicle_number}} " 
                                      maxlength="11" 
                                      required
                                      />
                                </div>
                                <span class="waves-effect waves-light indigo btn-small btn-save-edit-vehicle-number">Save</span>
                                <span class="waves-effect waves-light indigo btn-small btn-cancel-edit-vehicle-number">Cancel</span>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>Ship to City</td>
                            <td>{{$lmbHeader->picking->city_name}}</td>
                            <td></td>
                            <td></td>
                          </tr>
                        </table>
                        {!! get_button_save('Send Manifest', 'btn-send-manifest ' . ($lmbHeader->send_manifest ? 'hide' : '')) !!}
                        {!! get_button_save('Print', 'btn-print-manifest ') !!}
                        {!! get_button_cancel(url('picking-to-lmb'), 'Back', '') !!}

                        <hr>

                        <div class="row mt-2">
                          <div class="col s12 m6">
                          </div>
                          <div class="col s12 m6">
                          <!---- Search ----->
                          <div class="app-wrapper">
                            <div class="datatable-search">
                              <i class="material-icons mr-2 search-icon">search</i>
                              <input type="text" placeholder="Search" class="app-filter" id="serial_number_filter">
                            </div>
                        </div>
                        </div>
                      </div>
                        
                        <div class="section-data-tables"> 
                          <table id="serial-number-table" class="display" width="100%">
                              <thead>
                                  <tr>
                                    <th data-priority="2" width="30px">No.</th>
                                    <th>SERIAL NUMBER</th>
                                    <th>DELIVERY NO</th>
                                    <th>MODEL</th>
                                    <th>EAN CODE</th>
                                    @if(!$lmbHeader->send_manifest)
                                    <th width="5px"></th>
                                    @endif
                                  </tr>
                              </thead>
                              <tbody>
                               {{--  @foreach($lmbHeader->details as $key => $lmbDetail)
                                  <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$lmbDetail->serial_number}}</td>
                                    <td>{{$lmbDetail->delivery_no}}</td>
                                    <td>{{$lmbDetail->model}}</td>
                                    <td>{{$lmbDetail->ean_code}}</td>
                                  </tr>
                                @endforeach --}}
                              </tbody>
                          </table>
                        </div>
                        <!-- datatable ends -->
                      </div>

                    </li>
                  </ul>
                </div>
                <div class="content-overlay"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection

@push('page-modal')
<div id="modal-update-serial-number" class="modal" style="">
    <form id="form-update-serial-number" class="form-table">
        <div class="modal-content">
            <table>
                <tr>
                    <td>Serial Number</td>
                    <td>
                        <input type="hidden" name="serial_number" required>
                        <input type="text" name="new_serial_number" required>
                    </td>
                </tr>
                <tr>
                    <td>Delivery No</td>
                    <td>
                        <input type="hidden" name="delivery_no" required>
                        <select id="select-new_delivery_no"
                              name="new_delivery_no"
                              class="select2-data-ajax browser-default">
                        </select>
                        <input type="hidden" name="delivery_items">
                        <input type="hidden" name="invoice_no">
                        <input type="hidden" name="kode_customer">
                        <input type="hidden" name="code_sales">
                    </td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="submit" class="waves-effect waves-light indigo btn-small btn-save">Update</button>
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Close</a>
        </div>
    </form>
</div>
@endpush

@push('page-modal')
<!-- Modal Structure -->
<div id="modal-send-manifest" class="modal">
  <form id="form-send-manifest">
  <div class="modal-content">
    @include('web.picking.picking-to-lmb._modal_send_manifest')
  </div>
  </form>
</div>
@endpush

{{-- Load Modal Print --}}
@include('layouts.materialize.components.modal-print', [
  'title' => 'Print Picking to LMB',
  'url' => 'picking-to-lmb/' . (!empty($lmbHeader) ? $lmbHeader->driver_register_id : '') . '/export',
  'trigger' => '.btn-print-manifest'
  ])

@push('vendor_js')
<script src="{{ asset('materialize/vendors/jquery-validation/jquery.validate.min.js') }}">
</script>
@endpush

@push('script_js')
<script type="text/javascript">
   $('.btn-send-manifest').click(function(event) {
     /* Act on the event */
      $.ajax({
        url: '{{ url("picking-to-lmb/" . $lmbHeader->driver_register_id) }}',
        type: 'GET',
      })
      .done(function(result) { // selesai dan berhasil

        $('#modal-send-manifest').modal('open')
      })
      .fail(function(xhr) {
          showSwalError(xhr) // Custom function to show error with sweetAlert
      });
   });

   @if($lmbHeader->send_manifest || $lmbHeader->destination_number == 'AS')
   $('.btn-edit-vehicle-no').addClass('hide');
   @endif

   $('#form-send-manifest').validate({
    submitHandler: function(form) {
      swal({
          title: "Are you sure to loading Quantity?",
          icon: 'warning',
          buttons: {
            cancel: true,
            ok: 'OK'
          }
        }).then(function (confirm) { // proses confirm
          if (confirm) {
            setLoading(true); // Disable Button when ajax post data
            $.ajax({
                url: '{{ url("picking-to-lmb/" . $lmbHeader->driver_register_id . "/send-manifest") }}',
                type: 'POST',
                data: $(form).serialize()
              })
              .done(function(result) { // selesai dan berhasil
                setLoading(false); // Enable Button when failed
                showSwalAutoClose('Success', result.message)
                $('.btn-send-manifest').hide();
                $('.btn-print-manifest').removeClass('hide');
                $('#modal-send-manifest').modal('close')
                $('.btn-edit-vehicle-no').addClass('hide');
              })
              .fail(function(xhr) {
                setLoading(false); // Enable Button when failed
                  showSwalError(xhr) // Custom function to show error with sweetAlert
              });
          }
        })
    }
   })

   var dttable_lmb_detail;
   jQuery(document).ready(function($) {
    dttable_lmb_detail = $('#serial-number-table').DataTable({
        serverSide: true,
        scrollX: true,
        responsive: true,
        ajax: {
            url: '{{ url('picking-to-lmb/' . $lmbHeader->driver_register_id  . '/details-lmb') }}',
            type: 'GET',
            data: function(d) {
              d.search['value'] = $('#serial_number_filter').val()
            }
        },
        order: [3, 'asc'],
        "pageLength": 10,
        columns: [
            {data: 'DT_RowIndex', orderable:false, searchable: false, className: 'center-align'},
            {data: 'serial_number', name: 'serial_number', className: 'detail'},
            {data: 'delivery_no', name: 'delivery_no', className: 'detail'},
            {data: 'model', name: 'model', className: 'detail'},
            {data: 'ean_code', name: 'ean_code', className: 'detail'},
            @if(!$lmbHeader->send_manifest)
            {data: 'serial_number', render: function(data, type, row){
              return '{!! get_button_edit("#!") !!}'
            }}
            @endif
        ],
      });

    $("input#serial_number_filter").on("keyup click", function () {
      filterSerialNumber();
    });

    dttable_lmb_detail.on('click', '.btn-edit', function(){
      var tr = $(this).parent().parent();
       var data = dttable_lmb_detail.row(tr).data();
       $('#modal-update-serial-number').modal('open');

       $('#form-update-serial-number [name="serial_number"]').val(data.serial_number);
       $('#form-update-serial-number [name="new_serial_number"]').val(data.serial_number);
       $('#form-update-serial-number [name="delivery_no"]').val(data.delivery_no);

        $('#form-update-serial-number [name="new_delivery_no"]').empty();
       $('#form-update-serial-number [name="new_delivery_no"]').select2({
        placeholder: '-- Select Delivery No --',
        ajax: get_select2_ajax_options('{{url("picking-to-lmb/select-delivery-no")}}', {
          picking_id: data.picking_id,
          delivery_no: data.delivery_no,
          ean_code: data.ean_code
        })
      })
       set_select2_value('#form-update-serial-number [name="new_delivery_no"]', data.delivery_no, data.delivery_no)

       $('#form-update-serial-number [name="delivery_items"]').val(data.delivery_items);
       $('#form-update-serial-number [name="invoice_no"]').val(data.invoice_no);
       $('#form-update-serial-number [name="kode_customer"]').val(data.kode_customer);
       $('#form-update-serial-number [name="code_sales"]').val(data.code_sales);
    })

    $('#form-update-serial-number [name="new_delivery_no"]').change(function(){
      var data = $('#form-update-serial-number [name="new_delivery_no"]').select2('data')[0];
      console.log(data)
      $('#form-update-serial-number [name="delivery_items"]').val(data.delivery_items);
      $('#form-update-serial-number [name="invoice_no"]').val(data.invoice_no);
      $('#form-update-serial-number [name="kode_customer"]').val(data.kode_customer);
      $('#form-update-serial-number [name="code_sales"]').val(data.code_sales);
    })

    $('#form-update-serial-number').validate({
      submitHandler: function (form) {
        setLoading(true);
        $.ajax({
         url: '{{url("picking-to-lmb/edit-serial-number")}}',
         type: 'PUT',
         dataType: 'json',
         data: $(form).serialize() 
          + '&delivery_items=' + $('#form-update-serial-number [name="delivery_items"]').val()
          + '&invoice_no=' + $('#form-update-serial-number [name="invoice_no"]').val()
          + '&kode_customer=' + $('#form-update-serial-number [name="kode_customer"]').val()
          + '&code_sales=' + $('#form-update-serial-number [name="code_sales"]').val()
       })
       .done(function(result) {
         setLoading(false);
        if (!result.status) {
          showSwalAutoClose('Warning', result.message)
          return;
        }
        showSwalAutoClose("Success", result.message);
        $('#modal-update-serial-number').modal('close');
        dttable_lmb_detail.ajax.reload(null, false);
       })
       .fail(function(result) {
        showSwalAutoClose('Warning', result.message)
        setLoading(false);
       })
      }
    })
     $('.btn-edit-vehicle-no').click(function(event) {
       /* Act on the event */
       $('#edit-vehicle_number-wrapper').removeClass('hide')
       $('#vehicle_number-wrapper').addClass('hide')
     });
     $('.btn-cancel-edit-vehicle-number').click(function(event) {
       /* Act on the event */
       $('#new_vehicle_number').val($('#text-vehicle_number').text());
       $('#edit-vehicle_number-wrapper').addClass('hide')
       $('#vehicle_number-wrapper').removeClass('hide')
     });
     $('.btn-save-edit-vehicle-number').click(function(event) {
       /* Act on the event */
       var new_vehicle_number = $('#new_vehicle_number').val();
       if (new_vehicle_number == '') {
        alert('Please input vehicle no');
        return;
       }
       $.ajax({
         url: '{{url('picking-to-lmb/' . $lmbHeader->driver_register_id . '/update-vehicle-number')}}',
         type: 'PUT',
         dataType: 'json',
         data: {vehicle_number: new_vehicle_number},
       })
       .done(function(result) {
        if (result.status) {
          $('#text-vehicle_number').text(new_vehicle_number)
          $('#edit-vehicle_number-wrapper').addClass('hide')
           $('#vehicle_number-wrapper').removeClass('hide')
          showSwalAutoClose('Success', result.message)
        }
       })
       .fail(function() {
         console.log("error");
       })
       .always(function() {
         console.log("complete");
       });
       
     });
   });

   function filterSerialNumber() {
      dttable_lmb_detail.search($("#serial_number_filter").val(), $("#global_regex").prop("checked"), $("#global_smart").prop("checked")).draw();
    }
</script>
@endpush
