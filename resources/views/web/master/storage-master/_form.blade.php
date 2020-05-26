<form class="form-table" id="form-storage-master">
	<table>
		<tr>
			<td>Branch</td>
			<td>
				<div class="input-field col s12">
			    <select id="kode_cabang"
                class="select2-data-ajax browser-default select-branch"
                name="kode_cabang" 
                required>
                    <option></option>
			    </select>
			  </div>
			</td>
		</tr>
		<tr>
			<td>Storage Code</td>
			<td>
				<div class="input-field col s12">
					<input id="sto_loc_code_short" type="text" class="validate" name="sto_loc_code_short"
                    value="{{old('sto_loc_code_short', !empty($storageMaster) ? $storageMaster->sto_loc_code_short : '')}}" required>
			  </div>
			</td>
		</tr>
		<tr>
			<td>Storage Type</td>
			<td>
				<div class="input-field col s12">
			    <select id="sto_type_id"
                class="select2-data-ajax browser-default select-sto-type"
                name="sto_type_id" 
                required>
                    <option></option>
			    </select>
			  </div>
			</td>
		</tr>
		<tr>
			<td>Total Pallate</td>
			<td>
				<div class="input-field col s12">
				    <input id="total_max_pallet" type="number" class="validate" name="total_max_pallet" 
                    value="{{old('total_max_pallet', !empty($storageMaster) ? $storageMaster->total_max_pallet : '')}}" required>
			  </div>
			</td>
		</tr>
		<tr>
			<td>Used Space</td>
			<td>
				<input id="used_space" type="number" class="validate" name="used_space" value="{{old('used_space', !empty($storageMaster) ? $storageMaster->used_space : '')}}">
			</td>
		</tr>
		<tr>
			<td>Space WH</td>
			<td>
				<input id="space_wh" type="number" class="validate" name="space_wh" value="{{old('space_wh', !empty($storageMaster) ? $storageMaster->space_wh : '')}}">
			</td>
		</tr>
		<tr>
			<td>Hand Pallet Space</td>
			<td>
				<input id="hand_pallet_space" type="number" class="validate" name="hand_pallet_space" value="{{old('hand_pallet_space', !empty($storageMaster) ? $storageMaster->hand_pallet_space : '')}}">
			</td>
		</tr>
	</table>
	{!! get_button_save() !!}
    {!! get_button_cancel(url('storage-master')) !!}
</form>

@push('script_js')
<script type="text/javascript">
   jQuery(document).ready(function($) {
      // Loading branch data
      $('.select-branch').select2({
         placeholder: '-- Select --',
         ajax: get_select2_ajax_options('/master-cabang/select2-cabang')
      });

      // Loading storage type data
      $('.select-sto-type').select2({
         placeholder: '-- Select --',
         ajax: get_select2_ajax_options('/storage-master/select2-sto-type')
      });
   });
</script>
@endpush