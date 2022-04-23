<div class="container">
    <div class="section">
      <div class="card mt-0">
        <div class="card-content p-0">
          <ul class="collapsible m-0">
            <li class="active">
              <div class="collapsible-header p-0">
                <div class="row">
                  <div class="col s12 m8">
                    <div class="collapsible-main-header">
                      <i class="material-icons expand">expand_less</i>
                      <span>Data Manifest Normal</span>
                    </div>
                  </div>
                  <div class="col s12 m4">
                    <div class="app-wrapper">
                      <div class="datatable-search mb-0">
                        <i class="material-icons mr-2 search-icon">search</i>
                        <input type="text" placeholder="Search" class="app-filter no-propagation" id="data_manifest_normal_filter">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="collapsible-body p-0">
                <div class="section-data-tables"> 
                  <table id="data_branch_manifest_table" class="display" width="100%">
                    <thead>
                      <tr>
                        <th>NO.</th>
                        <th>MANIFEST</th>
                        <th>EXPEDITION</th>
                        <th>DESTINATION</th>
                        <th>VEHICLE NO</th>
                        <th>PICKING NO</th>
                        <th>STATUS</th>
                        <th width="50px;"></th>
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
var dtdatatable_data_manifest_normal;

jQuery(document).ready(function($) {
  
  dtdatatable_data_manifest_normal = $('#data_branch_manifest_table').DataTable({
      serverSide: true,
      scrollX: true,
      responsive: true,
      ajax: {
          url: "{{url('branch-manifest')}}",
          type: 'GET',
          data: function(d) {
              d.search['value'] = $('#data_manifest_normal_filter').val()
          }
      },
      order: [1, 'desc'],
      columns: [
          { data: 'DT_RowIndex', orderable:false, searchable: false, className: 'center-align'},
          { data: 'do_manifest_no', name: 'wms_branch_manifest_header.do_manifest_no', className: 'detail' },
          { data: 'expedition_name', name: 'wms_branch_manifest_header.expedition_name', className: 'detail' },
          { data: 'city_name', name: 'wms_branch_manifest_header.city_name', className: 'detail' },
          { data: 'vehicle_number', name: 'wms_branch_manifest_header.vehicle_number', className: 'detail' },
          { data: 'picking_no', name: 'wms_pickinglist_header.picking_no', className: 'detail' },
          { data: 'status', name: 'status', className: 'detail' },
          { data: 'action', className: 'center-align', orderable: false, searchable: false },
      ]
  });

  $("input#data_manifest_normal_filter").on("keyup click", delay(function () {
    filterGlobalDataManifestNormal();
  }, 1500));
});
function delay(fn, ms) {
  let timer = 0;
  return function (...args) {
    clearTimeout(timer);
    timer = setTimeout(fn.bind(this, ...args), ms || 0);
  }
}
function filterGlobalDataManifestNormal() {
  dtdatatable_data_manifest_normal.search($("#data_manifest_normal_filter").val(), $("#global_regex").prop("checked"), $("#global_smart").prop("checked")).draw();
}
</script>
@endpush
