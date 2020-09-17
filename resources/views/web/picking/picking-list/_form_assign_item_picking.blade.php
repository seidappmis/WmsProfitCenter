@push('script_css')
<style type="text/css">
  .assign-item-picking-wrapper td, .assign-item-picking-wrapper th {
    vertical-align: top;
  }
</style>
@endpush

<div class="assign-item-picking-wrapper mt-3">
  <h4 class="card-title">Assign Item Picking</h4>
  <hr>
  @if($pickinglistHeader->expedition_code != "AS")
  <span class="green-text" style="font-weight: 600;">CBM Truck : </span> {{setDecimal($pickinglistHeader->vehicle->cbm_max)}}
  <br>
  <span class="" style="font-weight: 600;">CBM Concept : </span> <span id="text-total-cbm-concept"></span>
  @endif
  <table class="bordered">
    <tbody>
      <tr>
        <td>
          <h4 class="card-title">Find Delivery No From Upload DO</h4>
          <hr>
          <div class="row pl-2 mb-0 form-table">
            <div class="input-field col s3">
                <input id="filter-type" type="hidden" class="validate" name="filter-type" value="do">
                <input id="filter-do-or-shipment" type="text" class="validate" name="filter-do-or-shipment" required>
            </div>
            <div class="col s9">
              <span class="waves-effect waves-light btn btn-small indigo darken-4 btn-view ml-2" id="btn-search-do">Search DO</span>
              @if(auth()->user()->cabang->hq)
              <span class="waves-effect waves-light btn btn-small indigo darken-4 btn-view ml-2" id="btn-search-shipment">Search Shipment</span>
              @endif
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

@push('page-modal')
<!-- Modal Structure -->
<div id="modal-split-concept" class="modal">
  <form id="form-split-concept">
  <div class="modal-content">
    @include('web.picking.picking-list._form_split_concept')
  </div>
  </form>
</div>
@endpush

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
                    + row.cbm + ' | '
                    + row.code_sales;
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

    $('#btn-search-do').click(function(event) {
      /* Act on the event */
      $('#filter-type').val('do')
      dtdatatable_do_for_picking.ajax.reload(null, false)
    });

    $('#btn-search-shipment').click(function(event) {
      /* Act on the event */
      $('#filter-type').val('shipment')
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
          d.filter_type = $('#filter-type').val()
          d.picking_id = '{{$pickinglistHeader->id}}'
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
          {data: 'invoice_no', className: 'detail'},
          {data: 'line_no', className: 'detail'},
          {data: 'delivery_no', className: 'detail'},
          {data: 'delivery_items', className: 'detail'},
          {data: 'model', className: 'detail'},
          {data: 'quantity', className: 'detail'},
          {data: 'cbm', className: 'detail'},
          {data: 'action', className: 'detail'},
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

    dtdatatable_do_for_picking.on('click', '.btn-split', function(event) {
      event.preventDefault();
      /* Act on the event */
      var tr = $(this).parent().parent();
      var data = dtdatatable_do_for_picking.row(tr).data();
      console.log(data)
      var row = '<tr>';
      row += '<td>' + data.invoice_no + '</td>';
      row += '<td>' + data.line_no + '</td>';
      row += '<td>' + data.delivery_no + '</td>';
      row += '<td>' + data.delivery_items + '</td>';
      row += '<td>' + data.quantity + '</td>';
      row += '<td>' + data.cbm + '</td>';
      row += '<td><input type="text" name="total_split" value="2"></td>';
      row += '<td><span class="waves-effect waves-light indigo btn-small btn-run-split-concept" onclick="runSplitConceptTable(this)">Run</span></td>';
      row += '</tr>';

      $('#form-split-concept [name="delivery_no"]').val(data.delivery_no)
      $('#form-split-concept [name="invoice_no"]').val(data.invoice_no)
      $('#form-split-concept [name="line_no"]').val(data.line_no)
      $('#form-split-concept [name="quantity"]').val(data.quantity)
      $('#form-split-concept [name="max_delivery_items"]').val(data.max_delivery_items)
      $('#form-split-concept [name="max_line_no"]').val(data.max_line_no)
      $('#text-split-cbm-per-item').text(data.cbm/data.quantity)

      $('#item-split-table tbody').empty();
      $('#item-split-table tbody').append(row);
      $('.btn-run-split-concept').trigger('click')
      // runSplitConceptTable('.btn-run-split-concept', data)
      $('#modal-split-concept').modal('open')
    });

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
    .done(function(result) { // selesai dan berhasil
      if (result.status) {
        showSwalAutoClose('Success', result.message);
        dtdatatable_picking_list_detail.ajax.reload(null, false)
        dtdatatable_do_for_picking.ajax.reload(null, false)
        dtdatatable_picking
        .rows()
        .remove()
        .draw();
        } else {
          swal('Warning!', result.message, 'warning')
        }
    })
    .fail(function(xhr) {
        showSwalError(xhr) // Custom function to show error with sweetAlert
    });
  }
</script>
@endpush