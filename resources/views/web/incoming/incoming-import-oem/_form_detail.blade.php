<form class="form-table" id="form-incoming-import-oem-detail">
  <table width="100%">
    <tr>
      <td>Model</td>
      <td>
        <div class="input-field col s12">
          <select name="model" required="" class="select2-data-ajax browser-default">
          </select>
        </div>
      </td>
    </tr>
  </table>
  <br>
  <table width="100%">
    <tr>
      <td>Description</td>
      <td>
        <div class="input-field col s12">
          <input type="text" class="validate" name="description">
        </div>
      </td>
    </tr>
    <tr>
      <td colspan="2">
        <table>
          <tr>
            <td>Qty</td>
            <td>
              <div class="input-field col s12">
                <input type="text" class="validate" name="qty" required>
              </div>
            </td>
            <td>CBM</td>
            <td>
              <div class="input-field col s12">
                <input type="text" class="validate" name="cbm" readonly>
              </div>
            </td>
            <td>Total CBM</td>
            <td>
              <div class="input-field col s12">
                <input type="text" class="validate" name="total_cbm" readonly>
              </div>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td>No. GR SAP</td>
      <td>
        <div class="input-field col s12">
          <input type="text" class="validate" disabled="">
        </div>
      </td>
    </tr>
    <tr>
      <td>Storage Location</td>
      <td>
        <div class="input-field col s12">
          <select name="storage_id" required="" class="select2-data-ajax browser-default">
          </select>
        </div>
      </td>
    </tr>
  </table>
</form>

@push('script_js')
<script type="text/javascript">
   jQuery(document).ready(function($) {

      // Loading Expedition Data
      $('#form-incoming-import-oem-detail [name="model"]').select2({
         placeholder: '-- Select Model --',
         ajax: get_select2_ajax_options('/master-model/select2-model')
      });

      $('#form-incoming-import-oem-detail [name="storage_id"]').select2({
         placeholder: '-- Select Storage Location --',
         ajax: get_select2_ajax_options('/storage-master/select2-sto-type')
      });

   });

   $('#form-incoming-import-oem-detail [name="model"]').change(function(event) {
     /* Act on the event */
     var data = $(this).select2('data')[0];
     $('#form-incoming-import-oem-detail [name="description"]').val(data.description);
     $('#form-incoming-import-oem-detail [name="cbm"]').val(data.cbm);
   });
   $('#form-incoming-import-oem-detail [name="qty"]').keyup(function(event) {
     var cbm = $('#form-incoming-import-oem-detail [name="cbm"]').val();
     var total_cbm = 0;
     total_cbm = $(this).val()*cbm;
     $('#form-incoming-import-oem-detail [name="total_cbm"]').val(total_cbm);
   });
</script>
@endpush