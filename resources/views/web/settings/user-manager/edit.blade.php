@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>User Manager</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">User Manager</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content">
                    	<h4 class="card-title">Edit User</h4>
                        @include('web.settings.user-manager._form')
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
        set_initial_form_value();
    });

    $("#form-user-manager").validate({
      submitHandler: function(form) {
        setLoading(true); // Disable Button when ajax post data
        $.ajax({
          url: '{{ url("user-manager/" . $user->id) }}',
          type: 'PUT',
          data: $(form).serialize(),
        })
        .done(function() { // selesai dan berhasil
            showSwalAutoClose("Success", 'Data Updated.')
          window.location.href = "{{ url('user-manager') }}"
        })
        .fail(function(xhr) {
            setLoading(false); // Enable Button when failed
            showSwalError(xhr) // Custom function to show error with sweetAlert
        });
      }
    });

    function set_initial_form_value(){
        set_select2_value('#form-user-manager [name="roles_id"]', '{{$user->roles_id}}', '{{$user->role->roles_name}}');
        set_select2_value('#form-user-manager [name="area"]', '{{$user->area}}', '{{$user->area}}');
        @if (!empty($user->cabang))
        set_select2_value('#form-user-manager [name="kode_customer"]', '{{$user->kode_customer}}', '{{ "[" . $user->cabang->short_description . "]" . $user->cabang->long_description}}');
        @endif
    }
</script>
@endpush