@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6 l6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Standby Driver List</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Standby Driver List</li>
                </ol>
            </div>
            <div class="col s12 m3 l3">
              <div class="app-wrapper">
                  <div class="datatable-search">
                    <select id="area_filter"  class="select2-data-ajax browser-default app-filter">
                    </select>
                  </div>
                </div>
            </div>
            <div class="col s12 m3 l3">
              <div class="app-wrapper">
                  <div class="datatable-search">
                    <div class="datatable-search mb-0">
                      <i class="material-icons mr-2 search-icon">search</i>
                      <input type="text" placeholder="Search" class="app-filter" id="transporter_filter">
                    </div>
                  </div>
                </div>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
              <div class="card ">
                <div class="card-content">
                  <table id="data-table-standby-driver-list" class="display" width="100%">
                    <thead>
                        <tr>
                          <th>NO</th>
                          <th>VEHICLE NUMBER</th>
                          <th>DRIVER ID</th>
                          <th>DRIVER NAME</th>
                          <th>VEHICLE DESCRIPTION</th>
                          <th>CBM MAX</th>
                          <th>VEHICLE CODE TYPE</th>
                          <th>DESTINATION NUMBER</th>
                          <th>DESTINATION</th>
                          <th>EXPEDITION CODE</th>
                          <th>SAP VENDOR CODE</th>
                          <th>TRANSPORTER</th>
                          <th>CHECKIN TIME</th>
                          <th>AREA</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
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
  $('#area_filter').select2({
     placeholder: '-- Select Area --',
     allowClear: true,
     ajax: get_select2_ajax_options('/master-area/select2-areas-all')
  });
  @if (auth()->user()->area != 'All')
    set_select2_value('#area_filter', '{{auth()->user()->area}}', '{{auth()->user()->area}}')
    $('#area_filter').attr('disabled','disabled')
  @endif

  var dt_table_driver_list;

  jQuery(document).ready(function($) {
     dt_table_driver_list = $('#data-table-standby-driver-list').DataTable({
      serverSide: true,
      scrollX: true,
      dom: 'Brtip',
      pageLength: 1,
      scrollY: '60vh',
      buttons: [
              {
                  text: 'PDF',
                  action: function ( e, dt, node, config ) {
                      window.location.href = "{{url('report-master-users/export?file_type=pdf')}}" + '&area=' + $('#area_filter').val();
                  }
              },
               {
                  text: 'EXCEL',
                  action: function ( e, dt, node, config ) {
                      window.location.href = "{{url('report-master-users/export?file_type=xls')}}" + '&area=' + $('#area_filter').val();
                  }
              }
          ],
      ajax: {
          url: '{{ url('picking-list/get-transporter-list') }}',
          type: 'GET',
          data: function(d) {
              d.search['value'] = $('#transporter_filter').val(),
              d.area = $('#area_filter').val()
            }
      },
      order: [1, 'asc'],
      columns: [
          {data: 'DT_RowIndex', orderable:false, searchable: false, className: 'center-align'},
          {data: 'vehicle_number', name: 'vehicle_number', className: 'detail'},
          {data: 'driver_id', name: 'driver_id', className: 'detail'},
          {data: 'driver_name', name: 'driver_name', className: 'detail'},
          {data: 'vehicle_description', name: 'vehicle_description', className: 'detail'},
          {data: 'cbm_max', name: 'cbm_max', className: 'detail'},
          {data: 'vehicle_code_type', name: 'vehicle_code_type', className: 'detail'},
          {data: 'destination_number', name: 'destination_number', className: 'detail'},
          {data: 'destination_name', name: 'destination_name', className: 'detail'},
          {data: 'expedition_code', name: 'expedition_code', className: 'detail'},
          {data: 'sap_vendor_code', name: 'sap_vendor_code', className: 'detail'},
          {data: 'expedition_name', name: 'expedition_name', className: 'detail'},
          {data: 'created_at', name: 'created_at', className: 'detail'},
          {data: 'area', name: 'area', className: 'detail'},
      ]
    });

     $('#area_filter').change(function(event) {
      /* Act on the event */
      dt_table_transporter.ajax.reload(null, false);  // (null, false) => user paging is not reset on reload
    });

    $("input#transporter_filter").on("keyup click", function () {
      filterGlobal();
    });

    });
  function filterGlobal() {
      dt_table_transporter.search($("#transporter_filter").val(), $("#global_regex").prop("checked"), $("#global_smart").prop("checked")).draw();
  }
</script>
@endpush
