<div class="col s12">
<div class="container">
    <div class="section pt-0">
        <div class="card">
            <div class="card-content p-0">
              <ul class="collapsible m-0">
                <li class="active">
                  <div class="collapsible-header p-0">
                    <div class="row">
                      <div class="col s12 m8">
                        <div class="collapsible-main-header">
                          <i class="material-icons expand">expand_less</i>
                          <span>Return Billing Branch</span>
                        </div>
                      </div>
                      <div class="col s12 m4">
                        <div class="app-wrapper">
                          <div class="datatable-search mb-0">
                            <i class="material-icons mr-2 search-icon">search</i>
                            <input type="text" placeholder="Search" class="app-filter no-propagation" id="return-billing-branch-filter">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="collapsible-body p-0">
                    <div class="section-data-tables"> 
                      <table id="return-billing-branch-table" class="display" width="100%">
                          <thead>
                              <tr>
                                <th>DO MANIFEST</th>
                                <th>EXPEDITION NAME</th>
                                <th>DESTINATION CITY</th>
                                <th width="50px;"></th>
                              </tr>
                          </thead>
                          <tbody>
                            {{-- <tr>
                              <td>JKT-180903-053</td>
                              <td>PUTRA NAGITA PRATAMA, PT.</td>
                              <td>BOGOR</td>
                              <td>{!! get_button_view(url('billing-return/1')) !!}</td>
                            </tr> --}}
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
  var dttable_return_billing_branch
  jQuery(document).ready(function($) {
    dttable_return_billing_branch = $('#return-billing-branch-table').DataTable({
      serverSide: true,
      scrollX: true,
      responsive: true,
      ajax: {
          url: '{{ url('billing-return/return-billing-branch') }}',
          type: 'GET',
          data: function(d) {
              d.search['value'] = $('#return-billing-branch-filter').val()
            }
      },
      order: [0, 'asc'],
      columns: [
          {data: 'do_manifest_no', name: 'do_manifest_no', className: 'detail'},
          {data: 'expedition_name', name: 'expedition_name', className: 'detail'},
          {data: 'expedition_name', name: 'expedition_name', className: 'detail'},
          {data: 'action', className: 'center-align', searchable: false, orderable: false},
      ]
    });
    $("input#return-billing-branch-filter").on("keyup click", function () {
      filterReturnBillingBranch();
    });
  });

  function filterReturnBillingBranch(){
    dttable_return_billing_branch.search($("#return-billing-branch-filter").val(), $("#global_regex").prop("checked"), $("#global_smart").prop("checked")).draw();
  }
</script>
@endpush