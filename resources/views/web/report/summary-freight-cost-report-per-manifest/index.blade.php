@extends('layouts.materialize.index')
{{-- @include('admin.materi.modal_form_materi') --}}

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Summary Freight Cost Report Per Manifest</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Summary Freight Cost Report Per Manifest</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content ">
                     <form class="form-table" id="form-summary-freight-cost">
                            <table>
                              <tr>
                                <td>Date of Manifest</td>
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
                                <td>DO Manifest</td>
                                <td><div class="input-field col s5">
                                  <input id="" type="text" class="validate " name="do_manifest_no">
                                </div></td>
                              </tr>
                              <tr>
                                <td>ReceiptID</td>
                                <td><div class="input-field col s5">
                                  <input id="" type="text" class="validate " name="invoice_receipt_id">
                                </div></td>
                              </tr>
                              <tr>
                                <td>Expedition</td>
                                <td>
                                    <div class="input-field col s12">
                                    <select name="expedition_code" class="select2-data-ajax browser-default">
                                    </select>
                                  </div>
                                  </td>
                              </tr>
                              <tr >
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
                                <td>Status Receipt</td>
                                <td>
                                  <div class="input-field col s4">
                                    <select name="paid_status" id="">
                                      <option value="" disabled selected>-All-</option>
                                      <option value="Unreceipt">Unreceipt</option>
                                      <option value="Draft Receipt">Draft Receipt</option>
                                      <option value="Already Receipt">Already Receipt</option> 
                                    </select>

                                  </div>
                                </td>
                              </tr>
                             
                            </table>
                            <div class="input-field col s12">
                              <button type="submit" class="waves-effect waves-light indigo btn mt-1 mb-1">Print</button>
                            </div>
                          </form>
                   </div>
                </div>
            </div>
        </div>
        <div class="content-overlay"></div>
    </div>

    <div class="col s12 summary-freight-cost-report-per-manifest-wrapper">
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
                                        <th>Paid Status</th>
                                        <th>Bulan</th>
                                        <th>ACC Code</th>
                                        <th>Branch Code</th>
                                        <th>SLOC</th>
                                        <th>Manifest No</th>
                                        <th>Tgl Manifest</th>
                                        <th>Transporter</th>
                                        <th>Destination</th>
                                        <th>Vehicle Type</th>
                                        <th>Vehicle No</th>
                                        <th>DO No</th>
                                        <th>Branch Short Description</th>
                                        <th>Ship To Code</th>
                                        <th>Ship to Description</th>
                                        <th>Destination City DO</th>
                                        <th>Total CBM DO</th>
                                        <th>SumOfTotalCBM</th>
                                        <th>BaseCostCBM</th>
                                        <th>CostPerDO</th>
                                        <th>BaseCostRitase</th>
                                        <th>RitaseCost</th>
                                        <th>Ritase2Cost</th>
                                        <th>MultiDrop</th>
                                        <th>Unloading</th>
                                        <th>OverStay</th>
                                        <th>Total</th>
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
              window.location.href = "{{url('summary-freight-cost-report-per-manifest/export?file_type=pdf')}}" + '&' + $('#form-summary-freight-cost').serialize();
          }
        },
         {
          text: 'EXCEL',
          action: function ( e, dt, node, config ) {
              window.location.href = "{{url('summary-freight-cost-report-per-manifest/export?file_type=xls')}}" + '&' + $('#form-summary-freight-cost').serialize();
          }
        }
      ],
      ajax: {
          url: '{{ url('summary-freight-cost-report-per-manifest') }}',
          type: 'GET',
          data: function(d) {
            d.start_date = $('#form-summary-freight-cost [name="start_date"]').val();
            d.end_date = $('#form-summary-freight-cost [name="end_date"]').val();
            d.invoice_receipt_id = $('#form-summary-freight-cost [name="invoice_receipt_id"]').val();
            d.do_manifest_no = $('#form-summary-freight-cost [name="do_manifest_no"]').val();
            d.do_manifest_date = $('#form-summary-freight-cost [name="do_manifest_date"]').val();
            d.expedition_code = $('#form-summary-freight-cost [name="expedition_code"]').val();
            d.city_code = $('#form-summary-freight-cost [name="city_code"]').val();
            d.region = $('#form-summary-freight-cost [name="region"]').val();
            d.paid_status = $('#form-summary-freight-cost [name="paid_status"]').val();
          }
      },
      columns: [
          {data: 'invoice_receipt_id'},
          {data: 'invoice_receipt_no'},
          {data: 'kwitansi_no'},
          {data: 'invoice_receipt_date'},
          {data: 'amount_after_tax'},
          {data: 'status'},
          {data: 'paid_status'},
          {data: 'bulan'},
          {data: 'acc_code'},
          {data: 'kode_cabang'},
          {data: 'code_sales'},
          {data: 'do_manifest_no'},
          {data: 'do_manifest_date'},
          {data: 'expedition_name'},
          {data: 'city_name'},
          {data: 'vehicle_description'},
          {data: 'vehicle_number'},
          {data: 'delivery_no'},
          {data: 'branch_short_description'},
          {data: 'ship_to_code'},
          {data: 'ship_to'},
          {data: 'city_name'},
          {data: 'cbm_do'},
          {data: 'cbm_vehicle'},
          {data: 'freight_cost'},
          {data: 'cbm_amount'},
          {data: 'ritase_freight_cost'},
          {data: 'ritase_amount'},
          {data: 'ritase2_amount'},
          {data: 'multidro_amount'},
          {data: 'unloading_amount'},
          {data: 'overstay_amount'},
          {data: 'amount_before_tax'},
          {data: 'region'},
      ]
    });
  });

  $('#form-summary-freight-cost').validate({
    submitHandler: function(form){
      dttable_summary_incoming_report.ajax.reload(null, false)
    }
  })

  $('#form-summary-freight-cost [name="expedition_code"]').select2({
        placeholder: '-- Select Expedition --',
        allowClear: true,
        ajax: get_select2_ajax_options('{{url('/master-expedition/select2-all-expedition')}}')
  })
  $('#form-summary-freight-cost [name="region"]').select2({
        placeholder: '-- Select Region --',
        allowClear: true,
        ajax: get_select2_ajax_options('{{url('/region/select2-region')}}')
  })
  $('#form-summary-freight-cost [name="city_code"]').select2({
    placeholder: '-- Select Destination --',
    allowClear: true,
    // ajax: get_select2_ajax_options('{{url('/master-expedition/select2-expedition-destination-city')}}')
    ajax: get_select2_ajax_options('{{url('/destination-city/select2-destination-city')}}')
  })
</script>
@endpush