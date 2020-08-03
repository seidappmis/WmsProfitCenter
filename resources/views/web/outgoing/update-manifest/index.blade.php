@extends('layouts.materialize.index')

@section('content')
<div class="row">

  @component('layouts.materialize.components.title-wrapper')
      <div class="row">
          <div class="col s12 m9">
              <h5 class="breadcrumbs-title mt-0 mb-0"><span>Update Manifest</span></h5>
              <ol class="breadcrumbs mb-0">
                  <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                  <li class="breadcrumb-item active">Update Manifest</li>
              </ol>
          </div>
          <div class="col s12 m3">
            <!---- Search ----->
                <div class="app-wrapper">
                  <div class="datatable-search">
                    <select id="area_filter">
                    </select>
                  </div>
                </div>
          </div>
      </div>
  @endcomponent

  <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card pl-1 pt-2">
                    <form id="form-search-manifest">
                      <div class="row">
                        <div class="input-field col s6 m4 l3">
                          <input placeholder="No. Manifest" id="manifest_no" name="manifest_no" type="text" class="validate" autocomplete="off">
                          <label for="manifest_no">No. Manifest</label>
                        </div>
                        <div class="input-field col s6 m4 l3">
                          <input placeholder="No. DO" id="delivery_no" name="delivery_no" type="text" class="validate" autocomplete="off">
                          <label for="delivery_no">No. DO</label>
                        </div>
                        <div class="col s6 m3">
                          {!!get_button_save('Search', 'btn-search-manifest mt-5')!!}
                        </div>
                      </div>
                    </form>
                    @include('web.outgoing.update-manifest._form_update_manifest')
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
  $('#area_filter').select2({
     placeholder: '-- Select Area --',
     allowClear: true,
     ajax: get_select2_ajax_options('/master-area/select2-area-only')
  });
  jQuery(document).ready(function($) {
    @if (auth()->user()->area != 'All')
        set_select2_value('#area_filter', '{{auth()->user()->area}}', '{{auth()->user()->area}}')
        $('#area_filter').attr('disabled','disabled')
      @endif
    $('.btn-search-manifest').click(function(event) {
      /* Act on the event */
     
    });
    $("#form-search-manifest").validate({
      submitHandler: function(form) {
        $.ajax({
          url: '{{ url("update-manifest") }}',
          type: 'POST',
          data: $(form).serialize() + '&area=' + $('#area_filter').val(),
        })
        .done(function(result) { // selesai dan berhasil
          if (result.status) {
            $('#form-search-manifest').addClass('hide');
            $('.form-update-manifest-wrapper').removeClass('hide');
          } else {
            showSwalAutoClose('', result.message);
          }
        })
        .fail(function(xhr) {
            showSwalError(xhr) // Custom function to show error with sweetAlert
        });
      }
    });
  });

</script>
@endpush