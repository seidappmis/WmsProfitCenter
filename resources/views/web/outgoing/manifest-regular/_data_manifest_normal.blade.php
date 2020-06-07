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
                  <table id="data_manifest_normal_table" class="display" width="100%">
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
  
  dtdatatable_data_manifest_normal = $('#data_manifest_normal_table').DataTable({
      serverSide: true,
      scrollX: true,
      responsive: true,
      ajax: {
          url: "{{url('manifest-regular')}}",
          type: 'GET',
          data: function(d) {
              d.search['value'] = $('#data_manifest_normal_filter').val()
          }
      },
      order: [0, 'asc'],
      columns: [
          { data: 'DT_RowIndex', orderable:false, searchable: false, className: 'center-align'},
          { data: 'do_manifest_no', name: 'do_manifest_no', className: 'detail' },
          { data: 'expedition_name', name: 'expedition_name', className: 'detail' },
          { data: 'city_name', name: 'city_name', className: 'detail' },
          { data: 'vehicle_number', name: 'vehicle_number', className: 'detail' },
          { data: 'picking_no', name: 'picking_no', className: 'detail' },
          { data: 'status', name: 'status', className: 'detail' },
          { data: 'action', className: 'center-align', orderable: false, searchable: false },
      ]
  });
});

</script>
@endpush
