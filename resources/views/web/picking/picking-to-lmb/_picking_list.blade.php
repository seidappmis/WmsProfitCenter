<div class="row mb-0">
  <div class="col s12 m6">
    <h5>Picking List</h5>
  </div>
  <div class="col s12 m6">
    <!---- Search ----->
    <div class="app-wrapper">
      <div class="datatable-search">
        <i class="material-icons mr-2 search-icon">search</i>
        <input type="text" placeholder="Search" class="app-filter" id="picking_list_filter">
      </div>
   </div>
  </div>
</div>

<div class="section-data-tables"> 
  <table id="picking-list-table" class="display" width="100%">
      <thead>
          <tr>
            <th>PICKING DATE.</th>
            <th>PICKING NO</th>
            <th>DRIVER NAME</th>
            <th>DESTINATION</th>
            <th>EXPEDITION NAME</th>
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
  var dttable_picking_list
  jQuery(document).ready(function($) {
     dttable_picking_list = $('#picking-list-table').DataTable({
          serverSide: true,
          scrollX: true,
          responsive: true,
          ajax: {
              url: '{{url('picking-to-lmb/picking-list')}}',
              type: 'GET',
              data: function(d) {
                d.search['value'] = $('#picking_list_filter').val()
              }
          },
          order: [0, 'asc'],
          columns: [
              {data: 'created_at', name: 'created_at', className: 'detail'},
              {data: 'picking_no', name: 'picking_no', className: 'detail'},
              {data: 'driver_name', name: 'driver_name', className: 'detail'},
              {data: 'destination_name', name: 'destination_name', className: 'detail'},
              {data: 'expedition_name', name: 'expedition_name', className: 'detail'},
              {data: 'action', className: 'center-align', orderable:false, searchable: false},
          ]
      });
  });
</script>
@endpush