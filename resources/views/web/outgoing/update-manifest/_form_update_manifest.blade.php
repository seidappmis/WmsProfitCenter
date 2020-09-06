<div class="form-update-manifest-wrapper hide">
  <form id="form-update-manifest">
  <table class="">
    <thead>
      <tr>
        <th class="center">MANIFEST NORMAL</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>
          <table width="100%" class="form-table">
            <tr>
              <td width="20%">Manifest No.</td>
              <td><div class="input-field col s12"><input type="text" class="validate" name="do_manifest_no" readonly=""></div></td>
              <td width="20%">Manifest Date</td>
              <td><div class="input-field col s12"><input type="text" class="validate" name="do_manifest_date" disabled></div></td>
            </tr>
            <tr>
              <td width="20%">Vehicle No.</td>
              <td><div class="input-field col s12"><input type="text" class="validate" name="vehicle_number"></div></td>
              <td width="20%">Expedition</td>
              <td>
                <input type="hidden" name="expedition_code">
                <div class="input-field col s12"><input type="text" class="validate" name="expedition_name" disabled></div>
              </td>
            </tr>
            <tr>
              <td width="20%">Driver Name</td>
              <td><div class="input-field col s12"><input type="text" class="validate" name="driver_name" disabled></div></td>
              <td width="20%">Vehicle Type</td>
              <td><div class="input-field col s12"><input type="text" class="validate" name="vehicle_description" disabled></div></td>
            </tr>
            <tr>
              <td width="20%">Destination City</td>
              <td><div class="input-field col s12"><input type="text" class="validate" name="city_name" disabled></div></td>
              <td width="20%">Container No</td>
              <td><div class="input-field col s12"><input type="text" class="validate" name="container_no"></div></td>
            </tr>
            <tr>
              <td width="20%">Seal No.</td>
              <td><div class="input-field col s12"><input type="text" class="validate" name="seal_no"></div></td>
              <td width="20%">Checker</td>
              <td><div class="input-field col s12"><input type="text" class="validate" name="checker"></div></td>
            </tr>
            <tr>
              <td width="20%">PDO No.</td>
              <td><div class="input-field col s12"><input type="text" class="validate" name="pdo_no"></div></td>
            </tr>
          </table>
          {!!get_button_save('Update')!!}
          {!!get_button_print('#', 'Re Print', 'btn-print mt-2')!!}
          {!!get_button_cancel('#', 'Back To', 'btn-back mt-2')!!}
        </td>
      </tr>
    </tbody>
  </table>
</form>
  <h6 class="card-header">Total Manifest : 1</h6>
  <h5 class="card-header">List DO</h5>
  <hr>
  <div class="row pl-2 mb-0 form-table">
    <div class="input-field col s3">
        <input id="filter-do-or-shipment" type="text" class="validate" name="filter-do-or-shipment">
    </div>
    <div class="col s9">
      <span class="waves-effect waves-light btn btn-small indigo darken-4 btn-view ml-2" id="btn-search-do">Search DO</span>
    </div>
  </div>
  <div class="section-data-tables"> 
    <table id="table-do" class="display" width="100%">
        <thead>
            <tr>
              <th>NO.</th>
              <th>No Shipment</th>
              <th>DO No</th>
              <th>DO Int No</th>
              <th>City Ship To</th>
              <th>Items</th>
              <th>Models</th>
              <th>Quantity</th>
              <th>Desc</th>
              <th>Status</th>
              <th>Customer Code</th>
              <th width="50px;"></th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
  </div>
  <!-- datatable ends -->
</div>

@push('script_js')
<script type="text/javascript">
  jQuery(document).ready(function($) {
    $('.btn-back').click(function(event) {
      /* Act on the event */
      $('#form-search-manifest').removeClass('hide');
      $('.form-update-manifest-wrapper').addClass('hide');
    });
  });
</script>
@endpush