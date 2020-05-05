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
               <select id="area" required="">
            	<option value="" disabled selected>-- Select --</option>
            	<option value="1">KARAWANG</option>
            	<option value="2">SURABAYA HUB</option>
            	<option value="3">SWADAYA</option>
               </select>
            </div>
         </td>
      </tr>
   </table>
   {!! get_button_save() !!}
   {!! get_button_cancel(url('master-gate')) !!}
</form>