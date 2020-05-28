@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m10">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Select DO</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('assign-vehicles') }}">Assign Vehicles</a></li>
                    <li class="breadcrumb-item active">Select DO</li>
                </ol>
            </div>
            <div class="col s12 m2">
              <div class="display-flex">
                @component('layouts.materialize.components.back-button')
                @endcomponent
              </div>
            </div>
        </div>
    @endcomponent

    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content">
                        <h4 class="card-title">Delivery Order List</h4>
                        <p><b class="green-text text-darken-3"> Vehicle No : {{$driverRegistered->vehicle_number}} | {{$driverRegistered->driver_name}}</b></p>
                      <p>Expedition : <b class="green-text text-darken-3">{{$driverRegistered->expedition_code}} | {{$driverRegistered->expedition_name}}</b></p>
                      <p>CBM Truck : <b class="green-text text-darken-3">{{$driverRegistered->vehicle->cbm_max}}</b> CBM Concept : <b class="green-text text-darken-3">0</b></p>

                      @include('web.outgoing.assign-vehicles._form_select_do')
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
        $('.btn-save').html('Update');
    });


  $("#form-master-vendor").validate({
      submitHandler: function(form) {
        $.ajax({
          url: '{{ url("master-vendor/") }}',
          type: 'PUT',
          data: $(form).serialize(),
        })
        .done(function() { // selesai dan berhasil
          swal("Good job!", "You clicked the button!", "success")
            .then((result) => {
              // Kalau klik Ok redirect ke index
              window.location.href = "{{ url('master-vendor') }}"
            }) // alert success
        })
        .fail(function(xhr) {
            showSwalError(xhr) // Custom function to show error with sweetAlert
        });
      }
    });
</script>
@endpush
