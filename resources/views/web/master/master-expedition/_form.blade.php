<form class="form-table" id="form-master-expedition">
    <table>
        <tr>
            <td>Code</td>
            <td>
                <div class="input-field col s12">
                    <input 
                        id="code" 
                        type="text" 
                        class="validate" 
                        name="code" 
                        value="{{old('code', !empty($masterExpedition) ? $masterExpedition->code : '')}}" 
                        {{!empty($masterExpedition) ? 'readonly' : ''}} 
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