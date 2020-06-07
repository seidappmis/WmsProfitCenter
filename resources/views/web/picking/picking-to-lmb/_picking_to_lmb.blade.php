<div class="row mb-0">
  <div class="col s12 m6">
    <h5>Picking to LMB</h5>
  </div>
  <div class="col s12 m6">
    <!---- Search ----->
    <div class="app-wrapper">
      <div class="datatable-search">
        <i class="material-icons mr-2 search-icon">search</i>
        <input type="text" placeholder="Search" class="app-filter" id="picking_to_lmb_filter">
      </div>
   </div>
  </div>
</div>

<div class="section-data-tables"> 
  <table id="picking-to-lmb-table" class="display" width="100%">
      <thead>
          <tr>
            <th>PICKING NO</th>
            <th>DRIVER NAME</th>
            <th>DESTINATION</th>
            <th>EXPEDITION NAME</th>
            <th>LMB.</th>
            <th width="50px;"></th>
          </tr>
      </thead>
      <tbody>
      </tbody>
  </table>
</div>
<!-- datatable ends -->

@push('script_js')
<script type="text/javascript">
  var dtdatatable = $('#picking-to-lmb-table').DataTable({
        serverSide: true,
        scrollX: true,
        responsive: true,
        ajax: {
            url: '{{url('picking-to-lmb')}}',
            type: 'GET',
            data: function(d) {
              d.search['value'] = $('#picking_to_lmb_filter').val()
            }
        },
        order: [0, 'asc'],
        columns: [
            {data: 'picking_no', name: 'picking_no', className: 'detail'},
            {data: 'driver_name', name: 'driver_name', className: 'detail'},
            {data: 'destination_name', name: 'destination_name', className: 'detail'},
            {data: 'expedition_name', name: 'expedition_name', className: 'detail'},
            {data: 'lmb_date', name: 'lmb_date', className: 'detail'},
            {data: 'action', className: 'center-align', orderable:false, searchable: false},
        ]
    });
</script>
@endpush