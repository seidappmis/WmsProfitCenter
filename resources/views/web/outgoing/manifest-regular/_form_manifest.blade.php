<form class="form-table" id="form-manifest">
    <input type="hidden" name="driver_register_id" value="{{$lmbHeader->driver_register_id}}">
    <table class="mb-1">
        <tr>
            <td width="30%">Manifest No.</td>
            <td>
                <div class="input-field col s12">
                    <input 
                        type="text" 
                        class="validate" 
                        name="do_manifest_no" 
                        value=""
                        readonly 
                        />
              </div>
            </td>
            <td width="30%">Manifest Date</td>
            <td>
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
            <td width="30%">Vehicle No.</td>
            <td>
                <div class="input-field col s12">
                    <input 
                        type="text" 
                        class="validate" 
                        name="vehicle_number" 
                        value="{{$lmbHeader->vehicle_number}}"
                        readonly 
                        />
              </div>
            </td>
            <td width="30%">Expedition</td>
            <td>
                <div class="input-field col s12">
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
            <td width="30%">Driver Name</td>
            <td>
                <div class="input-field col s12">
                    <input 
                        type="text" 
                        class="validate" 
                        name="driver_name" 
                        value="{{$lmbHeader->driver_name}}"
                        readonly 
                        />
              </div>
            </td>
            <td width="30%">Vehicle Type</td>
            <td>
                <div class="input-field col s12">
                    <input 
                        type="text" 
                        class="validate" 
                        name="vehicle_code_type" 
                        value=""
                        readonly 
                        />
              </div>
            </td>
        </tr>
        <tr>
            <td width="30%">Destination City</td>
            <td>
                <div class="input-field col s12">
                    <input 
                        type="text" 
                        class="validate" 
                        name="picking_no" 
                        value="{{$lmbHeader->destination_name}}"
                        readonly 
                        />
              </div>
            </td>
            <td width="30%">Container No.</td>
            <td>
                <div class="input-field col s12">
                    <input 
                        type="text" 
                        class="validate" 
                        name="container_no" 
                        value=""
                        />
              </div>
            </td>
        </tr>
        <tr>
            <td width="30%">No. Seal</td>
            <td>
                <div class="input-field col s12">
                    <input 
                        type="text" 
                        class="validate" 
                        name="seal_no" 
                        />
              </div>
            </td>
            <td width="30%">Checker</td>
            <td>
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
            <td width="30%">PDO No.</td>
            <td>
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
    {!! get_button_save() !!}
    {!! get_button_cancel(url('manifest-regular'), 'Back') !!}
</form>