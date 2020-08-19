@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Master Model</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Master Model</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content">
                        <h4 class="card-title">Edit Data</h4>
                        @include('web.master.master-model._form')
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
        @if (!empty($masterModel->material_group))
        set_select2_value('#material_group', '{{$masterModel->material_group}}', '{{$masterModel->ModelMaterialGroup->description}}');
        @endif

        @if (!empty($masterModel->category))
        set_select2_value('#category', '{{$masterModel->category}}', '{{$masterModel->ModelCategory->category_name}}');
        @endif

        @if (!empty($masterModel->model_type))
        set_select2_value('#model_type', '{{$masterModel->model_type}}', '{{$masterModel->ModelType->model_type}}');
        @endif
    };

    $("#form-master-model").validate({
      submitHandler: function(form) {
        setLoading(true); // Disable Button when ajax post data
        $.ajax({
          url: '{{ url("master-model/" . $masterModel->id) }}',
          type: 'PUT',
          data: $(form).serialize(),
        })
        .done(function() { // selesai dan berhasil
            showSwalAutoClose('Success', 'Data Updated.')
          window.location.href = "{{ url('master-model') }}"
        })
        .fail(function(xhr) {
            setLoading(false); // Enable Button when failed
            showSwalError(xhr) // Custom function to show error with sweetAlert
        });
      }
    });
</script>
@endpush