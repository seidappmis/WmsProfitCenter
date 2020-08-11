<form class="form-table" id="form-picking-list">
    <div class="row">
        <div class="col s12 m1 padding-1">
            <p>Storage:</p>
        </div>
        <div class="col s12 m4">
            <!---- Search ----->
            <div class="input-field col s12">
                <select name="storage_id" class="select2-data-ajax browser-default" required="">
                </select>
                <input type="hidden" name="storage_name">
            </div>
        </div>
    </div>
    <table class="form-table">
        <tr>
            <td>Date of Destpatch</td>
            <td>
                <div class="input-field col s12">
                    <input type="text" class="validate" name="picking_date" value="{{date('Y-m-d h:i A')}}" readonly>
                </div>
            </td>
            <td>Gate#</td>
            <td>
                <div class="input-field col s12">
                  <div>
                    <input id="input-gate-number" type="text" class="validate" name="gate_number" value="{{ !empty($pickinglistHeader->gate_number) ? $pickinglistHeader->gate_number : '' }}" {{ !empty($pickinglistHeader->gate_number) ? 'readonly' : 'required' }} >
                  </div>
                    <div class="hide">
                      <select id="select-gate-number"
                              name="gate_number"
                              class="select2-data-ajax browser-default">
                      </select>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td>WHS</td>
            <td>
                <div class="input-field col s12">
                    <input type="text" class="validate" name="picking_date" value="SHARP W/H {{auth()->user()->cabang->short_description}}" readonly>
                </div>
            </td>
            <td>
                <P>Order No</P>
            </td>
            <td>
                <div class="input-field col s12">
                    <input value="{{ !empty($pickinglistHeader->picking_no) ? $pickinglistHeader->picking_no : '' }}" id="notag" type="text" class="validate" name="notag" disabled>
                </div>
            </td>
        </tr>
        <tr>
            <td>Ship To City</td>
            <td>
                <div class="input-field col s12">
                    <select name="city_code" class="select2-data-ajax browser-default" required>
                    </select>
                    <input type="hidden" name="city_name" value="{{ !empty($pickinglistHeader->city_name) ? $pickinglistHeader->city_name : '' }}">
                </div>
            </td>
            <td></td>
            <td></td>
        </tr>
    </table>
    <table class="form-table" id="table-expedition-detail">
        <tr>
            <td width="120px;">Expedition</td>
            <td>
                <div class="input-field col s12">
                    <select name="expedition_code" class="select2-data-ajax browser-default" required="">
                    </select>
                    <input type="hidden" name="expedition_name">
                </div>
            </td>
            <td width="120px;">
                <P>Driver Name</P>
            </td>
            <td>
                <div class="input-field col s12 m6">
                    <select name="driver_id" class="select2-data-ajax browser-default">
                    </select>
                    <input type="hidden" name="driver_name">
                </div>
                <div class="input-field col s12 m6">
                    <input value="" id="driver_name" type="text" class="validate" name="driver_name">
                </div>
            </td>
        </tr>
        <tr>
            <td>Vehicle Type</td>
            <td>
                <div class="input-field col s12">
                    <select name="vehicle_code_type" class="select2-data-ajax browser-default" required="">
                    </select>
                </div>
            </td>
            <td>
              <div class="destination-input-wrapper hide">
                Destination
              </div>
            </td>
            <td>
              <div class="destination-input-wrapper hide">
                <select name="destination_number" class="select2-data-ajax browser-default">
                </select>
                <input type="hidden" name="destination_name">
              </div>
            </td>
        </tr>
        <tr>
            <td>Vehicle No</td>
            <td>
                <input type="hidden" name="driver_register_id">
                <div class="input-field col s12 m6">
                    <select name="vehicle_number" class="select2-data-ajax browser-default">
                    </select>
                </div>
                <div class="input-field col s12 m6">
                    <input value="" id="vehicle_number" type="text" class="validate" name="vehicle_number">
                </div>
            </td>
            <td></td>
            <td></td>
        </tr>
    </table>
    <div class="row pl-1">
        <div class="input-field col s12">
          @if(empty($pickinglistHeader))
            {!! get_button_save('Save') !!}
          @else
            {!! get_button_print('#', 'Print', 'btn-print mt-2') !!}
          @endif
            {!! get_button_cancel(url('picking-list'),'Back') !!}
        </div>
    </div>
</form>

{{-- Load Modal Print --}}
@include('layouts.materialize.components.modal-print', [
  'title' => 'Print Pickinglist',
  'url' => 'picking-list/' . (!empty($pickinglistHeader) ? $pickinglistHeader->id : '') . '/export',
  'trigger' => '.btn-print'
  ])

@push('script_js')
<script type="text/javascript">

    jQuery(document).ready(function($) {
      $('#form-picking-list [name="storage_id"]').select2({
        placeholder: '-- Select Storage --',
        ajax: get_select2_ajax_options('/storage-master/select2-user-storage-without-intransit')
      })
      $('#form-picking-list [name="storage_id"]').change(function(event) {
          var data = $(this).select2('data')[0];
          $('#form-picking-list [name="storage_name"]').val(data.text);
      });

        @if(auth()->user()->cabang->hq)
        init_form_hq()
        @else
        init_form_branch()
        @endif
    });

    function init_form_hq(){
      $('.destination-input-wrapper').removeClass('hide');
      $('#select-gate-number').select2({
         placeholder: '-- Select Gate --',
         ajax: get_select2_ajax_options('/master-gate/select2-free-gate')
      });
      $('#form-picking-list [name="destination_number"]').select2({
        placeholder: '-- Select Destination --',
        ajax: get_select2_ajax_options('/master-destination/select2-destination')
      });
      $('#form-picking-list [name="destination_number"]').change(function(event) {
        /* Act on the event */
        var data = $(this).select2('data')[0]
        $('#form-picking-list [name="destination_name"]').val(data.text);
      });

      set_hq_select_ship_to_city()
      set_hq_select_expedition()
      set_hq_select_vehicle_type()
      set_hq_select_vehicle_number()
      set_hq_select_driver_name()
      $('#select-gate-number').parent().removeClass('hide')
      $('#input-gate-number').parent().addClass('hide')

      $('#form-picking-list [name="driver_id"]').change(function(event) {
          /* Act on the event */
          var data = $(this).select2('data')[0]
          $('#form-picking-list [name="driver_name"]').val(data.text)
      });

      $('#form-picking-list select[name="vehicle_number"]').change(function(event) {
          /* Act on the event */
          var data = $(this).select2('data')[0]
          $('#form-picking-list [name="driver_register_id"]').val(data.driver_register_id)
          set_select2_value('#form-picking-list [name="driver_id"]', '', '')
          set_hq_select_driver_name({driver_register_id: data.driver_register_id})
          // set_select2_value('#form-picking-list [name="driver_id"]', data.driver_id, data.driver_name)
      });

      $('#form-picking-list [name="expedition_code"]').change(function(event) {
          /* Act on the event */
          var data = $(this).select2('data')[0]
          set_hq_select_ship_to_city({expedition_code: $(this).val()})
          set_hq_select_vehicle_type({expedition_code: $(this).val()})
          set_select2_value('#form-picking-list [name="city_code"]', '', '')
          set_select2_value('#form-picking-list [name="vehicle_code_type"]', '', '')
          $('#form-picking-list [name="expedition_name"]').val(data.text)
      });

      $('#form-picking-list [name="vehicle_code_type"]').change(function(event) {
          /* Act on the event */
          set_select2_value('#form-picking-list select[name="vehicle_number"]', '', '')
          set_hq_select_vehicle_number({vehicle_code_type: $(this).val(), expedition_code: $('#form-picking-list [name="expedition_code"]').val()})
      });

      $('#form-picking-list [name="city_code"]').change(function(event) {
        var data = $(this).select2('data')[0];
        $('#form-picking-list [name="city_name"]').val(data == undefined ? '' : data.text);
        // Ambil Sendiri => hide expedition detail
        if ($(this).val() == 'AS') {
          set_select2_value('#form-picking-list [name="destination_number"]', '', '')
          $('#table-expedition-detail').hide();
        } else {
          $('.destination-input-wrapper').removeClass('hide');
          $('#table-expedition-detail').show();
        }
    });
      
    }

    function set_hq_select_driver_name(filter = {driver_register_id: ''}){
        $('#form-picking-list [name="driver_id"]').select2({
            placeholder: '-- Select Driver --',
            ajax: get_select2_ajax_options('/picking-list/select2-driver-by-register-id', filter)
          })
        
    }

    function set_hq_select_vehicle_number(filter = {expedition_code: '', vehicle_code_type: ''}){
        $('#form-picking-list select[name="vehicle_number"]').select2({
            placeholder: '-- Select Vehicle No. --',
            ajax: get_select2_ajax_options('/picking-list/select2-vehicle-number', filter)
          })
    }

    function set_hq_select_expedition(){
        $('#form-picking-list [name="expedition_code"]').select2({
            placeholder: '-- Select Expedition --',
            ajax: get_select2_ajax_options('/master-expedition/select2-all-expedition')
      })
    }


    function set_hq_select_vehicle_type(filter = {expedition_code: ''}) {
        $('#form-picking-list [name="vehicle_code_type"]').select2({
          placeholder: '-- Select Vehicle --',
          ajax: get_select2_ajax_options('/master-vehicle-expedition/select2-vehicle', filter)
        })
    }

    function set_hq_select_ship_to_city(filter = {expedition_code: ''}){
        filter.tambah_ambil_sendiri = true
      $('#form-picking-list [name="city_code"]').select2({
        placeholder: '-- Select Destination City --',
        allowClear: true,
        ajax: get_select2_ajax_options('/master-expedition/select2-expedition-destination-city', filter)
      })
    }

    function init_form_branch(){
      set_branch_select_ship_to_city()
      set_branch_select_expedition()
      set_branch_select_vehicle_type()
      $('#form-picking-list select[name="vehicle_number"]').attr('required', 'required');
      set_branch_select_vehicle_number()
      $('#form-picking-list [name="driver_id"]').attr('required', 'required');
      set_branch_select_driver_name()

      $('#form-picking-list [name="driver_id"]').change(function(event) {
          /* Act on the event */
          var data = $(this).select2('data')[0]
          $('#form-picking-list [name="driver_name"]').val(data.text)
      });
      $('#form-picking-list select[name="vehicle_number"]').change(function(event) {
          /* Act on the event */
          var data = $(this).select2('data')[0]
          set_select2_value('#form-picking-list [name="driver_id"]', '', '')
          set_branch_select_driver_name({expedition_code: data.expedition_code})
          // set_select2_value('#form-picking-list [name="driver_id"]', data.driver_id, data.driver_name)
      });
      $('#form-picking-list [name="expedition_code"]').change(function(event) {
          /* Act on the event */
          var data = $(this).select2('data')[0]
          // set_branch_select_ship_to_city({expedition_code: $(this).val()})
          set_branch_select_vehicle_type({expedition_code: $(this).val()})
          // set_select2_value('#form-picking-list [name="city_code"]', '', '')
          set_select2_value('#form-picking-list [name="vehicle_code_type"]', '', '')
          $('#form-picking-list [name="expedition_name"]').val(data.text)
      });
      $('#form-picking-list [name="vehicle_code_type"]').change(function(event) {
          /* Act on the event */
          set_select2_value('#form-picking-list select[name="vehicle_number"]', '', '')
          set_branch_select_vehicle_number({vehicle_code_type: $(this).val(), expedition_code: $('#form-picking-list [name="expedition_code"]').val()})
      });
      $('#form-picking-list [name="city_code"]').change(function(event) {
          var data = $(this).select2('data')[0];
          $('#form-picking-list [name="city_name"]').val(data == undefined ? '' : data.text);
          // Ambil Sendiri => hide expedition detail
          if ($(this).val() == 'AS') {
              $('#table-expedition-detail').hide();
          } else {
              $('#table-expedition-detail').show();
          }
      });
    }

    function set_branch_select_driver_name(filter = {expedition_code: ''}){
        $('#form-picking-list [name="driver_id"]').select2({
            placeholder: '-- Select Driver --',
            ajax: get_select2_ajax_options('/branch-master-driver/select2', filter)
          })
    }

    function set_branch_select_vehicle_number(filter = {expedition_code: '', vehicle_code_type: ''}){
        $('#form-picking-list select[name="vehicle_number"]').select2({
            placeholder: '-- Select Vehicle No. --',
            ajax: get_select2_ajax_options('/branch-expedition-vehicle/select2-vehicle-number', filter)
          })
    }

    function set_branch_select_expedition(){
        $('#form-picking-list [name="expedition_code"]').select2({
            placeholder: '-- Select Expedition --',
            ajax: get_select2_ajax_options('/master-branch-expedition/select2-active-expedition')
      })
    }


    function set_branch_select_vehicle_type(filter = {expedition_code: ''}) {
        $('#form-picking-list [name="vehicle_code_type"]').select2({
          placeholder: '-- Select Vehicle --',
          ajax: get_select2_ajax_options('/branch-expedition-vehicle/select2-vehicle', filter)
        })
    }

    function set_branch_select_ship_to_city(filter = {expedition_code: ''}){
        filter.tambah_ambil_sendiri = true
      $('#form-picking-list [name="city_code"]').select2({
        placeholder: '-- Select Destination City --',
        allowClear: true,
        ajax: get_select2_ajax_options('/destination-city-of-branch/select2', filter)
      })
    }

  

  

  // $('#form-picking-list [name="expedition_code"]').select2({
  //   placeholder: '-- Select Expedition --',
  //   ajax: get_select2_ajax_options('/master-expedition/select2-all-expedition')
  // })
  // $('#form-picking-list [name="driver_id"]').select2({
  //   placeholder: '-- Select Driver --',
  //   ajax: get_select2_ajax_options('/master-expedition/select2-all-expedition')
  // })
  // $('#form-picking-list [name="vehicle_code_type"]').select2({
  //   placeholder: '-- Select Vehicle --',
  //   ajax: get_select2_ajax_options('/master-expedition/select2-all-expedition')
  // })
  // $('#form-picking-list select[name="vehicle_number"]').select2({
  //   placeholder: '-- Select Vehicle No. --',
  //   ajax: get_select2_ajax_options('/master-expedition/select2-all-expedition')
  // })
</script>
@endpush