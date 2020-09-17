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
            <th>CBM</th>
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
  var dtdatatable_picking_list_detail
  jQuery(document).ready(function($) {
    dtdatatable_picking_list_detail = $('#picking-list-detail-table').DataTable({
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
      "fnDrawCallback": function( oSettings ) {
        $('#text-total-cbm-concept').text(setDecimal(oSettings.json.total_cbm))
      },
      columns: [
          {data: 'DT_RowIndex', orderable:false, searchable: false, className: 'center-align'},
          {data: 'delivery_no', name: 'delivery_no', className: 'detail'},
          {data: 'delivery_items', name: 'delivery_items', className: 'detail'},
          {data: 'model', name: 'model', className: 'detail'},
          {data: 'quantity', name: 'quantity', className: 'detail'},
          {data: 'quantity_in_lmb', name: 'quantity_in_lmb', className: 'detail'},
          {data: 'cbm', name: 'ean_code', className: 'detail'},
          {data: 'ean_code', name: 'ean_code', className: 'detail'},
          {data: 'action', className: 'center-align', searchable: false, orderable: false},
      ],
    });

    dtdatatable_picking_list_detail.on('click', '.btn-delete', function(event) {
      event.preventDefault();
      /* Act on the event */
       var tr = $(this).parent().parent();
        var data = dtdatatable_picking_list_detail.row(tr).data();
        id = data.id
        event.preventDefault();
        /* Act on the event */
        // Ditanyain dulu usernya mau beneran delete data nya nggak.
        swal({
          title: "Are you sure?",
          text: "You will not be able to recover this imaginary file!",
          icon: 'warning',
          buttons: {
            cancel: true,
            delete: 'Yes, Delete It'
          }
        }).then(function (confirm) { // proses confirm
          if (confirm) { // Bila oke post ajax ke url delete nya
            // Ajax Post Delete
            $.ajax({
              url: '{{url('picking-list/detail')}}' + '/' + id,
              type: 'DELETE',
            })
            .done(function() { // Kalau ajax nya success
              showSwalAutoClose('Success', 'detail deleted.')
              dtdatatable_do_for_picking.ajax.reload(null, false)
              dtdatatable_picking_list_detail.ajax.reload(null, false); // reload datatable
            })
            .fail(function() { // Kalau ajax nya gagal
              console.log("error");
            });

          }
        })
    });
  });
</script>
@endpush