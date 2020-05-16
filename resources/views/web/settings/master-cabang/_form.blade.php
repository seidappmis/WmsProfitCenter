<input type="hidden" name="id">

<form class="form-table" id="form-master-cabang">
    <table>
        <tr>
            <td>Kode Customer</td>
            <td>
                <div class="input-field col s12">
                   <input id="customer"
                   type="text"
                   class="validate"
                   name="customer"
                   value="{{old('code_customer', !empty($masterCabang) ? $masterCabang->code_customer : '')}}">
                </div>
            </td>
        </tr>
        <tr>
            <td>Kode Cabang</td>
            <td>
                <div class="input-field col s12">
                   <input id="cabang"
                   type="text"
                   class="validate"
                   name="cabang"
                   value="{{old('code_cabang', !empty($masterCabang) ? $masterCabang->code_cabang : '')}}">
                </div>
            </td>
        </tr>
        <tr>
            <td>Short Description</td>
            <td>
                <div class="input-field col s12">
                   <input id="sdes"
                   type="text"
                   class="validate"
                   name="sdes"
                   value="{{old('short_des', !empty($masterCabang) ? $masterCabang->short_des : '')}}">
                </div>
            </td>
        </tr>
        <tr>
            <td>Long Description</td>
            <td>
                <div class="input-field col s12">
                   <input id="ldes"
                   type="text"
                   class="validate"
                   name="ldes"
                   value="{{old('long_des', !empty($masterCabang) ? $masterCabang->long_des : '')}}">
                </div>
            </td>
        </tr>
        <tr>
            <td>Region</td>
            <td>
                <div class="input-field col s12">
                    <select id="region"
                    class="select2-data-ajax browser-default select-region">
                        <option></option>
                    </select>
                </div>
            </td>
        </tr>
        <tr>
            <td>Type Code</td>
            <td>
                <div class="input-field col s12">
                    <select id="tycode"
                    class="select2-data-ajax browser-default select-tycode">
                        <option></option>
                    </select>
                </div>
            </td>
        </tr>
        <tr>
            <td>HQ</td>
            <td>
                <div class="input-field col s12 mt-2">
                    <p>
                    <label>
                      <input id="hq"
                      type="checkbox"
                      class="filled-in" />
                      <span></span>
                    </label>
                  </p>
                </div>
            </td>
        </tr>
        <tr>
            <td>START WMS</td>
            <td>
                <div class="input-field col s12">
                   <input id="wms"
                   type="text"
                   class="validate"
                   name="wms"
                   value="{{old('stwms', !empty($masterCabang) ? $masterCabang->stwms : '')}}">
                </div>
            </td>
        </tr>
    </table>
    {!! get_button_save() !!}
    {!! get_button_cancel(url('master-cabang')) !!}
</form>

@push('script_js')
<script type="text/javascript">
   jQuery(document).ready(function($) {
      // Loading region data
      $('.select-region').select2({
         placeholder: '-- Select --',
         ajax: get_select2_ajax_options('/master-region/select2-regions')
      });
   });
</script>
@endpush

@push('script_js')
<script type="text/javascript">
   jQuery(document).ready(function($) {
      // Loading region data
      $('.select-tycode').select2({
         placeholder: '-- Select --',
         ajax: get_select2_ajax_options('/master-tycode/select2-tycodes')
      });
   });
</script>
@endpush
