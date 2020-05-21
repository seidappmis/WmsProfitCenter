<form class="form-table" id="form-master-driver">
    <table>
        <tr>
            <td>Expedition</td>
            <td>
                <div class="input-field select2 col s12">
                    <select id="expedition_name" 
                    class="select2-data-ajax browser-default select-exp" 
                    name="expedition_name"
                    required>
                       <option></option>
                    </select>
              </div>
            </td>
        </tr>
    </table>
    <!-- Detail Table -->
    <div id="detail-driver">
    <table class="mt-1">
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
                  <input type="file" id="photo" class="dropify" name="photo" data-default-file="" data-height="350"/>
                </div>
            </td>
        </tr>
        <tr>
            <td class="label">Driver Name</td>
            <td>
                <div class="input-field col s12">
                    <input id="name" type="text" class="validate">
                </div>
            </td>
        </tr>
        <tr>
            <td class="label">Driving License Type</td>
            <td>
                <div class="input-field col s12">
                    <select>
                        <option value="" disabled selected>-- Select Type --</option>
                        <option value="1">SIM A</option>
                        <option value="2">SIM B</option>
                        <option value="3">SIM B1</option>
                    </select>
                </div>
            </td>
        </tr>
        <tr>
            <td class="label">Driving Lisence No.</td>
            <td>
                <div class="input-field col s12">
                    <input id="number" type="text" class="validate" required>
                </div>
            </td>
        </tr>
        <tr>
            <td class="label">ID (KTP) No.</td>
            <td>
                <div class="input-field col s12">
                    <input id="ktp_id" type="text" class="validate">
                </div>
            </td>
        </tr>
        <tr>
            <td class="label">Phone 1</td>
            <td>
                <div class="input-field col s12">
                    <input id="phone" type="text" class="validate">
                </div>
            </td>
        </tr>
        <tr>
            <td class="label">Phone 2</td>
            <td>
                <div class="input-field col s12">
                    <input id="phone" type="text" class="validate" name="phone2">
                </div>
            </td>
        </tr>
        <tr>
            <td class="label">Remarks 1</td>
            <td>
                <div class="input-field col s12">
                    <input id="remarks" type="text" class="validate" name="remarks1">
                </div>
            </td>
        </tr>
        <tr>
            <td class="label">Remarks 2</td>
            <td>
                <div class="input-field col s12">
                   <input id="remarks" type="text" class="validate" name="remarks2">
                </div>
            </td>
        </tr>
        <tr>
            <td class="label">Remarks 3</td>
            <td>
                <div class="input-field col s12">
                   <input id="remarks" type="text" class="validate" name="remarks3">
                </div>
            </td>
        </tr>
        <tr>
            <td class="label">Active</td>
            <td>
                <div class="input-field col s12 mt-2">
                  <p>
                  <label>
                    <input type="checkbox" class="filled-in" checked="checked" />
                    <span></span>
                  </label>
                  </p>
                </div>
            </td>
        </tr>
    </table>
    </div>
    {!! get_button_save() !!}
    {!! get_button_cancel(url('master-driver')) !!}
</form>
@push('script_js')
<script type="text/javascript">
   jQuery(document).ready(function($) {
      // Loading area data
      $('.select-exp').select2({
         placeholder: '-- Select --',
         ajax: get_select2_ajax_options('/master-expedition/select2-master-expedition','expedition_name')
      });
   });
</script>
@endpush