<br>
<h6>Total Manifest: 1</h6>
<h5 class="card-title">List DO</h5>
<hr>
<div class="section-data-tables"> 
  <table id="list-do-table" class="display" width="100%">
    <thead>
      <tr>
        <th>NO.</th>
        <th>No Shipment</th>
        <th>DO No</th>
        <th>DO Int No</th>
        <th>City Ship To</th>
        <th>Items</th>
        <th>Model</th>
        <th>QTY</th>
        <th>DESC</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
    </tbody>
  </table>
</div>
  <!-- datatable ends -->

@push('script_js')
<script type="text/javascript">
  var dttable_list_do
  jQuery(document).ready(function($) {
    dttable_list_do = $('#list-do-table').DataTable({
    serverSide: true,
    scrollX: true,
    responsive: true,
    ajax: {
        url: '{{ url('manifest-as/' . $manifestHeader->do_manifest_no . '/list-do') }}',
        type: 'GET',
        data: function(d) {
            d.search['value'] = $('#global_filter').val()
          }
    },
    order: [2, 'asc'],
    columns: [
        {data: 'DT_RowIndex', orderable:false, searchable: false, className: 'center-align'},
        {data: 'invoice_no', name: 'invoice_no', className: 'detail'},
        {data: 'delivery_no', name: 'delivery_no', className: 'detail'},
        {data: 'do_internal', name: 'do_internal', className: 'detail'},
        {data: 'ship_to', name: 'ship_to', className: 'detail'},
        {data: 'delivery_items', name: 'delivery_items', className: 'detail'},
        {data: 'model', name: 'model', className: 'detail'},
        {data: 'quantity', name: 'quantity', className: 'detail'},
        {data: 'desc', name: 'desc', className: 'detail'},
        {data: 'status', name: 'status', className: 'detail'},
      ],
    });

   
  });
</script>
@endpush