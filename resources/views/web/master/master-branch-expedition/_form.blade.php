<form class="form-table" id="form-branch-expedition">
    <table>
        <tr>
            <td>Branch Code</td>
            <td>
                <div class="input-field col s12">
                    <select name="kode_cabang"  class="select2-data-ajax browser-default ">
                        <option value="{{Auth::user()->cabang->kode_cabang}}" selected></option>
                    </select>
                </div>
            </td>
        </tr>
        <tr>
            <td>Code</td>
            <td>
                <div class="input-field col s12">
                    <input id="code" type="text" class="validate" name="code" value="{{old('code', !empty($branchExpedition) ? $branchExpedition->code : '')}}" disabled>
                </div>
            </td>
        </tr>
        <tr>
            <td>Expedition Name</td>
            <td>
                <div class="input-field col s12">
                    <input id="name" type="text" class="validate" name="expedition_name" value="{{old('expedition_name', !empty($branchExpedition) ? $branchExpedition->expedition_name : '')}}" required>
                </div>
            </td>
        </tr>
        <tr>
            <td>Address</td>
            <td>
                <div class="input-field col s12">
                    <textarea name="address" id="address" class="materialize-textarea">{{old('address', !empty($branchExpedition) ? $branchExpedition->address : '')}}</textarea>
                </div>
            </td>
        </tr>
        <tr>
            <td>INITIAL</td>
            <td>
                <div class="input-field col s12">
                    <input name="initial" id="initial" type="text" class="validate" value="{{old('initial', !empty($branchExpedition) ? $branchExpedition->initial : '')}}" required>
                </div>
            </td>
        </tr>
        <tr>
            <td>NPWP</td>
            <td>
                <div class="input-field col s12">
                    <input name="npwp" id="npwp" type="text" class="validate" value="{{old('npwp', !empty($branchExpedition) ? $branchExpedition->npwp : '')}}">
                </div>
            </td>
        </tr>
        <tr>
            <td>CONTACT PERSON</td>
            <td>
                <div class="input-field col s12">
                    <input id="cp" type="text" class="validate" name="contact_person" value="{{old('contact_person', !empty($branchExpedition) ? $branchExpedition->contact_person : '')}}">
                </div>
            </td>
        </tr>
        <tr>
            <td>PHONE NUMBER 1</td>
            <td>
                <div class="input-field col s12">
                    <input id="phone_number_1" type="number" class="validate" name="phone_number_1" value="{{old('phone_number_1', !empty($branchExpedition) ? $branchExpedition->phone_number_1 : '')}}">
                </div>
            </td>
        </tr>
        <tr>
            <td>PHONE NUMBER 2</td>
            <td>
                <div class="input-field col s12">
                    <input id="phone_number_2" type="number" class="validate" name="phone_number_2" value="{{old('phone_number_2', !empty($branchExpedition) ? $branchExpedition->phone_number_2 : '')}}">
                </div>
            </td>
        </tr>
        <tr>
            <td>FAX NUMBER</td>
            <td>
                <div class="input-field col s12">
                    <input id="fax" type="number" class="validate" name="fax_number" value="{{old('fax_number', !empty($branchExpedition) ? $branchExpedition->fax_number : '')}}">
                </div>
            </td>
        </tr>
        <tr>
            <td>BANK</td>
            <td>
                <div class="input-field col s12">
                    <input id="bank" type="text" class="validate" name="bank" value="{{old('bank', !empty($branchExpedition) ? $branchExpedition->bank : '')}}">
                </div>
            </td>
        </tr>
        <tr>
            <td>CURRENCY</td>
            <td>
                <div class="input-field col s12">
                    <input id="currency" type="text" class="validate" name="currency" maxlength="3" value="{{old('currency', !empty($branchExpedition) ? $branchExpedition->currency : '')}}">
                </div>
            </td>
        </tr>
        <tr>
            <td>ACTIVE</td>
            <td>
                <div class="input-field col s12 mt-2">
                    <p>
                        <label>
                            <input name="status_active" type="checkbox" class="filled-in" {{!empty($branchExpedition) && $branchExpedition->status_active ? 'checked' : ''}} /><span></span>
                        </label>
                    </p>
                </div>
            </td>
        </tr>
    </table>
    {!! get_button_save() !!}
    {!! get_button_cancel(url('master-branch-expedition')) !!}
</form>

@push('script_js')
<script type="text/javascript">
   jQuery(document).ready(function($) {
      // Loading region data
      $('#form-branch-expedition [name="kode_cabang"]').select2({
         placeholder: '-- Select Branch--',
        //  ajax: get_select2_ajax_options('/master-cabang/select2-cabang')
      });
   });
</script>
@endpush
