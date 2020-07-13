@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m3">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Finish Good Production</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Finish Good Production</li>
                </ol>
            </div>
            <div class="col s12 m3">
              <!---- Filter ----->
                <div class="app-wrapper mr-2">
                  <div class="datatable-search">
                    <select id="area_filter"
                          class="select2-data-ajax browser-default app-filter">
                    </select>
                  </div>
                </div>
            </div>
            <div class="col s12 m6">
              <div class="display-flex">
                <!---- Search ----->
                <div class="app-wrapper mr-2">
                  <div class="datatable-search">
                    <i class="material-icons mr-2 search-icon">search</i>
                    <input type="text" placeholder="Search" class="app-filter" id="global_filter">
                  </div>
                </div>
              </div>
            </div>
            <div class="col s12 m3"></div>
        </div>
        <div class="row">
          <div class="col s12 m4">
            <!---- Button Add ----->
            <a href="{{ url('finish-good-production/create') }}" class="btn btn-large waves-effect waves-light btn-add" type="submit" name="action">
              New Incoming Finish Good
            </a>
          </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content p-0">
                        <div class="section-data-tables"> 
                          <table id="data-table-section-contents" class="display" width="100%">
                              <thead>
                                  <tr>
                                    <th data-priority="1" width="30px">No.</th>
                                    <th>RECEIPT NO</th>
                                    <th>TICKET NO</th>
                                    <th>WAREHOUSE</th>
                                    <th>FACTORY</th>
                                    <th width="50px;"></th>
                                  </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td>1.</td>
                                  <td>ARV-WHHYP-181003-019</td>
                                  <td>L-TV-1810010006</td>
                                  <td>SHARP KARAWANG W/H</td>
                                  <td>TV</td>
                                  <td>
                                    {!! get_button_view(url('finish-good-production/1')) !!}
                                    {!! get_button_print() !!}
                                  </td>
                                </tr>
                              </tbody>
                          </table>
                        </div>
                        <!-- datatable ends -->
                    </div>
                </div>
            </div>
        </div>
        <div class="content-overlay"></div>
    </div>
</div>
@endsection

@push('script_js')
<script type="text/javascript">
  var dtdatatable = $('#data-table-section-contents').DataTable({
    // serverSide: true,
    scrollX: true,
    responsive: true,
    order: [1, 'asc'],
  });

  // Filter Area
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
    
  });

</script>
@endpush