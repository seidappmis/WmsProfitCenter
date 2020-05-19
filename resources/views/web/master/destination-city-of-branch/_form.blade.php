<form class="form-table" id="form-destination-city-of-branch">
    <table>
        <tr>
            <td>Destination City Name</td>
            <td>
                <div class="input-field col s12 m6">
                    <input name="city_name" id="city_name" type="text" class="validate" value="{{old('city_name', !empty($destinationCity) ? $destinationCity->city_name : '')}}" required>
              </div>
            </td>
        </tr>
    </table>
    {!! get_button_save() !!}
    {!! get_button_cancel(url('destination-city-of-branch')) !!}
</form>