 <div class="col s12">
<div class="container">
    <div class="section">
        <div class="card mb-0">
            <div class="card-content p-0">
              <ul class="collapsible m-0">
                <li class="active">
                  <div class="collapsible-header p-0">
                    <div class="row">
                      <div class="col s12 m8">
                        <div class="collapsible-main-header">
                          <i class="material-icons expand">expand_less</i>
                          <span>From Manifest HQ</span>
                        </div>
                      </div>
                      <div class="col s12 m4">
                        <div class="app-wrapper">
                          <div class="datatable-search mb-0">
                            <i class="material-icons mr-2 search-icon">search</i>
                            <input type="text" placeholder="Search" class="app-filter no-propagation" id="from-manifest-hq-filter">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="collapsible-body p-0">
                    <div class="section-data-tables"> 
                      <table id="from-manifest-hq-table" class="display" width="100%">
                          <thead>
                              <tr>
                                <th>DO MANIFEST</th>
                                <th>DO MANIFEST DATE</th>
                                <th>EXPEDITION NAME</th>
                                <th>DESTINATION CITY</th>
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
</div>

@push('script_js')
<script type="text/javascript">
  var dttable_manifest_hq
  jQuery(document).ready(function($) {
    dttable_manifest_hq = $('#from-manifest-hq-table').DataTable({
      serverSide: true,
      scrollX: true,
      pageLength: 5,
      responsive: true,
      ajax: {
          url: '{{ url('conform-manifest/from-manifest-hq') }}',
          type: 'GET',
          data: function(d) {
              d.search['value'] = $('#from-manifest-hq-filter').val()
            }
      },
      order: [1, 'asc'],
      columns: [
          {data: 'do_manifest_no'},
          {data: 'do_manifest_date', visible: false},
          {data: 'expedition_name'},
          {data: 'city_name'},
          {data: 'status'},
          {data: 'action', className: 'center-align', searchable: false, orderable: false},
      ]
    });
    $("input#from-manifest-hq-filter").on("keyup click", function () {
      filterManifestHQ();
    });
  });

  function filterManifestHQ(){
    dttable_manifest_hq.search($("#from-manifest-hq-filter").val(), $("#global_regex").prop("checked"), $("#global_smart").prop("checked")).draw();
  }

</script>
@endpush