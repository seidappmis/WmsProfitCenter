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
          <input type="hidden" name="id">
          <table class="form-table">
            <tr>
              <td width="24%">Total CBM</td>
              <td width="24%"><span class="text-total_cbm"></span></td>
              <td></td>
              <td width="24%" class="red">Master FC CBM</td>
              <td width="24%" class="red"><div class="input-field col s12"><input type="text" class="validate" name="freight_cost"></div></td>
            </tr>
            <tr>
              <td width="24%">Total Cost CBM</td>
              <td width="24%"><span class="text-cbm_amount"></span></td>
              <td></td>
              <td width="24%">Multidrop Cost</td>
              <td width="24%"><div class="input-field col s12"><input type="text" class="validate" name="multidro_amount"></div></td>
            </tr>
            <tr>
              <td width="24%">Total Cost Ritase</td>
              <td width="24%"><span class="text-ritase_amount"></span></td>
              <td></td>
              <td width="24%">Unloading Cost</td>
              <td width="24%"><div class="input-field col s12"><input type="text" class="validate" name="unloading_amount"></div></td>
            </tr>
            <tr>
              <td width="24%">Ritase 2 Cost</td>
              <td width="24%"><div class="input-field col s12"><input type="text" class="validate" name="ritase2_amount"></div></td>
              <td></td>
              <td width="24%">Overstay Cost</td>
              <td width="24%"><div class="input-field col s12"><input type="text" class="validate" name="overstay_amount"></div></td>
            </tr>
            <tr>
              <td>Cost Per DO</td>
              <td><span class="text-cost-per-do"></span></td>
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
    $('#form-cost-per-do').validate({
      submitHandler: function (form){
        setLoading(true);
        $.ajax({
          url: '{{url("receipt-invoice/" . (!empty($invoiceReceiptHeader) ? $invoiceReceiptHeader->id : "null") . '/do-data' )}}',
          type: 'PUT',
          dataType: 'json',
          data: $(form).serialize(),
        })
        .done(function(result) {
          setLoading(false);
          if (result.status) {
            showSwalAutoClose('Success', result.message)
            loadDODetail(result.data);
            dttable_list_manifest_receipt.ajax.reload(null, false)
            dttable_list_manifest_receipt_do.ajax.reload(null, false)
          } else {
            showSwalAutoClose('Warning', result.message)
          }
        })
        .fail(function() {
          setLoading(false);
          console.log("error");
        })
        .always(function() {
          console.log("complete");
        });
        
      }
    })

    $('#modal-detail-do .table_do_detail').on('click', '.btn-update', function(event) {
      event.preventDefault();
      /* Act on the event */
      var id = $(this).data('id');
      var cbm = $('#modal-detail-do [name="cbm_item_' + id + '"]').val()
      setLoading(true);
      $.ajax({
        url: '{{url("receipt-invoice/" . (!empty($invoiceReceiptHeader) ? $invoiceReceiptHeader->id : "null") . '/do-data' )}}' + '/' + id,
        type: 'PUT',
        dataType: 'json',
        data: {cbm: cbm, id: $('#form-cost-per-do [name="id"]').val()},
      })
      .done(function(result) {
        setLoading(false);
        if (result.status) {
          showSwalAutoClose('Success', result.message)
          loadDODetail(result.data);
          dttable_list_manifest_receipt.ajax.reload(null, false)
          dttable_list_manifest_receipt_do.ajax.reload(null, false)
        } else {
          showSwalAutoClose('Warning', result.message)
        }
      })
      .fail(function() {
        setLoading(false);
        console.log("error");
      })
      .always(function() {
        console.log("complete");
      });
      
    });

    $('#table_list_manifest_receipt_do').on('click', '.btn-view', function(event) {
      event.preventDefault();
      /* Act on the event */
      var tr = $(this).parent().parent();
      var data = dttable_list_manifest_receipt_do.row(tr).data();
      console.log(data)

      loadDODetail(data)

      $('#modal-detail-do').modal('open')
      
    });
  });

  function loadDODetail(data){
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

          $('#form-cost-per-do [name="id"]').val(data.id)
          $('#form-cost-per-do [name="freight_cost"]').val(getDecimal(data.freight_cost))
          $('#form-cost-per-do [name="multidro_amount"]').val(getDecimal(data.multidro_amount))
          $('#form-cost-per-do [name="unloading_amount"]').val(getDecimal(data.unloading_amount))
          $('#form-cost-per-do [name="ritase2_amount"]').val(getDecimal(data.ritase2_amount))
          $('#form-cost-per-do [name="overstay_amount"]').val(getDecimal(data.overstay_amount))

          $('#modal-detail-do .text-total_cbm').text(data.cbm_do)
          $('#modal-detail-do .text-cbm_amount').text(parseFloat(getDecimal(data.cbm_amount)).toFixed(3))
          $('#modal-detail-do .text-ritase_amount').text(getDecimal(data.ritase_amount))

          getCostPerDO(data)

          $('#modal-detail-do .table_do_detail tbody').empty();
          $.each(result.data, function(index, val) {
             /* iterate through array or object */
              var row = '';
              row += '<tr>';
              row += '<td>' + val.delivery_items + '</td>';
              row += '<td>' + val.model + '</td>';
              row += '<td>' + val.quantity + '</td>';
              var cbm = val.cbm / val.quantity;
              row += '<td><div class="input-field col s12"><input type="text" class="validate" name="cbm_item_' + val.id + '" value="' + cbm + '"></div></td>';
              row += '<td>' + val.cbm + '</td>';
              row += '<td><span class="waves-effect waves-light indigo btn-small btn-update" data-id="' + val.id + '">Update</span></td>';
              row += '</tr>';
              $('#modal-detail-do .table_do_detail tbody').append(row)
          });
        }
      })
      .fail(function() {
        console.log("error");
      })
      .always(function() {
        console.log("complete");
      });
  }

  function getCostPerDO(data){
    var cost_per_do = parseFloat(getDecimal(data.cbm_amount)) + parseFloat(getDecimal(data.ritase_amount)) + parseFloat(getDecimal(data.ritase2_amount)) + parseFloat(getDecimal(data.multidro_amount)) + parseFloat(getDecimal(data.unloading_amount)) + parseFloat(getDecimal(data.overstay_amount));

    $('.text-cost-per-do').text(cost_per_do.toFixed(3))
  }
</script>
@endpush