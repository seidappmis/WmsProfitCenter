 <h4 class="card-title">Report Receipt No for Accounting List</h4>
<hr>
<br>
<table id="table_report_receipt" width="100%">
   <thead>
      <tr>
      <th>NO TANDA TERIMA</th>
      <th>RECEIPT ID</th>
      <th>RECEIPT DATE</th>
      <th>KWITANSI NO</th>
      <th>EXPEDITION</th>
      <th width="50px"></th>
      </tr>
   </thead>
</table>
<hr>
<br>
<form id="form-report-receipt" class="mb-1">
<input type="hidden" value="{{ $group_id_report }}" name="group_id_report">
<div class="row">
   <div class="input-field col s12 m3">
      <input type="text" name="logistic_staff" value="{{ $rs_receipt[0]->logistic_staff }}" placeholder="" class="">
      <label>Logistic Staff</label>
   </div>
   <div class="input-field col s12 m3">
      <input type="text" name="logistic_ass_manager" value="{{ $rs_receipt[0]->logistic_ass_manager }}" placeholder="" class="">
      <label>Logistic Ass. Supervisor</label>
   </div>
   <div class="input-field col s12 m3">
      <input type="text" name="logistic_manager" value="{{ $rs_receipt[0]->logistic_manager }}" placeholder="" class="">
      <label>Logistic Ass. Manager</label>
   </div>
   <div class="input-field col s12 m3">
      <input type="text" name="accounting_division" value="{{ $rs_receipt[0]->accounting_division }}" placeholder="" class="">
      <label>Accounting</label>
   </div>
</div>
{!! get_button_save('Save', 'btn-save-report-receipt mt-1') !!}
{!! get_button_print(url('#!'), 'Print Receipt Accounting', 'btn-print mt-1') !!}

</form>

@include('layouts.materialize.components.modal-print', [
'title' => 'Print Receipt Invoice Accounting',
'url' => 'receipt-invoice-accounting/' . $group_id_report . '/export-receipt-invoice-accounting',
'trigger' => '.btn-print'
])

@push('script_js')
<script type="text/javascript">
  var dttable_report_receipt;
  $(document).ready(function(){
    dttable_report_receipt = $('#table_report_receipt').DataTable({
      serverSide: true,
      scrollX: true,
      responsive: true,
      searching: false,
      paging: false,
      info: false,
      ajax: {
        url: '{{url("receipt-invoice-accounting/" . $group_id_report)}}',
        type: 'GET',
      },
      order: [1, 'asc'],
      columns: [
        {
          data: 'invoice_receipt_no'
        },
        {
          data: 'invoice_receipt_id'
        },
        {
          data: 'invoice_date'
        },
        {
          data: 'kwitansi_no'
        },
        {
          data: 'expedition_name'
        },
        {
          data: 'action', orderable: false
        },
      ]
    });

    dttable_report_receipt.on('draw', function (data) {
      if (dttable_report_receipt.page.info().recordsDisplay == 0) {
        window.location.href = '/receipt-invoice-accounting'
      } 
    });

    dttable_report_receipt.on('click', '.btn-delete', function(){
      var tr = $(this).parent().parent();
      var data = dttable_report_receipt.row(tr).data();
      swal({
        title: "Delete Receipt ID " + data.invoice_receipt_id + "?",
        icon: 'warning',
        buttons: {
          cancel: true,
          delete: 'Yes, Delete It'
        }
      }).then(function (confirm) { // proses confirm
        if (confirm) { // Bila oke post ajax ke url delete nya
          // Ajax Post Delete
          $.ajax({
            url: '/receipt-invoice-accounting/' + data.group_id_report + '/invoice/' + data.invoice_receipt_id,
            type: 'DELETE',
          })
          .done(function(result) { // Kalau ajax nya success
            if(result.status){
              showSwalAutoClose('Success', result.message);
              dttable_report_receipt.ajax.reload(null, false); // reload datatable
            } else {
              showSwalAutoClose("Failed", result.message);
            }
          })
          .fail(function() { // Kalau ajax nya gagal
            console.log("error");
          });
          
        }
      })
    })

    $('#form-report-receipt').validate({
      submitHandler: function(form){
        setLoading(true)
        $.ajax({
          url: '{{ url("receipt-invoice-accounting/" . $group_id_report) }}',
          type: 'PUT',
          data: $(form).serialize(),
        })
        .done(function(result) { // selesai dan berhasil
          setLoading(false)
          if (result.status) {
            showSwalAutoClose("Success", result.message)
          } else {
            showSwalAutoClose("Warning", result.message)
          }
        })
        .fail(function(xhr) {
            setLoading(false); // Enable Button when failed
            showSwalError(xhr) // Custom function to show error with sweetAlert
        });
      }
    })
  })
</script>
@endpush