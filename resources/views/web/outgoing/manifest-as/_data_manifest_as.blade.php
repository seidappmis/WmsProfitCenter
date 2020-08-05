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
                      <span>Data Manifest AS</span>
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
                        <th width="10px">No.</th>
                        <th>Manifest</th>
                        <th>Remarks 1</th>
                        <th>Remarks 2</th>
                        <th>Picking No</th>
                        <th>Status</th>
                        <th width="5px;"></th>
                        <th width="5px;"></th>
                        <th width="5px;"></th>
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
          url: "{{url('manifest-as')}}",
          type: 'GET',
          data: function(d) {
              d.search['value'] = $('#data_manifest_normal_filter').val()
          }
      },
      order: [1, 'desc'],
      columns: [
          { data: 'DT_RowIndex', orderable:false, searchable: false, className: 'center-align'},
          { data: 'do_manifest_no', name: 'do_manifest_no', className: 'detail' },
          { data: 'seal_no', name: 'seal_no', className: 'detail' },
          { data: 'pdo_no', name: 'pdo_no', className: 'detail' },
          { data: 'picking_no', name: 'picking_no', className: 'detail' },
          { data: 'status', name: 'status', className: 'detail' },
          { data: 'actionEdit', className: 'center-align', orderable: false, searchable: false },
          { data: 'actionDelete', className: 'center-align', orderable: false, searchable: false },
          { data: 'actionPrint', className: 'center-align', orderable: false, searchable: false },
      ]
  });
});

</script>
@endpush
