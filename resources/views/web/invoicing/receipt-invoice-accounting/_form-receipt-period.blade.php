<form id="form-add-receipt">
<input type="hidden" name="group_id_report">
<h4 class="card-title">Search</h4>
<hr>
<br>
<div class="row">
<div class="col s12 m2 mt-1">
   Receipt Period
</div>
<div class="app-search col s12 m4">
   <input type="text" id="filter-receipt-period" class="monthpicker" autocomplete="off">
   </div>
   <div class="col s12 m2">
   <a href="#!" class="waves-effect waves-light indigo btn btn-search-receipt">
      Search
   </a>
   </div>
</div>
<h4 class="card-title">Result</h4>
<hr>
<div class="section-data-tables">
   <table id="table-list-receipt" class="display" width="100%">
   <thead>
      <tr>
         <th>NO TANDA TERIMA</th>
         <th>RECEIPT ID</th>
         <th>RECEIPT DATE</th>
         <th>KWITANSI NO</th>
         <th>SUM OF CBM</th>
         <th data-priority="1" class="datatable-checkbox-cell" width="30px">
         <label>
            <input type="checkbox" class="select-all" />
            <span></span>
         </label>
         </th>
      </tr>
   </thead>
   <tbody></tbody>
   </table>
</div>
<div class="row">
   <div class="col s12">
   {!! get_button_save('Submit') !!}
   </div>
</div>
</form>


@push('script_js')
<script type="text/javascript">
  $('.monthpicker').datepicker({
    format: 'mm/yyyy',
    autoHide: true
  });
  var dttable_list_receipt;
  $(document).ready(function(){
    dttable_list_receipt = $('#table-list-receipt').DataTable({
      serverSide: true,
      scrollX: true,
      responsive: true,
      ajax: {
        url: '{{url("receipt-invoice-accounting/receipt-list")}}',
        type: 'GET',
        data: function(d) {
          d.receipt_period = $('#filter-receipt-period').val();
        }
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
          data: 'DT_RowIndex',
          orderable: false,
          searchable: false,
          render: function(data, type, row) {
            if (type === 'display') {
              return '<label><input type="checkbox" value="" class="checkbox"><span></span></label>';
            }
            return data;
          },
          className: "datatable-checkbox-cell"
        },
      ]
    });

    set_datatables_checkbox('#table-list-receipt', dttable_list_receipt)

    $('.btn-search-receipt').click(function(){
      dttable_list_receipt.ajax.reload(null, false)
    })

    $('#form-add-receipt').validate({
      submitHandler: function (form){
        setLoading(true); // Disable Button when ajax post data
        var data_list_receipt = [];
        dttable_list_receipt.$('input[type="checkbox"]').each(function() {
           /* iterate through array or object */
           if(this.checked){
            var row = $(this).closest('tr');
            var row_data = dttable_list_receipt.row(row).data();
            data_list_receipt.push(row_data);
           }
        });
        $.ajax({
          url: '{{ url("receipt-invoice-accounting") }}',
          type: 'POST',
          data: $(form).serialize() + '&data_list_receipt=' + JSON.stringify(data_list_receipt),
        })
        .done(function(result) { // selesai dan berhasil
          if (result.status) {
            showSwalAutoClose("Success", result.message)
            window.location.href = "{{ url('receipt-invoice-accounting') }}" + "/" + result.data.group_id_report
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