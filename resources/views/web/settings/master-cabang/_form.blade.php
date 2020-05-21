<input type="hidden" name="id">

<form class="form-table" id="form-master-cabang">
    <table>
        <tr>
            <td>Kode Customer</td>
            <td>
                <div class="input-field col s12">
                   <input id="kode_customer"
                   type="text"
                   class="validate"
                   name="kode_customer"
                   value="{{old('kode_customer', !empty($masterCabang) ? $masterCabang->kode_customer : '')}}">
                </div>
            </td>
        </tr>
        <tr>
            <td>Kode Cabang</td>
            <td>
                <div class="input-field col s12">
                   <input id="kode_cabang"
                   type="text"
                   class="validate"
                   name="kode_cabang"
                   value="{{old('kode_cabang', !empty($masterCabang) ? $masterCabang->kode_cabang : '')}}">
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
                   value="{{old('short_description', !empty($masterCabang) ? $masterCabang->short_description : '')}}">
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
                   value="{{old('long_description', !empty($masterCabang) ? $masterCabang->long_description : '')}}">
                </div>
            </td>
        </tr>
        <tr>
            <td>Region</td>
            <td>
                <div class="input-field col s12">
                    <select id="region" name="region" 
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
                   <input id="start_wms"
                   type="text"
                   class="validate"
                   name="start_wms"
                   value="{{old('start_wms', !empty($masterCabang) ? $masterCabang->start_wms : '')}}">
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
         placeholder: '-- Select Region--',
         ajax: get_select2_ajax_options('/master-cabang/select2-region')
      });

      // Loading type code data
      $('.select-tycode').select2({
        placeholder: '-- Select Type--',
        data : [
          {
            id: 'BR',
            text: 'BR'
          },
          {
            id: 'DS',
            text: 'DS'
          }
        ]
      });
   });
</script>
@endpush
