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
                        <h4 class="card-title">New Driver</h4>
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
    $("#form-branch-master-driver").validate({
      submitHandler: function(form) {
        setLoading(true); // Disable Button when ajax post data
        var fd = new FormData(form);
        $.ajax({
          url: '{{ url('branch-master-driver') }}',
          type: 'POST',
          data: fd,
          contentType: "application/json",
          dataType: "json",
          contentType: false,
          processData: false,
        })
        .done(function() { // selesai dan berhasil
          showSwalAutoClose('Success', 'Branch Driver Created')
          window.location.href = "{{ url('branch-master-driver') }}"
        })
        .fail(function(xhr) {
          setLoading(false); // Enable Button when failed
          showSwalError(xhr) // Custom function to show error with sweetAlert
        });
      }
    });
</script>
@endpush