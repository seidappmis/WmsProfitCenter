<table>
   <tr>
      <td>Insurance Policy No</td>
      <td colspan="3">
         <input name="insurance_policy_no" type="text" class="validate" required>
      </td>
   </tr>
   <tr>
      <td>Damage Goods Report</td>
      <td colspan="3">
         <select name="dur_dgr_id" class="select2-data-ajax browser-default" required>
         </select>
      </td>
   </tr>
   <tr>
      <td>Vessel Name</td>
      <td colspan="3">
         <!-- <select name="vessel_name" class="select2-data-ajax browser-default" required>
         </select> -->
         <input name="vessel_name" type="text" readonly>
      </td>
   </tr>
   <tr>
      <td>Sailed On</td>
      <td colspan="3">
         <input type="text" name="sailed_on" required>
      </td>
   </tr>
   <tr>
      <td>Sailed Date</td>
      <td>
         <input type="text" name="sailed_date" class="datepicker" required>
      </td>
      <td>Arrived Date</td>
      <td>
         <input type="text" name="arrived_date" class="datepicker" required>
      </td>
   </tr>
   <tr>
      <td>Discharging Date</td>
      <td>
         <input type="text" name="discharging_date" class="datepicker" required>
      </td>
      <td>Delivery to the site </td>
      <td>
         <input type="text" name="delivery_date" class="datepicker" required>
      </td>
   </tr>
   <tr>
      <td>Cargo Description </td>
      <td colspan="3">
         <textarea class="materialize-textarea" name="cargo_description" style="resize: vertical;min-height:100px;"></textarea>
      </td>
   </tr>
   <tr>
      <td>Quantity</td>
      <td colspan="3">
         <input type="number" name="qty">
      </td>
   </tr>
</table>

@push('script_js')
<script type="text/javascript">
   $(document).ready(function($) {
      $('[name="dur_dgr_id"]').select2({
         placeholder: '-- Select Damage Goods Report --',
         ajax: get_select2_ajax_options('/marine-cargo/select2-dgr')
      });
      // $('[name="vessel_name"]').select2({
      //    placeholder: '-- Select Vessel --',
      //    ajax: get_select2_ajax_options('/berita-acara-during-select2-kapal')
      // });
   });

   $('[name="dur_dgr_id"]').change(function() {
      var data = $(this).select2('data')[0];

      $('[name="vessel_name"]').val('');
      if (data.ship_name) {
         $('[name="vessel_name"]').val(data.ship_name)
      }
   });
</script>
@endpush