@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Branch Master Driver</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Branch Master Driver</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content">
                        <h4 class="card-title">Edit Driver</h4>
                        @include('web.master.branch-master-driver._form')
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
    $("#form-branch-master-driver").validate({
      submitHandler: function(form) {
        var fd = new FormData(form);
        $.ajax({
          url: '{{ url('branch-master-driver', $branchDriver->driver_id) }}',
          type: 'POST',
          data: fd,
          contentType: "application/json",
          dataType: "json",
          contentType: false,
          processData: false,
        })
        .done(function() { // selesai dan berhasil
          swal("Good job!", "You clicked the button!", "success")
            .then((result) => {
              // Kalau klik Ok redirect ke index
              window.location.href = "{{ url('branch-master-driver') }}"
            }) // alert success
        })
        .fail(function(xhr) {
            showSwalError(xhr) // Custom function to show error with sweetAlert
        });
      }
    });

    function set_form_data(){
        set_select2_value('#form-branch-master-driver [name="expedition_code"]', '{{$branchDriver->expedition_code}}', '{{$branchDriver->expedition->expedition_name}}');
        $('#form-branch-master-driver [name="expedition_code"]').attr('disabled', 'disabled');
        $('#form-branch-master-driver [name="driving_lisence_type"]').val('{{$branchDriver->driving_lisence_type}}').trigger('change')
        $('select').formSelect();
    }
</script>
@endpush