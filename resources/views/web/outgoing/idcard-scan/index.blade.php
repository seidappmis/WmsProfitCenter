@extends('layouts.materialize.index')

@section('content')
<div class="row">

  @component('layouts.materialize.components.title-wrapper')
      <div class="row">
          <div class="col s12 m5">
              <h5 class="breadcrumbs-title mt-0 mb-0"><span>IDCard Scan</span></h5>
              <ol class="breadcrumbs mb-0">
                  <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                  <li class="breadcrumb-item active">IDCard Scan</li>
              </ol>
          </div>
      </div>
  @endcomponent

  <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content">
                        <table class="form-table">
                          <tr>
                            <td width="20%" class="label">Driver ID</td>
                            <td>
                              <div class="row">
                                <div class="col s12 m6 l3">
                                  <input placeholder="" id="search-driver-id" type="text" class="validate" maxlength="10" required="">
                                </div>
                              </div>
                            </td>
                          </tr>
                        </table>
                      <form id="form-id-card-scan">
                        <div id="form-id-card-scan-wrapper" style="display: none;">
                          <input type="hidden" name="driver_id">
                          <table class="form-table">
                            <tr>
                              <td width="20%" class="label">Driver Name</td>
                              <td><input type="text" name="driver_name" readonly="readonly"></td>
                              <td width="30%" rowspan="7" class="center-align">
                                <img src="{{asset('images/profil.png')}}" width="120px">
                              </td>
                            </tr>
                            <tr>
                              <td class="label">Transporter</td>
                              <td>
                                <input type="hidden" name="expedition_code">
                                <input type="text" name="expedition_name" readonly="readonly">
                              </td>
                            </tr>
                            <tr>
                              <td class="label">Vehicle No.</td>
                              <td>
                                <div class="input-field col s12">
                                  <select required="" name="vehicle_number" class="select2-data-ajax browser-default ">
                                  </select>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td class="label">Vehicle Type</td>
                              <td>
                                <div class="input-field col s12">
                                  <select required="" name="vehicle_code_type" class="select2-data-ajax browser-default ">
                                  </select>
                                  <input type="hidden" name="vehicle_description">
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td class="label">Capacity (CBM)</td>
                              <td><span id="text-cbm-min"></span> to <span id="text-cbm-max"></span></td>
                            </tr>
                            <tr>
                              <td class="label">Destination</td>
                              <td>
                                <div class="input-field col s12">
                                  <select required="" name="destination_number" class="select2-data-ajax browser-default ">
                                  </select>
                                  <input type="hidden" name="destination_name">
                                </div>
                              </td>
                            </tr>
                            <tr id="input-area-wrapper">
                              <td class="label">Area</td>
                              <td>
                                <div class="input-field col s12">
                                  <select required="" name="area" class="select2-data-ajax browser-default ">
                                  </select>
                                </div>
                              </td>
                            </tr>
                          </table>
                          <br>
                          <button type="submit" class="waves-effect waves-light indigo btn">Save</button>
                          <button type="" class="waves-effect waves-light btn">Clear</button>
                        </div>
                      </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-overlay"></div>
    </div>

</div>
@endsection


@push('script_js')
<script src="{{ asset('materialize/vendors/jquery-validation/jquery.validate.min.js') }}">
</script>
@endpush


@push('script_js')
<script type="text/javascript">
  jQuery(document).ready(function($) {
    set_select2_vehicle_number()
    
  });
    $('#search-driver-id').keyup(function(event) {
      /* Act on the event */
      if ($(this).val().length == 10) {
        $.ajax({
          url: '{{ url("idcard-scan") }}' + '/' + $(this).val(),
          type: 'GET',
          dataType: 'json'
        })
        .done(function(data) { // selesai dan berhasil
          if (data.status) {
            $('#form-id-card-scan [name="driver_id"]').val(data.data.driver_id)
            $('#form-id-card-scan [name="driver_name"]').val(data.data.driver_name)
            $('#form-id-card-scan [name="expedition_code"]').val(data.data.expedition_code)
            $('#form-id-card-scan [name="expedition_name"]').val(data.data.expedition.expedition_name)
            set_select2_value('#form-id-card-scan [name="destination_number"]', '', '')
            set_select2_vehicle_number({expedition_code: data.data.expedition_code})
            set_select2_value('#form-id-card-scan [name="vehicle_number"]', '', '')
            set_select2_value('#form-id-card-scan [name="vehicle_code_type"]', '', '')
            $('#text-cbm-min').text('')
            $('#text-cbm-max').text('')
            $('#form-id-card-scan-wrapper').show();
          } else {
            $('#form-id-card-scan-wrapper').hide();
            swal("Failed!", data.message, "error")
          }
        })
        .fail(function(xhr) {
          $('#form-id-card-scan-wrapper').hide();
          
          showSwalAutoClose('Not Found!', "Driver not found/not active in master driver");
          // swal("Not Found!", "Driver not found/not active in master driver", "error")
            // showSwalError(xhr) // Custom function to show error with sweetAlert
        });
      }
    });

    $("#form-id-card-scan").validate({
      submitHandler: function(form) {
        $.ajax({
          url: '{{ url("idcard-scan") }}',
          type: 'POST',
          data: $(form).serialize(),
        })
        .done(function() { // selesai dan berhasil
          swal("Good job!", "You clicked the button!", "success")
            .then((result) => {
              // Kalau klik Ok redirect ke index
              window.location.href = "{{ url('idcard-scan') }}"
            }) // alert success
        })
        .fail(function(xhr) {
            showSwalError(xhr) // Custom function to show error with sweetAlert
        });
      }
    });

    $('#form-id-card-scan [name="destination_number"]').change(function(event) {
      /* Act on the event */
      var data = $(this).select2('data')[0];
      $('#form-id-card-scan [name="destination_name"]').val(data.text);
    });

    $('#form-id-card-scan [name="vehicle_code_type"]').change(function(event) {
      /* Act on the event */
      var data = $(this).select2('data')[0];
      $('#form-id-card-scan [name="vehicle_description"]').val(data.text);
    });

    jQuery(document).ready(function($) {
      $('#form-id-card-scan [name="destination_number"]').select2({
         placeholder: '-- Select Destination --',
         ajax: get_select2_ajax_options('/master-destination/select2-destination')
      });

      $('#form-id-card-scan [name="area"]').select2({
         placeholder: '-- Select Area --',
         ajax: get_select2_ajax_options('/master-area/select2-areas')
      });

      @if (auth()->user()->area != 'All')
        set_select2_value('#form-id-card-scan [name="area"]', '{{auth()->user()->area}}', '{{auth()->user()->area}}')
        $('#input-area-wrapper').addClass('hide')
      @endif

    });

    function set_select2_vehicle_number(filter = {expedition_code: ''}){
      $('#form-id-card-scan [name="vehicle_number"]').select2({
         placeholder: '-- Select Vehicle Number --',
         ajax: get_select2_ajax_options('/idcard-scan/select2-vehicle-number', filter)
      });

      $('#form-id-card-scan [name="vehicle_number"]').change(function(event) {
        /* Act on the event */
        var data = $(this).select2('data')[0]
        set_select2_vehicle_code_type({vehicle_group_id: data.vehicle_group_id})
        $('#text-cbm-min').text(data.cbm_min)
        $('#text-cbm-max').text(data.cbm_max)
        if (data.vehicle_code_type != undefined) {
          set_select2_value('#form-id-card-scan [name="vehicle_code_type"]', data.vehicle_code_type, data.vehicle_description)
        }
      });
    }

    function set_select2_vehicle_code_type(filter = {vehicle_group_id: ''}){
      $('#form-id-card-scan [name="vehicle_code_type"]').select2({
         placeholder: '-- Select Vehicle Type --',
         ajax: get_select2_ajax_options('/master-vehicle/select2-vehicle', filter)
      });
      $('#form-id-card-scan [name="vehicle_code_type"]').change(function(event) {
        /* Act on the event */
        var data = $(this).select2('data')[0]
        $('#text-cbm-min').text(data.cbm_min)
        $('#text-cbm-max').text(data.cbm_max)
      });
    }
</script>
@endpush