<form class="form-table" id="form-master-expedition">

    <table>
        <tr>
            <td>Code</td>
            <td>
                <div class="input-field col s12">
                    <input 
                        id="code" 
                        type="text" 
                        class="validate" 
                        name="code" 
                        value="{{old('code', !empty($masterExpedition) ? $masterExpedition->code : '')}}" 
                        {{!empty($masterExpedition) ? 'readonly' : ''}} 
                        required
                        />
              </div>
            </td>
        </tr>
        <tr>
            <td>Expedition Name</td>
            <td>
                <div class="input-field col s12">
                    <input 
                        id="expedition_name" 
                        type="text" 
                        class="validate" 
                        name="expedition_name" 
                        value="{{old('expedition_name', !empty($masterExpedition) ? $masterExpedition->expedition_name : '')}}" 
                        {{!empty($masterExpedition) ? 'readonly' : ''}} 
                        required
                        />
              </div>
            </td>
        </tr>
        <tr>
            <td>Address</td>
            <td>
                <div class="input-field col s12">
                    <input 
                        id="address" 
                        type="text" 
                        class="validate" 
                        name="address" 
                        value="{{old('address', !empty($masterExpedition) ? $masterExpedition->address : '')}}" 
                       
                        />
              </div>
            </td>
        </tr>
        <tr>
            <td>SAP CODE</td>
            <td>
                <div class="input-field col s12">
                    <input 
                        id="sap_code" 
                        type="text" 
                        class="validate" 
                        name="sap_code" 
                        value="{{old('sap_code', !empty($masterExpedition) ? $masterExpedition->sap_code : '')}}" 
                        {{!empty($masterExpedition) ? 'readonly' : ''}} 
                        required
                        />
              </div>
            </td>
        </tr>
        <tr>
            <td>NPWP</td>
            <td>
                <div class="input-field col s12">
                    <input 
                        id="npwp" 
                        type="text" 
                        class="validate" 
                        name="npwp"
                        value="{{old('npwp', !empty($masterExpedition) ? $masterExpedition->npwp : '')}}" 
                       
                        />
              </div>
            </td>
        </tr>
        <tr>
            <td>CONTACT PERSON</td>
            <td>
                <div class="input-field col s12">
                    <input 
                        id="contact_person" 
                        type="text" 
                        class="validate" 
                        name="contact_person" 
                        value="{{old('contact_person', !empty($masterExpedition) ? $masterExpedition->contact_person : '')}}" 
                       
                        />
              </div>
            </td>
        </tr>
        <tr>
            <td>PHONE NUMBER 1</td>
            <td>
                <div class="input-field col s12">
                    <input 
                        id="phone1" 
                        type="text" 
                        class="validate" 
                        name="phone1" 
                        value="{{old('phone1', !empty($masterExpedition) ? $masterExpedition->phone1 : '')}}" 
                       
                        />
              </div>
            </td>
        </tr>
        <tr>
            <td>PHONE NUMBER 2</td>
            <td>
                <div class="input-field col s12">
                    <input 
                        id="phone2" 
                        type="text" 
                        class="validate" 
                        name="phone2" 
                        value="{{old('phone2', !empty($masterExpedition) ? $masterExpedition->phone2 : '')}}" 
                       
                        />
              </div>
            </td>
        </tr>
        <tr>
            <td>FAX NUMBER</td>
            <td>
                <div class="input-field col s12">
                    <input 
                        id="fax_number" 
                        type="text" 
                        class="validate" 
                        name="fax_number" 
                        value="{{old('fax_number', !empty($masterExpedition) ? $masterExpedition->fax_number : '')}}" 
                       
                        />
              </div>
            </td>
        </tr>
        <tr>
            <td>BANK</td>
            <td>
                <div class="input-field col s12">
                    <input 
                        id="bank" 
                        type="text" 
                        class="validate" 
                        name="bank" 
                        value="{{old('bank', !empty($masterExpedition) ? $masterExpedition->bank : '')}}" 
                       
                        />
              </div>
            </td>
        </tr>
        <tr>
            <td>CURRENCY</td>
            <td>
                <div class="input-field col s12">
                    <input 
                        id="currency" 
                        type="text" 
                        class="validate" 
                        name="currency" 
                        value="{{old('currency', !empty($masterExpedition) ? $masterExpedition->currency : '')}}" 
                       
                        />
              </div>
            </td>
        </tr>
      
        <tr>
            <td>ACTIVE</td>
            <td>
              <div class="input-field col s12 mt-2">
                <p>
                    <label>
                      <input type="checkbox" class="filled-in" name="status_active" {{!empty($masterExpedition) && $masterExpedition->status_active ? 'checked' : ''}} />
                      <span></span>
                    </label>
                  </p>
              </div>
            </td>
        </tr>
    </table>
    {!! get_button_save() !!}
    {!! get_button_cancel(url('master-expedition')) !!}
</form>



