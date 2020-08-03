@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Master Destination</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Master Destination</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content">
                        <h4 class="card-title">Edit Destination</h4>
                        @include('web.master.master-destination._form')
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
      set_initial_form_data();
      $('.btn-save').html('Update');
  });

    function set_initial_form_data(){

      @if(!empty($masterDestination->kode_cabang))
        set_select2_value('#cabang', '{{$masterDestination->kode_cabang}}', '{{$masterDestination->MasterCabang->kode_cabang}}')
      @endif

        set_select2_value('#current_region_input', '{{$masterDestination->region}}', '{{$masterDestination->Region->region}}')
    };

    $("#form-master-destination").validate({
     submitHandler: function(form) {
       $.ajax({
         url: '{{ url("master-destination/" . $masterDestination->destination_number)}}',
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
             window.location.href = "{{ url('master-destination') }}"
           }) // alert success
       })
       .fail(function(xhr) {
           showSwalError(xhr) // Custom function to show error with sweetAlert
       });

     }
   });
</script>
@endpush