<form class="form-table" id="form-master-destination">
    <table>
        <tr>
            <td>Destination Number</td>
            <td>
                <div class="input-field col s12">
                    <input 
                        id="destination_number" 
                        type="text" 
                        class="validate" 
                        name="destination_number" 
                        value="{{old('destination_number', !empty($masterDestination) ? $masterDestination->destination_number : '')}}" 
                        {{!empty($masterDestination) ? 'readonly' : ''}} 
                        required
                        />
              </div>
            </td>
        </tr>
        <tr>
            <td>Description</td>
            <td>
                <div class="input-field col s12">
                    <input 
                        id="description" 
                        type="text" 
                        class="validate" 
                        name="description" 
                        value="{{old('description', !empty($masterDestination) ? $masterDestination->description : '')}}"
                        />
              </div>
            </td>
        </tr>
        <tr>
            <td>Region</td>
            <td>
                <div class="input-field col s12">
                    <input 
                        id="region" 
                        type="text" 
                        class="validate" 
                        name="region" 
                        value="{{old('region', !empty($masterDestination) ? $masterDestination->region : '')}}"
                        required
                        />
              </div>
            </td>
        </tr>
    </table>
    {!! get_button_save() !!}
    {!! get_button_cancel(url('master-destination')) !!}
</form>