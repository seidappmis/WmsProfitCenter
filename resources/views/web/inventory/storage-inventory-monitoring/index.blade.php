@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Storage Inventory Monitoring</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Storage Inventory Monitoring</li>
                </ol>
            </div>
            <div class="col s12 m6">
              <div class="display-flex">
                <!---- Search ----->
                <div class="app-wrapper mr-2">
                  <div class="datatable-search">
                    <i class="material-icons mr-2 search-icon">search</i>
                    <input type="text" placeholder="Search" class="app-filter" id="storage-inventory-monitoring-filter">
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
                          <table id="storage-inventory-monitoring-table" class="display" width="100%">
                              <thead>
                                  <tr>
                                    <th data-priority="1" width="30px">NO.</th>
                                    <th>STORAGE TYPE</th>
                                    <th>STORAGE LOC. CODE</th>
                                    <th>MODEL NAME</th>
                                    <th>QTY</th>
                                    <th>LAST UPDATE</th>
                                    <th width="100px;"></th>
                                  </tr>
                              </thead>
                              <tbody>
                                {{-- <tr>
                                  <th data-priority="1" width="30px">1.</th>
                                  <th>PAL-Intransit BR</th>
                                  <th>3690</th>
                                  <th>FP-JM40Y-B</th>
                                  <th>5</th>
                                  <th>2020-02-07 15:28:PM</th>
                                  <th>
                                    <span class="waves-effect btn-small amber darken-4 btn-edit" href="#">View Log</span>
                                  </th>
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
  var table

  jQuery(document).ready(function($) {
    dttable_storage_inventory_monitoring = $('#storage-inventory-monitoring-table').DataTable({
      serverSide: true,
      scrollX: true,
      responsive: true,
      ajax: {
          url: '{{ url('storage-inventory-monitoring') }}',
          type: 'GET',
          data: function(d) {
              d.search['value'] = $('#storage-inventory-monitoring-filter').val()
            }
      },
      order: [5, 'desc'],
      columns: [
          {data: 'DT_RowIndex', orderable:false, searchable: false, className: 'center-align'},
          {data: 'sto_type_desc', name: 'wms_master_storage.sto_type_desc', className: 'detail'},
          {data: 'sto_loc_code_long', name: 'wms_master_storage.sto_loc_code_long', className: 'detail'},
          {data: 'model_name', name: 'model_name', className: 'detail'},
          {data: 'quantity_total', name: 'quantity_total', className: 'detail'},
          {data: 'last_updated', name: 'last_updated', className: 'detail'},
          {data: 'action', className: 'center-align', searchable: false, orderable: false},
      ]
    });
  });

  $("input#storage-inventory-monitoring-filter").on("keyup click", function () {
    filterGlobal();
  });

  // Custom search
  function filterGlobal() {
      dttable_storage_inventory_monitoring.search($("#storage-inventory-monitoring-filter").val(), $("#global_regex").prop("checked"), $("#global_smart").prop("checked")).draw();
  }
</script>
@endpush