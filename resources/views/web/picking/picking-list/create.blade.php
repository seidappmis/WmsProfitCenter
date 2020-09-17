@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Picking List</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Picking List</li>
                </ol>
            </div>
        </div>
    @endcomponent

    <div class="col s12">
        <div class="container">

            <div class="section">

              <div class="card">
                <div class="card-content p-0">
                  <ul class="collapsible m-0">
                    <li class="active">
                      <div class="collapsible-header"><i class="material-icons">keyboard_arrow_right</i>CREATE / EDIT</div>
                      <div class="collapsible-body padding-1">
                          @include('web.picking.picking-list._form_picking_list')
                          {{-- @include('web.picking.picking-list._form_assign_item_picking') --}}
                      </div>
                    </li>
                  </ul>
                </div>
                <div class="content-overlay"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection

@push('vendor_js')
<script src="{{ asset('materialize/vendors/jquery-validation/jquery.validate.min.js') }}">
</script>
@endpush

@push('script_js')
<script type="text/javascript">
    $("#form-picking-list").validate({
      submitHandler: function(form) {
        setLoading(true); // Disable Button when ajax post data
        $.ajax({
          url: '{{ url("picking-list") }}',
          type: 'POST',
          data: $(form).serialize(),
        })
        .done(function(result) { // selesai dan berhasil
          if (result.status) {
            showSwalAutoClose('Success', result.message)
            window.location.href = "{{ url('picking-list') }}" + '/' + result.data.id + '/edit';
          } else {
            showSwalAutoClose('Warning', result.message)
            setLoading(false); // Enable Button when failed
          }
        })
        .fail(function(xhr) {
          setLoading(false); // Enable Button when failed
            showSwalError(xhr) // Custom function to show error with sweetAlert
        });
      }
    });
</script>
@endpush
