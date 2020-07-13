@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Edit Assign Vehicle</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Edit Assign Vehicle</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content">
                        <form id="form-assign-vehicle">
                        <div id="form-assign-vehicle-wrapper">
                          <input type="hidden" name="driver_id">
                          <table class="form-table">
                            <tr>
                              <td class="label">Vehicle No.</td>
                              <td>
                                {{$driverRegistered->vehicle_number}}
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
                              <td><span id="text-capacity-cbm"></span></td>
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
                          </table>
                          <br>
                          <button type="submit" class="waves-effect waves-light indigo btn">Save</button>
                          {!!get_button_cancel(url('picking-list'))!!}
                        </div>
                      </form>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-overlay"></div>
    </div>
</div>
@endsection

@push('vendor_js')
<script src="{{ asset('materialize/vendors/jquery-validation/jquery.validate.min.js') }}">
</script>
@endpush


@push('script_js')
<script type="text/javascript">
    jQuery(document).ready(function($) {
        set_form_data();
    });
    $("#form-assign-vehicle").validate({
      submitHandler: function(form) {
        $.ajax({
          url: '{{ url("assign-vehicles", $driverRegistered->id) }}',
          type: 'PUT',
          data: $(form).serialize(),
        })
        .done(function() { // selesai dan berhasil
          swal("Good job!", "You clicked the button!", "success")
            .then((result) => {
              // Kalau klik Ok redirect ke index
              window.location.href = "{{ url('picking-list') }}"
            }) // alert success
        })
        .fail(function(xhr) {
            showSwalError(xhr) // Custom function to show error with sweetAlert
        });
      }
    });

    $('#form-assign-vehicle [name="vehicle_code_type"]').select2({
         placeholder: '-- Select Vehicle --',
         ajax: get_select2_ajax_options('/master-vehicle/select2-vehicle')
      });

    $('#form-assign-vehicle [name="vehicle_code_type"]').change(function(event) {
      /* Act on the event */
      var data = $(this).select2('data')[0]
      $('#text-capacity-cbm').text(data.cbm_max == undefined ? '{{$driverRegistered->vehicle->cbm_max}}' : data.cbm_max)
    });

    $('#form-assign-vehicle [name="destination_number"]').select2({
         placeholder: '-- Select Destination --',
         ajax: get_select2_ajax_options('/master-destination/select2-destination')
      });

    $('#form-assign-vehicle [name="destination_number"]').change(function(event) {
      /* Act on the event */
      var data = $(this).select2('data')[0];
      $('#form-assign-vehicle [name="destination_name"]').val(data.text);
    });

    $('#form-assign-vehicle [name="vehicle_code_type"]').change(function(event) {
      /* Act on the event */
      var data = $(this).select2('data')[0];
      $('#form-assign-vehicle [name="vehicle_description"]').val(data.text);
    });

    function set_form_data(){
        set_select2_value('#form-assign-vehicle [name="vehicle_code_type"]', '{{$driverRegistered->vehicle_code_type}}', '{{$driverRegistered->vehicle_description}}');
        set_select2_value('#form-assign-vehicle [name="destination_number"]', '{{$driverRegistered->destination_number}}', '{{$driverRegistered->destination_name}}');
    }
</script>
@endpush