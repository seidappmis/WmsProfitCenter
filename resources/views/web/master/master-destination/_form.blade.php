<form class="form-table" id="form-master-destination">
    <table>
        <tr>
            <td>City Code</td>
            <td>
                <div class="input-field col s12">
                    <input 
                        id="destination_number" 
                        type="text" 
                        class="validate" 
                        name="destination_number" 
                        value="{{old('destination_number', !empty($masterDestination) ? $masterdestination->destination_number : '')}}" 
                        {{!empty($masterDestination) ? 'readonly' : ''}} 
                        required
                        />
              </div>
            </td>
        </tr>
        <tr>
            <td>City Name</td>
            <td>
                <div class="input-field col s12">
                    <input 
                        id="description" 
                        type="text" 
                        class="validate" 
                        name="description" 
                        value="{{old('city_name', !empty($masterDestination) ? $masterDestination->description : '')}}"
                        />
              </div>
            </td>
        </tr>
        <tr>
            <td>Cabang</td>
            <td>
                <div class="input-field col s12">
                    <input 
                        id="region" 
                        type="text" 
                        class="validate" 
                        name="region" 
                        value="{{old('region', !empty($masterDestination) ? $masterDestination->region : '')}}" 
                        {{!empty($masterDestination) ? 'readonly' : ''}} 
                        required
                        />
              </div>
            </td>
        </tr>
    </table>
    {!! get_button_save() !!}
    {!! get_button_cancel(url('master-destination')) !!}
</form>