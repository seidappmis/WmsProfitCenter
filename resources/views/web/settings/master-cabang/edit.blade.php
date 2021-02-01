@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Master Cabang</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Master Cabang</li>
                </ol>
            </div>
        </div>
    @endcomponent

    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content">
                    	<h4 class="card-title">Edit Cabang</h4>
                    	@include('web.settings.master-cabang._form')
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
        set_initial_form_data();
        $('.btn-save').html('Update');
    });

    function set_initial_form_data(){
        $('#tycode').val('{{$masterCabang->type}}').trigger('change')
        @if(!empty($masterCabang->Region))
        set_select2_value('#region', '{{$masterCabang->region}}', '{{$masterCabang->Region->region}}')
        @endif
    };

 	$("#form-master-cabang").validate({
      submitHandler: function(form) {
        setLoading(true); // Disable Button when ajax post data
        $.ajax({
          url: '{{ url("master-cabang/" . $masterCabang->kode_customer) }}',
          type: 'PUT',
          data: $(form).serialize(),
        })
        .done(function() { // selesai dan berhasil
            showSwalAutoClose('Success', 'Data updated.')
          window.location.href = "{{ url('master-cabang') }}"
        })
        .fail(function(xhr) {
            setLoading(false); // Enable Button when failed
            showSwalError(xhr) // Custom function to show error with sweetAlert
        });
      }
    });
</script>
@endpush
