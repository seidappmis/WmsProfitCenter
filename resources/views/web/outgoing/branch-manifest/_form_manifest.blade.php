<form class="form-table" id="form-manifest">
    <input type="hidden" name="driver_register_id" value="{{$lmbHeader->driver_register_id}}">
    <table class="mb-1">
        <tr>
            <td width="20%">Manifest No.</td>
            <td width="30%">
                <div class="input-field col s8">
                    <input 
                        type="text" 
                        class="validate" 
                        name="do_manifest_no" 
                        value="{{!empty($manifestHeader) ? $manifestHeader->do_manifest_no : ''}}"
                        readonly 
                        />
              </div>
              <div class="col s4 mt-3">{{!empty($manifestHeader) ? $manifestHeader->manifest_type : ''}}</div>
            </td>
            <td width="20%">Manifest Date</td>
            <td width="30%">
                <div class="input-field col s12">
                    <input 
                        type="text" 
                        class="validate" 
                        name="do_manifest_date" 
                        value="{{date('Y-m-d')}}"
                        readonly 
                        />
              </div>
            </td>
        </tr>
        <tr>
            <td width="20%">Vehicle No.</td>
            <td width="30%">
                <div class="input-field col s12">
                    <input 
                        type="text" 
                        class="validate" 
                        name="vehicle_number" 
                        value="{{$lmbHeader->vehicle_number}}"
                        readonly 
                        required="" 
                        />
              </div>
            </td>
            <td width="20%">Expedition</td>
            <td width="30%">
                <div class="input-field col s12">
                    <input type="hidden" name="expedition_code" value="{{$lmbHeader->expedition_code}}">
                    <input 
                        type="text" 
                        class="validate" 
                        name="expedition_name" 
                        value="{{$lmbHeader->expedition_name}}"
                        readonly 
                        />
              </div>
            </td>
        </tr>
        <tr>
            <td width="20%">Driver Name</td>
            <td width="30%">
                <div class="input-field col s12">
                    <input type="hidden" name="driver_id" value="{{$lmbHeader->driver_id}}">
                    <input 
                        type="text" 
                        class="validate" 
                        name="driver_name" 
                        value="{{$lmbHeader->driver_name}}"
                        readonly 
                        />
              </div>
            </td>
            <td width="20%">Vehicle Type</td>
            <td width="30%">
                <div class="input-field col s12">
                    <input 
                        type="hidden" 
                        class="validate" 
                        name="vehicle_code_type" 
                        value="{{$lmbHeader->picking->vehicle_code_type}}"
                        readonly 
                        />
                        <input 
                        type="text" 
                        class="validate" 
                        name="vehicle_description" 
                        value="{{$lmbHeader->picking->vehicle->vehicle_description}}"
                        readonly 
                        />
              </div>
            </td>
        </tr>
        <tr>
            <td width="20%">Destination City</td>
            <td width="30%">
                <div class="input-field col s12">
                    <input 
                        type="hidden" 
                        class="validate" 
                        name="destination_number_driver" 
                        value="{{$lmbHeader->destination_number}}"
                        readonly 
                        />
                    <input 
                        type="text" 
                        class="validate" 
                        name="destination_name_driver" 
                        value="{{$lmbHeader->destination_name}}"
                        readonly 
                        />
                    <select name="city_code" class="select2-data-ajax browser-default" required>
                    </select>
                    <input type="hidden" name="city_name" value="{{ !empty($pickinglistHeader->city_name) ? $pickinglistHeader->city_name : '' }}">
              </div>
            </td>
            <td width="20%">Container No.</td>
            <td width="30%">
                <div class="input-field col s12">
                    <input 
                        type="text" 
                        class="validate" 
                        name="container_no" 
                        value="{{$lmbHeader->container_no}}"
                        />
              </div>
            </td>
        </tr>
        <tr>
            <td width="20%">No. Seal</td>
            <td width="30%">
                <div class="input-field col s12">
                    <input 
                        type="text" 
                        class="validate" 
                        name="seal_no" 
                        value="{{$lmbHeader->seal_no}}"
                        />
              </div>
            </td>
            <td width="20%">Checker</td>
            <td width="30%">
                <div class="input-field col s12">
                    <input 
                        type="text" 
                        class="validate" 
                        name="checker" 
                        />
              </div>
            </td>
        </tr>
        <tr>
            <td width="20%">PDO No.</td>
            <td width="30%">
                <div class="input-field col s12">
                    <input 
                        type="text" 
                        class="validate" 
                        name="pdo_no" 
                        />
              </div>
            </td>
            <td colspan="2"></td>
        </tr>
    </table>
    {!! get_button_save('Save', 'btn-save') !!}
    {!! get_button_delete() !!}
    {!! get_button_print() !!}
    {!! get_button_cancel(url('manifest-regular'), 'Back', '') !!}
</form>

@push('script_js')
<script type="text/javascript">
    jQuery(document).ready(function($) {
      $('#form-manifest [name="city_code"]').select2({
        placeholder: '-- Select Destination City --',
        allowClear: true,
        ajax: get_select2_ajax_options('/master-expedition/select2-expedition-destination-city', {expedition_code: '{{$lmbHeader->expedition_code}}'})
      })

        $('#form-manifest [name="city_code"]').change(function(event) {
            var data = $(this).select2('data')[0];
          $('#form-manifest [name="city_name"]').val(data == undefined ? '' : data.text);
        });
    });
</script>
@endpush