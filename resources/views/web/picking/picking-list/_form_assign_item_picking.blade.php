@push('script_css')
<style type="text/css">
  .assign-item-picking-wrapper td, .assign-item-picking-wrapper th {
    vertical-align: top;
  }
</style>
@endpush

<div class="assign-item-picking-wrapper">
  <h4 class="card-title">Assign Item Picking</h4>
  <hr>

  <table class="bordered">
    <tbody>
      <tr>
        <td>
          <h4 class="card-title">Find Delivery No From Upload DO</h4>
          <hr>
          <div class="row pl-2 mb-0 form-table">
            <div class="input-field col s3">
                <input id="filter-do-or-shipment" type="text" class="validate" name="filter-do-or-shipment" required>
            </div>
            <div class="col s9">
              <span class="waves-effect waves-light btn btn-small indigo darken-4 btn-view ml-2" id="btn-search-do-shipment">Search DO or Shipment</span>
            </div>
          </div>
          <span class="waves-effect waves-light btn btn-small indigo darken-4 btn-view mt-2" onclick="multiPickSelectedItems(this)">Multi Pick Selected Items</span> 
          <p class="red-text pt-1 pb-1">*) Only per page</p>
          <div class="section-data-tables"> 
            <table id="do-for-picking-table" class="display" width="100%">
                <thead>
                    <tr>
                      <th data-priority="1" class="datatable-checkbox-cell" width="30px">
                        <label>
                            <input type="checkbox" class="select-all" />
                            <span></span>
                        </label>
                      </th>
                      <th>SHIPMENT NO.</th>
                      <th>LINE NO.</th>
                      <th>DO NO.</th>
                      <th>DO ITEMS</th>
                      <th>MODEL</th>
                      <th>QTY</th>
                      <th>CBM</th>
                      <th width="50px;"></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
          </div>
          <!-- datatable ends -->
        </td>
        <td width="35%">
          <h4 class="card-title">Submit to Picking List</h4>
          <hr>
          <span class="waves-effect waves-light btn btn-small indigo darken-4 btn-view mb-1" onclick="submit_do()">Submit DO</span>
          <table id="item-picking-list" class="table-pick-list-result display" width="100%">
            <thead><tr><th>Shipment NO | Delivery No | Model | Delivery Item | Quantity | CBM</th></tr></thead>
            <tbody>
            </tbody>
          </table>
          <br>
          <span class="waves-effect waves-light btn btn-small indigo darken-4 btn-view mb-1" id="remove-selected-do-items">Remove</span>
        </td>
      </tr>
    </tbody>
  </table>
</div>

@push('script_js')
<script type="text/javascript">
  var dtdatatable_picking;
  var dtdatatable_do_for_picking;

  jQuery(document).ready(function() {
    
    dtdatatable_picking = $('#item-picking-list').DataTable({
      scrollY: '60vh',
      scrollCollapse: true,
      paging:   false,
      ordering: false,
      searching: false,
      info:     false,
      data: [],
      columns: [
        {
          render: function ( data, type, row ) {
                if ( type === 'display' ) {
                    return row.invoice_no + ' | ' 
                    + row.delivery_no + ' | ' 
                    + row.model + ' | '
                    + row.delivery_items + ' | '
                    + row.quantity + ' | '
                    + row.cbm;
                }
                return data;
            },
          }
      ]
    });

    dtdatatable_picking.on('click', 'tr', function(event) {
      event.preventDefault();
      /* Act on the event */
      $(this).toggleClass('selected');
    });

    $('#remove-selected-do-items').click(function(event) {
      /* Act on the event */
      dtdatatable_picking
        .rows( '.selected' )
        .remove()
        .draw();
      dtdatatable_do_for_picking.ajax.reload(null, false)
    });

    $('#btn-search-do-shipment').click(function(event) {
      /* Act on the event */
      dtdatatable_do_for_picking.ajax.reload(null, false)
    });

    dtdatatable_do_for_picking = $('#do-for-picking-table').DataTable({
      serverSide: true,
      ordering: false,
      ajax: {
        url: '{{url('picking-list/do-or-shipment-data')}}',
        data: function(d) {
          var selected_list = [];
          dtdatatable_picking.$('tr').each(function() {
            var row_data = dtdatatable_picking.row(this).data()
            selected_list.push(row_data.invoice_no + row_data.delivery_no + row_data.delivery_items);
          });
          d.selected_list = JSON.stringify(selected_list)
          d.do_or_shipment = $('#filter-do-or-shipment').val()
        }
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
          {data: 'invoice_no', name: 'invoice_no', className: 'detail'},
          {data: 'quantity', name: 'quantity', className: 'detail'},
          {data: 'delivery_no', name: 'delivery_no', className: 'detail'},
          {data: 'delivery_items', name: 'delivery_items', className: 'detail'},
          {data: 'model', name: 'model', className: 'detail'},
          {data: 'quantity', name: 'quantity', className: 'detail'},
          {data: 'cbm', name: 'cbm', className: 'detail'},
          {data: 'action', name: 'action', className: 'detail'},
      ]
    });

    set_datatables_checkbox('#do-for-picking-table', dtdatatable_do_for_picking)

    dtdatatable_do_for_picking.on('click', '.btn-pick', function(event) {
      if ($(this).is(':disabled')) {
        return;
      }
      $(this).prop('disabled', true);
      var tr = $(this).parent().parent();
      var data = dtdatatable_do_for_picking.row(tr).data();

      dtdatatable_picking.row.add(data).draw()
      dtdatatable_do_for_picking.ajax.reload(null, false)
    })
  });

  function multiPickSelectedItems(ths){
    if ($(ths).is(':disabled')) {
      return;
    }
    $(ths).prop('disabled', true);
    dtdatatable_do_for_picking.$('input[type="checkbox"]').each(function() {
       /* iterate through array or object */
       if(this.checked){
        var row = $(this).closest('tr');
        var row_data = dtdatatable_do_for_picking.row(row).data();

        dtdatatable_picking.row.add(row_data)
       }
    });

    dtdatatable_picking.draw()

    if ($('thead input[type="checkbox"]', dtdatatable_do_for_picking.table().container()).attr("checked")) {
      $('thead input[type="checkbox"]', dtdatatable_do_for_picking.table().container()).trigger('click');
    }
    dtdatatable_do_for_picking.ajax.reload(null, false)
  }

  function submit_do(){
    var selected_list = [];
    dtdatatable_picking.$('tr').each(function() {
      var row_data = dtdatatable_picking.row(this).data()
      selected_list.push(row_data);
    });
    $.ajax({
      url: '{{ url("picking-list/submit-do") }}',
      type: 'POST',
      data: {picking_id: "{{$pickinglistHeader->id}}", selected_list: JSON.stringify(selected_list)},
    })
    .done(function() { // selesai dan berhasil
      swal("Good job!", "You clicked the button!", "success")
        .then((result) => {
          dtdatatable_picking_list_detail.ajax.reload(null, false)
          dtdatatable_do_for_picking.ajax.reload(null, false)
          dtdatatable_picking
          .rows()
          .remove()
          .draw();
        }) // alert success
    })
    .fail(function(xhr) {
        showSwalError(xhr) // Custom function to show error with sweetAlert
    });
  }
</script>
@endpush