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
              <td width="18%">Manifest No.</td>
              <td>
                <div class="input-field col s8">
                  <input type="text" class="validate" name="do_manifest_no" readonly="">
                </div>
                <div class="input-field col s4">
                  <span id="manifest_type"></span>
                </div>
              </td>
              <td width="18%">Manifest Date</td>
              <td><div class="input-field col s12"><input type="text" class="validate" name="do_manifest_date" disabled></div></td>
            </tr>
            <tr>
              <td width="18%">Vehicle No.</td>
              <td><div class="input-field col s12"><input type="text" class="validate" name="vehicle_number" required=""></div></td>
              <td width="18%">Expedition</td>
              <td>
                <div class="input-field col s12">
                  <input type="text" class="validate text-expedition_name"  disabled>
                  <select name="expedition_code" class="select2-data-ajax browser-default" required="">
                  </select>
                  <input type="hidden" name="expedition_name">
                </div>
              </td>
            </tr>
            <tr>
              <td width="18%">Driver Name</td>
              <td><div class="input-field col s12"><input type="text" class="validate" name="driver_name" disabled></div></td>
              <td width="18%">Vehicle Type</td>
              <td><div class="input-field col s12">
                <input type="text" class="validate" name="text_vehicle_description" disabled>
                <input type="hidden" name="vehicle_description">
                  <select name="vehicle_code_type" class="select2-data-ajax browser-default" required="">
                  </select>
              </div></td>
            </tr>
            <tr>
              <td width="18%">Destination City</td>
              <td>
                <div class="input-field col s12">
                  <input type="text" class="validate" name="destination_name_driver" disabled>
                   <select name="city_code" class="select2-data-ajax browser-default" required>
                  </select>
                  <input type="hidden" name="city_name" value="">
                </div>
              </td>
              <td width="18%">Container No</td>
              <td><div class="input-field col s12"><input type="text" class="validate" name="container_no"></div></td>
            </tr>
            <tr>
              <td width="18%">Seal No.</td>
              <td><div class="input-field col s12"><input type="text" class="validate" name="seal_no"></div></td>
              <td width="18%">Checker</td>
              <td><div class="input-field col s12"><input type="text" class="validate" name="checker"></div></td>
            </tr>
            <tr>
              <td width="18%">PDO No.</td>
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

  {{-- Load Modal Print --}}
@include('layouts.materialize.components.modal-print', [
  'title' => 'Print Manifest',
  'url' => '#',
  'trigger' => '.btn-print'
  ])

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