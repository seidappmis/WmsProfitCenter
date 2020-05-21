<form class="form-table" id="form-master-driver">
    @method('PUT')
    <table>
        <tr>
            <td>Expedition</td>
            <td>
                <div class="input-field  col s12">
                    <select name="expedition_code" 
                    class="select2-data-ajax browser-default" required onchange="checkExpeditionValue()">   
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
                    <input id="driver_id" 
                        type="text" 
                        class="validate"
                        name="driver_id"
                        >
                </div>
            </td>
            <td width="30%" rowspan="11" class="center-align">
                <div class="col s12">
                  <p>Maximum upload size 2MB.</p>
                  <br>
                  <input type="file" 
                  id="photo_name" class="dropify" 
                  name="photo_name" 
                  data-default-file="" 
                  data-height="350"/>
                </div>
            </td>
        </tr>
        <tr>
            <td class="label">Driver Name</td>
            <td>
                <div class="input-field col s12">
                    <input id="driver_name" 
                    type="text" 
                    class="validate"
                    name="driver_name">
                </div>
            </td>
        </tr>
        <tr>
            <td class="label">Driving License Type</td>
            <td>
                <div class="input-field col s12">
                    <select name="driving_lisence_type" required>
                        <option value="" disabled {{empty($masterDriver) ? 'selected' : ''}}>-- Driving License Type --</option>
                        <option value="1"{{!empty($masterDriver) && $masterDriver->driving_lisence_type == 1 ? 'selected' : ''}}>SIM A</option>
                        <option value="2"{{!empty($masterDriver) && $masterDriver->driving_lisence_type == 2 ? 'selected' : ''}}>SIM B</option>
                        <option value="3"{{!empty($masterDriver) && $masterDriver->driving_lisence_type == 3 ? 'selected' : ''}}>SIM B1</option>
                    </select>
                    {{-- <select>
                        <option value="" disabled selected>-- Select Type --</option>
                        <option value="1">SIM A</option>
                        <option value="2">SIM B</option>
                        <option value="3">SIM B1</option>
                    </select> --}}
                </div>
            </td>
        </tr>
        <tr>
            <td class="label">Driving Lisence No.</td>
            <td>
                <div class="input-field col s12">
                    <input id="driving_lisence_number" 
                    type="text" 
                    class="validate" 
                    name="driving_lisence_number"
                    value="{{old('driving_lisence_number', !empty($masterDriver) ? $masterDriver->driving_lisence_number : '')}}" 
                    {{!empty($masterDriver) ? 'readonly' : ''}} 
                    required>
                </div>
            </td>
        </tr>
        <tr>
            <td class="label">ID (KTP) No.</td>
            <td>
                <div class="input-field col s12">
                    <input id="ktp_no" 
                    type="text" 
                    class="validate"
                    name="ktp_no"
                    value="{{old('ktp_no', !empty($masterDriver) ? $masterDriver->ktp_no : '')}}" 
                    {{!empty($masterDriver) ? 'readonly' : ''}} 
                    required>
                    >
                </div>
            </td>
        </tr>
        <tr>
            <td class="label">Phone 1</td>
            <td>
                <div class="input-field col s12">
                    <input id="phone1" 
                    type="text" 
                    class="validate"
                    name="phone1"
                    value="{{old('phone1', !empty($masterDriver) ? $masterDriver->phone1 : '')}}" 
                    {{!empty($masterDriver) ? 'readonly' : ''}} 
                    required>
                </div>
            </td>
        </tr>
        <tr>
            <td class="label">Phone 2</td>
            <td>
                <div class="input-field col s12">
                    <div class="input-field col s12">
                    <input id="phone2" 
                    type="text" 
                    class="validate"
                    name="phone2"
                    value="{{old('phone2', !empty($masterDriver) ? $masterDriver->phone2 : '')}}" 
                    {{!empty($masterDriver) ? 'readonly' : ''}} 
                    required
                        >
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td class="label">Remarks 1</td>
            <td>
                <div class="input-field col s12">
                    <input id="remarks1" 
                    type="text" 
                    class="validate" 
                    name="remarks1"
                    value="{{old('remarks1', !empty($masterDriver) ? $masterDriver->remarks1 : '')}}" 
                    {{!empty($masterDriver) ? 'readonly' : ''}} 
                    required>
                </div>
            </td>
        </tr>
        <tr>
            <td class="label">Remarks 2</td>
            <td>
                <div class="input-field col s12">
                   <input id="remarks2" 
                   type="text"
                    class="validate" 
                    name="value="{{old('remarks2', !empty($masterDriver) ? $masterDriver->remarks2 : '')}}" 
                    {{!empty($masterDriver) ? 'readonly' : ''}} 
                    required>">
                </div>
            </td>
        </tr>
        <tr>
            <td class="label">Remarks 3</td>
            <td>
                <div class="input-field col s12">
                   <input id="remarks3" 
                   type="text" 
                   class="validate" 
                   name="remarks3"
                   value="{{old('remarks3', !empty($masterDriver) ? $masterDriver->remarks3 : '')}}" 
                    {{!empty($masterDriver) ? 'readonly' : ''}} 
                    required>>
                </div>
            </td>
        </tr>
        <tr>
            <td class="label">Active</td>
            <td>
                <div class="input-field col s12 mt-2">
                  <p>
                  <label>
                    <input type="checkbox" class="filled-in" checked="checked" name="status_active"
                    {{!empty($masterDriver) && $masterDriver->status_active ? 'checked' : ''}}/>
                    <span></span>
                  </label>
                  </p>
                </div>
            </td>
        </tr>
    </table>
  
    {!! get_button_save() !!}
    {!! get_button_cancel(url('master-driver')) !!}
</form>
@push('script_js')
<script type="text/javascript">
   jQuery(document).ready(function($) {
      // Loading area data
    //   $('.select-code').select2({
    //      placeholder: '-- Select --',
    //      ajax: get_select2_ajax_options('/master-expedition/select2-master_expedition')
    //   });
    $('#form-master-driver [expedition_name="expedition_code"]').select2({
         placeholder: '-- Select Expedition --',
         ajax: get_select2_ajax_options('/master-expedition/select2-all-expedition')
      });
   });
   function checkExpeditionValue(){
    if ($('#form-master-driver [expedition_name="expedition_code"]').val() !== null) {
        $('#form-driver-wrapper').show();
    } else {
        $('#form-driver-wrapper').hide();
    }
   }
</script>
@endpush