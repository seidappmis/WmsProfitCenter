@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m8">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Create Incoming Import/OEM</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('incoming-import-oem') }}">Incoming Import/OEM</a></li>
                    <li class="breadcrumb-item active">Create</li>
                </ol>
            </div>
            <div class="col s12 m3">
                <!---- Search ----->
                <div class="app-wrapper mr-2 area-wrapper">
                  <div class="datatable-search">
                    <select id="area_filter"
                          class="select2-data-ajax browser-default app-filter">
                  </select>
                  </div>
                </div>
              </div>
            <div class="col s12 m1">
                <!---- Button Back ----->
                <a class="btn btn-large waves-effect waves-light indigo right btn-back" href="{{ url('incoming-import-oem') }}">Back</a>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
      <div class="container">
        <div class="section">
          <div class="card">
            <div class="card-content">
              <h4 class="card-title">INPUT INCOMING IMPORT/OEM/OTHERS</h4>
              <hr>
              @include('web.incoming.incoming-import-oem._form_header')
            </div>
            <div class="card-content">
              <!-- Incoming Detail -->
              <h4 class="card-title">Incoming Detail</h4>
              <hr>
              <form class="form-table">
                <table></table>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection

@push('script_js')
<script src="{{ asset('materialize/vendors/jquery-validation/jquery.validate.min.js') }}">
</script>
@endpush

@push('script_js')
<script type="text/javascript">
  // $('.collapsible').collapsible({
  //       accordion:true
  //   });
  jQuery(document).ready(function($) {
    @if(auth()->user()->cabang->hq)
      $('#area_filter').select2({
         placeholder: '-- Select Area --',
         allowClear: true,
         ajax: get_select2_ajax_options('/master-area/select2-area-only')
      });
      @if (auth()->user()->area != 'All')
        $('#area_filter').attr('disabled', 'disabled');
        set_select2_value('#area_filter', '{{auth()->user()->area}}', '{{auth()->user()->area}}')
        $("#form-incoming-import-oem-header [name='area_code']").val('{{auth()->user()->area_data->code}}')
        $("#form-incoming-import-oem-header [name='area']").val('{{auth()->user()->area}}')
      @else
        $('#area_filter').attr('disabled', 'disabled');
        set_select2_value('#area_filter', '{{$area->area}}', '{{$area->area}}')
        $("#form-incoming-import-oem-header [name='area_code']").val('{{$area->code}}')
        $("#form-incoming-import-oem-header [name='area']").val('{{$area->area}}')
      @endif
    @else
    $('.area-wrapper').hide()
    @endif
    $("#form-incoming-import-oem-header").validate({
      submitHandler: function(form) {
        $.ajax({
          url: '{{ url("incoming-import-oem") }}',
          type: 'POST',
          data: $(form).serialize(),
        })
        .done(function(data) { // selesai dan berhasil
          swal("Good job!", "You clicked the button!", "success")
            .then((result) => {
              // Kalau klik Ok redirect ke view
              window.location.href = "{{ url('incoming-import-oem') }}" + '/' + data.arrival_no
            }) // alert success
        })
        .fail(function(xhr) {
            showSwalError(xhr) // Custom function to show error with sweetAlert
        });
      }
    });
  });
</script>
@endpush