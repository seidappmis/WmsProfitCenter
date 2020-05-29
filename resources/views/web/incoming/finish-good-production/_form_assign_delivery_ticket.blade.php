<form class="form-table" id="form-assign-delivery-ticket">
    <table>
        <tr>
            <td width="45%">
            <b>From Barcode Production</b>
            <table>
                <tr>
                    <td>
                    <b>Delivery Ticket| Model | Quantity | Ean | Type</b>
                    <textarea id="textarea1" class="textarea-custom"></textarea>
                    <!-- <table>
                        <tr>
                            <td class="white-text" height="300">tes</td>
                        </tr>
                    </table> -->
                    </td>
                </tr>
            </table>
            <br><br><br><br>
            </td>
            <td width="10%" class="center-align">
              <div class="col s12">
                  <p><button type="submit" class="waves-effect waves-light indigo btn">>></button></p>
                  <br>
                  <p><button type="submit" class="waves-effect waves-light indigo btn"><<</button></p>
              </div>
            </td>
            <td width="45%">
            <b>Submit to Logsys</b>
            <table>
                <tr>
                    <td>
                    <b>Delivery Ticket| Model | Quantity | Ean | Type</b>
                    <textarea id="textarea2" class="textarea-custom"></textarea>
                    <!-- <table>
                        <tr>
                            <td class="white-text" height="300">lala</td>
                        </tr>
                    </table> -->
                    </td>
                </tr>
            </table>
            <table>
            <tr>
                <td>Storage Location</td>
                <td>
                  <div class="input-field col s12">
                  <select id="storage_id"
                          name="storage_id"
                          class="select2-data-ajax browser-default select-storage-location" required>
                    <option></option>
                  </select>
                  </div> 
                </td>
            </tr>
            </table>
            {!! get_button_save() !!}
            {!! get_button_save('Submit to Inventory') !!}
            </td>
        </tr>
    </table>
</form>

@push('script_js')
<script type="text/javascript">
   jQuery(document).ready(function($) {
      // Storage Location
      $('.select-storage-location').select2({
         placeholder: '-- Select Storage Location --',
         allowClear: true,
         ajax: get_select2_ajax_options('/storage-master/select2-storage')
      });
   });
</script>
@endpush