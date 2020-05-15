<form class="form-table"
id="form-master-vendor">
    <table>
        <tr>
            <td>Vendor Code</td>
            <td>
                <div class="input-field col s12">
                    <input id="vendor_code" type="text" class="validate" required>
              </div>
            </td>
        </tr>
        <tr>
            <td>Vendor Name</td>
            <td>
                <div class="input-field col s12">
                    <input id="vendor_name" type="text" class="validate" required>
              </div>
            </td>
        </tr>
        <tr>
            <td>Description</td>
            <td>
                <div class="input-field col s12">
                    <textarea id="description" class="materialize-textarea"></textarea>
              </div>
            </td>
        </tr>
        <tr>
            <td>Address</td>
            <td>
                <div class="input-field col s12">
                    <textarea id="vendor_address" class="materialize-textarea"></textarea>
              </div>
            </td>
        </tr>
        <tr>
            <td>Name</td>
            <td>
                <div class="input-field col s12">
                    <input type="text" id="contact_person_name">
              </div>
            </td>
        </tr>
        <tr>
            <td>Phone</td>
            <td>
                <div class="input-field col s12">
                    <input type="number" id="contact_person_phone">
              </div>
            </td>
        </tr>
        <tr>
            <td>Email</td>
            <td>
                <div class="input-field col s12">
                    <input type="email" id="contact_person_mail" required>
              </div>
            </td>
        </tr>
    </table>
    {!! get_button_save() !!}
    {!! get_button_cancel(url('master-vendor')) !!}
</form>

@push('script_js')
<script type="text/javascript">
   jQuery(document).ready(function($) {
      // Loading area data
      $('.select-area').select2({
         placeholder: '-- Select --',
         ajax: get_select2_ajax_options('/master-area/select2-areas')
      });
   });
</script>
@endpush
