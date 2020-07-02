<form class="form-table" id="form-branch-master-driver">
    @if(!empty($branchDriver))
     @method('PUT')
     @endif
    <table>
        <tr>
            <td>Expedition</td>
            <td>
                <div class="input-field col s12">
                    <select name="expedition_code" class="select2-data-ajax browser-default" required onchange="checkExpeditionValue()">
                    </select>
                </div>
            </td>
        </tr>
    </table>
    <!-- Detail Table -->
    <table class="mt-1" id="form-driver-wrapper" style="display: none;">
        <tr>
            <td width="20%" class="label">Driver ID</td>
            <td>
                <div class="input-field col s12">
                    <input name="driver_id" id="driver_id" type="text" class="validate" value="{{old('driver_id', !empty($branchDriver) ? $branchDriver->driver_id : '')}}" required disabled>
                </div>
            </td>
            <td width="30%" rowspan="11" class="center-align">
                <div class="col s12">
                    @if(!empty($branchDriver))
                    <img src="{{Storage::url('Photo/'. $branchDriver->photo_name)}}" style="max-width: 80%;">
                    @endif
                    <p>Maximum upload size 2MB.</p>
                    <br>
                    <input type="file" id="input-file-now" class="dropify" name="photo_name" data-default-file="{{asset('images/profil.png')}}" data-height="350" />
                </div>
            </td>
        </tr>
        <tr>
            <td class="label">Driver Name</td>
            <td>
                <div class="input-field col s12">
                    <input name="driver_name" id="name" type="text" class="validate" value="{{old('driver_name', !empty($branchDriver) ? $branchDriver->driver_name : '')}}">
                </div>
            </td>
        </tr>
        <tr>
            <td class="label">Driving License Type</td>
            <td>
                <div class="input-field col s12">
                    <select name="driving_license_type">
                        <option value="">-- Select Type --</option>
                        <option>SIM A</option>
                        <option>SIM B</option>
                        <option>SIM B1</option>
                        <option>SIM B2</option>
                    </select>
                </div>
            </td>
        </tr>
        <tr>
            <td class="label">Driving license No.</td>
            <td>
                <div class="input-field col s12">
                    <input name="driving_license_no" id="number" type="text" class="validate" required value="{{old('driving_license_no', !empty($branchDriver) ? $branchDriver->driving_license_no : '')}}">
                </div>
            </td>
        </tr>
        <tr>
            <td class="label">ID (KTP) No.</td>
            <td>
                <div class="input-field col s12">
                    <input name="ktp_no" id="ktp_id" type="text" class="validate" value="{{old('ktp_no', !empty($branchDriver) ? $branchDriver->ktp_no : '')}}">
                </div>
            </td>
        </tr>
        <tr>
            <td class="label">Phone 1</td>
            <td>
                <div class="input-field col s12">
                    <input name="phone1" id="phone" type="text" class="validate" value="{{old('phone1', !empty($branchDriver) ? $branchDriver->phone1 : '')}}">
                </div>
            </td>
        </tr>
        <tr>
            <td class="label">Phone 2</td>
            <td>
                <div class="input-field col s12">
                    <input name="phone2" type="text" class="validate" value="{{old('phone2', !empty($branchDriver) ? $branchDriver->phone2 : '')}}">
                </div>
            </td>
        </tr>
        <tr>
            <td class="label">Remarks 1</td>
            <td>
                <div class="input-field col s12">
                    <input id="remarks" type="text" class="validate" name="remarks1" value="{{old('remarks1', !empty($branchDriver) ? $branchDriver->remarks1 : '')}}">
                </div>
            </td>
        </tr>
        <tr>
            <td class="label">Remarks 2</td>
            <td>
                <div class="input-field col s12">
                    <input id="remarks" type="text" class="validate" name="remarks2" value="{{old('remarks2', !empty($branchDriver) ? $branchDriver->remarks2 : '')}}">
                </div>
            </td>
        </tr>
        <tr>
            <td class="label">Remarks 3</td>
            <td>
                <div class="input-field col s12">
                    <input id="remarks" type="text" class="validate" name="remarks3" value="{{old('remarks3', !empty($branchDriver) ? $branchDriver->remarks3 : '')}}">
                </div>
            </td>
        </tr>
        <tr>
            <td class="label">Active</td>
            <td>
                <div class="input-field col s12 mt-2">
                    <p>
                        <label>
                            <input name="active_status" type="checkbox" class="filled-in"  {{!empty($branchDriver) && $branchDriver->active_status ? 'checked' : ''}} />
                            <span></span>
                        </label>
                    </p>
                </div>
            </td>
        </tr>
    </table>
    {!! get_button_save() !!}
    {!! get_button_cancel(url('branch-master-driver'), 'Back') !!}
</form>
@push('script_js')
<script type="text/javascript">
   jQuery(document).ready(function($) {

      // Loading Expedition Data
      $('#form-branch-master-driver [name="expedition_code"]').select2({
         placeholder: '-- Select Expedition --',
         ajax: get_select2_ajax_options('/master-branch-expedition/select2-all-expedition')
      });
   });

   function checkExpeditionValue(){
    if ($('#form-branch-master-driver [name="expedition_code"]').val() !== null) {
        $('#form-driver-wrapper').show();
    } else {
        $('#form-driver-wrapper').hide();
    }
   }
</script>
@endpush