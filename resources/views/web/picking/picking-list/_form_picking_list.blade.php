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
                    <input type="text" class="validate" name="gate_number" value="{{ !empty($pickinglistHeader->gate_number) ? $pickinglistHeader->gate_number : '' }}" {{ !empty($pickinglistHeader->gate_number) ? 'readonly' : 'required' }} >
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
                        <option value="" disabled selected>-Select Area-</option>
                        <option value="1">SLEMAN</option>
                        <option value="2">YOGYA KOTA</option>
                        <option value="3">BANTUL</option>
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
                    <select name="expedition_code" class="select2-data-ajax browser-default">
                        <option value="" disabled selected>-Select Area-</option>
                        <option value="1">SLEMAN</option>
                        <option value="2">YOGYA KOTA</option>
                        <option value="3">BANTUL</option>
                    </select>
                </div>
            </td>
            <td width="120px;">
                <P>Driver Name</P>
            </td>
            <td>
                <div class="input-field col s12 m6">
                    <select name="driver_id" class="select2-data-ajax browser-default">
                        <option value="" disabled selected>-Select Driver-</option>
                        <option value="1">SLEMAN</option>
                        <option value="2">YOGYA KOTA</option>
                        <option value="3">BANTUL</option>
                    </select>
                </div>
                <div class="input-field col s12 m6">
                    <input value="" id="notag" type="text" class="validate" name="notag">
                </div>
            </td>
        </tr>
        <tr>
            <td>Vehicle Type</td>
            <td>
                <div class="input-field col s12">
                    <select name="vehicle_code_type" class="select2-data-ajax browser-default">
                        <option value="" disabled selected>-Select Area-</option>
                        <option value="1">SLEMAN</option>
                        <option value="2">YOGYA KOTA</option>
                        <option value="3">BANTUL</option>
                    </select>
                </div>
            </td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Vehicle No</td>
            <td>
                <div class="input-field col s12 m6">
                    <select name="vehicle_number" class="select2-data-ajax browser-default">
                        <option value="" disabled selected>-Select Area-</option>
                        <option value="1">SLEMAN</option>
                        <option value="2">YOGYA KOTA</option>
                        <option value="3">BANTUL</option>
                    </select>
                </div>
                <div class="input-field col s12 m6">
                    <input value="" id="notag" type="text" class="validate" name="notag">
                </div>
            </td>
            <td></td>
            <td></td>
        </tr>
    </table>
    <div class="row pl-1">
        <div class="input-field col s12">
            {!! get_button_save('Save') !!}
            {!! get_button_cancel(url('picking-list'),'Back') !!}
        </div>
    </div>
</form>

@push('script_js')
<script type="text/javascript">

    jQuery(document).ready(function($) {
        @if(auth()->user()->cabang->hq)
        init_form_hq()
        @else
        init_form_branch()
        @endif
    });

    function init_form_hq(){
      $('#form-picking-list [name="city_code"]').select2({
        placeholder: '-- Select City --',
        ajax: get_select2_ajax_options('/destination-city/select2-destination-city')
      })
      $('#form-picking-list [name="city_code"]').change(function(event) {
          var data = $(this).select2('data')[0];
          $('#form-picking-list [name="city_name"]').val(data.text);
          // Ambil Sendiri => hide expedition detail
          if ($(this).val() == 'AS') {
              $('#table-expedition-detail').hide();
          } else {
              $('#table-expedition-detail').show();
          }
      });
    }

    function init_form_branch(){

    }

  $('#form-picking-list [name="storage_id"]').select2({
    placeholder: '-- Select Storage --',
    ajax: get_select2_ajax_options('/storage-master/select2-user-storage-without-intransit')
  })
  $('#form-picking-list [name="storage_id"]').change(function(event) {
      var data = $(this).select2('data')[0];
      $('#form-picking-list [name="storage_name"]').val(data.text);
  });

  

  $('#form-picking-list [name="expedition_code"]').select2({
    placeholder: '-- Select Expedition --',
    ajax: get_select2_ajax_options('/master-expedition/select2-all-expedition')
  })
  $('#form-picking-list [name="driver_id"]').select2({
    placeholder: '-- Select Driver --',
    ajax: get_select2_ajax_options('/master-expedition/select2-all-expedition')
  })
  $('#form-picking-list [name="vehicle_code_type"]').select2({
    placeholder: '-- Select Vehicle --',
    ajax: get_select2_ajax_options('/master-expedition/select2-all-expedition')
  })
  $('#form-picking-list [name="vehicle_number"]').select2({
    placeholder: '-- Select Vehicle No. --',
    ajax: get_select2_ajax_options('/master-expedition/select2-all-expedition')
  })
</script>
@endpush