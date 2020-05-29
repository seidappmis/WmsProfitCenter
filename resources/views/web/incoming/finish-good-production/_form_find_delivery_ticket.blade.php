<form class="form-table" id="form-find-delivery-ticket">
    <table>
        <tr>
            <td>Choose Plant</td>
            <td>
               <div class="input-field col s12">
                <select id="category"
                  name="category"
                  class="select2-data-ajax browser-default select-category" required>
                <option></option>
               </div>  
            </td>
        </tr>
        <tr>
            <td>Delivery Ticket</td>
            <td>
               <div class="input-field col s12">
                <input id="delivery" type="text" class="validate" name="delivery" required>
              </div> 
            </td>
        </tr>
        <tr>
            <td>Choose Type</td>
            <td>
                <div class="input-field col s12 m4">
                <select id="model_type"
                  name="model_type"
                  class="select2-data-ajax browser-default select-model-type" required>
                <option></option>
                </select>
                </div>
                <div class="input-field col s12 m1"></div>
                <div class="input-field col s12 m7">
                    <button type="submit" class="waves-effect waves-light indigo btn-small btn mt-2">Search Delivery Ticket</button>
                </div>
            </td>
        </tr>
    </table>
</form>

@push('script_js')
<script type="text/javascript">
   jQuery(document).ready(function($) {
      // Choose Plant
      $('.select-category').select2({
         placeholder: '-- Select Plant--',
         ajax: get_select2_ajax_options('/master-model/select2-category')
      });

      // Choose Type
      $('.select-model-type').select2({
         placeholder: '-- Select Type--',
         allowClear: true,
         ajax: get_select2_ajax_options('/master-model/select2-model-type')
      });
   });
</script>
@endpush