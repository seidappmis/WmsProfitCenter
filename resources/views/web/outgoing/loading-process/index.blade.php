@extends('layouts.materialize.index')

@section('content')
<div class="row">

  @component('layouts.materialize.components.title-wrapper')
      <div class="row">
          <div class="col s12 m5">
              <h5 class="breadcrumbs-title mt-0 mb-0"><span>Loading Process</span></h5>
              <ol class="breadcrumbs mb-0">
                  <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                  <li class="breadcrumb-item active">Loading Process</li>
              </ol>
          </div>
          <div class="col s12 m3">
            <!---- Search ----->
                <div class="app-wrapper">
                  <div class="datatable-search">
                    <select id="area_filter">
                      <option>-Select Area-</option>
                      <option>KARAWANG</option>
                      <option>SURABAYA HUB</option>
                      <option>SWADAYA</option>
                    </select>
                  </div>
                </div>
          </div>
          <div class="col s12 m4">
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
      </div>
  @endcomponent

  <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content p-0">
                        <div class="section-data-tables"> 
                          <table id="loading-process-table" class="display" width="100%">
                              <thead>
                                  <tr>
                                    <th>GATE</th>
                                    <th>STATUS</th>
                                    <th>VEHICLE NO.</th>
                                    <th>DESTINATION</th>
                                    <th>EXPEDITION NAME</th>
                                    <th>VEHICLE TYPE</th>
                                    <th>TOTAL CBM</th>
                                    <th>CAPACITY</th>
                                    <th>BALANCE</th>
                                    <th>START TIME</th>
                                    <th width="50px;"></th>
                                  </tr>
                              </thead>
                              <tbody>
                                {{-- <tr>
                                  <td>603</td>
                                  <td>Loading Process</td>
                                  <td>BE 9387 AC BOIMIN</td>
                                  <td>Lampung Jakarta-Lampung</td>
                                  <td>SARANA AGUNG MULIA SETIA, PT.</td>
                                  <td>TRONTON 10 M</td>
                                  <td>70.224</td>
                                  <td>65.000</td>
                                  <td>-5.224</td>
                                  <td>2020-02-07 14:03:PM</td>
                                  <td></td>
                                </tr> --}}
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
    var dttable_loading_process
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
      
      dttable_loading_process = $('#loading-process-table').DataTable({
        serverSide: true,
        scrollX: true,
        responsive: true,
        ajax: {
            url: '{{ url('loading-process') }}',
            type: 'GET',
            data: function(d) {
                d.search['value'] = $('#global_filter').val(),
                d.area = $('#area_filter').val()
              }
        },
        order: [1, 'asc'],
        columns: [
            {data: 'gate', name: 'gate', className: 'detail'},
            {data: 'vehicle_number', name: 'vehicle_number', className: 'detail'},
            {data: 'expedition_name', name: 'expedition_name', className: 'detail'},
            {data: 'expedition_name', name: 'expedition_name', className: 'detail'},
            {data: 'expedition_name', name: 'expedition_name', className: 'detail'},
            {data: 'vehicle_code_type', name: 'vehicle_code_type', className: 'detail'},
            {data: 'cbm', name: 'cbm', className: 'detail'},
            {data: 'capacity', name: 'capacity', className: 'detail'},
            {data: 'balance', name: 'balance', className: 'detail'},
            {data: 'start_time', name: 'start_time', className: 'detail'},
            {data: 'action', className: 'center-align', searchable: false, orderable: false},
        ]
      });
      $("input#global_filter").on("keyup click", delay(function () {
        filterLoadingProcess();
      }, 1500));

      $('#area_filter').change(function(event) {
        /* Act on the event */
        filterLoadingProcess();
      });
    });
    function delay(fn, ms) {
      let timer = 0;
      return function (...args) {
        clearTimeout(timer);
        timer = setTimeout(fn.bind(this, ...args), ms || 0);
      }
    }
    function filterLoadingProcess(){
      dttable_loading_process.search($("#global_filter").val(), $("#global_regex").prop("checked"), $("#global_smart").prop("checked")).draw();
    }
</script>
@endpush