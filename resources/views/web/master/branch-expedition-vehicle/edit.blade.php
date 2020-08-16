@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Branch Expedition Vehicle</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Branch Expedition Vehicle</li>
                </ol>
            </div>
        </div>
    @endcomponent

    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content">
                    	@include('web.master.branch-expedition-vehicle._form')
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
  $("#form-branch-expedition-vehicle").validate({
      submitHandler: function(form) {
        setLoading(true); // Disable Button when ajax post data
        $.ajax({
          url: '{{ url("branch-expedition-vehicle", $branchExpeditionVehicle->id) }}',
          type: 'PUT',
          data: $(form).serialize(),
        })
        .done(function() { // selesai dan berhasil
          showSwalAutoClose('Warning', 'Data Updated')
          window.location.href = "{{ url('branch-expedition-vehicle') }}"
        })
        .fail(function(xhr) {
          setLoading(false); // Enable Button failed
            showSwalError(xhr) // Custom function to show error with sweetAlert
        });
      }
    });

  function set_form_data() {
    set_select2_value('#form-branch-expedition-vehicle [name="expedition_code"]', '{{$branchExpeditionVehicle->expedition_code}}', '{{$branchExpeditionVehicle->expedition->code . '-' . $branchExpeditionVehicle->expedition->expedition_name}}');
    
    set_select2_value('#form-branch-expedition-vehicle [name="vehicle_code_type"]', '{{$branchExpeditionVehicle->vehicle_code_type}}', '{{$branchExpeditionVehicle->vehicle->vehicle_desription}}');

    @if(!empty($branchExpeditionVehicle->destination))
    set_select2_value('#form-branch-expedition-vehicle [name="destination"]', '{{$branchExpeditionVehicle->destination}}', '{{$branchExpeditionVehicle->destination_data->destination_description}}');
    @endif
  }
</script>
@endpush
