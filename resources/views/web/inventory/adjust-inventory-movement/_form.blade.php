<form class="form-table" id="form-adjust-inventory-movement">
  <table>
    <tr>
      <td width="20%">BRANCH</td>
      <td>
        <div class="input-field col s12">
          <select name="kode_cabang" class="select2-data-ajax browser-default" required="">
          </select>
        </div>
      </td>
    </tr>
    <tr>
      <td>STORAGE LOCATION</td>
      <td><div class="input-field col s12">
        <select name="sloc" class="select2-data-ajax browser-default" required>
        </select>
      </div></td>
    </tr>
    
    <tr>
      <td>MODEL</td>
      <td><div class="input-field col s12">
        <select name="model" class="select2-data-ajax browser-default" required>
        </select>
        <input type="hidden" name="model_name">
        <input type="hidden" name="ean_code">
        <input type="hidden" name="cbm">
      </div></td>
    </tr>
    <tr>
      <td>AVAILABLE QTY</td>
      <td><div class="input-field col s12">
        <input id="prev_quantity" type="text" class="validate" name="prev_quantity" value="0" readonly="readonly">
      </div></td>
    </tr>
    <tr>
      <td>QTY</td>
      <td>
        <div class="input-field col s12">
          <input id="quantity" type="number" class="validate " name="quantity" required="">
         {{--  <select>
            <option value="" disabled selected>-All-</option>
            <option value="1">JAKARTA-JEMBER</option>
            <option value="2">JAKARTA-KARAWANG</option>
            <option value="3">JAKARTA-KEDIRI</option>
          </select> --}}
        </div>
      </td>
    </tr>
    <tr>
      <td>MOVEMENT TYPE</td>
      <td>
        <div class="input-field col s12">
          <select name="movement_code_type" class="select2-data-ajax browser-default" required="">
            <option value="">-- Select Movement--</option>
            <option value="965" data-type="INCREASE">965 - Adjust plus</option>
            <option value="966" data-type="DECREASE">966 - Adjust minus</option>
            <option value="701" data-type="INCREASE">701 - Adjust Stock Taking plus</option>
            <option value="702" data-type="DECREASE">702 - Adjust Stock Taking minus</option>
          </select>
          <input type="hidden" name="movement_code_type_action">
        </div>
      </td>
    </tr>
    <tr>
      <td>REMARKS</td>
      <td><div class="input-field col s12">
        <textarea id="textarea2" class="materialize-textarea" required></textarea>
      </div></td>
    </tr>
  </table>
  <div class="input-field col s12">
    @if(auth()->user()->allowTo('edit'))
    <button type="submit" class="waves-effect waves-light indigo btn mt-1 mb-1">Submit</button>
    @endif
  </div>
</form>

@push('script_js')
<script type="text/javascript">
  jQuery(document).ready(function($) {
    set_select2_branch()
    set_select2_sloc()
    set_select2_model()
    $('#form-adjust-inventory-movement [name="movement_code_type"]').select2({placeholder: '-- Select Movement --'})
    $('#form-adjust-inventory-movement [name="movement_code_type"]').change(function(event) {
      /* Act on the event */
      var data = $(this).select2('data')[0].element.dataset
      $('#form-adjust-inventory-movement [name="movement_code_type_action"]').val(data.type)
    });
  });

  function set_select2_model(filter = {sloc: null}){
    $('#form-adjust-inventory-movement [name="model"]').select2({
       placeholder: '-- Select Model --',
       ajax: get_select2_ajax_options('/master-model/select2-model-sloc', filter)
    });
    $('#form-adjust-inventory-movement [name="model"]').change(function(event) {
      /* Act on the event */
      var data = $(this).select2('data')[0];
		$('#form-adjust-inventory-movement [name="prev_quantity"]').val(data.quantity_total);
		$('#form-adjust-inventory-movement [name="model_name"]').val(data.model_name);
		$('#form-adjust-inventory-movement [name="ean_code"]').val(data.ean_code);
		$('#form-adjust-inventory-movement [name="cbm"]').val(data.cbm);
    });
  }

  function set_select2_branch(){
    $('#form-adjust-inventory-movement [name="kode_cabang"]').select2({
       placeholder: '-- Select Branch --',
       ajax: get_select2_ajax_options('/master-cabang/select2-grant-cabang')
    });
    $('#form-adjust-inventory-movement [name="kode_cabang"]').change(function(event) {
      /* Act on the event */
      set_select2_sloc({cabang: $(this).val()})
    });
  }
  
  function set_select2_sloc(filter = {cabang: null}){
    $('#form-adjust-inventory-movement [name="sloc"]').select2({
       placeholder: '-- Select Location --',
       ajax: get_select2_ajax_options('/storage-master/select2-storage-cabang', filter)
    });
    $('#form-adjust-inventory-movement [name="sloc"]').change(function(event) {
      /* Act on the event */
      set_select2_model({sloc: $(this).val()});
	  //$('#form-adjust-inventory-movement [name="model"]').trigger('change');
    });
    $('#form-adjust-inventory-movement [name="sloc"]').val('').trigger('change')
  }
</script>
@endpush