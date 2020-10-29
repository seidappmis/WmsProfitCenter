@extends('layouts.materialize.index')

@section('content')
<div class="row">

  @component('layouts.materialize.components.title-wrapper')
      <div class="row">
          <div class="col s12 m9">
              <h5 class="breadcrumbs-title mt-0 mb-0"><span>Manifest AS</span></h5>
              <ol class="breadcrumbs mb-0">
                  <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                  <li class="breadcrumb-item active">Manifest AS</li>
              </ol>
          </div>
          <div class="col s12 m3">
            <!---- Search ----->
                <div class="app-wrapper">
                  <div class="datatable-search">
                    <select id="area_filter">
                      {{-- <option>-Select Area-</option>
                      <option>KARAWANG</option>
                      <option>SURABAYA HUB</option>
                      <option>SWADAYA</option> --}}
                    </select>
                  </div>
                </div>
          </div>
      </div>
  @endcomponent
<div class="col s12">
  @include('web.outgoing.manifest-as._lmb_waiting_manifest')
  @include('web.outgoing.manifest-as._data_manifest_as')

    <div class="content-overlay"></div>
  </div>
</div>
@endsection

@push('script_js')
<script type="text/javascript">
  $('#area_filter').select2({
     placeholder: '-- Select Area --',
     allowClear: true,
     ajax: get_select2_ajax_options('{{url('/master-area/select2-area-only')}}')
  });
  @if (auth()->user()->area != 'All')
      set_select2_value('#area_filter', '{{auth()->user()->area}}', '{{auth()->user()->area}}')
      $('#area_filter').attr('disabled','disabled')
    @endif
  jQuery(document).ready(function($) {
    $('#area_filter').change(function(event) {
      /* Act on the event */
      dtdatatable_data_manifest_normal.ajax.reload(null, false)
    });
  });
</script>
@endpush