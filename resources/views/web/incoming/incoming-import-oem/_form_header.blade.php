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
          <input name="po" type="text" class="validate" value="{{!empty($incomingManualHeader) ? $incomingManualHeader->po : ''}}" required="required">
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
  <span class="waves-effect waves-light indigo btn-small btn-submit-to-inventory mt-1 mr-1 hide">Submit to Inventory</span>
</form>
@push('script_js')
<script type="text/javascript">
   jQuery(document).ready(function($) {

      // Loading Expedition Data
      $('#form-incoming-import-oem-header [name="vendor_name"]').select2({
         placeholder: '-- Select Vendor Name --',
         ajax: get_select2_ajax_options('/master-vendor/select2-vendor-name')
      });

      @if(!empty($incomingManualHeader) && !$incomingManualHeader->submit)
      $('#form-incoming-import-oem-detail').removeClass('hide');
      @if($incomingManualHeader->details->count() > 0 && !$incomingManualHeader->submit)
      $('.btn-submit-to-inventory').removeClass('hide');
      @endif
      $('.btn-submit-to-inventory').click(function(event) {
        /* Act on the event */
        swal({
          text: "Are you sure want to Submit to Inventory {{$incomingManualHeader->arrival_no}} and the details?",
          icon: 'warning',
          buttons: {
            cancel: true,
            delete: 'Yes, Submit It'
          }
        }).then(function (confirm) { // proses confirm
          if (confirm) {
            $.ajax({
              url: '{{ url('incoming-import-oem') }}' + '/{{$incomingManualHeader->arrival_no}}/submit-to-inventory',
              type: 'POST',
              dataType: 'json',
            })
            .done(function() {
              // Data has been Transfered on Storage
              showSwalAutoClose('Success', 'Data has been Transfered on Storage');
              window.location.href = '{{url('incoming-import-oem')}}';
            })
            .fail(function() {
              console.log("error");
            });
          }
        })
      });
      @elseif(!empty($incomingManualHeader) && $incomingManualHeader->submit)
      $('.btn-save').addClass('hide');
      $('#add-detail-wrapper').addClass('hide')
      @endif


   });
</script>
@endpush