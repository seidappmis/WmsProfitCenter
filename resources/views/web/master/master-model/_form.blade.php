<form class="form-table" id="form-master-model">
  <table>
    <tr>
      <td>Model Name</td>
      <td>
        <div class="input-field col s12">
          <input type="text" id="model_name" name="model_name" class="validate" required>
        </div>
      </td>
    </tr>
    <tr>
      <td>Model From Barcode Prod</td>
      <td>
        <div class="input-field col s12">
          <input type="text" id="model_from_apbar" name="model_from_apbar" required>
        </div>
      </td>
    </tr>
    <tr>
      <td>Ean Code</td>
      <td>
        <div class="input-field col s12">
          <input type="text" id="ean_code" name="ean_code" required>
        </div>
      </td>
    </tr>
    <tr>
      <td>CBM</td>
      <td>
        <div class="input-field col s12">
          <input type="number" id="cbm" name="cbm" required>
        </div>
      </td>
    </tr>
    <tr>
      <td>Material Group</td>
      <td>
        <div class="input-field col s12">
          <select id="material_group"
                  name="material_group"
                  class="select2-data-ajax browser-default select-material-group" required>
            <option></option>
          </select>
        </div>
      </td>
    </tr>
    <tr>
      <td>Category</td>
      <td>
        <div class="input-field col s12">
          <select id="category"
                  name="category"
                  class="select2-data-ajax browser-default select-category" required>
            <option></option>
          </select>
        </div>
      </td>
    </tr>
    <tr>
      <td>Type</td>
      <td>
        <div class="input-field col s12">
          <select id="model_type"
                  name="model_type"
                  class="select2-data-ajax browser-default select-model-type" required>
            <option></option>
          </select>
        </div>
      </td>
    </tr>
    <tr>
      <td>Description</td>
      <td>
        <div class="input-field col s12">
          <input type="text" id="description" name="description">
        </div>
      </td>
    </tr>
    <tr>
      <td>Max Pieces/Carton</td>
      <td>
        <div class="input-field col s12">
          <input type="number" id="pcs_ctn" name="pcs_ctn">
        </div>
      </td>
    </tr>
    <tr>
      <td>Max Carton/Palet</td>
      <td>
        <div class="input-field col s12">
          <input type="number" id="ctn_plt" name="ctn_plt">
        </div>
      </td>
    </tr>
    <tr>
      <td>Palet</td>
      <td>
        <div class="input-field col s12">
          <input type="number" id="max_pallet" name="max_pallet" required>
        </div>
      </td>
    </tr>
    <tr>
      <td>Price 1</td>
      <td>
        <div class="input-field col s12">
          <input placeholder="0" type="number" id="price1" name="price1">
        </div>
      </td>
    </tr>
    <tr>
      <td>Price 2</td>
      <td>
        <div class="input-field col s12">
          <input placeholder="0" type="number" id="price2" name="price2">
        </div>
      </td>
    </tr>
    <tr>
      <td>Price 3</td>
      <td>
        <div class="input-field col s12">
          <input placeholder="0" type="number" id="price3" name="price3">
        </div>
      </td>
    </tr>
  </table>
  {!! get_button_save() !!}
  {!! get_button_cancel(url('master-model')) !!}
</form>

@push('script_js')
<script type="text/javascript">
   jQuery(document).ready(function($) {
      // Loading material group data
      $('.select-material-group').select2({
         placeholder: '-- Select Material Group--',
      });

      // Loading category data
      $('.select-category').select2({
         placeholder: '-- Select Category--',
      });

      // Loading model type data
      $('.select-model-type').select2({
         placeholder: '-- Select Category--',
      });
   });
</script>
@endpush