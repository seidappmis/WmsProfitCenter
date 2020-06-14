<form class="form-table" id="form-adjust-inventory-movement">
  <table>
    <tr>
      <td width="20%">BRANCH</td>
      <td>
        <div class="input-field col s12">
          <select name="kode_cabang" class="select2-data-ajax browser-default">
           {{--  <option value=""  disabled selected>-- Select Branch --</option>
            <option>[HYP]PT. SEID HQ JKT</option>
            <option>[JKT]PT. SEID CAB. JAKARTA</option>
            <option>[JF]PT. SEID CAB. JAKARTA</option> --}}
          </select>
        </div>
      </td>
    </tr>
    <tr>
      <td>STORAGE LOCATION</td>
      <td><div class="input-field col s12">
        <select name="sloc" class="select2-data-ajax browser-default" required>
          {{-- <option value="" disabled selected>-- Please Select Location --</option>
          <option value="1">1001-YP-1st Class</option>
          <option value="2">1060-HYP-Return All</option>
          <option value="3">1090-HYP-Intransit BR</option> --}}
        </select>
      </div></td>
    </tr>
    
    <tr>
      <td>MODEL</td>
      <td><div class="input-field col s12">
        <input id="model" type="text" class="validate" name="model" maxlength="50" required>
      </div></td>
    </tr>
    <tr>
      <td>AVAILABLE QTY</td>
      <td><div class="input-field col s12">
        <input id="prev_quantity" type="text" class="validate" name="prev_quantity" value="0" disabled>
      </div></td>
    </tr>
    <tr>
      <td>QTY</td>
      <td>
        <div class="input-field col s12">
          <input id="quantity" type="number" class="validate " name="quantity">
         {{--  <select>
            <option value="" disabled selected>-All-</option>
            <option value="1">JAKARTA-JEMBER</option>
            <option value="2">JAKARTA-KARAWANG</option>
            <option value="3">JAKARTA-KEDIRI</option>
          </select> --}}
        </div>
      </td>
    </tr>
    <tr>
      <td>MOVEMENT TYPE</td>
      <td>
        <div class="input-field col s12">
          <select>
            <option value="" disabled selected>-- Select Movement--</option>
            <option value="1">965 - Adjust plus</option>
            <option value="2">966 - Adjust minus</option>
            <option value="3">701 - Adjust Stock Taking plus</option>
          </select>
        </div>
      </td>
    </tr>
    <tr>
      <td>REMARKS</td>
      <td><div class="input-field col s12">
        <textarea id="textarea2" class="materialize-textarea" required></textarea>
      </div></td>
    </tr>
  </table>
  <div class="input-field col s12">
    <button type="submit" class="waves-effect waves-light indigo btn">Submit</button>
  </div>
</form>

@push('script_js')
<script type="text/javascript">
  $('#form-adjust-inventory-movement [name="kode_cabang"]').select2({
     placeholder: '-- Select Branch --',
     ajax: get_select2_ajax_options('/master-cabang/select2-cabang')
  });
  $('#form-adjust-inventory-movement [name="sloc"]').select2({
     placeholder: '-- Select Location --',
     ajax: get_select2_ajax_options('/storage-master/select2-storage')
  });
</script>
@endpush