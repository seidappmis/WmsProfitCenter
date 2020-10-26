<form class="form-table" id="form-master-model">
  <table>
    <tr>
      <td>Model Name</td>
      <td>
        <div class="input-field col s12">
          <input type="text" id="model_name" name="model_name" class="validate" value="{{old('model_name', !empty($masterModel) ? $masterModel->model_name : '')}}" required>
        </div>
      </td>
    </tr>
    <tr>
      <td>Model From Barcode Prod</td>
      <td>
        <div class="input-field col s12">
          <input type="text" id="model_from_apbar" name="model_from_apbar" value="{{old('model_from_apbar', !empty($masterModel) ? $masterModel->model_from_apbar : '')}}" required>
        </div>
      </td>
    </tr>
    <tr>
      <td>Ean Code</td>
      <td>
        <div class="input-field col s12">
          <input type="text" id="ean_code" name="ean_code" value="{{old('ean_code', !empty($masterModel) ? $masterModel->ean_code : '')}}" required>
        </div>
      </td>
    </tr>
    <tr>
      <td>CBM</td>
      <td>
        <div class="input-field col s12">
          <input type="text" id="cbm" name="cbm" value="{{old('cbm', !empty($masterModel) ? $masterModel->cbm : '')}}" required autocomplete="off">
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
          <input type="text" id="description" name="description" value="{{old('description', !empty($masterModel) ? $masterModel->description : '')}}">
        </div>
      </td>
    </tr>
    <tr>
      <td>Max Pieces/Carton</td>
      <td>
        <div class="input-field col s12">
          <input type="number" id="pcs_ctn" name="pcs_ctn" value="{{old('pcs_ctn', !empty($masterModel) ? $masterModel->pcs_ctn : '')}}">
        </div>
      </td>
    </tr>
    <tr>
      <td>Max Carton/Palet</td>
      <td>
        <div class="input-field col s12">
          <input type="number" id="ctn_plt" name="ctn_plt" value="{{old('ctn_plt', !empty($masterModel) ? $masterModel->ctn_plt : '')}}">
        </div>
      </td>
    </tr>
    <tr>
      <td>Palet</td>
      <td>
        <div class="input-field col s12">
          <input type="number" id="max_pallet" name="max_pallet" value="{{old('max_pallet', !empty($masterModel) ? $masterModel->max_pallet : '')}}">
        </div>
      </td>
    </tr>
    <tr>
      <td>Price 1</td>
      <td>
        <div class="input-field col s12">
          <input placeholder="0" type="number" id="price1" name="price1" value="{{old('price1', !empty($masterModel) ? $masterModel->price1 : '')}}">
        </div>
      </td>
    </tr>
    <tr>
      <td>Price 2</td>
      <td>
        <div class="input-field col s12">
          <input placeholder="0" type="number" id="price2" name="price2" value="{{old('price2', !empty($masterModel) ? $masterModel->price2 : '')}}">
        </div>
      </td>
    </tr>
    <tr>
      <td>Price 3</td>
      <td>
        <div class="input-field col s12">
          <input placeholder="0" type="number" id="price3" name="price3" value="{{old('price3', !empty($masterModel) ? $masterModel->price3 : '')}}">
        </div>
      </td>
    </tr>
    <tr>
      <td>Price Carton Box</td>
      <td>
        <div class="input-field col s12">
          <input placeholder="0" type="number" id="price_carton_box" name="price_carton_box" value="{{old('price_carton_box', !empty($masterModel) ? $masterModel->price_carton_box : '')}}">
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
         ajax: get_select2_ajax_options('/master-model/select2-material-group')
      });

      // Loading category data
      $('.select-category').select2({
         placeholder: '-- Select Category--',
         ajax: get_select2_ajax_options('/master-model/select2-category')
      });

      // Loading model type data
      $('.select-model-type').select2({
         placeholder: '-- Select Category--',
         ajax: get_select2_ajax_options('/master-model/select2-model-type')
      });

      $('#cbm').inputmask('cbm_mask');

   });
</script>
@endpush