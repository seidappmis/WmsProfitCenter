<form class="form-table" id="form-destination-city">
    <table>
        <tr>
            <td>City Code</td>
            <td>
                <div class="input-field col s12">
                    <input 
                        id="city_code" 
                        type="text" 
                        class="validate" 
                        name="city_code" 
                        value="{{old('city_code', !empty($destinationCity) ? $destinationCity->city_code : '')}}" 
                        {{!empty($destinationCity) ? 'readonly' : ''}} 
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
                        id="city_name" 
                        type="text" 
                        class="validate" 
                        name="city_name" 
                        value="{{old('city_name', !empty($destinationCity) ? $destinationCity->city_name : '')}}"
                        />
              </div>
            </td>
        </tr>
    </table>
    {!! get_button_save() !!}
    {!! get_button_cancel(url('destination-city')) !!}
</form>