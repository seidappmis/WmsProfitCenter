<form class="form-table" id="form-vehicle-group">
    <table>
        <tr>
            <td>VEHICLE GROUP CATEGORY</td>
            <td>
                <input id="group_name" 
                type="text" 
                class="validate"
                name="group_name"
                value="{{old('group_name', !empty($vehicleGroup) ? $vehicleGroup->group_name : '')}}">
            </td>
        </tr>
    </table>
    {!! get_button_save() !!}
    {!! get_button_cancel(url('master-vehicle'), 'Back') !!}
</form>