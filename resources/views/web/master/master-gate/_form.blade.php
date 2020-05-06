<form class="form-table" id="form-master-gate">
   <table>
      <tr>
         <td>Gate Number</td>
         <td>
            <div class="input-field col s12">
               <input id="gate_number" type="number" class="validate" name="gate_number" required>
            </div>
         </td>
      </tr>
      <tr>
	   <td>Description</td>
	   <td>
            <div class="input-field col s12">
               <input id="description" type="text" class="validate" name="description" required>
            </div>
         </td>
      </tr>
      <tr>
         <td>Area</td>
         <td>
            <div class="input-field col s12">
               <select class="select2-data-ajax browser-default select-area" id="area" required>
                  <option></option>
               </select>
            </div>
         </td>
      </tr>
   </table>
   {!! get_button_save() !!}
   {!! get_button_cancel(url('master-gate')) !!}
</form>

@push('script_js')
<script type="text/javascript">
   jQuery(document).ready(function($) {
      // Loading area data
      $('.select-area').select2({
         placeholder: '-- Select --',
         ajax: get_select2_ajax_options('/master-gate/select2-areas')
      });
   });
</script>
@endpush