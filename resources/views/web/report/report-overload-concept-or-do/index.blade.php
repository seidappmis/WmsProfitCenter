@extends('layouts.materialize.index')
{{-- @include('admin.materi.modal_form_materi') --}}

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Report Overload Concept or DO</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Report Overload Concept or DO</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content pb-1 pt-1 pl-1 pr-1">
                     <form class="form-table" id="form-report-overload">
                            <table>
                              @if(auth()->user()->cabang->hq)
                                <tr>
                                    <td>Area</td>
                                    <td>
                                      <div class="input-field col s12">
                                        <select name="area" class="select2-data-ajax browser-default" required="">
                                        </select>
                                      </div>
                                    </td>
                                  </tr>
                                @else
                                <tr>
                                    <td>Area</td>
                                    <td>
                                      <div class="input-field col s12">
                                        <select id="kode_cabang"
                                          name="kode_cabang"
                                          class="select2-data-ajax browser-default"
                                          required="" 
                                          >
                                    </select>
                                      </div>
                                    </td>
                                  </tr>
                                @endif
                              <tr>
                                <td>Overload Concept Date</td>
                                <td>
                                  <div class="input-field col s6">
                                    <div class="col s3 m2 label">
                                      From
                                    </div>
                                    <div class="col s9 m10">
                                      <input placeholder="" name="start_date" type="text" class="validate datepicker" readonly required="">
                                    </div>
                                  </div>
                                  <div class="input-field col s6">
                                    <div class="col s3 m2 label">
                                      To
                                    </div>
                                    <div class="col s9 m10">
                                      <input placeholder="" name="end_date" type="text" class="validate datepicker" readonly required="">
                                    </div>
                                  </div>
                                </td>
                              </tr>
                            </table>
                            <div class="input-field col s12">
                              <button type="submit" class="waves-effect waves-light indigo btn">Submit</button>
                            </div>
                            <br>
                         </form>
                   </div>
                </div>
                <div class="card">
                  <div class="card-content p-0">
                      <form class="form-table">
                          <table id="table_report_overload" class="display" width="100%">
                              <thead>
                                  <tr>
                                    <th>INVOICE</th>
                                    <th>LINE NO</th>
                                    <th>OUTPUT DATE</th>
                                    <th>OUTPUT TIME</th>
                                    <th>DESTINATION NUMBER</th>
                                    <th>VEHICLE CODE TYPE</th>
                                    <th>CAR NO</th>
                                    <th>CONT NO</th>
                                    <th>CHECKIN DATE</th>
                                    <th>CHECKIN TIME</th>
                                    <th>EXPEDITION ID</th>
                                    <th>DELIVERY NO</th>
                                    <th>DELIVERY ITEMS</th>
                                    <th>MODEL</th>
                                    <th>QUANTITY</th>
                                    <th>CBM</th>
                                    <th>SHIP TO</th>
                                    <th>SOLD TO</th>
                                    <th>SHIP TO CITY</th>
                                    <th>SHIP TO DISTRICT</th>
                                    <th>SHIP TO STREET</th>
                                    <th>SOLD TO CITY</th>
                                    <th>SOLD TO DISTRIC</th>
                                    <th>SOLD TO STREET</th>
                                    <th>REMARKS</th>
                                    <th>CREATED DATE</th>
                                    <th>CREATED BY</th>
                                    <th>SPLIT DATE</th>
                                    <th>SPLIT BY</th>
                                    <th>AREA</th>
                                    <th>CONCEPT TYPE</th>
                                    <th>EXPEDITION NAME</th>
                                    <th>SOLD TO CODE</th>
                                    <th>SHIP TO CODE</th>
                                    <th>EXPEDITION CODE</th>
                                    <th>CODE SALES</th>
                                    <th>STATUS CONFIRM</th>
                                    <th>CONFIRM BY</th>
                                    <th>CONFIRM DATE</th>
                                    <th>OVERLOAD REASON</th>
                                    <th>QUANTITY BEFORE</th>
                                    <th>CBM BEFORE</th>
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
  var dttable_report_overload;
  jQuery(document).ready(function($) {
    dttable_report_overload = $('#table_report_overload').DataTable({
      serverSide: true,
      scrollX: true,
      dom: 'Brtip',
      scrollY: '60vh',
      buttons: [
        {
          text: 'PDF',
          action: function ( e, dt, node, config ) {
              window.location.href = "{{url('report-overload-concept-or-do/export?file_type=pdf')}}" + '&' + $('#form-report-overload').serialize();
          }
        },
         {
          text: 'EXCEL',
          action: function ( e, dt, node, config ) {
              window.location.href = "{{url('report-overload-concept-or-do/export?file_type=xls')}}" + '&' + $('#form-report-overload').serialize();
          }
        }
      ],
      ajax: {
          url: '{{ url('report-overload-concept-or-do') }}',
          type: 'POST',
          data: function(d) {
            d.area = $('#form-report-overload [name="area"]').val()
            d.kode_cabang = $('#form-report-overload [name="kode_cabang"]').val()
            d.start_date = $('#form-report-overload [name="start_date"]').val()
            d.end_date = $('#form-report-overload [name="end_date"]').val()
          }
      },
      columns: [
          {data: 'invoice_no'},
          {data: 'line_no'},
          {data: 'output_date'},
          {data: 'output_time'},
          {data: 'destination_number'},
          {data: 'vehicle_code_type'},
          {data: 'car_no'},
          {data: 'cont_no'},
          {data: 'checkin_date'},
          {data: 'checkin_time'},
          {data: 'expedition_id'},
          {data: 'delivery_no'},
          {data: 'delivery_items'},
          {data: 'model'},
          {data: 'quantity'},
          {data: 'cbm'},
          {data: 'ship_to'},
          {data: 'sold_to'},
          {data: 'ship_to_city'},
          {data: 'ship_to_district'},
          {data: 'ship_to_street'},
          {data: 'sold_to_city'},
          {data: 'sold_to_district'},
          {data: 'sold_to_street'},
          {data: 'remarks'},
          {data: 'created_at'},
          {data: 'created_by'},
          {data: 'split_date'},
          {data: 'split_by'},
          {data: 'area'},
          {data: 'concept_type'},
          {data: 'expedition_name'},
          {data: 'sold_to_code'},
          {data: 'ship_to_code'},
          {data: 'expedition_code'},
          {data: 'code_sales'},
          {data: 'status_confirm'},
          {data: 'confirm_by'},
          {data: 'confirm_date'},
          {data: 'overload_reason'},
          {data: 'quantity_before'},
          {data: 'cbm_before'},
      ]
    });

    $('#form-report-overload').validate({
      submitHandler: function (form){
        dttable_report_overload.ajax.reload(null, false)
      }
    })
  });

  $('#form-report-overload [name="area"]').select2({
     placeholder: '-- Select Area --',
     allowClear: true,
     ajax: get_select2_ajax_options('/master-area/select2-area-only')
  });

  $('#form-report-overload [name="kode_cabang"]').select2({
       placeholder: '-- Select Branch --',
       allowClear: true,
       ajax: get_select2_ajax_options('/master-cabang/select2-grant-cabang')
    });
</script>
@endpush