@extends('layouts.materialize.index')
{{-- @include('admin.materi.modal_form_materi') --}}

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m4 l4">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Concept or DO Outstanding List</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Concept or DO Outstanding List</li>
                </ol>
            </div>
           
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content p-0">
                        <form id="form-report-outstanding-list" class="form-table" onsubmit="return false;">
                          <input type="hidden" name="type">
                            <table>
                              <tr style="background-color: darkgray">
                                <td>Area</td>
                                <td>
                                  <div class="input-field col s12">
                                    <select name="area" class="select2-data-ajax browser-default">
                                    </select>
                                  </div>
                                </td>
                              </tr>
                              <tr style="background-color: darkgray">
                                <td>OR</td>
                                <td></td>
                              </tr>
                              <tr style="background-color: darkgray">
                                <td>Branch</td>
                                <td>
                                  <div class="input-field col s12">
                                    <select name="cabang" class="select2-data-ajax browser-default">
                                    </select>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td>Shipment No</td>
                                <td><div class="input-field col s12">
                                  <input id="model" type="text" class="validate" name="invoice_no">
                                </div></td>
                              </tr>
                              <tr>
                                <td>Do NO</td>
                                <td><div class="input-field col s12">
                                  <input id="aqty" type="text" class="validate " name="delivery_no">
                                </div></td>
                              </tr>
                              <tr class="area-wrapper">
                                <td>Expedition</td>
                                <td>
                                  <div class="input-field col s12">
                                    <select name="expedition" class="select2-data-ajax browser-default">
                                    </select>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td>Upload Concept Date</td>
                                <td>
                                  <div class="input-field col s6">
                                    <div class="col s3 m2 label">
                                      From
                                    </div>
                                    <div class="col s9 m10">
                                      <input placeholder="" id="first_name" type="text" class="validate datepicker" readonly>
                                    </div>
                                  </div>
                                  <div class="input-field col s6">
                                    <div class="col s3 m2 label">
                                      To
                                    </div>
                                    <div class="col s9 m10">
                                      <input placeholder="" id="first_name" type="text" class="validate datepicker" readonly>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                              <tr class="area-wrapper">
                                <td>Vahicle Type</td>
                                <td><div class="input-field col s12">
                                  <select name="vehicle_type" class="select2-data-ajax browser-default">
                                    </select>
                                </div></td>
                              </tr>
                            </table>
                            <div class="input-field col s12">
                              <button type="submit" class="waves-effect waves-light indigo btn mt-1 mb-1 ml-1">Submit</button>
                            </div>
                          </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-overlay"></div>
    </div>

    <div class="col s12 outstanding-list-area-wrapper hide">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content p-0">
                        <div class="section-data-tables">
                            <table class="display" id="data-concept-or-do-outstanding-list-area" width="100%">
                                <thead>
                                    <tr>
                                        <th>SHIPMENT NO</th>
                                        <th>LINE NO</th>
                                        <th>OUTPUT DATE</th>
                                        <th>OUTPUT TIME</th>
                                        <th>DESTINATION NAME</th>
                                        <th>VEHICLE CODE TYPE</th>
                                        <th>EXPEDITION NAME</th>
                                        <th>CAR NO</th>
                                        <th>CONT NO</th>
                                        <th>CHECKIN DATE</th>
                                        <th>CHECKIN TIME</th>
                                        <th>DELIVERY NO</th>
                                        <th>DELIVERY ITEMS</th>
                                        <th>MODEL</th>
                                        <th>QUANTITY</th>
                                        <th>CBM</th>
                                        <th>SHIP TO</th>
                                        <th>SOLD TO</th>
                                        <th>SHIP TO CITY</th>
                                        <th>SHIP TO DISTRICT</th>
                                        <th>SOLD TO CITY</th>
                                        <th>SOLD TO DISTRICT</th>
                                        <th>SOLD TO STREET</th>
                                        <th>REMARKS</th>
                                        <th>AREA</th>
                                        <th>UPLOAD DATE</th>
                                        <th>UPLOAD BY</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <!-- datatable ends -->
                    </div>
                </div>
            </div>
        </div>
        <div class="content-overlay">
        </div>
    </div>

    <div class="col s12 outstanding-list-branch-wrapper hide">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content p-0">
                        <div class="section-data-tables">
                            <table class="display" id="data-concept-or-do-outstanding-list-branch" width="100%">
                                <thead>
                                    <tr>
                                        <th>INVOICE NO</th>
                                        <th>DELIVERY NO</th>
                                        <th>DELIVERY ITEMS</th>
                                        <th>DO DATE</th>
                                        <th>KODE CUSTOMER</th>
                                        <th>LONG DESCRIPTION CUSTOMER</th>
                                        <th>MODEL</th>
                                        <th>EAN CODE</th>
                                        <th>QUANTITY</th>
                                        <th>CBM</th>
                                        <th>CREATED DATE</th>
                                        <th>CREATED BY</th>
                                        <th>CODE SALES</th>
                                        <th>AREA</th>
                                        <th>KODE CABANG</th>
                                        <th>SPLIT DATE</th>
                                        <th>SPLIT BY</th>
                                        <th>REMARKS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <!-- datatable ends -->
                    </div>
                </div>
            </div>
        </div>
        <div class="content-overlay">
        </div>
    </div>

</div>
@endsection

@push('vendor_js')
<script src="{{ asset('materialize/vendors/jquery-validation/jquery.validate.min.js') }}">
</script>
@endpush


@push('script_js')
<script type="text/javascript">
  var dttable_outstanding_list_area;
  var dttable_outstanding_list_branch;
  jQuery(document).ready(function($) {
    dttable_outstanding_list_area = $('#data-concept-or-do-outstanding-list-area').DataTable({
      serverSide: true,
      scrollX: true,
      dom: 'Brtip',
      scrollY: '60vh',
      buttons: [
        {
          text: 'PDF',
          action: function ( e, dt, node, config ) {
              window.location.href = "{{url('concept-or-do-outstanding-list/export?file_type=pdf')}}" + '&' + $('#form-report-outstanding-list').serialize();
          }
        },
         {
          text: 'EXCEL',
          action: function ( e, dt, node, config ) {
              window.location.href = "{{url('concept-or-do-outstanding-list/export?file_type=xls')}}" + '&' + $('#form-report-outstanding-list').serialize();
          }
        }
      ],
      ajax: {
          url: '{{ url('concept-or-do-outstanding-list') }}',
          type: 'GET',
          data: function(d) {
            d.type = $('#form-report-outstanding-list [name="type"]').val()
            d.area = $('#form-report-outstanding-list [name="area"]').val()
            d.branch = $('#form-report-outstanding-list [name="branch"]').val()
          }
      },
      columns: [
          {data: 'invoice_no'},
          {data: 'line_no'},
          {data: 'output_date'},
          {data: 'output_time'},
          {data: 'destination_name'},
          {data: 'vehicle_code_type'},
          {data: 'expedition_name'},
          {data: 'car_no'},
          {data: 'cont_no'},
          {data: 'checkin_date'},
          {data: 'checkin_time'},
          {data: 'delivery_no'},
          {data: 'delivery_items'},
          {data: 'model'},
          {data: 'quantity'},
          {data: 'cbm'},
          {data: 'ship_to'},
          {data: 'sold_to'},
          {data: 'ship_to_city'},
          {data: 'ship_to_district'},
          {data: 'sold_to_city'},
          {data: 'sold_to_district'},
          {data: 'sold_to_street'},
          {data: 'remarks'},
          {data: 'area'},
          {data: 'created_at'},
          {data: 'upload_by', name: 'users.username'},
      ]
    });

    dttable_outstanding_list_branch = $('#data-concept-or-do-outstanding-list-branch').DataTable({
      serverSide: true,
      scrollX: true,
      dom: 'Brtip',
      scrollY: '60vh',
      buttons: [
        {
          text: 'PDF',
          action: function ( e, dt, node, config ) {
              window.location.href = "{{url('concept-or-do-outstanding-list/export?file_type=pdf')}}" + '&branch=' + $('#branch_filter').val();
          }
        },
         {
          text: 'EXCEL',
          action: function ( e, dt, node, config ) {
              window.location.href = "{{url('concept-or-do-outstanding-list/export?file_type=xls')}}" + '&branch=' + $('#branch_filter').val();
          }
        }
      ],
      ajax: {
          url: '{{ url('concept-or-do-outstanding-list') }}',
          type: 'GET',
          data: function(d) {
            d.type = 'branch'
            d.branch = $('#form-report-outstanding-list [name="cabang"]').val()
            d.branch = $('#form-report-outstanding-list [name="cabang"]').val()
          }
      },
      columns: [
          {data: 'invoice_no'},
          {data: 'delivery_no'},
          {data: 'delivery_items'},
          {data: 'do_date'},
          {data: 'kode_customer'},
          {data: 'long_description_customer'},
          {data: 'model'},
          {data: 'ean_code'},
          {data: 'quantity'},
          {data: 'cbm'},
          {data: 'created_at'},
          {data: 'created_by'},
          {data: 'code_sales'},
          {data: 'area'},
          {data: 'kode_cabang'},
          {data: 'split_date'},
          {data: 'split_by'},
          {data: 'remarks'},
      ]
    });

    $('#form-report-outstanding-list').validate({
      submitHandler: function (form){
        if ($('#form-report-outstanding-list [name="area"]').val() == null || $('#form-report-outstanding-list [name="area"]').val() == '') {
          $('.outstanding-list-area-wrapper').addClass('hide')
          $('.outstanding-list-branch-wrapper').removeClass('hide')
          dttable_outstanding_list_branch.ajax.reload(null, false)
        } else {
          $('.outstanding-list-area-wrapper').removeClass('hide')
          $('.outstanding-list-branch-wrapper').addClass('hide')
          dttable_outstanding_list_area.ajax.reload(null, false)
        }
      }
    })

    $('#form-report-outstanding-list [name="cabang"]').change(function(event) {
      /* Act on the event */
      if ($(this).val() != '') {
        init_form_branch();
      }
    });

    $('#form-report-outstanding-list [name="area"]').change(function(event) {
      /* Act on the event */
      if ($(this).val() != '') {
        init_form_area();
      }
    });
  });

  function init_form_branch(){
    $('.area-wrapper').addClass('hide')
    $('#form-report-outstanding-list [name="type"]').val('branch');
    set_select2_value('#form-report-outstanding-list [name="area"]', '', '');
    set_select2_value('#form-report-outstanding-list [name="expedition"]', '', '');
    set_select2_value('#form-report-outstanding-list [name="vehicle_type"]', '', '');
  }

  function init_form_area() {
    $('.area-wrapper').removeClass('hide')
    $('#form-report-outstanding-list [name="type"]').val('area');
    set_select2_value('#form-report-outstanding-list [name="cabang"]', '', '');

  }

  $('#form-report-outstanding-list [name="area"]').select2({
     placeholder: '-- Select Area --',
     allowClear: true,
     ajax: get_select2_ajax_options('/master-area/select2-area-only')
  });
  $('#form-report-outstanding-list [name="cabang"]').select2({
     placeholder: '-- Select Branch --',
     allowClear: true,
     ajax: get_select2_ajax_options('/master-cabang/select2-grant-cabang')
  });
  $('#form-report-outstanding-list [name="expedition"]').select2({
     placeholder: '-- All --',
     allowClear: true,
     ajax: get_select2_ajax_options('/master-expedition/select2-all-expedition')
  });
  $('#form-report-outstanding-list [name="vehicle_type"]').select2({
     placeholder: '-- All --',
     allowClear: true,
     ajax: get_select2_ajax_options('/master-vehicle/select2-vehicle')
  });
</script>
@endpush