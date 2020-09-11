<div class="card-content">
  @include('web.invoicing.receipt-invoice._form_manifest')

  <!-- Receipt Invoice -->
  <div class="row">
    <div class="col s12">
        <div class="row">
          <h4 class="card-title">Receipt Invoice</h4>
          <hr>
          <div class="section-data-tables">
              <h6 class="card-title">List Manifest Receipt</h6>
              <hr>
              <span class="waves-effect waves-light btn btn-small indigo darken-4 mb-1">Create Receipt No.</span>
              <table id="data-table-section-contents" class="display" width="100%">
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
        <br>
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
        {!! get_button_save('Submit to Accounting') !!}
    </div>
  </div>
</div>

@push('vendor_js')
<script src="{{ asset('materialize/vendors/jquery-validation/jquery.validate.min.js') }}">
</script>
@endpush