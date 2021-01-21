<br>
<h4 class="card-title">INPUT PAYMENT REQUISITION</h4>
<hr>
<br>
<form id="form-input-payment-requisition" class="form-table">
<table id="table_input_payment_requisition" width="100%">
   <thead>
      <tr>
         <th>EXPEDITION NAME</th>
         <th>PAYMENT REQUISITION</th>
      </tr>
   </thead>
</table>
{!! get_button_save('Save', 'btn-save-payment-requisition mt-1') !!}
</form>

@push('script_js')
<script>
var dttable_input_payment_requisition
$(document).ready(function(){
   dttable_input_payment_requisition = $('#table_input_payment_requisition').DataTable({
        serverSide: true,
        scrollX: true,
        responsive: true,
        searching: false,
        paging: false,
        info: false,
        ajax: {
            url: '/receipt-invoice-accounting/{{ $group_id_report }}/payment-requisition',
            type: 'GET',
            data: function(d) {
                d.search['value'] = $('#global_filter').val();
              }
        },
        order: [0, 'asc'],
        columns: [
            {data: 'expedition_name'},
            {data: 'payment_requisition', orderable: false, render: function(data, type, row) {
               var inputfield = '';
               inputfield += '<input type="hidden" value="' + (row.expedition_name !== null ? row.expedition_name : '') + '" name="expedition_name[]" class="" required>';
               inputfield += '<input type="text" value="' + (data !== null ? data : '') + '" name="payment_requisition[]" class="" required>';
               return inputfield;
            }},
        ]
    });

    $('#form-input-payment-requisition').validate({
       submitHandler: function (form) {
          setLoading(true)
          $.ajax({
               url: '{{ url("receipt-invoice-accounting/" . $group_id_report . "/payment-requisition") }}',
               type: 'POST',
               data: $(form).serialize(),
            })
            .done(function(result) { // selesai dan berhasil
               if (result.status) {
                  setLoading(false)
                  showSwalAutoClose("Success", result.message)
               } else {
                  setLoading(false)
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