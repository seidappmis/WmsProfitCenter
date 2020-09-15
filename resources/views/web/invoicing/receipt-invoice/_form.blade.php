<div class="card-content">
  @include('web.invoicing.receipt-invoice._form_manifest')

  <!-- Receipt Invoice -->
  <div class="row">
    <div class="col s12">
        <div class="row">
          <h4 class="card-title">Receipt Invoice</h4>
          <hr>
          <div class="card">
            <div class="card-content pt-1 pb-1 pr-1 pl-1">
              <strong>NEW</strong>
              <h6 class="card-title">List Manifest Receipt</h6>
              <hr>
              <span class="waves-effect waves-light btn btn-small indigo darken-4 mb-1">Create Receipt No.</span>
              <div class="section-data-tables">
                <table id="table_list_manifest_receipt" class="display" width="100%">
                    <thead>
                      <tr>
                        <th data-priority="1" width="30px">NO.</th>
                        <th>Manifest No</th>
                        <th>DATE MANIFEST</th>
                        <th>VEHICLE NO</th>
                        <th>VEHICLE</th>
                        <th>DESTINATION</th>
                        <th>COUNT OF DO</th>
                        <th>SUM OF CBM</th>
                        <th>CBM</th>
                        <th>RITASE</th>
                        <th>RITASE2</th>
                        <th>MULTIDROP</th>
                        <th>UNLOADING</th>
                        <th>OVERSTAY</th>
                        <th>TOTAL</th>
                        <th width="50px;"></th>
                      </tr>
                    </thead>
                    <tbody></tbody> 
                </table>
              </div>

              <div class="row">
                <div class="input-field col s3">
                    <input id="name" type="text" placeholder="">
                    <label for="first_name">Kwitansi No.</label>
                </div>
                <div class="input-field col s3">
                    <input id="name" type="text" placeholder="" readonly="readonly">
                    <label for="first_name">Receipt ID.</label>
                </div>
                <div class="input-field col s3">
                    <input id="name" type="text" placeholder="" readonly="readonly">
                    <label for="first_name">Receipt No.</label>
                </div>
              </div>
              <hr>
              <div class="row">
                  <div class="input-field col s2">
                    <input id="name" type="text" placeholder="" required>
                    <label for="first_name">PPh 2% (A)</label>
                </div>
                <div class="input-field col s2">
                    <input id="name" type="text" placeholder="" required>
                    <label for="first_name">PPn 10% (B)</label>
                </div>
                <div class="input-field col s2">
                    <input id="name" type="text" placeholder="" readonly="readonly">
                    <label for="first_name">Amount Invoice (X)</label>
                </div>
                <div class="input-field col s2">
                    <input id="name" type="text" placeholder="" readonly="readonly">
                    <label for="first_name">Amount Invoice + PPn(B+X)</label>
                </div>
              </div>
              <div class="row">
                  <div class="input-field col s12 m4">
                      <textarea id="textarea2" class="materialize-textarea" placeholder=""></textarea>
                      <label for="textarea2">REMARKS</label>
                  </div>
              </div>
              {!! get_button_print('#', 'Print Receipt NO', 'btn-print-receipt-no mt-0') !!}
              {!! get_button_print('#', 'Print Receive Invoice', 'btn-print-receive-invoice mt-0') !!}
              <br>
              {!! get_button_save('Submit to Accounting') !!}
            </div>
          </div>
        </div>
    </div>
  </div>
</div>

@include('layouts.materialize.components.modal-print', [
  'title' => 'Print Receipt No',
  'url' => 'receipt-invoice/' . (!empty($invoiceReceiptHeader) ? $invoiceReceiptHeader->id : '') . '/export-receipt-no',
  'trigger' => '.btn-print-receipt-no'
  ])

@include('layouts.materialize.components.modal-print', [
  'title' => 'Print Receive Invoice',
  'url' => 'receipt-invoice/' . (!empty($invoiceReceiptHeader) ? $invoiceReceiptHeader->id : '') . '/export-receive-invoice',
  'trigger' => '.btn-print-receive-invoice'
  ])

@push('vendor_js')
<script src="{{ asset('materialize/vendors/jquery-validation/jquery.validate.min.js') }}">
</script>
@endpush

@push('script_js')
<script type="text/javascript">
  var dttable_list_manifest_receipt
  jQuery(document).ready(function($) {
    dttable_list_manifest_receipt = $('#table_list_manifest_receipt').DataTable({
        serverSide: true,
        scrollX: true,
        responsive: false,
        ajax: {
            url: '{{url("receipt-invoice/" . $invoiceReceiptHeader->id)}}',
            type: 'GET',
        },
        order: [1, 'asc'],
        columns: [
            {data: 'DT_RowIndex', orderable:false, searchable: false, className: 'center-align'},
            {data: 'do_manifest_no'},
            {data: 'do_manifest_date'},
            {data: 'vehicle_number'},
            {data: 'vehicle_description'},
            {data: 'city_name'},
            {data: 'count_of_do'},
            {data: 'sum_of_cbm', className: 'center-align'},
            {data: 'cbm', className: 'center-align'},
            {data: 'ritase', className: 'center-align'},
            {data: 'ritas2', className: 'center-align'},
            {data: 'multidrop', className: 'center-align'},
            {data: 'unloading', className: 'center-align'},
            {data: 'overstay', className: 'center-align'},
            {data: 'total', className: 'center-align'},
            {data: 'action', className: 'center-align'},
        ]
    });
  });
</script>
@endpush