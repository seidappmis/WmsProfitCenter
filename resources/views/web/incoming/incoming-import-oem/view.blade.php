@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Create Incoming Import/OEM</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('incoming-import-oem') }}">Incoming Import/OEM</a></li>
                    <li class="breadcrumb-item active">{{$incomingManualHeader->arrival_no}}</li>
                </ol>
            </div>
            <div class="col s12 m2"></div>
            <div class="col s12 m4">
              <div class="display-flex">
                <!---- Search ----->
                <div class="app-wrapper mr-2">
                  <div class="datatable-search">
                    <select id="area_filter" class="select2-data-ajax browser-default app-filter">
                    </select>
                  </div>
                </div>
                <!---- Button Back ----->
                <a class="btn btn-large waves-effect waves-light indigo" href="{{ url('incoming-import-oem') }}">Back</a>
              </div>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
      <div class="container">
        <div class="section">
          <div class="card">
            <div class="card-content">
              <h4 class="card-title">INPUT INCOMING IMPORT/OEM/OTHERS</h4>
              <hr>
              @include('web.incoming.incoming-import-oem._form_header')
            </div>
            <div class="card-content pt-0 pb-0" id="add-detail-wrapper">
                <ul class="collapsible" id="collapsible-detail">
                   <li class="">
                     <div class="collapsible-header">Add New Detail</div>
                     <div class="collapsible-body white pt-1">
                          @include('web.incoming.incoming-import-oem._form_detail')
                     </div>
                   </li>
                </ul>
                  <div class="content-overlay"></div>
            </div>
            <div class="card-content">
            <div class="section-data-tables">
              <!-- Incoming Detail -->
              <h4 class="card-title">Incoming Detail</h4>
              <hr>
              <form class="form-table">
                <table id="data-table-incoming-detail" class="display" width="100%">
                  <thead bgcolor="#344b68">
                    <tr>
                      <th data-priority="1" width="30px" class="white-text">NO.</th>
                      <th class="white-text">Model</th>
                      <th class="white-text">Quantity</th>
                      <th class="white-text">CBM</th>
                      <th class="white-text">Total CBM</th>
                      <th class="white-text">No. GR SAP</th>
                      <th class="white-text">Description</th>
                      <th class="white-text">Storage Location</th>

                      @if($incomingManualHeader->inc_type == "OTHERS")
                      <th class="white-text">Serial Number</th>
                      @endif

                      <th class="white-text">Created Date</th>
                      <th width="50px;"></th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </form>
            </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection

@push('script_js')
<script src="{{ asset('materialize/vendors/jquery-validation/jquery.validate.min.js') }}">
</script>
@endpush

@push('script_js')
<script type="text/javascript">
  var dttable_incoming_detail;
  jQuery(document).ready(function($) {
    @if(auth()->user()->cabang->hq)
      $('#area_filter').select2({
         placeholder: '-- Select Area --',
         allowClear: true,
         ajax: get_select2_ajax_options('/master-area/select2-area-only')
      });
      $('#area_filter').attr('disabled', 'disabled');
      set_select2_value('#area_filter', '{{$incomingManualHeader->area}}', '{{$incomingManualHeader->area}}')
      $("#form-incoming-import-oem-header [name='area']").val('{{$incomingManualHeader->area}}')
    @else
    $('.area-wrapper').hide()
    @endif
  });
  dttable_incoming_detail = $('#data-table-incoming-detail').DataTable({
    serverSide: true,
    scrollX: true,
    responsive: false,
    ajax: {
        url: '{{ url("incoming-import-oem", $incomingManualHeader->arrival_no) }}',
        type: 'GET',
        data: function(d) {
            d.search['value'] = $('#global_filter').val(),
            d.area = $('#area_filter').val()
          }
    },
    order: [1, 'asc'],
    columns: [
        {data: 'DT_RowIndex', orderable:false, searchable: false, className: 'center-align'},
        {data: 'model', name: 'model', className: 'detail'},
        {data: 'qty', name: 'qty', className: 'detail'},
        {data: 'cbm', name: 'cbm', className: 'detail'},
        {data: 'total_cbm', name: 'total_cbm', className: 'detail'},
        {data: 'no_gr_sap', name: 'no_gr_sap', className: 'detail'},
        {data: 'description', name: 'description', className: 'detail'},
        {data: 'storage_location', name: 'storage_location', className: 'detail'},
        @if($incomingManualHeader->inc_type == "OTHERS")
        {data: 'serial_numbers', name: 'serial_numbers', className: 'detail'},
        @endif
        {data: 'created_at', name: 'created_at', className: 'detail'},
        {data: 'action', className: 'center-align', searchable: false, orderable: false},
    ],
  });

  @if(!$incomingManualHeader->submit)
  dttable_incoming_detail.on('draw', function (data) {
      if(dttable_incoming_detail.page.info().recordsDisplay > 0){
        $('.btn-submit-to-inventory').removeClass('hide');
      } else {
        $('.btn-submit-to-inventory').addClass('hide');
      }
  });
  @endif

  dttable_incoming_detail.on('click', '.btn-edit', function(event) {
    var tr = $(this).parent().parent();
    var data = dttable_incoming_detail.row(tr).data();
    set_select2_value($('#form-incoming-import-oem-detail [name="storage_id"]'), data.storage_id, data.storage_location)
    set_select2_value($('#form-incoming-import-oem-detail [name="model_id"]'), data.model, data.model)
    $('#form-incoming-import-oem-detail [name="id"]').val(data.id);
    $('#form-incoming-import-oem-detail [name="model"]').val(data.model_name);
    $('#form-incoming-import-oem-detail [name="description"]').val(data.description);
    $('#form-incoming-import-oem-detail [name="cbm"]').val(data.cbm);
    $('#form-incoming-import-oem-detail [name="no_gr_sap"]').val(data.no_gr_sap);
    $('#form-incoming-import-oem-detail [name="qty"]').val(data.qty).trigger('change');
    $('#form-incoming-import-oem-detail [name="model"]').val(data.model);
    $('#collapsible-detail').collapsible('open');
  })

  dttable_incoming_detail.on('click', '.btn-delete', function(event) {
      event.preventDefault();
      /* Act on the event */
      // Ditanyain dulu usernya mau beneran delete data nya nggak.
      var tr = $(this).parent().parent();
      var data = dttable_incoming_detail.row(tr).data();
      swal({
        text: "Are you sure want to delete " + data.model + " and the details?",
        icon: 'warning',
        buttons: {
          cancel: true,
          delete: 'Yes, Delete It'
        }
      }).then(function (confirm) { // proses confirm
        if (confirm) {
          setLoading(true); // Disable Button when ajax post data
            $.ajax({
            url: '{{ url('incoming-import-oem', $incomingManualHeader->arrival_no) }}' + '/detail/' + data.id ,
            type: 'DELETE',
            dataType: 'json',
          })
          .done(function() {
            setLoading(false); // Enable Button when failed
            showSwalAutoClose('',  "Incoming detail has been deleted.")
            dttable_incoming_detail.ajax.reload(null, false);  // (null, false) => user paging is not reset on reload
          })
          .fail(function() {
            setLoading(false); // Enable Button when failed
            console.log("error");
          });
        }
      })
    });

  jQuery(document).ready(function($) {
      set_form_data();
      update_handler();
      add_detail_handler();
  });

  function set_form_data() {
    $('#form-incoming-import-oem-header .btn-save').html('Update')
    set_select2_value('#form-incoming-import-oem-header [name="vendor_name"]', '{{$incomingManualHeader->vendor_name}}', '{{$incomingManualHeader->vendor_name}}');
    $('input:radio[name="inc_type"]').filter('[value="{{$incomingManualHeader->inc_type}}"]').attr('checked', true);
    @if($incomingManualHeader->submit)
    $('input:radio[name="inc_type"]').prop('disabled', true);
    @endif
  }

  function update_handler(){
    // PUT request to update data header
    $("#form-incoming-import-oem-header").validate({
      submitHandler: function(form) {
        setLoading(true); // Disable Button when ajax post data
        $.ajax({
          url: '{{ url("incoming-import-oem", $incomingManualHeader->arrival_no) }}',
          type: 'PUT',
          data: $(form).serialize(),
        })
        .done(function(result) { // selesai dan berhasil
          setLoading(false); // Enable Button when failed
          showSwalAutoClose('Success', result.message)
          $('#form-incoming-import-oem-detail [name="no_gr_sap"]').val(result.no_gr_sap);
          dttable_incoming_detail.ajax.reload(null, false)
        })
        .fail(function(xhr) {
          setLoading(false); // Enable Button when failed
            showSwalError(xhr) // Custom function to show error with sweetAlert
        });
      }
    });
    // END PUT request
  }

  function add_detail_handler(){
    // POST request to store detail
    // data dikirim dalam form data 
    $("#form-incoming-import-oem-detail").validate({
      submitHandler: function(form) {
        setLoading(true); // Disable Button when ajax post data
        var fdata = new FormData(form);
        $.ajax({
          url: '{{ url("incoming-import-oem", $incomingManualHeader->arrival_no) . "/detail" }}',
          type: 'POST',
          data: fdata,
          contentType: "application/json",
          dataType: "json",
          contentType: false,
          processData: false
        })
        .done(function(data) { // selesai dan berhasil
          // console.log(data);
          setLoading(false); // Enable Button when failed
          
          if (data.status == false) {
            swal("Failed!", data.message, "warning");
            return;
          }
          showSwalAutoClose('', data.message)
          dttable_incoming_detail.ajax.reload(null, false);  // (null, false) => user paging is not reset on reload
          $("#form-incoming-import-oem-detail")[0].reset();
          $('#form-incoming-import-oem-detail [name="id"]').val('');
          set_select2_value('#form-incoming-import-oem-detail [name="model_id"]', '', '')
          set_select2_value('#form-incoming-import-oem-detail [name="storage_id"]', '', '')
        })
        .fail(function(xhr) {
            setLoading(false); // Enable Button when failed
            showSwalError(xhr) // Custom function to show error with sweetAlert
        });
      }
    });
  }

</script>
@endpush