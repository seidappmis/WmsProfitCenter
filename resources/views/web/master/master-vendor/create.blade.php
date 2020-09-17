@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Master Vendor</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Master Vendor</li>
                </ol>
            </div>
        </div>
    @endcomponent

    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content">
                        <h4 class="card-title">New Data</h4>
                        @include('web.master.master-vendor._form')
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
    $("#form-master-vendor").validate({
      submitHandler: function(form) {
        setLoading(true); // Disable Button when ajax post data
        $.ajax({
          url: '{{ url("master-vendor") }}',
          type: 'POST',
          data: $(form).serialize(),
        })
        .done(function() { // selesai dan berhasil
            showSwalAutoClose('Success', 'Data Created.')
          window.location.href = "{{ url('master-vendor') }}"
        })
        .fail(function(xhr) {
            setLoading(false); // Enable Button when failed
            showSwalError(xhr) // Custom function to show error with sweetAlert
        });
      }
    });
</script>
@endpush
