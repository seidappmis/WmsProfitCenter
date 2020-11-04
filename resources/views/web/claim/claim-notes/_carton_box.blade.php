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
                      <span>Claim Notes </span>
                    </div>
                  </div>
                  <div class="col s12 m4">
                    <div class="app-wrapper">
                      <div class="datatable-search mb-0">
                        <i class="material-icons mr-2 search-icon">search</i>
                        <input type="text" placeholder="Search" class="app-filter no-propagation" id="global_filter">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="collapsible-body p-0">
                <div class="section-data-tables">
                  <table id="data-table-claim-notes-box" class="display" width="100%">
                    <thead>
                      <tr>
                        <th data-priority="1" width="30px">NO.</th>
                        <th>BERITA ACARA</th>
                        <th>CLAIM NOTE</th>
                        <th>REPORTING DATE</th>
                        <th>EXPEDITION NAME</th>
                        <th>DESTINATION</th>
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
  var dtdatatable_box = $('#data-table-claim-notes-box').DataTable({
    paging: false,
    serverSide: true,
    scrollX: true,
    responsive: true,
    ajax: {
      url: '{{url("claim-notes/list-claim-notes")}}',
      type: 'GET',
    },
    order: [1, 'asc'],
    columns: [
      // {
      //   data: 'id',
      //   orderable: false,
      //   searchable: false,
      //   render: function(data, type, row) {
      //     return '<label><input type="checkbox" name="outstanding[]" value="' + data + '" class="checkbox checkbox-outstanding"><span></span></label>';
      //   },
      //   className: "datatable-checkbox-cell"
      // },
      {
        data: 'DT_RowIndex',
        orderable: false,
        searchable: false,
        className: 'center-align'
      },
      {
        data: 'berita_acara_no',
        name: 'berita_acara_no',
        className: 'detail'
      },
      {
        data: 'do_no',
        name: 'do_no',
        className: 'detail'
      },
      {
        data: 'model_name',
        name: 'model_name',
        className: 'detail'
      },
      {
        data: 'serial_number',
        name: 'serial_number',
        className: 'detail'
      },
      {
        data: 'qty',
        name: 'qty',
        className: 'center-align'
      },
      {
        data: 'description',
        name: 'description',
        className: 'detail'
      }
    ]
  });
</script>
@endpush