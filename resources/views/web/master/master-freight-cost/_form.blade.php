<form class="form-table" id="form-master-freight">
  <table id="table-freight-cost">
    <tr>
      <td>Origin Area</td>
      <td>
        <div class="input-field col s12">
          <select id="area" class="select2-data-ajax browser-default select-area" name="area" required>
            <option></option>
          </select>
        </div>
      </td>
    </tr>
    <tr>
      <td>Ambil Sendiri</td>
      <td>
        <div class="input-field col s12 mt-2">
          <p>
            <label>
              <input id="ambil_sendiri" type="checkbox" class="filled-in" name="ambil_sendiri" />
              <span></span>
            </label>
          </p>
        </div>
      </td>
    </tr>
    <tr>
      <td class="destination_city">Destination City</td>
      <td class="destination_city">
        <div class="input-field col s12">
          <select id="city_code" class="select2-data-ajax browser-default select-destination-city" name="city_code" required>
            <option></option>
          </select>
        </div>
      </td>
    </tr>
    <tr>
      <td class="expedition">Expedition</td>
      <td class="expedition">
        <div class="input-field col s12">
          <select id="expedition_code" class="select2-data-ajax browser-default select-expedition" name="expedition_code" required>
            <option></option>
          </select>
        </div>
      </td>
    </tr>
    <tr>
      <td class="vehicle_type">Vehicle Type</td>
      <td class="vehicle_type">
        <div class="input-field col s12">
          <select id="vehicle_code_type" class="select2-data-ajax browser-default select-vehicle-type" name="vehicle_code_type" required>
            <option></option>
          </select>
        </div>
      </td>
    </tr>
    <tr>
      <td>
        <p>
          <label>
            <input id="ritase" class="with-gap" name="group1" type="radio" checked/>
            <span>Ritase</span>
          </label>
          <label>
            <input id="cbm" class="with-gap" name="group1" type="radio" />
            <span>CBM</span>
          </label>
        </p>
      </td>
      <td>
        <div class="input-field col s12">
          <input id="ritase_cbm_input" type="text" class="validate" required>
        </div>
      </td>
    </tr>
    <tr>
      <td>Lead Time</td>
      <td>
        <div class="input-field col m2 s12">
          <input id="leadtime" type="text" class="validate" name="leadtime" required>
        </div>
        <div class="col m6 s12 mt-2 ml-2">
          <span>Days</span>
        </div>
      </td>
    </tr>
  </table>
  {!! get_button_save() !!}
  {!! get_button_cancel(url('master-freight-cost')) !!}
</form>

@push('script_js')
<script type="text/javascript">
   jQuery(document).ready(function($) {
      // Loading area data
      $('.select-area').select2({
         placeholder: '-- Area --',
         ajax: get_select2_ajax_options('/master-area/select2-areas')
      });

      // Loading destination city data
      $('.select-destination-city').select2({
         placeholder: '-- Destination --',
         ajax: get_select2_ajax_options('/master-area/select2-areas')
      });

      // Loading expedition data
      $('.select-expedition').select2({
         placeholder: '-- Expedition --',
         ajax: get_select2_ajax_options('/master-area/select2-areas')
      });

      // Loading vehicle type data
      $('.select-vehicle-type').select2({
         placeholder: '-- Select Vehicle --',
         ajax: get_select2_ajax_options('/master-area/select2-areas')
      });

      // Checkbox ambil sendiri
      $('#ambil_sendiri').change(function() {
        if($(this).is(":checked")) {
          var data = [{id: 'AS', text: 'AS (Ambil Sendiri)'}];

          $('.select-destination-city').select2({
             placeholder: '-- AS (Ambil Sendiri) --',
             data : data
          });
          $('.select-expedition').select2({
             placeholder: '-- AS (Ambil Sendiri) --',
             data : data
          });
          $('.select-vehicle-type').select2({
             placeholder: '-- AS (Ambil Sendiri) --',
             data : data
          });
          $('#leadtime').hide();
        }else{
          $('.select-destination-city').select2({
             placeholder: '-- Destination --',
             ajax: get_select2_ajax_options('/master-area/select2-areas')
          });
          $('.select-expedition').select2({
             placeholder: '-- Expedition --',
             ajax: get_select2_ajax_options('/master-area/select2-areas')
          });
          $('.select-vehicle-type').select2({
             placeholder: '-- Select Vehicle --',
             ajax: get_select2_ajax_options('/master-area/select2-areas')
          });
          $('#leadtime').show();
        }       
    });
   });
</script>
@endpush