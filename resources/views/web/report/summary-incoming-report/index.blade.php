@extends('layouts.materialize.index')
{{-- @include('admin.materi.modal_form_materi') --}}

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Summary Incoming Report</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Summary Incoming Report</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content p-0">
                        <form class="form-table" id="form-summary-incoming-report">
                            <table>
                              <tr>
                                <td>WAREHOUSE</td>
                                <td>
                                  <div class="input-field col s12">
                                    <select name="area" class="select2-data-ajax browser-default">
                                    </select>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td>BRANCH</td>
                                <td>
                                  <div class="input-field col s12">
                                    <select name="cabang" class="select2-data-ajax browser-default">
                                    </select>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td>TYPE</td>
                                <td ><div class="col s12 ">
                                        <label>
                                            <input class="validate inline" required="" name="type" type="radio" checked="">
                                            <span>ALL</span>
                                        </label>
                                        <label>
                                            <input class="validate inline" required="" name="type" type="radio">
                                            <span>PRODUCTION</span>
                                        </label>
                                        <label>
                                            <input class="validate inline" required="" name="type" type="radio">
                                            <span>MANUAL</span>
                                        </label>
                                    
                                </div></td>
                              </tr>
                              <tr>
                                <td>SELECTION DATE</td>
                                <td>
                                  <div class="input-field col s6">
                                    <div class="col s3 m2 label">
                                      START
                                    </div>
                                    <div class="col s9 m10">
                                      <input placeholder="" id="start_date" name="start_date" type="text" class="validate datepicker" readonly required="">
                                    </div>
                                  </div>
                                  <div class="input-field col s6">
                                    <div class="col s3 m2 label">
                                      END
                                    </div>
                                    <div class="col s9 m10">
                                      <input placeholder="" id="end_date" name="end_date" type="text" class="validate datepicker" readonly required="">
                                    </div>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td>MODEL</td>
                                <td><div class="input-field col s12">
                                  <input id="" type="text" class="validate" name="model">
                                </div></td>
                              </tr>
                            </table>
                            <div class="input-field col s12">
                              <button type="submit" class="waves-effect waves-light indigo btn ml-1">Submit</button>
                            </div>
                          </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-overlay"></div>
    </div>

    <div class="col s12 summary-incoming-report-wrapper">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content p-0">
                        <div class="section-data-tables">
                            <table class="display" id="table_summary_incoming_report" width="100%">
                                <thead>
                                    <tr>
                                        <th>RECEIPT NO</th>
                                        <th>DELIVERY TICKET</th>
                                        <th>TYPE</th>
                                        <th>EAN CODE</th>
                                        <th>INVOICE NO</th>
                                        <th>NO GR SAP</th>
                                        <th>DOCUMENT DATE</th>
                                        <th>SUPPLIER</th>
                                        <th>EXPEDITION</th>
                                        <th>WAREHOUSE</th>
                                        <th>AREA</th>
                                        <th>MODEL</th>
                                        <th>DESCRIPTION</th>
                                        <th>QUANTITY</th>
                                        <th>CBM</th>
                                        <th>TOTAL CBM</th>
                                        <th>STORAGE LOCATION</th>
                                        <th>CREATED DATE</th>
                                        <th>CREATED BY</th>
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
  var dttable_summary_incoming_report;
  jQuery(document).ready(function($) {
    dttable_summary_incoming_report = $('#table_summary_incoming_report').DataTable({
      serverSide: true,
      scrollX: true,
      dom: 'Brtip',
      scrollY: '60vh',
      buttons: [
        {
          text: 'PDF',
          action: function ( e, dt, node, config ) {
              window.location.href = "{{url('summary-incoming-report/export?file_type=pdf')}}" + '&' + $('#form-summary-incoming-report').serialize();
          }
        },
         {
          text: 'EXCEL',
          action: function ( e, dt, node, config ) {
              window.location.href = "{{url('summary-incoming-report/export?file_type=xls')}}" + '&' + $('#form-summary-incoming-report').serialize();
          }
        }
      ],
      ajax: {
          url: '{{ url('summary-incoming-report') }}',
          type: 'GET',
          data: function(d) {
            d.area = $('#form-summary-incoming-report [name="area"]').val();
            d.cabang = $('#form-summary-incoming-report [name="cabang"]').val();
            d.start_date = $('#form-summary-incoming-report [name="start_date"]').val();
            d.end_date = $('#form-summary-incoming-report [name="end_date"]').val();
            d.model = $('#form-summary-incoming-report [name="model"]').val();
          }
      },
      columns: [
          {data: 'receipt_no'},
          {data: 'delivery_ticket'},
          {data: 'type'},
          {data: 'ean_code'},
          {data: 'invoice_no'},
          {data: 'no_gr_sap'},
          {data: 'document_date'},
          {data: 'vendor_name'},
          {data: 'expedition_name'},
          {data: 'area'},
          {data: 'area'},
          {data: 'model'},
          {data: 'description'},
          {data: 'qty'},
          {data: 'cbm'},
          {data: 'total_cbm'},
          {data: 'storage_location'},
          {data: 'created_at'},
          {data: 'created_by_name'},
      ]
    });
  });

  $('#form-summary-incoming-report').validate({
    submitHandler: function(form){
      dttable_summary_incoming_report.ajax.reload(null, false)
    }
  })

  $('#form-summary-incoming-report [name="area"]').select2({
     placeholder: '-- Select Area --',
     allowClear: true,
     ajax: get_select2_ajax_options('/master-area/select2-area-only')
  });
  $('#form-summary-incoming-report [name="cabang"]').select2({
     placeholder: '-- Select Branch --',
     allowClear: true,
     ajax: get_select2_ajax_options('/master-cabang/select2-all-cabang')
  });
</script>
@endpush