@extends('layouts.materialize.index')
{{-- @include('admin.materi.modal_form_materi') --}}

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Summary Outgoing Report</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Summary Outgoing Report</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content p-0">
                        <form class="form-table" id="form-summary-outgoing-report">
                            <table>
                              <tr>
                                <td>Area</td>
                                <td>
                                  <div class="input-field col s12">
                                    <select name="area" class="select2-data-ajax browser-default" required="">
                                    </select>
                                  </div>
                                 <label>
                                    <input name="include_hq" type="checkbox" class="filled-in "/>
                                 <span><b>Include HQ</b></span>
                                 </label>
                                </td>
                              </tr>
                              <tr>
                                  <td>Do Received</td>
                                  <td> <label>
                                    <input name="do_received" type="checkbox" class="filled-in "/>
                                 <span><b></b></span>
                                 </label> </td>
                              </tr>
                              <tr>
                                <td>Branch</td>
                                <td>
                                  <div class="input-field col s6">
                                     <select id="kode_cabang"
                                          name="kode_cabang"
                                          class="select2-data-ajax browser-default"
                                          >
                                    </select>
                                   </div>
                                </td>
                              </tr>
                              <tr>
                                <td>Date of Manifest</td>
                                <td>
                                  <div class="input-field col s6">
                                    <div class="col s3 m2 label">
                                      From
                                    </div>
                                    <div class="col s9 m10">
                                      <input placeholder="" name="start_do_manifest_date" type="text" class="validate datepicker" readonly required="">
                                    </div>
                                  </div>
                                  <div class="input-field col s6">
                                    <div class="col s3 m2 label">
                                      To
                                    </div>
                                    <div class="col s9 m10">
                                      <input placeholder="" name="end_do_manifest_date" type="text" class="validate datepicker" readonly required="">
                                    </div>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td>Do Date</td>
                                <td>
                                  <div class="input-field col s6">
                                    <div class="col s3 m2 label">
                                      From
                                    </div>
                                    <div class="col s9 m10">
                                      <input placeholder="" name="start_do_date" type="text" class="validate datepicker" readonly>
                                    </div>
                                  </div>
                                  <div class="input-field col s6">
                                    <div class="col s3 m2 label">
                                      To
                                    </div>
                                    <div class="col s9 m10">
                                      <input placeholder="" name="end_do_date" type="text" class="validate datepicker" readonly>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td>Actual Time Arrival ( ATA )</td>
                                <td>
                                  <div class="input-field col s6">
                                    <div class="col s3 m2 label">
                                      From
                                    </div>
                                    <div class="col s9 m10">
                                      <input placeholder="" name="start_actual_time_arrival" type="text" class="validate datepicker" readonly>
                                    </div>
                                  </div>
                                  <div class="input-field col s6">
                                    <div class="col s3 m2 label">
                                      To
                                    </div>
                                    <div class="col s9 m10">
                                      <input placeholder="" name="end_actual_time_arrival" type="text" class="validate datepicker" readonly>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td>Unloading Date</td>
                                <td>
                                  <div class="input-field col s6">
                                    <div class="col s3 m2 label">
                                      From
                                    </div>
                                    <div class="col s9 m10">
                                      <input placeholder="" name="start_unloading_date" type="text" class="validate datepicker" readonly>
                                    </div>
                                  </div>
                                  <div class="input-field col s6">
                                    <div class="col s3 m2 label">
                                      To
                                    </div>
                                    <div class="col s9 m10">
                                      <input placeholder="" name="end_unloading_date" type="text" class="validate datepicker" readonly>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td>Document DO Return Date</td>
                                <td>
                                  <div class="input-field col s6">
                                    <div class="col s3 m2 label">
                                      From
                                    </div>
                                    <div class="col s9 m10">
                                      <input placeholder="" name="start_document_do_return_date" type="text" class="validate datepicker" readonly>
                                    </div>
                                  </div>
                                  <div class="input-field col s6">
                                    <div class="col s3 m2 label">
                                      To
                                    </div>
                                    <div class="col s9 m10">
                                      <input placeholder="" name="end_document_do_return_date" type="text" class="validate datepicker" readonly>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td>MANIFEST NO.</td>
                                <td><div class="input-field col s5">
                                  <input name="do_manifest_no" type="text" class="validate ">
                                </div></td>
                              </tr>
                              <tr>
                                <td>SHIPMENT NO.</td>
                                <td><div class="input-field col s5">
                                  <input name="shipment_no" type="text" class="validate ">
                                </div></td>
                              </tr>
                              <tr>
                                <td>DO NO.</td>
                                <td><div class="input-field col s5">
                                  <input name="delivery_no" type="text" class="validate ">
                                </div></td>
                              </tr>
                              <tr>
                                <td>OUTGOING TYPE</td>
                                <td>
                                  <div class="input-field col s5">
                                    <select name="otgoing_type">
                                      <option value="" disabled selected>-Select Type-</option>
                                      <option value="1">MANUAL</option>
                                      <option value="2">NORMAL</option>
                                      <option value="3">RESEND</option>
                                      <Option value="4">LCL</Option>
                                    </select>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td>Status</td>
                                <td>
                                  <div class="input-field col s4">
                                    <select name="status" id="">
                                      <option value="" disabled selected>-select status-</option>
                                      <option value="1">ALL</option>
                                      <option value="2">UNCONFIRM</option>
                                      <option value="3">HOLD</option>
                                      <option value="4">CONFIRMED RECEIPT</option>
                                      <option value="5">CONFIRMED REJECTED</option>
                                      <option value="6">NO DETAIL</option>   
                                    </select>

                                  </div>
                                </td>
                              </tr>
                              <tr>
                                  <td></td>
                                  <td> <label>
                                    <input name="not_include_manifest_as" type="checkbox" class="filled-in "/>
                                 <span><b>Not Include Manifest AS</b></span>
                                 </label></td>
                              </tr>
                            </table>
                            <div class="input-field col s12">
                              <button type="submit" class="waves-effect waves-light indigo btn">Submit</button>
                            </div>
                          </form>
                    </div>
                </div>
            </div>

            <div class="secion summary-outgoing-report-wrapper hide">
              <div class="card">
                <div class="card-conten">
                  <div class="section-data-tables"> 
                      <table id="table_summary_outgoing_report" class="display" width="100%">
                          <thead>
                              <tr>
                                <th>OUTGOING TYPE</th>
                                <th>MANIFEST DATE</th>
                                <th>MANIFEST NO</th>
                                <th>PICKING LIST NO</th>
                                <th>SHIPMENT NO</th>
                                <th>DO NO</th>
                                <th>DO INTERNAL</th>
                                <th>RESERVATION NO</th>
                                <th>DO DATE</th>
                                <th>ITEM</th>
                                <th>ETD</th>
                                <th>ETA</th>
                                <th>LEAD TIME</th>
                                <th>CHECKER</th>
                                <th>SOLD TO CODE</th>
                                <th>SOLD TO DETAIL</th>
                                <th>SHIP TO CODE</th>
                                <th>SHIP TO DETAIL</th>
                                <th>REGION</th>
                                <th>DESTINATION MANIFEST</th>
                                <th>DESTINATION DO</th>
                                <th>MODEL</th>
                                <th>MODEL DESCRIPTION</th>
                                <th>QUANTITY</th>
                                <th>CBM</th>
                                <th>TOTAL CBM</th>
                                <th>TRANSPORTER CODE</th>
                                <th>TRANSPORTER DETAIL</th>
                                <th>VEHICLE NO</th>
                                <th>VEHICLE TYPE</th>
                                <th>VEHICLE DESCRIPTION</th>
                                <th>CONT NO</th>
                                <th>SEAL NO</th>
                                <th>PDO NO</th>
                                <th>CODE SALES</th>
                                <th>STATUS</th>
                                <th>CREATED BY</th>
                                <th>CREATED DATE</th>
                                <th>MODIFY BY</th>
                                <th>MODIFY DATE</th>
                                <th>DESC</th>
                                <th>DELIVERY STATUS</th>
                                <th>CONFIRM</th>
                                <th>STATUS CONFIRM</th>
                                <th>CONFIRM BY</th>
                                <th>CONFIRM DATE</th>
                                <th>ACTUAL TIME ARRIVAL</th>
                                <th>ACTUAL UNLOADING DATE</th>
                                <th>DOC DO RETURN DATE</th>
                                <th>STATUS REJECT</th>
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
  var dttable_summary_outgoing_report
  jQuery(document).ready(function($) {
    dttable_summary_outgoing_report = $('#table_summary_outgoing_report').DataTable({
      serverSide: true,
      scrollX: true,
      dom: 'Brtip',
      scrollY: '60vh',
      buttons: [
        {
          text: 'PDF',
          action: function ( e, dt, node, config ) {
              window.location.href = "{{url('summary-outgoing-report/export?file_type=pdf')}}" + '&branch=' + $('#branch_filter').val();
          }
        },
         {
          text: 'EXCEL',
          action: function ( e, dt, node, config ) {
              window.location.href = "{{url('summary-outgoing-report/export?file_type=xls')}}" + '&branch=' + $('#branch_filter').val();
          }
        }
      ],
      ajax: {
          url: '{{ url('summary-outgoing-report') }}',
          type: 'POST',
          data: function(d) {
              d.area = $('#form-summary-outgoing-report [name="area"]').val()
              d.do_manifest_no = $('#form-summary-outgoing-report [name="do_manifest_no"]').val()
              d.kode_cabang = $('#form-summary-outgoing-report [name="kode_cabang"]').val()
              d.include_hq = $('#form-summary-outgoing-report [name="include_hq"]').is(":checked")
              d.do_received = $('#form-summary-outgoing-report [name="do_received"]').val()
              d.not_include_manifest_as = $('#form-summary-outgoing-report [name="not_include_manifest_as"]').val()
              d.invoice_no = $('#form-summary-outgoing-report [name="invoice_no"]').val()
              d.delivery_no = $('#form-summary-outgoing-report [name="delivery_no"]').val()
              d.start_do_manifest_date = $('#form-summary-outgoing-report [name="start_do_manifest_date"]').val()
              d.end_do_manifest_date = $('#form-summary-outgoing-report [name="end_do_manifest_date"]').val()
              d.start_do_date = $('#form-summary-outgoing-report [name="start_do_date"]').val()
              d.end_do_date = $('#form-summary-outgoing-report [name="end_do_date"]').val()
              d.start_actual_time_arrival = $('#form-summary-outgoing-report [name="start_actual_time_arrival"]').val()
              d.end_actual_time_arrival = $('#form-summary-outgoing-report [name="end_actual_time_arrival"]').val()
              d.start_unloading_date = $('#form-summary-outgoing-report [name="start_unloading_date"]').val()
              d.end_unloading_date = $('#form-summary-outgoing-report [name="end_unloading_date"]').val()
              d.start_doc_do_return_date = $('#form-summary-outgoing-report [name="start_doc_do_return_date"]').val()
              d.end_doc_do_return_date = $('#form-summary-outgoing-report [name="end_doc_do_return_date"]').val()
            }
      },
      order: [1, 'asc'],
      columns: [
          {data: 'manifest_type'},
          {data: 'do_manifest_date'},
          {data: 'do_manifest_no'},
          {data: 'do_manifest_no'},
          {data: 'invoice_no'},
          {data: 'delivery_no'},
          {data: 'do_internal'},
          {data: 'reservasi_no'},
          {data: 'do_date'},
          {data: 'delivery_items'},
          {data: 'do_manifest_date'},
          {data: 'eta'},
          {data: 'lead_time'},
          {data: 'checker'},
          {data: 'sold_to_code'},
          {data: 'sold_to'},
          {data: 'ship_to_code'},
          {data: 'ship_to'},
          {data: 'region'},
          {data: 'destination_name_driver'},
          {data: 'city_name'},
          {data: 'model'},
          {data: 'model_description'},
          {data: 'quantity'},
          {data: 'detail_cbm'},
          {data: 'detail_total_cbm'},
          {data: 'expedition_code'},
          {data: 'expedition_name'},
          {data: 'vehicle_number'},
          {data: 'vehicle_code_type'},
          {data: 'vehicle_description'},
          {data: 'container_no'},
          {data: 'seal_no'},
          {data: 'pdo_no'},
          {data: 'code_sales'},
          {data: 'status'},
          {data: 'created_by_name'},
          {data: 'created_at'},
          {data: 'updated_by_name'},
          {data: 'updated_at'},
          {data: 'desc'},
          {data: 'delivery_status'},
          {data: 'confirm'},
          {data: 'status_confirm'},
          {data: 'confirm_by'},
          {data: 'confirm_date'},
          {data: 'actual_time_arrival'},
          {data: 'actual_unloading_date'},
          {data: 'doc_do_return_date'},
          {data: 'status_reject'},
         ]
    });

    $('#form-summary-outgoing-report').validate({
      submitHandler: function (form){
        $('.summary-outgoing-report-wrapper').removeClass('hide')
        dttable_summary_outgoing_report.ajax.reload(null, false)
      }
    })

    $('#form-summary-outgoing-report [name="area"]').select2({
       placeholder: '-- Select Area --',
       allowClear: true,
       ajax: get_select2_ajax_options('/master-area/select2-area-with-all')
    });

    $('#form-summary-outgoing-report [name="kode_cabang"]').select2({
       placeholder: '-- Select Branch --',
       allowClear: true,
       ajax: get_select2_ajax_options('/master-cabang/select2-grant-cabang')
    });
  });
</script>
@endpush