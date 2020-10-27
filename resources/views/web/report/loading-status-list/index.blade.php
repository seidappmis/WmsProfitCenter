@extends('layouts.materialize.index')
{{-- @include('admin.materi.modal_form_materi') --}}

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m8 l8">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Loading Status List</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Loading Status List</li>
                </ol>
            </div>
            <div class="col s12 m4 l4">
                <!---- Search ----->
                
                <!-- end search -->
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content p-0">
                        <form class="form-table" id="form-loading-status-list">
                            <table>
                              <tr>
                                <td>Area</td>
                                <td>
                                  <div class="input-field col s12">
                                    <select name="area" class="select2-data-ajax browser-default">
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
                              <tr>
                                <td>Vahicle No.</td>
                                <td><div class="input-field col s12">
                                  <input id="aqty" type="text" class="validate " name="vehicle_number">
                                </div></td>
                              </tr>
                              <tr>
                                <td>Destination Concept</td>
                                <td>
                                  <div class="input-field col s6">
                                    <select name="destination_number" class="select2-data-ajax browser-default">
                                    </select>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td>Expedition</td>
                                <td>
                                  <div class="input-field col s6">
                                    <select name="expedition_code" class="select2-data-ajax browser-default">
                                    </select>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td>Vahicle Type</td>
                                <td>
                                  <div class="input-field col s6">
                                    <select name="vehicle_code_type" class="select2-data-ajax browser-default">
                                    </select>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td>Do Manifest No.</td>
                                <td><div class="input-field col s12">
                                  <input id="aqty" type="text" class="validate " name="do_manifest_no">
                                </div></td>
                              </tr> 
                              <tr>
                                <td>Upload Concept Date</td>
                                <td>
                                  <div class="input-field col s6">
                                    <div class="col s3 m2 label">
                                      From
                                    </div>
                                    <div class="col s9 m10">
                                      <input placeholder="" name="start_upload_concept_date" type="text" class="validate datepicker" readonly>
                                    </div>
                                  </div>
                                  <div class="input-field col s6">
                                    <div class="col s3 m2 label">
                                      To
                                    </div>
                                    <div class="col s9 m10">
                                      <input placeholder="" name="end_upload_concept_date" type="text" class="validate datepicker" readonly>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td>Register Driver Date</td>
                                <td>
                                  <div class="input-field col s6">
                                    <div class="col s3 m2 label">
                                      From
                                    </div>
                                    <div class="col s9 m10">
                                      <input placeholder="" name="start_register_driver_date" type="text" class="validate datepicker" readonly>
                                    </div>
                                  </div>
                                  <div class="input-field col s6">
                                    <div class="col s3 m2 label">
                                      To
                                    </div>
                                    <div class="col s9 m10">
                                      <input placeholder="" name="end_register_driver_date" type="text" class="validate datepicker" readonly>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td>Mapping Concept Date</td>
                                <td>
                                  <div class="input-field col s6">
                                    <div class="col s3 m2 label">
                                      From
                                    </div>
                                    <div class="col s9 m10">
                                      <input placeholder="" name="start_mapping_concept_date" type="text" class="validate datepicker" readonly>
                                    </div>
                                  </div>
                                  <div class="input-field col s6">
                                    <div class="col s3 m2 label">
                                      To
                                    </div>
                                    <div class="col s9 m10">
                                      <input placeholder="" name="end_mapping_concept_date" type="text" class="validate datepicker" readonly>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td>Loading Start Date</td>
                                <td>
                                  <div class="input-field col s6">
                                    <div class="col s3 m2 label">
                                      From
                                    </div>
                                    <div class="col s9 m10">
                                      <input placeholder="" name="start_loading_start_date" type="text" class="validate datepicker" readonly>
                                    </div>
                                  </div>
                                  <div class="input-field col s6">
                                    <div class="col s3 m2 label">
                                      To
                                    </div>
                                    <div class="col s9 m10">
                                      <input placeholder="" name="end_loading_start_date" type="text" class="validate datepicker" readonly>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td>Loading Finish Date</td>
                                <td>
                                  <div class="input-field col s6">
                                    <div class="col s3 m2 label">
                                      From
                                    </div>
                                    <div class="col s9 m10">
                                      <input placeholder="" name="start_loading_finish_date" type="text" class="validate datepicker" readonly>
                                    </div>
                                  </div>
                                  <div class="input-field col s6">
                                    <div class="col s3 m2 label">
                                      To
                                    </div>
                                    <div class="col s9 m10">
                                      <input placeholder="" name="end_loading_finish_date" type="text" class="validate datepicker" readonly>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td>Complete Date</td>
                                <td>
                                  <div class="input-field col s6">
                                    <div class="col s3 m2 label">
                                      From
                                    </div>
                                    <div class="col s9 m10">
                                      <input placeholder="" name="start_complete_date" type="text" class="validate datepicker" readonly>
                                    </div>
                                  </div>
                                  <div class="input-field col s6">
                                    <div class="col s3 m2 label">
                                      To
                                    </div>
                                    <div class="col s9 m10">
                                      <input placeholder="" name="end_complete_date" type="text" class="validate datepicker" readonly>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                              
                              <tr>
                                <td>Status</td>
                                <td>
                                  <div class="input-field col s4">
                                    <select name="status" id="">
                                      <option value="">-All Status-</option>
                                      <option value="Waiting Truck">Waiting Truck</option>
                                      <option value="Waiting Loading">Waiting Loading</option>
                                      <option value="Loading Process">Loading Process</option>
                                      <option value="Waiting D/O">Waiting D/O</option>
                                      <option value="Complete">Complete</option>
                                    </select>

                                  </div>
                                </td>
                              </tr>
                         
                            </table>
                            <div class="input-field col s12">
                              <button type="submit" class="waves-effect waves-light indigo btn">Submit</button>
                            </div>
                          </form>
                    </div>
                </div>
            </div>

            <div class="secion loading-status-list-wrapper hide">
              <div class="card">
                <div class="card-conten">
                  <div class="section-data-tables"> 
                      <table id="table_loading_status_list" class="display" width="100%">
                          <thead>
                              <tr>
                                <th>CONCEPT INVOICE NO</th>
                                <th>CONCEPT LINE NO</th>
                                <th>CONCEPT OUTPUT DATE</th>
                                <th>CONCEPT OUTPUT TIME</th>
                                <th>CONCEPT DESTINATION NAME</th>
                                <th>CONCEPT VEHICLE CODE TYPE</th>
                                <th>CONCEPT CAR NO</th>
                                <th>CONCEPT CONT NO</th>
                                <th>CONCEPT CHECKIN DATE</th>
                                <th>CONCEPT CHECKIN TIME</th>
                                <th>CONCEPT DELIVERY NO</th>
                                <th>CONCEPT DELIVERY ITEMS</th>
                                <th>CONCEPT MODEL</th>
                                <th>CONCEPT QUANTITY</th>
                                <th>CONCEPT CBM</th>
                                <th>CONCEPT SHIP TO</th>
                                <th>CONCEPT SOLD TO</th>
                                <th>CONCEPT SHIP TO CITY</th>
                                <th>CONCEPT SHIP TO STREET</th>
                                <th>CONCEPT SOLD TO CITY</th>
                                <th>CONCEPT SOLD TO DISTRICT</th>
                                <th>CONCEPT SOLD TO STREET</th>
                                <th>CONCEPT REMARKS</th>
                                <th>CONCEPT UPLOAD DATE</th>
                                <th>REG DRIVER ID</th>
                                <th>REG DRIVER NAME</th>
                                <th>REG VEHICLE NO</th>
                                <th>REG VEHICLE DESC</th>
                                <th>REG VEHICLE TYPE</th>
                                <th>REG CBM TRUCK</th>
                                <th>REG DATE IN</th>
                                <th>REG DATE OUT</th>
                                <th>REG DESTINATION</th>
                                <th>REG REGION</th>
                                <th>REG EXPEDITION CODE</th>
                                <th>REG EXPEDITION NAME</th>
                                <th>MAPPING CONCEPT DATE</th>
                                <th>SELECT GATE DATE</th>
                                <th>LOAD GATE NUMBER</th>
                                <th>LOAD LOADING START</th>
                                <th>LOAD LOADING END</th>
                                <th>LOAD LOADING MINUTES</th>
                                <th>LOAD LOAD DO MANIFEST NO</th>
                                <th>STATUS</th>
                                <th>SOLD TO CODE</th>
                                <th>SHIP TO CODE</th>
                                <th>AREA</th>
                              </tr>
                          </thead>
                          <tbody>
                          </tbody>
                      </table>
                    </div>
                </div>
              </div>
            </div>

        </div>
        <div class="content-overlay"></div>
    </div>
</div>
@endsection

@push('vendor_js')
<script src="{{ asset('materialize/vendors/jquery-validation/jquery.validate.min.js') }}">
</script>
@endpush

@push('script_js')
<script type="text/javascript">
  $('#form-loading-status-list [name="area"]').select2({
     placeholder: '-- Select Area --',
     allowClear: true,
     ajax: get_select2_ajax_options('/master-area/select2-area-only')
  });

  $('#form-loading-status-list [name="destination_number"]').select2({
    placeholder: '-- ALL --',
     allowClear: true,
    ajax: get_select2_ajax_options('/master-destination/select2-destination')
  });

  $('#form-loading-status-list [name="expedition_code"]').select2({
    placeholder: '-- ALL --',
    allowClear: true,
    ajax: get_select2_ajax_options('/master-expedition/select2-all-expedition')
  })

  $('#form-loading-status-list [name="vehicle_code_type"]').select2({
    placeholder: '-- ALL --',
    allowClear: true,
    ajax: get_select2_ajax_options('/master-vehicle/select2-vehicle')
  })

  var dttable_loading_status_list;
  jQuery(document).ready(function($) {
    dttable_loading_status_list = $('#table_loading_status_list').DataTable({
      serverSide: true,
      scrollX: true,
      dom: 'Brtip',
      scrollY: '60vh',
      buttons: [
        {
          text: 'PDF',
          action: function ( e, dt, node, config ) {
              window.location.href = "{{url('loading-status-list/export?file_type=pdf')}}" + '&' + $('#form-loading-status-list').serialize();
          }
        },
         {
          text: 'EXCEL',
          action: function ( e, dt, node, config ) {
              window.location.href = "{{url('loading-status-list/export?file_type=xls')}}" + '&' + $('#form-loading-status-list').serialize();
          }
        }
      ],
      ajax: {
          url: '{{ url('loading-status-list') }}',
          type: 'POST',
          data: function(d) {
              d.area = $('#form-loading-status-list [name="area"]').val()
              d.invoice_no = $('#form-loading-status-list [name="invoice_no"]').val()
              d.delivery_no = $('#form-loading-status-list [name="delivery_no"]').val()
              d.vehicle_number = $('#form-loading-status-list [name="vehicle_number"]').val()
              d.destination_number = $('#form-loading-status-list [name="destination_number"]').val()
              d.expedition_code = $('#form-loading-status-list [name="expedition_code"]').val()
              d.vehicle_code_type = $('#form-loading-status-list [name="vehicle_code_type"]').val()
              d.do_manifest_no = $('#form-loading-status-list [name="do_manifest_no"]').val()
              d.start_upload_concept_date = $('#form-loading-status-list [name="start_upload_concept_date"]').val()
              d.end_upload_concept_date = $('#form-loading-status-list [name="end_upload_concept_date"]').val()
              d.start_register_driver_date = $('#form-loading-status-list [name="start_register_driver_date"]').val()
              d.end_register_driver_date = $('#form-loading-status-list [name="end_register_driver_date"]').val()
              d.start_mapping_concept_date = $('#form-loading-status-list [name="start_mapping_concept_date"]').val()
              d.end_mapping_concept_date = $('#form-loading-status-list [name="end_mapping_concept_date"]').val()
              d.start_loading_start_date = $('#form-loading-status-list [name="start_loading_start_date"]').val()
              d.end_loading_start_date = $('#form-loading-status-list [name="end_loading_start_date"]').val()
              d.start_loading_finish_date = $('#form-loading-status-list [name="start_loading_finish_date"]').val()
              d.end_loading_finish_date = $('#form-loading-status-list [name="end_loading_finish_date"]').val()
              d.start_complete_date = $('#form-loading-status-list [name="start_complete_date"]').val()
              d.end_complete_date = $('#form-loading-status-list [name="end_complete_date"]').val()
              d.status = $('#form-loading-status-list [name="status"]').val()
            }
      },
      order: [1, 'asc'],
      columns: [
          {data: 'invoice_no'},
          {data: 'line_no'},
          {data: 'output_date'},
          {data: 'output_time'},
          {data: 'concept_destination_name'},
          {data: 'vehicle_code_type'},
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
          {data: 'ship_to_street'},
          {data: 'sold_to_city'},
          {data: 'sold_to_district'},
          {data: 'sold_to_street'},
          {data: 'remarks'},
          {data: 'created_at'},
          {data: 'reg_driver_id'},
          {data: 'reg_driver_name'},
          {data: 'reg_vehicle_no'},
          {data: 'reg_vehicle_description'},
          {data: 'reg_vehicle_type'},
          {data: 'reg_cbm_truck'},
          {data: 'reg_date_in'},
          {data: 'reg_date_out'},
          {data: 'reg_destination'},
          {data: 'reg_region'},
          {data: 'reg_expedition_code'},
          {data: 'reg_expedition_name'},
          {data: 'mapping_concept_date'},
          {data: 'select_gate_date'},
          {data: 'load_gate_number'},
          {data: 'load_loading_start'},
          {data: 'load_loading_end'},
          {data: 'load_loading_minutes'},
          {data: 'load_do_manifest_no'},
          {data: 'status'},
          {data: 'sold_to_code'},
          {data: 'ship_to_code'},
          {data: 'area'},
         ]
    });

    $('#form-loading-status-list').validate({
      submitHandler: function (form){
        $('.loading-status-list-wrapper').removeClass('hide')
        dttable_loading_status_list.ajax.reload(null, false)
      }
    })
  });
</script>
@endpush