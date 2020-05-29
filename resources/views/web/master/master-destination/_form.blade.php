<form class="form-table" id="form-master-destination">
    <table>
        <tr>
            <td>Destination Number</td>
            <td>
                <div class="input-field col s12">
                    <input
                        id="destination_number"
                        type="text"
                        class="validate"
                        name="destination_number"
                        value="{{old('destination_number', !empty($masterDestination) ? $masterDestination->destination_number : '')}}"
                        {{!empty($masterDestination) ? 'readonly' : ''}}
                        required
                        />
              </div>
            </td>
        </tr>
        <tr>
            <td>Description</td>
            <td>
                <div class="input-field col s12">
                    <input
                        id="description"
                        type="text"
                        class="validate"
                        name="description"
                        value="{{old('description', !empty($masterDestination) ? $masterDestination->description : '')}}"
                        />
              </div>
            </td>
        </tr>
        <tr>
            <td>Region</td>
            <td>
                <div class="input-field col s12">
                    <p>
                        <label>
                          <input class="with-gap choose-region" name="region_type" value="new_region" type="radio" checked />
                          <span>New Region</span>
                        </label>
                        <label>
                          <input class="with-gap choose-region" name="region_type" value="current" type="radio" />
                          <span>Current</span>
                        </label>
                    </p>
                    <input
                        id="new_region_input"
                        type="text"
                        class="validate"
                        name="new_region"
                        value="{{old('region', !empty($masterDestination) ? $masterDestination->region : '')}}"
                        required
                        />
                    <select id="current_region_input"
                            name="current_region"
                            style="display: none;"
                            class="select2-data-ajax browser-default select-region" required>
                    </select>
              </div>
            </td>
        </tr>
        <tr>
            <td>Cabang</td>
            <td>
                <div class="input-field col s12">
                    <select id="cabang"
                    name="cabang"
                    class="select2-data-ajax browser-default select-cabang" required>
                    </select>
              </div>
            </td>
        </tr>
    </table>
    {!! get_button_save() !!}
    {!! get_button_cancel(url('master-destination')) !!}
</form>

@push('script_js')
<script type="text/javascript">
  jQuery(document).ready(function($) {
      // Loading cabang Data
      $('.select-cabang').select2({
         placeholder: '-- Select Cabang --',
         ajax: get_select2_ajax_options('/master-cabang/select2-cabang')
      });
   });

    $('#form-master-destination [name="region_type"]').change(function(event) {
        /* Act on the event */
        if ($(this).val() == 'new_region') {
            $('#new_region_input').show();
            $('#current_region_input').hide();
        } else {
            $('#new_region_input').hide();
            $('#current_region_input').show();

            // Loading region Data
            $('#form-master-destination [name="current_region"]').select2({
               placeholder: '-- Select Region --',
               ajax: get_select2_ajax_options('/region/select2-region')
            });
        }
    });
</script>
@endpush
