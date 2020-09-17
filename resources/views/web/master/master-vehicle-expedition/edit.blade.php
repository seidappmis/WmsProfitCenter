@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Master Vehicle Expedition</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Master Vehicle Expedition</li>
                </ol>
            </div>
        </div>
    @endcomponent

    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content">
                    	@include('web.master.master-vehicle-expedition._form')
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
  $("#form-master-vehicle-expedition").validate({
      submitHandler: function(form) {
        setLoading(true); // Disable Button when ajax post data
        $.ajax({
          url: '{{ url("master-vehicle-expedition", $masterVehicleExpedition->id) }}',
          type: 'PUT',
          data: $(form).serialize(),
        })
        .done(function() { // selesai dan berhasil
          showSwalAutoClose('Success', 'Data updated.')
          window.location.href = "{{ url('master-vehicle-expedition') }}"
        })
        .fail(function(xhr) {
          setLoading(false); // Enable Button when failed
            showSwalError(xhr) // Custom function to show error with sweetAlert
        });
      }
    });

  function set_form_data() {
    set_select2_value('#form-master-vehicle-expedition [name="vehicle_code_type"]', '{{$masterVehicleExpedition->vehicle_code_type}}', '{{$masterVehicleExpedition->VehicleDetail->vehicle_description}}');
    set_select2_value('#form-master-vehicle-expedition [name="expedition_code"]', '{{$masterVehicleExpedition->expedition_code}}', '{{$masterVehicleExpedition->MasterExpedition->code . '-' . $masterVehicleExpedition->MasterExpedition->expedition_name}}');

    @if(!empty($masterVehicleExpedition->destination_data)) // dieksekusi cuma kalau destination_data nya ada isinya
    set_select2_value('#form-master-vehicle-expedition [name="destination"]', '{{$masterVehicleExpedition->destination}}', '{{$masterVehicleExpedition->destination_data->destination_description}}');
    @endif
  }
</script>
@endpush
