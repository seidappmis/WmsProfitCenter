<form class="form-table">
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
                <input id="stnk_number" type="text" class="validate" name="stnk_number">
              </div>
            </td>
        </tr>
        <tr>
            <td>Remarks 1</td>
            <td>
                <div class="input-field col s12">
                <input id="remaks1" type="number" class="validate" name="remaks1">
              </div>
            </td>
        </tr>
        <tr>
            <td>Remarks 2</td>
            <td>
                <div class="input-field col s12">
                <input id="remaks2" type="number" class="validate" name="remaks2">
              </div>
            </td>
        </tr>
        <tr>
            <td>ACTIVE</td>
            <td>
                <div class="input-field col s12 mt-2">
                  <p>
                      <label>
                        <input type="checkbox" class="filled-in" name="status_active" {{!empty($masterExpedition) && $masterExpedition->status_active ? 'checked' : ''}} />
                        <span></span>
                      </label>
                    </p>
                </div>
              </td>
        </tr>
    </table>
    {!! get_button_save() !!}
    {!! get_button_cancel(url('master-vehicle-expedition')) !!}
</form>