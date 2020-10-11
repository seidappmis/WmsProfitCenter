<div class="container">
    <div class="section">
        <div class="card">
            <div class="card-content p-0">
                <ul class="collapsible m-0">
                    <li class="active">
                        <div class="collapsible-header p-0">
                            <div class="row">
                                <div class="col s12 m8">
                                    <div class="collapsible-main-header">
                                        <i class="material-icons expand">
                                            expand_less
                                        </i>
                                        <span>
                                            Truck Waiting Manifest
                                        </span>
                                    </div>
                                </div>
                                <div class="col s12 m4">
                                    <div class="app-wrapper">
                                        <div class="datatable-search mb-0">
                                            <i class="material-icons mr-2 search-icon">
                                                search
                                            </i>
                                            <input class="app-filter no-propagation" id="truck_waiting_manifest_filter" placeholder="Search" type="text">
                                            </input>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="collapsible-body p-0">
                            <div class="section-data-tables">
                                <table class="display" id="truck_waiting_manifest_table" width="100%">
                                    <thead>
                                        <tr>
                                            <th>
                                                VEHICLE NUMBER
                                            </th>
                                            <th>
                                                DRIVER NAME
                                            </th>
                                            <th>
                                                TRANSPORTER
                                            </th>
                                            <th>
                                                DESTINATION
                                            </th>
                                            <th>
                                                PICKING NO.
                                            </th>
                                            <th width="50px;">
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <!-- datatable ends -->
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

@push('script_js')
<script type="text/javascript">
var dtdatatable_truck_waiting_manifest;

jQuery(document).ready(function($) {
  
  dtdatatable_truck_waiting_manifest = $('#truck_waiting_manifest_table').DataTable({
      serverSide: true,
      scrollX: true,
      responsive: true,
      ajax: {
          url: "{{url('branch-manifest/truck-waiting-manifest')}}",
          type: 'GET',
          data: function(d) {
              d.search['value'] = $('#truck_waiting_manifest_filter').val()
          }
      },
      order: [0, 'asc'],
      columns: [
          { data: 'vehicle_number', name: 'vehicle_number', className: 'detail' },
          { data: 'driver_name', name: 'driver_name', className: 'detail' },
          { data: 'expedition_name', name: 'expedition_name', className: 'detail' },
          { data: 'destination_name', name: 'destination_name', className: 'detail' },
          { data: 'picking_no', name: 'picking_no', className: 'detail' },
          { data: 'action', className: 'center-align', orderable: false, searchable: false },
      ]
  });

  $("input#truck_waiting_manifest_filter").on("keyup click", function () {
    filterGlobalTruckWaitingManifest();
  });
});

function filterGlobalTruckWaitingManifest() {
  dtdatatable_data_manifest_normal.search($("#truck_waiting_manifest_filter").val(), $("#global_regex").prop("checked"), $("#global_smart").prop("checked")).draw();
}

</script>
@endpush
