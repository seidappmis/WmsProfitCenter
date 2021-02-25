<div class="card-content">
  @include('web.invoicing.receipt-invoice._form_manifest')

  <!-- Receipt Invoice -->
  <div class="row">
    <div class="col s12">
      <div class="row">
        <h4 class="card-title">Receipt Invoice</h4>
        <hr>
        <div class="card">
          <div class="card-content pt-1 pb-1 pr-1 pl-1">
            <strong>NEW</strong>
            <h6 class="card-title">List Manifest Receipt</h6>
            <hr>
            @if(!empty($invoiceReceiptHeader) && empty($invoiceReceiptHeader->invoice_receipt_no))
            <span class="waves-effect waves-light btn btn-small btn-create-receipt-no indigo darken-4 mb-1">Create Receipt No.</span>
            @endif
            <div class="section-data-tables">
              <table id="table_list_manifest_receipt" class="display" width="100%">
                <thead>
                  <tr>
                    <th data-priority="1" width="30px">NO.</th>
                    <th>Manifest No</th>
                    <th>DATE MANIFEST</th>
                    <th>VEHICLE NO</th>
                    <th>VEHICLE</th>
                    <th>DESTINATION</th>
                    <th>COUNT OF DO</th>
                    <th>SUM OF CBM</th>
                    <th>CBM</th>
                    <th>RITASE</th>
                    <th>RITASE2</th>
                    <th>MULTIDROP</th>
                    <th>UNLOADING</th>
                    <th>OVERSTAY</th>
                    <th>TOTAL</th>
                    <th width="50px;"></th>
                    <th width="50px;"></th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>

            <div class="row mt-2">
              <div class="input-field col s3">
                <input id="kwitansi_no" type="text" value="{{!empty($invoiceReceiptHeader) ? $invoiceReceiptHeader->kwitansi_no : ''}}" placeholder="">
                <label for="kwitansi_no">Kwitansi No.</label>
              </div>
              <div class="input-field col s3">
                <input id="invoice_receipt_id" type="text" placeholder="" value="{{!empty($invoiceReceiptHeader) ? $invoiceReceiptHeader->invoice_receipt_id : ''}}" readonly="readonly">
                <label for="invoice_receipt_id">Receipt ID.</label>
              </div>
              <div class="input-field col s4">
                <input id="invoice_receipt_no" type="text" placeholder="" value="{{!empty($invoiceReceiptHeader) ? $invoiceReceiptHeader->invoice_receipt_no : ''}}" readonly="readonly">
                <label for="invoice_receipt_no">Receipt No.</label>
              </div>
              <div class="col s2">
                <span class="waves-effect waves-light btn btn-small btn-update-receipt-invoice indigo darken-4 mt-5 {{!empty($invoiceReceiptHeader->invoice_receipt_no) ? '' : 'hide'}}">Update</span>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="input-field col s2">
                <input id="amount_pph" class="mask_money" type="text" value="{{!empty($invoiceReceiptHeader) ? $invoiceReceiptHeader->amount_pph : ''}}" placeholder="" required>
                <label for="amount_pph">PPh 2% (A)</label>
              </div>
              <div class="input-field col s2">
                <input id="amount_ppn" class="mask_money" type="text" value="{{!empty($invoiceReceiptHeader) ? $invoiceReceiptHeader->amount_ppn : ''}}" placeholder="" required>
                <label for="amount_ppn">PPn 10% (B)</label>
              </div>
              <div class="input-field col s2">
                <input id="amount_before_tax" class="mask_money" type="text" placeholder="" readonly="readonly">
                <label for="first_name">Amount Invoice (X)</label>
              </div>
              <div class="input-field col s3">
                <input id="amount_after_tax" class="mask_money" type="text" placeholder="" readonly="readonly">
                <label for="first_name">Amount Invoice + PPn(B+X)</label>
              </div>
              <div class="col s3">
                <span class="waves-effect waves-light btn btn-small btn-update-ppn indigo darken-4 mt-5 {{!empty($invoiceReceiptHeader->invoice_receipt_no) ? '' : 'hide'}}">Update PPN</span>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s12 m4">
                <textarea id="remarks" class="materialize-textarea" placeholder="">{{!empty($invoiceReceiptHeader) ? $invoiceReceiptHeader->remarks : ''}}</textarea>
                <label for="remarks">REMARKS</label>
              </div>
            </div>
            @if(!empty($invoiceReceiptHeader))
            {!! get_button_print('#', 'Print Receipt NO', 'btn-print-receipt-no mt-0') !!}
            {!! get_button_print('#', 'Print Receive Invoice', 'btn-print-receive-invoice mt-0') !!}
            <br>
            {!! get_button_save('Submit to Accounting', 'btn-submit-to-accounting mt-1') !!}
            @endif

            <div class="list-do-wrapper hide mt-2">
              <h6 class="card-title">LIST DO</h6>
              <hr>
              Manifest No : <span id="text-detail-manifest-no"></span>
              <div class="row update-ritase-wrapper">
                <div class="input-field col m2">
                  <input id="update-ritase-amount" class="mask_money" type="text" placeholder="">
                  <label for="ritase">Update Ritase</label>
                </div>
                <div class="col m3">
                  <span class="waves-effect waves-light btn btn-small btn-update-ritase indigo darken-4 mt-5">Update Ritase</span>
                </div>
              </div>
              <div class="section-data-tables">
                <table id="table_list_manifest_receipt_do" class="display" width="100%">
                  <thead>
                    <tr>
                      <th data-priority="1" width="30px">NO.</th>
                      <th>MANIFEST NO</th>
                      <th>DO DATE</th>
                      <th>DO NO</th>
                      <th>DO Int No</th>
                      <th>CITY DO</th>
                      <th>SHIP TO DETAIL</th>
                      <th>CBM DO</th>
                      <th>CBM</th>
                      <th>RITASE</th>
                      <th>RITASE2</th>
                      <th>MULTIDROP</th>
                      <th>UNLOADING</th>
                      <th>OVERSTAY</th>
                      <th>COST PER DO</th>
                      <th width="50px;"></th>
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@include('layouts.materialize.components.modal-print', [
'title' => 'Print Receipt No',
'url' => '#!',
])

@include('layouts.materialize.components.modal-print', [
'title' => 'Print Receive Invoice',
'url' => 'receipt-invoice/' . (!empty($invoiceReceiptHeader) ? $invoiceReceiptHeader->id : '') . '/export-receive-invoice',
'trigger' => '.btn-print-receive-invoice'
])

@push('vendor_js')
<script src="{{ asset('materialize/vendors/jquery-validation/jquery.validate.min.js') }}">
</script>
@endpush

@push('script_js')
<script type="text/javascript">
  var dttable_list_manifest_receipt
  var dttable_list_manifest_receipt_do
  jQuery(document).ready(function($) {
    $('.btn-print-receipt-no').click(function(event) {
        /* Act on the event */
        $('#modal-print-PrintReceiptNo').modal('open');
        initPrintPreviewPrintReceiptNo('/receipt-invoice/{{ (!empty($invoiceReceiptHeader) ? $invoiceReceiptHeader->id : '') }}/export-receipt-no', 'remarks=' + $('#remarks').val());
      });
    
    $('.mask_money').inputmask({
      alias: 'currency',
      autoUnmask: true,
    });

    $('#remarks').keyup(function(){
      $.ajax({
        url: '{{url("receipt-invoice/" . (!empty($invoiceReceiptHeader) ? $invoiceReceiptHeader->id : "null") )}}' + '/update-remarks',
        type: 'PUT',
        data: 'remarks=' + $(this).val()
      })
      .done(function(result) { // Kalau ajax nya success
      })
      .fail(function() { // Kalau ajax nya gagal
        console.log("error");
      });
    })
    @if(!empty($invoiceReceiptHeader))
    dttable_list_manifest_receipt = $('#table_list_manifest_receipt').DataTable({
      serverSide: true,
      scrollX: true,
      responsive: false,
      paging: false,
      info: false,
      ajax: {
        url: '{{url("receipt-invoice/" . (!empty($invoiceReceiptHeader) ? $invoiceReceiptHeader->id : "null"))}}',
        type: 'GET'
      },
      order: [1, 'asc'],
      "fnDrawCallback": function(oSettings) {
        var invoiceReceiptHeader = oSettings.json.invoiceReceiptHeader;
        $('#amount_before_tax').val(setDecimal(invoiceReceiptHeader.amount_before_tax != null ? invoiceReceiptHeader.amount_before_tax : 0))
        $('#amount_after_tax').val(setDecimal(invoiceReceiptHeader.amount_after_tax != null ? invoiceReceiptHeader.amount_after_tax : 0))
        $('#amount_ppn').val(setDecimal(invoiceReceiptHeader.amount_ppn != null ? invoiceReceiptHeader.amount_ppn : 0))
        $('#amount_pph').val(setDecimal(invoiceReceiptHeader.amount_pph != null ? invoiceReceiptHeader.amount_pph : 0))
        calculateInvoice()
      },
      columns: [{
          data: 'DT_RowIndex',
          orderable: false,
          searchable: false,
          className: 'center-align'
        },
        {
          data: 'do_manifest_no'
        },
        {
          data: 'do_manifest_date'
        },
        {
          data: 'vehicle_number'
        },
        {
          data: 'vehicle_description'
        },
        {
          data: 'city_name'
        },
        {
          data: 'count_of_do'
        },
        {
          data: 'cbm_do',
          className: 'right-align'
        },
        {
          data: 'cbm_amount',
          className: 'right-align'
        },
        {
          data: 'ritase_amount',
          className: 'right-align'
        },
        {
          data: 'ritase2_amount',
          className: 'right-align'
        },
        {
          data: 'multidro_amount',
          className: 'right-align'
        },
        {
          data: 'unloading_amount',
          className: 'right-align'
        },
        {
          data: 'overstay_amount',
          className: 'right-align'
        },
        {
          data: 'total',
          className: 'right-align'
        },
        {
          data: 'action_view',
          className: 'center-align'
        },
        {
          data: 'action_delete',
          className: 'center-align'
        },
      ]
    });

    dttable_list_manifest_receipt_do = $('#table_list_manifest_receipt_do').DataTable({
      serverSide: true,
      scrollX: true,
      responsive: false,
      paging: false,
      info: false,
      ajax: {
        url: '{{url("receipt-invoice/" . (!empty($invoiceReceiptHeader) ? $invoiceReceiptHeader->id : "null") . "/manifest" )}}',
        type: 'GET',
        data: function(d) {
          d.do_manifest_no = $('#text-detail-manifest-no').text();
        }
      },
      order: [1, 'asc'],
      columns: [{
          data: 'DT_RowIndex',
          orderable: false,
          searchable: false,
          className: 'center-align'
        },
        {
          data: 'do_manifest_no'
        },
        {
          data: 'do_date'
        },
        {
          data: 'delivery_no'
        },
        {
          data: 'do_manifest_no'
        },
        {
          data: 'city_name'
        },
        {
          data: 'ship_to'
        },
        {
          data: 'cbm_do',
          className: 'center-align'
        },
        {
          data: 'cbm_amount',
          className: 'center-align'
        },
        {
          data: 'ritase_amount',
          className: 'center-align'
        },
        {
          data: 'ritase2_amount',
          className: 'center-align'
        },
        {
          data: 'multidro_amount',
          className: 'center-align'
        },
        {
          data: 'unloading_amount',
          className: 'center-align'
        },
        {
          data: 'overstay_amount',
          className: 'center-align'
        },
        {
          data: 'total',
          className: 'center-align'
        },
        {
          data: 'action_view',
          className: 'center-align'
        },
      ]
    });

    dttable_list_manifest_receipt.on('click', '.btn-view', function(event) {
      event.preventDefault();
      /* Act on the event */
      var tr = $(this).parent().parent();
      var data = dttable_list_manifest_receipt.row(tr).data();
      if(data.ritase_amount != 0) {
        $('.update-ritase-wrapper').removeClass('hide');
        $('#update-ritase-amount').val(data.ritase_amount)
      } else {
        $('.update-ritase-wrapper').addClass('hide');
      }
      $('#text-detail-manifest-no').text(data.do_manifest_no)
      $('.list-do-wrapper').removeClass('hide')
      dttable_list_manifest_receipt_do.ajax.reload(null, false)
    });

    $('.btn-update-ritase').click(function(){
      $.ajax({
        url: '{{url("receipt-invoice/" . (!empty($invoiceReceiptHeader) ? $invoiceReceiptHeader->id : "null") )}}' + '/manifest/' + $('#text-detail-manifest-no').text() + '/update-ritase',
        type: 'PUT',
        data: {
          ritase_amount: $('#update-ritase-amount').val()
        }
      })
      .done(function(result) { // Kalau ajax nya success
        if (result.status) {
          showSwalAutoClose('Success', result.message)
          dttable_list_manifest_receipt.ajax.reload(null, false); // reload datatable
          dttable_list_manifest_receipt_do.ajax.reload(null, false); // reload datatable
        }
      })
      .fail(function() { // Kalau ajax nya gagal
        console.log("error");
      });
    })

    dttable_list_manifest_receipt.on('click', '.btn-delete', function(event) {
      event.preventDefault();
      /* Act on the event */
      var tr = $(this).parent().parent();
      var data = dttable_list_manifest_receipt.row(tr).data();
      swal({
        text: "Delete Manifest No " + data.do_manifest_no + "?",
        icon: 'warning',
        buttons: {
          cancel: true,
          delete: 'Yes, Delete It'
        }
      }).then(function(confirm) { // proses confirm
        if (confirm) { // Bila oke post ajax ke url delete nya
          // Ajax Post Delete
          $.ajax({
              url: '{{url("receipt-invoice/" . (!empty($invoiceReceiptHeader) ? $invoiceReceiptHeader->id : "null") )}}' + '/manifest/' + data.do_manifest_no,
              type: 'DELETE',
            })
            .done(function(result) { // Kalau ajax nya success
              if (result.status) {
                showSwalAutoClose('Success', result.message)
                dttable_list_manifest_receipt.ajax.reload(null, false); // reload datatable
                dttable_manifest.ajax.reload(null, false); // reload datatable
              }
            })
            .fail(function() { // Kalau ajax nya gagal
              console.log("error");
            });

        }
      })
    });

    $('.btn-submit-to-accounting').click(function(){
      swal({
        text: "Data cannot be edit/delete, Are you sure to transfer to accounting?",
        icon: 'warning',
        buttons: {
          cancel: true,
          ok: 'Ok'
        }
      }).then(function(confirm) { // proses confirm
        if (confirm) { // Bila oke post ajax ke url delete nya
          // Ajax Post Delete
          $.ajax({
              url: '{{url("receipt-invoice/" . (!empty($invoiceReceiptHeader) ? $invoiceReceiptHeader->id : "null") )}}' + '/submit-to-accounting',
              type: 'POST',
            })
            .done(function(result) { // Kalau ajax nya success
              if (result.status) {
                showSwalAutoClose('Success', result.message)
                dttable_list_manifest_receipt.ajax.reload(null, false); // reload datatable
                dttable_manifest.ajax.reload(null, false); // reload datatable
                setTimeout(function(){
                     window.location.href = '{{url("receipt-invoice/" . (!empty($invoiceReceiptHeader) ? $invoiceReceiptHeader->id : "null") )}}'
                  }, 1000)
              }
            })
            .fail(function() { // Kalau ajax nya gagal
              console.log("error");
            });

        }
      })
    })

    $('.btn-update-receipt-invoice').click(function(event) {
      $.ajax({
          url: '{{url("receipt-invoice/" .  (!empty($invoiceReceiptHeader) ? $invoiceReceiptHeader->id : "null") . "/update-receipt-invoice")}}',
          type: 'PUT',
          dataType: 'json',
          data: {
            kwitansi_no: $('#kwitansi_no').val()
          }
        })
        .done(function(result) {
          if (result.status) {
            showSwalAutoClose("Success", result.message)
            $('#kwitansi_no').val(result.data.kwitansi_no)
            $('#invoice_receipt_id').val(result.data.invoice_receipt_id)
          }
        })
        .fail(function(xhr) {
          showSwalError(xhr)
          console.log("error");
        })
        .always(function() {
          console.log("complete");
        });
    })

    $('.btn-create-receipt-no').click(function(event) {
      /* Act on the event */
      $.ajax({
          url: '{{url("receipt-invoice/" .  (!empty($invoiceReceiptHeader) ? $invoiceReceiptHeader->id : "null") . "/create-receipt-no")}}',
          type: 'POST',
          dataType: 'json',
        })
        .done(function(result) {
          if (result.status) {
            showSwalAutoClose("Success", result.message)
            $('#invoice_receipt_no').val(result.data.invoice_receipt_no)
            $('.btn-update-receipt-invoice').removeClass('hide')
            $('.btn-create-receipt-no').addClass('hide')
          }
        })
        .fail(function(xhr) {
          showSwalError(xhr)
          console.log("error");
        })
        .always(function() {
          console.log("complete");
        });

    });

    $('.btn-update-ppn').click(function(event) {
      /* Act on the event */
      $.ajax({
          url: '{{url("receipt-invoice/" .  (!empty($invoiceReceiptHeader) ? $invoiceReceiptHeader->id : "null") . "/update-ppn")}}',
          type: 'PUT',
          dataType: 'json',
          data: {
            amount_pph: $('#amount_pph').val(),
            amount_ppn: $('#amount_ppn').val()
          }
        })
        .done(function(result) {
          if (result.status) {
            showSwalAutoClose("Success", result.message)
            $('#amount_after_tax').val(result.data.amount_after_tax)
            calculateInvoice()
          } else {
            showSwalAutoClose("Warning", result.message)
          }
        })
        .fail(function(xhr) {
          showSwalError(xhr)
          console.log("error");
        })
        .always(function() {
          console.log("complete");
        });
    });
    @endif
  });

  function calculateInvoice() {
    {{-- var amount_after_tax = parseFloat($('#amount_ppn').val()) + parseFloat($('#amount_before_tax').val()) - parseFloat($('#amount_pph').val()); --}}
    var amount_after_tax = parseFloat($('#amount_ppn').val()) + parseFloat($('#amount_before_tax').val());
    $('#amount_after_tax').val(amount_after_tax.toFixed(3))
  }
</script>
@endpush

@include('web.invoicing.receipt-invoice.modal-detail-do')