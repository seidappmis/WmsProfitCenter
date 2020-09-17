<form class="form-table hide" id="form-incoming-import-oem-detail">
  <table width="100%">
    <tr>
      <td width="50%">Model</td>
      <td>
        <div class="input-field col s12">
          <input type="hidden" name="arrival_no_header" value="{{$incomingManualHeader->arrival_no}}">
          <input type="hidden" name="id">
          <input type="hidden" name="model">
          <select name="model_id" required="" class="select2-data-ajax browser-default">
            <option value=""></option>
          </select>
        </div>
      </td>
    </tr>
  </table>
  <br>
  <table width="100%">
    <tr>
      <td width="50%">Description</td>
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
                <input type="number" class="validate" name="qty" min="1" required>
              </div>
            </td>
            <td>CBM</td>
            <td>
              <div class="input-field col s12">
                <input type="text" class="validate" name="cbm" readonly="readonly">
              </div>
            </td>
            <td>Total CBM</td>
            <td>
              <div class="input-field col s12">
                <input type="text" class="validate" name="total_cbm" readonly="readonly">
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
          <input type="text" class="validate" readonly="readonly" name="no_gr_sap" value="{{$incomingManualHeader->no_gr_sap}}">
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
    @if($incomingManualHeader->inc_type == "OTHERS")
    <tr>
      <td>
        <div class="file-field input-field">
          <div class="btn btn-sm">
            <span>Browse</span>
            <input type="file" name="file-serial-number">
          </div>
          <div class="file-path-wrapper">
            <input class="file-path validate" type="text" placeholder="Select file Serial Number ..">
            File Format: csv
          </div>
        </div>
      </td>
    </tr>
    @endif
  </table>
  {!! get_button_save('Save', 'btn-save mt-1') !!}
</form>

@push('script_js')
<script type="text/javascript">
   jQuery(document).ready(function($) {

      // Loading Expedition Data
      $('#form-incoming-import-oem-detail [name="model_id"]').select2({
         placeholder: '-- Select Model --',
         ajax: get_select2_ajax_options('/master-model/select2-model')
      });

      $('#form-incoming-import-oem-detail [name="storage_id"]').select2({
         placeholder: '-- Select Storage Location --',
         ajax: get_select2_ajax_options('/storage-master/select2-storage', {sto_type_id: [1,2]})
      });

   });

   $('#form-incoming-import-oem-detail [name="model_id"]').change(function(event) {
     /* Act on the event */
     var data = $(this).select2('data')[0];
     $('#form-incoming-import-oem-detail [name="model"]').val(data.model_name);
     $('#form-incoming-import-oem-detail [name="description"]').val(data.description);
     $('#form-incoming-import-oem-detail [name="cbm"]').val(data.cbm);
   });
   $('#form-incoming-import-oem-detail [name="qty"]').keyup(function(event) {
     countTotalCbm(this)
   });

   $('#form-incoming-import-oem-detail [name="qty"]').change(function(event) {
     countTotalCbm(this)
   });

   function countTotalCbm(ths){
    var cbm = $('#form-incoming-import-oem-detail [name="cbm"]').val();
     var total_cbm = 0;
     total_cbm = ($(ths).val()*cbm).toFixed(3);
     $('#form-incoming-import-oem-detail [name="total_cbm"]').val(total_cbm);
   }
</script>
@endpush