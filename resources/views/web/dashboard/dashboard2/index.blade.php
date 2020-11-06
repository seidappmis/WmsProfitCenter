@extends('layouts.materialize.index')

@section('content')
  @component('layouts.materialize.components.title-wrapper')
      <div class="row">
          <div class="col s12 m8 mb-1">
              <h5 class="breadcrumbs-title mt-0 mb-0"><span>Graphic Dashboard 2</span></h5>
              <ol class="breadcrumbs mb-0">
                  <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                  <li class="breadcrumb-item active">Graphic Dashboard 2</li>
              </ol>
          </div>
          <div class="col s12 m4">
            <!---- Search ----->
                <div class="app-wrapper">
                  <div class="datatable-search">
                    <select id="area_filter" class="select2-data-ajax browser-default app-filter">
                    </select>
                  </div>
                </div>
          </div>
      </div>
  @endcomponent

<div class="row">
    <div class="col s12 m6">
        <div class="">
            <div class="section">
                <div class="card">
                    <div class="card-content">
                        <h4 class="header m-0">Daily By Destination</h4>
                        @include('web.dashboard.dashboard2._daily_by_destination_graph')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col s12 m6">
        <div class="">
            <div class="section">
                <div class="card">
                    <div class="card-content">
                        <h4 class="header m-0">Daily By Category</h4>
                        @include('web.dashboard.dashboard2._daily_by_category_graph')
                    </div>
                </div>

            </div>
            
        </div>
    </div>
</div>
@endsection

@push('script_js')
<script type="text/javascript">
      $('#area_filter').select2({
         placeholder: '-- Select Area --',
         allowClear: true,
         ajax: get_select2_ajax_options('/master-area/select2-area-only')
      });
      @if (auth()->user()->area != 'All')
      set_select2_value('#area_filter', '{{auth()->user()->area}}', '{{auth()->user()->area}}')
      $('#area_filter').attr('disabled','disabled')
    @endif
    jQuery(document).ready(function($) {
      $('#area_filter').change(function(event) {
        /* Act on the event */
        loadDailyByCategory();
        
      });
    });
</script>
@endpush