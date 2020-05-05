<input type="hidden" name="id">
<form class="form-table" id="form-master-area">
    <table>
        <tr>
            <td>AREA</td>
            <td>
                <div class="input-field col s12">
                    <input id="area" 
                    type="text" 
                    class="validate" 
                    name="area" 
                    value="{{old('area', !empty($masterArea) ? $masterArea->area : '')}}">
                </div>
            </td>
        </tr>
        <tr>
            <td>CODE</td>
            <td>
                <div class="input-field col s12">
                    <input id="code_area" 
                    type="text" 
                    class="validate" 
                    name="code_area"
                    value="{{old('code_area', !empty($masterArea) ? $masterArea->code_area : '')}}">
                </div>
            </td>
        </tr>
    </table>
    {!! get_button_save() !!}
    {!! get_button_cancel(url('master-area')) !!}
</form>