@push('page-modal')
<!---- Modal Upload ----->
<div id="modal-detail-do" class="modal" style="width: 1100px;">
  <div class="modal-content p-0 mt-1 ml-1 mr-1">
    <div class="row">
      <div class="col m5">
        Detail DO
      </div>
      <div class="col m7">
        <div class="modal-action modal-close">
        <span class="right">X</span>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col m5">
        Manifest No : <span class="text-manifest_no"></span><br>
        <h6>DO</h6>
        <hr>
        <table class="table_do display" width="100%">
          <thead>
            <tr>
              <th>DO NO</th>
              <th>SHIP TO CODE</th>
              <th>CUSTOMER NAME</th>
              <th>DESTINATION CITY</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>

        <h6>DO Detail</h6>
        <hr>
        <table class="table_do_detail display form-table small" width="100%">
          <thead>
            <tr>
              <th>ITEMS</th>
              <th>MODEL</th>
              <th>QTY</th>
              <th>CBM</th>
              <th>TOTAL CBM</th>
              <th></th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>

      </div>
      <div class="col m7">
        Cost per DO
        <hr>
        <span class="text-delivery_no"></span>

        <form id="form-cost-per-do">
          
          <table class="form-table">
            <tr>
              <td width="24%">Total CBM</td>
              <td width="24%"><span class="text-total_cbm"></span></td>
              <td></td>
              <td width="24%" class="red">Master FC CBM</td>
              <td width="24%" class="red"><div class="input-field col s12"><input type="text" class="validate" name="master_fc_cbm"></div></td>
            </tr>
            <tr>
              <td width="24%">Total Cost CBM</td>
              <td width="24%"><span class="text-total_cbm"></span></td>
              <td></td>
              <td width="24%">Multidrop Cost</td>
              <td width="24%"><div class="input-field col s12"><input type="text" class="validate" name="master_fc_cbm"></div></td>
            </tr>
            <tr>
              <td width="24%">Total Cost Ritase</td>
              <td width="24%"><span class="text-total_cbm"></span></td>
              <td></td>
              <td width="24%">Unloading Cost</td>
              <td width="24%"><div class="input-field col s12"><input type="text" class="validate" name="master_fc_cbm"></div></td>
            </tr>
            <tr>
              <td width="24%">Ritase 2 Cost</td>
              <td width="24%"><div class="input-field col s12"><input type="text" class="validate" name="master_fc_cbm"></div></td>
              <td></td>
              <td width="24%">Overstay Cost</td>
              <td width="24%"><div class="input-field col s12"><input type="text" class="validate" name="master_fc_cbm"></div></td>
            </tr>
            <tr>
              <td>Cost Per DO</td>
              <td><span class="text-total_cbm"></span></td>
              <td></td>
              <td></td><td></td>
            </tr>
          </table>
          {!! get_button_save('Update') !!}
        </form>
      </div>
    </div>

  </div>
   <div class="modal-footer">
    <span class="modal-action modal-close waves-effect waves-green btn-flat">Cancel</span>
  </div>
</div>
@endpush

@push('script_js')
<script type="text/javascript">
  jQuery(document).ready(function($) {
    $('#table_list_manifest_receipt_do').on('click', '.btn-view', function(event) {
      event.preventDefault();
      /* Act on the event */
      var tr = $(this).parent().parent();
      var data = dttable_list_manifest_receipt_do.row(tr).data();
      console.log(data)

      $.ajax({
        url: '{{url("receipt-invoice/" . (!empty($invoiceReceiptHeader) ? $invoiceReceiptHeader->id : "null") . '/do-data' )}}',
        type: 'GET',
        dataType: 'json',
        data: {do_manifest_no: data.do_manifest_no, delivery_no: data.delivery_no},
      })
      .done(function(result) {
        if (result.status) {
          $('#modal-detail-do .text-manifest_no').text(data.do_manifest_no)
          $('#modal-detail-do .text-delivery_no').text(data.delivery_no)

          $('#modal-detail-do .table_do tbody').empty();
          var row = '';
          row += '<tr>';
          row += '<td>' + data.delivery_no + '</td>';
          row += '<td>' + data.ship_to_code + '</td>';
          row += '<td>' + data.ship_to + '</td>';
          row += '<td>' + data.city_name + '</td>';
          row += '</tr>';
          $('#modal-detail-do .table_do tbody').append(row)

          $('#modal-detail-do .table_do_detail tbody').empty();
          $.each(result.data, function(index, val) {
             /* iterate through array or object */
              var row = '';
              row += '<tr>';
              row += '<td>' + val.delivery_items + '</td>';
              row += '<td>' + val.model + '</td>';
              row += '<td>' + val.quantity + '</td>';
              row += '<td><div class="input-field col s12"><input type="text" class="validate" name="master_fc_cbm" value="' + val.cbm + '"></div></td>';
              var total_cbm = val.quantity * val.cbm;
              row += '<td>' + total_cbm + '</td>';
              row += '<td><span class="waves-effect waves-light indigo btn-small btn-update">Update</span></td>';
              row += '</tr>';
              $('#modal-detail-do .table_do_detail tbody').append(row)
          });

          $('#modal-detail-do').modal('open')
        }
      })
      .fail(function() {
        console.log("error");
      })
      .always(function() {
        console.log("complete");
      });
      
    });
  });
</script>
@endpush