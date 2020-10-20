@extends('layouts.materialize.index')

@section('content')
<div class="row">

  @component('layouts.materialize.components.title-wrapper')
      <div class="row">
          <div class="col s12 m9">
              <h5 class="breadcrumbs-title mt-0 mb-0"><span>Branch Manifest</span></h5>
              <ol class="breadcrumbs mb-0">
                  <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                  <li class="breadcrumb-item active">Branch Manifest</li>
              </ol>
          </div>
      </div>
  @endcomponent
<div class="col s12">
  @include('web.outgoing.branch-manifest._truck_waiting_manifest')
  @include('web.outgoing.branch-manifest._data_manifest_normal')

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
  jQuery(document).ready(function($) {
    @if (auth()->user()->area != 'All')
        set_select2_value('#area_filter', '{{auth()->user()->area}}', '{{auth()->user()->area}}')
        $('#area_filter').attr('disabled','disabled')
      @endif
  });
</script>
@endpush