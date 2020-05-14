<form class="form-table" id="form-vehicle-detail">
    <table>
        <tr>
            <td>Vehicle Code Type</td>
            <td>
                <input id="vehicle_code_type" name="vehicle_code_type" type="text" class="validate">
            </td>
        </tr>
        <tr>
            <td>Description</td>
            <td>
                <input id="vehicle_desription" name="vehicle_desription" type="text" class="validate"">
            </td>
        </tr>
        <tr>
            <td>SAP Description</td>
            <td>
                <input id="sap_description" name="sap_description" type="text" class="validate"">
            </td>
        </tr>
        <tr>
            <td>CBM MIN</td>
            <td>
                <input id="cbm_min" name="cbm_min" type="number" class="validate"">
            </td>
        </tr>
        <tr>
            <td>CBM MAX</td>
            <td>
                <input id="cbm_max" name="cbm_max" type="number" class="validate"">
            </td>
        </tr>
        <tr>
            <td>Number</td>
            <td>
                <input id="numb" type="number" class="validate"">
            </td>
        </tr>
    </table>
    {!! get_button_save() !!}
    {!! get_button_cancel(url('master-vehicle/'),'Back') !!}
</form>