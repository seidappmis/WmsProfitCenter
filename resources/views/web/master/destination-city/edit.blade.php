@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Destination City</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Destination City</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content ">
                        <h4 class="card-title">Edit Destination City</h4>
                        @include('web.master.destination-city._form')
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
        $('.btn-save').html('Update');
    });

 	$("#form-destination-city").validate({
      submitHandler: function(form) {
        $.ajax({
          url: '{{ url("destination-city/" . $destinationCity->city_code) }}',
          type: 'PUT',
          data: $(form).serialize(),
        })
        .done(function() { // selesai dan berhasil
          swal({
            icon: "success",
            title: "Good job!",
            text: "You clicked the button!",
            timer: 1000,
            buttons: false
          })
            .then((result) => { 
              // Kalau klik Ok redirect ke index
              window.location.href = "{{ url('destination-city') }}"
            }) // alert success
        })
        .fail(function(xhr) {
            showSwalError(xhr) // Custom function to show error with sweetAlert
        });

      }
    });
</script>
@endpush