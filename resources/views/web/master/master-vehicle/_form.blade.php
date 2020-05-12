<form class="form-table" id="form-vehicle-detail">
    <table>
        <tr>
            <td>Vehicle Code Type</td>
            <td>
                <input id="category" type="text" class="validate">
            </td>
        </tr>
        <tr>
            <td>Description</td>
            <td>
                <input id="description" type="text" class="validate"">
            </td>
        </tr>
        <tr>
            <td>SAP Description</td>
            <td>
                <input id="sap" type="text" class="validate"">
            </td>
        </tr>
        <tr>
            <td>CBM MIN</td>
            <td>
                <input id="min" type="number" class="validate"">
            </td>
        </tr>
        <tr>
            <td>CBM MAX</td>
            <td>
                <input id="max" type="number" class="validate"">
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
    {!! get_button_cancel(url('master-vehicle/1'),'Back') !!}
</form>