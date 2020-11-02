@extends('layouts.materialize.index')
{{-- @include('admin.materi.modal_form_materi') --}}

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Summary Freight Cost Analysis</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Summary Freight Cost Analysis</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content">
                      <form class="form-table" id="form-summary-freight-cost-analysis">
                        <table>
                          <tr>
                            <td>Expedition</td>
                            <td>
                              <div class="input-field col s12">
                                <select name="expedition_code" class="select2-data-ajax browser-default" required="">
                                </select>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>Manifest Date</td>
                            <td>
                              <div class="input-field col s6">
                                <div class="col s3 m2 label">
                                  From
                                </div>
                                <div class="col s9 m10">
                                  <input placeholder="" name="start_date" type="text" class="validate datepicker" readonly required>
                                </div>
                              </div>
                              <div class="input-field col s6">
                                <div class="col s3 m2 label">
                                  To
                                </div>
                                <div class="col s9 m10">
                                  <input placeholder="" name="end_date" type="text" class="validate datepicker" readonly required>
                                </div>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>DO Date</td>
                            <td>
                              <div class="input-field col s6">
                                <div class="col s3 m2 label">
                                  From
                                </div>
                                <div class="col s9 m10">
                                  <input placeholder="" name="start_date_do" type="text" class="validate datepicker" readonly>
                                </div>
                              </div>
                              <div class="input-field col s6">
                                <div class="col s3 m2 label">
                                  To
                                </div>
                                <div class="col s9 m10">
                                  <input placeholder="" name="end_date_do" type="text" class="validate datepicker" readonly>
                                </div>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>DO Manifest</td>
                            <td>
                              <div class="input-field col s12">
                                  <input placeholder="" name="do_manifest_no" id="first_name" type="text" class="validate">
                                  {{-- <label for="first_name">From</label> --}}
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>Recipt ID</td>
                            <td>
                              <div class="input-field col s12">
                                  <input placeholder="" name="invoice_receipt_id" id="first_name" type="text" class="validate">
                                  {{-- <label for="first_name">From</label> --}}
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>Destination</td>
                            <td>
                              <div class="input-field col s12">
                                <select name="city_code" class="select2-data-ajax browser-default">
                                </select>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>Region</td>
                            <td>
                              <div class="input-field col s12">
                                <select name="region" class="select2-data-ajax browser-default">
                                </select>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>Status</td>
                            <td>
                              <div class="input-field col s12">
                                <select name="status" class="select2-data-ajax browser-default">
                                  <option value="" disabled selected>-All-</option>
                                  <option value="1">UNRECEIPT</option>
                                  <option value="2">DRAFT UNRECEIPT</option>
                                  <option value="3">ALREADY UNRECEIPT</option>
                                </select>
                              </div>
                            </td>
                          </tr>
                        </table>
                        <button class="btn btn-large waves-effect waves-light green darken-4 mt-2" type="submit" name="action">
                          <i class="material-icons left">local_printshop</i>
                          Print
                        </button>
                      </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-overlay"></div>
    </div>

    <div class="col s12 summary-freight-cost-analysis-wrapper">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content p-0">
                        <div class="section-data-tables">
                            <table class="display" id="tabel-freight-cost-report-per-manifest" width="100%">
                                <thead>
                                    <tr>
                                        <th>ReceiptID</th>
                                        <th>ReceiptNum</th>
                                        <th>Invoice Number</th>
                                        <th>ReceiptDate</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Bulan</th>
                                        <th>ACC Code</th>
                                        <th>Kode Cabang</th>
                                        <th>Code Sales</th>
                                        <th>Expedition Code</th>
                                        <th>DO Manifest No</th>
                                        <th>DO Manifest Date</th>
                                        <th>Expedition Name</th>
                                        <th>Vehicle Description</th>
                                        <th>Destination Manifest</th>
                                        <th>Delivery No</th>
                                        <th>DO Date</th>
                                        <th>MODEL</th>
                                        <th>Total CBM DO</th>
                                        <th>Qty</th>
                                        <th>Base Cost Ritase</th>
                                        <th>Base Cost CBM</th>
                                        <th>Total CBM Truck</th>
                                        <th>Total Freight Cost</th>
                                        <th>Ritase2</th>
                                        <th>Multidrop</th>
                                        <th>Unloading</th>
                                        <th>Overstay</th>
                                        <th>Ship To Code</th>
                                        <th>Ship To</th>
                                        <th>Region</th>
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
    dttable_summary_incoming_report = $('#tabel-freight-cost-report-per-manifest').DataTable({
      serverSide: true,
      scrollX: true,
      dom: 'Brtip',
      scrollY: '60vh',
      buttons: [
        {
          text: 'PDF',
          action: function ( e, dt, node, config ) {
              window.location.href = "{{url('summary-freight-cost-analysis/export?file_type=pdf')}}" + '&' + $('#form-summary-freight-cost-analysis').serialize();
          }
        },
         {
          text: 'EXCEL',
          action: function ( e, dt, node, config ) {
              window.location.href = "{{url('summary-freight-cost-analysis/export?file_type=xls')}}" + '&' + $('#form-summary-freight-cost-analysis').serialize();
          }
        }
      ],
      ajax: {
          url: '{{ url('summary-freight-cost-analysis') }}',
          type: 'GET',
          data: function(d) {
            d.expedition_code = $('#form-summary-freight-cost-analysis [name="expedition_code"]').val();
            d.start_date = $('#form-summary-freight-cost-analysis [name="start_date"]').val();
            d.end_date = $('#form-summary-freight-cost-analysis [name="end_date"]').val();
            d.start_date_do = $('#form-summary-freight-cost-analysis [name="start_date_do"]').val();
            d.end_date_do = $('#form-summary-freight-cost-analysis [name="end_date_do"]').val();
            d.do_manifest_no = $('#form-summary-freight-cost-analysis [name="do_manifest_no"]').val();
            d.invoice_receipt_id = $('#form-summary-freight-cost-analysis [name="invoice_receipt_id"]').val();
            d.city_code = $('#form-summary-freight-cost-analysis [name="city_code"]').val();
            d.region = $('#form-summary-freight-cost-analysis [name="region"]').val();
            d.paid_status = $('#form-summary-freight-cost-analysis [name="paid_status"]').val();
          }
      },
      columns: [
          {data: 'invoice_receipt_id'},
          {data: 'invoice_receipt_no'},
          {data: 'kwitansi_no'},
          {data: 'invoice_receipt_date'},
          {data: 'amount_after_tax'},
          {data: 'manifest_type'},
          {data: 'month'},
          {data: 'acc_code'},
          {data: 'kode_cabang'},
          {data: 'code_sales'},
          {data: 'expedition_code'},
          {data: 'do_manifest_no'},
          {data: 'do_manifest_date'},
          {data: 'expedition_name'},
          {data: 'vehicle_description'},
          {data: 'destination_manifest'},
          {data: 'delivery_no'},
          {data: 'do_date'},
          {data: 'model'},
          {data: 'total_cbm_do'},
          {data: 'qty'},
          {data: 'base_cost_ritase'},
          {data: 'base_cost_cbm'},
          {data: 'total_cbm_truck'},
          {data: 'total_freight_cost'},
          {data: 'ritase2'},
          {data: 'multidrop'},
          {data: 'unloading'},
          {data: 'overstay'},
          {data: 'ship_to_code'},
          {data: 'ship_to'},
          {data: 'region'},
      ]
    });

    $('#form-summary-freight-cost-analysis [name="expedition_code"]').select2({
        placeholder: '-- Select Expedition --',
        ajax: get_select2_ajax_options('/master-expedition/select2-all-expedition', {
          'tambah_ambil_sendiri': true,
          'tambah_all': true
        })
    })
    $('#form-summary-freight-cost-analysis [name="city_code"]').select2({
        placeholder: '-- All --',
        ajax: get_select2_ajax_options('/destination-city/select2-destination-city')
    })
    $('#form-summary-freight-cost-analysis [name="region"]').select2({
        placeholder: '-- All --',
        ajax: get_select2_ajax_options('/region/select2-region')
    })
    $('#form-summary-freight-cost-analysis [name="status"]').select2({
        placeholder: '-- All --',
      })

    $("#form-summary-freight-cost-analysis").validate({
      submitHandler: function(form) {
        dttable_summary_incoming_report.ajax.reload(null, false)
      }
    });
  });
</script>
@endpush