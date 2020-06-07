<div class="section-data-tables"> 
  <table id="picking-list-detail-table" class="display" width="100%">
      <thead>
          <tr>
            <th data-priority="2" width="30px">No.</th>
            <th>DELIVERY NO.</th>
            <th>DELIVERY ITEMS</th>
            <th>MODEL</th>
            <th>QTY</th>
            <th>QTY IN LMB</th>
            <th>EAN CODE</th>
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
  var dtdatatable = $('#picking-list-detail-table').DataTable({
    serverSide: true,
    scrollX: true,
    responsive: true,
    ajax: {
        url: '{{ url('picking-list/' . $pickinglistHeader->id) }}',
        type: 'GET',
        data: function(d) {
            d.search['value'] = $('#global_filter').val()
          }
    },
    order: [2, 'asc'],
    columns: [
        {data: 'DT_RowIndex', orderable:false, searchable: false, className: 'center-align'},
        {data: 'delivery_no', name: 'delivery_no', className: 'detail'},
        {data: 'delivery_items', name: 'delivery_items', className: 'detail'},
        {data: 'model', name: 'model', className: 'detail'},
        {data: 'quantity', name: 'quantity', className: 'detail'},
        {data: 'quantity_in_lmb', name: 'quantity_in_lmb', className: 'detail'},
        {data: 'ean_code', name: 'ean_code', className: 'detail'},
        {data: 'action', className: 'center-align', searchable: false, orderable: false},
    ],
  });
</script>
@endpush