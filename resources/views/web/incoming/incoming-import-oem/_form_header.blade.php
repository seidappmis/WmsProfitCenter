<form class="form-table" id="form-incoming-import-oem-header">
  <input type="hidden" name="area">
  <input type="hidden" name="area_code">
  <table width="100%">
    <tr>
      <td width="25%">Arrival No</td>
      <td width="25%">
        <div class="input-field col s12">
          <input type="text" class="validate" value="{{!empty($incomingManualHeader) ? $incomingManualHeader->arrival_no : ''}}" disabled>
        </div>
      </td>
      <td width="50%" colspan="2">
        <div class="input-field col s12">
          <div class="row">
            <div class="col s12 m4">
              <label>
                <input name="inc_type" type="radio" value="IMPORT" />
                <span>IMPORT</span>
              </label>
            </div>
            <div class="col s12 m4">
              <label>
                <input name="inc_type" type="radio" value="OEM" />
                <span>OEM</span>
              </label>
            </div>
            <div class="col s12 m4">
              <label>
                <input name="inc_type" type="radio" value="OTHERS" checked/>
                <span>OTHERS</span>
              </label>
            </div>
          </div>
        </div>
      </td>
    </tr>
    <tr>
      <td>PO</td>
      <td>
        <div class="input-field col s12">
          <input name="po" type="text" class="validate" value="{{!empty($incomingManualHeader) ? $incomingManualHeader->po : ''}}" required>
        </div>
      </td>
      <td>Vendor Name</td>
      <td>
        <div class="input-field col s12">
          <select name="vendor_name" required="" class="select2-data-ajax browser-default">
          </select>
        </div>
      </td>
    </tr>
    <tr>
      <td>Invoice No</td>
      <td>
        <div class="input-field col s12">
          <input name="invoice_no" value="{{!empty($incomingManualHeader) ? $incomingManualHeader->invoice_no : ''}}" type="text" class="validate">
        </div>
      </td>
      <td>Actual Arrive Date</td>
      <td>
        <div class="input-field col s12">
          <input name="actual_arrival_date" value="{{!empty($incomingManualHeader) ? $incomingManualHeader->actual_arrival_date : ''}}" type="text" class="validate datepicker">
        </div>
      </td>
    </tr>
    <tr>
      <td>No GR SAP</td>
      <td>
        <div class="input-field col s12">
          <input name="no_gr_sap" type="text" value="{{!empty($incomingManualHeader) ? $incomingManualHeader->no_gr_sap : ''}}" class="validate">
        </div>
      </td>
      <td>Expedition Name</td>
      <td>
        <div class="input-field col s12">
          <input name="expedition_name" value="{{!empty($incomingManualHeader) ? $incomingManualHeader->expedition_name : ''}}" type="text" class="validate">
        </div>
      </td>
    </tr>
    <tr>
      <td>Document Date</td>
      <td>
        <div class="input-field col s12">
          <input name="document_date" value="{{!empty($incomingManualHeader) ? $incomingManualHeader->document_date : ''}}" type="text" class="validate datepicker">
        </div>
      </td>
      <td>Container No</td>
      <td>
        <div class="input-field col s12">
          <input name="container_no" value="{{!empty($incomingManualHeader) ? $incomingManualHeader->container_no : ''}}" type="text" class="validate">
      </td>
    </tr>
  </table>
  {!! get_button_save('Save', 'btn-save mt-1') !!}
  <button class="waves-effect waves-light indigo btn-small btn-submit-to-inventory mt-1 mr-1 mb-1 hide">Submit to Inventory</button>
</form>
@push('script_js')
<script type="text/javascript">
   jQuery(document).ready(function($) {

      // Loading Expedition Data
      $('#form-incoming-import-oem-header [name="vendor_name"]').select2({
         placeholder: '-- Select Vendor Name --',
         ajax: get_select2_ajax_options('/master-vendor/select2-vendor-name')
      });

   });
</script>
@endpush