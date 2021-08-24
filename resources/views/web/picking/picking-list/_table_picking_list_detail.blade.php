@if($pickinglistHeader->lmb_details->count() == 0)
{!! get_button_delete('Multi Delete Selected Items', 'btn-multi-delete-selected-item mb-1') !!}
@endif
<div class="section-data-tables"> 
  <table id="picking-list-detail-table" class="display" width="100%">
      <thead>
          <tr>
            <th data-priority="1" class="datatable-checkbox-cell" width="30px">
              <label>
                  <input type="checkbox" class="select-all" />
                  <span></span>
              </label>
            </th>
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
          url: '{{ url("picking-list/" . $pickinglistHeader->id) }}',
          type: 'GET',
          data: function(d) {
              d.search['value'] = $('#global_filter').val()
            }
      },
      order: [
        [2, 'asc'],
        [3, 'asc']
      ],
      fnDrawCallback: function( oSettings ) {
        var total_cbm = oSettings.json.total_cbm;
        $('#text-total-cbm-concept').text(setDecimal(total_cbm != null ? total_cbm : 0))
      },
      columns: [
          {
            data: 'DT_RowIndex',
            orderable: false,
            render: function ( data, type, row ) {
                if ( type === 'display' ) {
                    return '<label><input type="checkbox" name="id[]" value="" class="checkbox"><span></span></label>';
                }
                return data;
            },
            className: "datatable-checkbox-cell"
          },
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

    set_datatables_checkbox('#picking-list-detail-table', dtdatatable_picking_list_detail)

    $('.btn-multi-delete-selected-item').click(function(event) {
      /* Act on the event */
      /* Act on the event */
      swal({
        title: "Are you sure?",
        text: "Are you sure delete selected item?",
        icon: 'warning',
        buttons: {
          cancel: true,
          delete: 'Yes, Delete It'
        }
      }).then(function (confirm) { // proses confirm
        var data_picking_list_details = [];
        dtdatatable_picking_list_detail.$('input[type="checkbox"]').each(function() {
           /* iterate through array or object */
           if(this.checked){
            var row = $(this).closest('tr');
            var row_data = dtdatatable_picking_list_detail.row(row).data();
            data_picking_list_details.push(row_data);
           }
        });
        if (confirm) { // Bila oke post ajax ke url delete nya
          // Ajax Post Delete
          $.ajax({
            url: '{{ url("picking-list/delete-selected-details") }}' ,
            type: 'DELETE',
            data: 'data_picking_list_details=' + JSON.stringify(data_picking_list_details),
          })
          .done(function() { // Kalau ajax nya success
            showSwalAutoClose('Success', 'selected data deleted.')
            dtdatatable_do_for_picking.ajax.reload(null, false)
            dtdatatable_picking_list_detail.ajax.reload(null, false); // reload datatable
          })
          .fail(function() { // Kalau ajax nya gagal
            console.log("error");
          });
          
        }
      })
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
              url: '{{url("picking-list/detail")}}' + '/' + id,
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

	dtdatatable_picking_list_detail.on('click', '.btn-detail-send-lmb', function(event) {
		event.preventDefault();

		var tr = $(this).parent().parent();
		var data = dtdatatable_picking_list_detail.row(tr).data();
		id = data.id;
		
		swal({
			text: 'Are you sure send to LMB?',
			icon: 'warning',
			buttons: {
				cancel: true,
				ok: 'OK'
			}
		}).then(function(confirm){
			if (confirm) {
				setLoading(true);
				$.ajax({
					url: '{{url("picking-list/detail")}}' + '/' + id + '/send-to-lmb',
				}).done(function(){
					setLoading(false);
					showSwalAutoClose('Success', 'detail already send to lmb');
					dtdatatable_do_for_picking.ajax.reload(null, false);
					dtdatatable_picking_list_detail.ajax.reload(null, false);
				}).fail(function(xhr){
					setLoading(false);
					console.log('error');
					showSwalError(xhr);
				});
			}
		});
	});

  });
</script>
@endpush