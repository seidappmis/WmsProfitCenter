<form class="form-table"
id="form-master-vendor">
    <table>
        <tr>
            <td>Vendor Code</td>
            <td>
                <div class="input-field col s12">
                <input id="vendor_code" name="vendor_code" type="text" class="validate" required value="{{ !empty($masterVendor) ? $masterVendor->vendor_code : '' }}">
              </div>
            </td>
        </tr>
        <tr>
            <td>Vendor Name</td>
            <td>
                <div class="input-field col s12">
                    <input id="vendor_name" name="vendor_name" type="text" class="validate" required
                    value="{{ !empty($masterVendor) ? $masterVendor->vendor_name : '' }}">
              </div>
            </td>
        </tr>
        <tr>
            <td>Description</td>
            <td>
                <div class="input-field col s12">
                    <textarea id="description" name="description" class="materialize-textarea"
                    >{{ !empty($masterVendor) ? $masterVendor->description : '' }}</textarea>
              </div>
            </td>
        </tr>
        <tr>
            <td>Address</td>
            <td>
                <div class="input-field col s12">
                    <textarea id="vendor_address" name="vendor_address" class="materialize-textarea">{{ !empty($masterVendor) ? $masterVendor->vendor_address : '' }}</textarea>
              </div>
            </td>
        </tr>
        <tr>
            <td>Name</td>
            <td>
                <div class="input-field col s12">
                    <input type="text" id="contact_person_name" name="contact_person_name"
                    value="{{ !empty($masterVendor) ? $masterVendor->contact_person_name : '' }}">
              </div>
            </td>
        </tr>
        <tr>
            <td>Phone</td>
            <td>
                <div class="input-field col s12">
                    <input type="number" id="contact_person_phone" name="contact_person_phone"
                    value="{{ !empty($masterVendor) ? $masterVendor->contact_person_phone : '' }}">
              </div>
            </td>
        </tr>
        <tr>
            <td>Email</td>
            <td>
                <div class="input-field col s12">
                    <input type="email" id="contact_person_email" name="contact_person_email" required
                    value="{{ !empty($masterVendor) ? $masterVendor->contact_person_email : '' }}">
              </div>
            </td>
        </tr>
    </table>
    {!! get_button_save() !!}
    {!! get_button_cancel(url('master-vendor')) !!}
</form>
