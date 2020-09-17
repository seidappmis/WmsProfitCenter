@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Master Driver</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Master Driver</li>
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
                       @include('web.master.master-driver._form')
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
    $("#form-master-driver").validate({
      submitHandler: function(form) {
        setLoading(true); // Disable Button when ajax post data
        var fd = new FormData(form);
        $.ajax({
          url: '{{ url('master-driver', $masterDriver->driver_id) }}',
          type: 'POST',
          data: fd,
          contentType: "application/json",
          dataType: "json",
          contentType: false,
          processData: false,
        })
        .done(function() { // selesai dan berhasil
          showSwalAutoClose('Success', 'Driver data  updated')
          window.location.href = "{{ url('master-driver') }}"
        })
        .fail(function(xhr) {
            showSwalError(xhr) // Custom function to show error with sweetAlert
            setLoading(false); // Enable Button failed
        });
      }
    });

    function set_form_data(){
      @if(!empty($masterDriver->expedition_code))
        set_select2_value('#form-master-driver [name="expedition_code"]', '{{$masterDriver->expedition_code}}', '{{$masterDriver->expedition->expedition_name}}');
        @endif
        $('#form-master-driver [name="expedition_code"]').attr('disabled', 'disabled');
        $('#form-master-driver [name="driving_license_type"]').val('{{$masterDriver->driving_license_type}}').trigger('change')
        $('select').formSelect();
    }
</script>
@endpush