<form class="form-table" id="form-branch-expedition-vehicle">
    <h4 class="card-title">New Vehicle Expedition</h4>
    <table>
        <tr>
            <td>Expedition</td>
            <td>
                <div class="input-field col s12">
                    <select name="expedition_code" class="select2-data-ajax browser-default" required>
                    </select>
                </div>
            </td>
        </tr>
        <tr>
            <td>Vehicle No.</td>
            <td>
                <div class="input-field col s12">
                    <input id="no" type="text" class="validate" name="vehicle_number" required value="{{old('vehicle_number', !empty($branchExpeditionVehicle) ? $branchExpeditionVehicle->vehicle_number : '')}}">
                </div>
            </td>
        </tr>
        <tr>
            <td>Vehicle Type</td>
            <td>
                <div class="input-field col s12">
                    <select name="vehicle_code_type" class="select2-data-ajax browser-default" required>
                    </select>
                </div>
            </td>
        </tr>
        <tr>
            <td>Destination</td>
            <td>
                <div class="input-field col s12">
                    <select name="destination" class="select2-data-ajax browser-default">
                    </select>
                </div>
            </td>
        </tr>
        <tr>
            <td>Description</td>
            <td>
                <div class="input-field col s12">
                    <input name="vehicle_detail_description" id="description" type="text" class="validate" value="{{old('vehicle_detail_description', !empty($branchExpeditionVehicle) ? $branchExpeditionVehicle->vehicle_detail_description : '')}}">
                </div>
            </td>
        </tr>
        <tr>
            <td>STNK Number</td>
            <td>
                <div class="input-field col s12">
                    <input name="remark1" id="cp" type="text" class="validate" value="{{old('remark1', !empty($branchExpeditionVehicle) ? $branchExpeditionVehicle->remark1 : '')}}">
                </div>
            </td>
        </tr>
        <tr>
            <td>Remarks 1</td>
            <td>
                <div class="input-field col s12">
                    <input name="remark2" id="phone1" type="text" class="validate" value="{{old('remark2', !empty($branchExpeditionVehicle) ? $branchExpeditionVehicle->remark2 : '')}}">
                </div>
            </td>
        </tr>
        <tr>
            <td>Remarks 2</td>
            <td>
                <div class="input-field col s12">
                    <input name="remark3" id="phone2" type="text" class="validate" value="{{old('remark3', !empty($branchExpeditionVehicle) ? $branchExpeditionVehicle->remark3 : '')}}">
                </div>
            </td>
        </tr>
        <tr>
            <td>ACTIVE</td>
            <td>
                <div class="input-field col s12">
                    <p>
                        <label>
                            <input name="status_active" type="checkbox" class="filled-in" {{!empty($branchExpeditionVehicle) && $branchExpeditionVehicle->status_active ? 'checked' : ''}} />
                            <span></span>
                        </label>
                    </p>
                </div>
            </td>
        </tr>
    </table>
    {!! get_button_save() !!}
    {!! get_button_cancel(url('branch-expedition-vehicle')) !!}
</form>
@push('script_js')
<script type="text/javascript">
   jQuery(document).ready(function($) {

      // Loading Expedition Data
      $('#form-branch-expedition-vehicle [name="expedition_code"]').select2({
         placeholder: '-- Select Expedition --',
         ajax: get_select2_ajax_options('/master-branch-expedition/select2-active-expedition')
      });

      $('#form-branch-expedition-vehicle [name="vehicle_code_type"]').select2({
         placeholder: '-- Select Vehicle --',
         ajax: get_select2_ajax_options('/master-vehicle/select2-vehicle')
      });

      $('#form-branch-expedition-vehicle [name="destination"]').select2({
         placeholder: '-- Select Destination --',
         ajax: get_select2_ajax_options('/master-destination/select2-destination')
      });
   });
</script>
@endpush