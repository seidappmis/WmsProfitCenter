<h5>Split Concept</h5>
<div class="section-data-tables">
  <table id="item-split-table" class="display form-table" width="100%">
    <input type="hidden" name="invoice_no">
    <input type="hidden" name="delivery_no">
    <input type="hidden" name="line_no">
    <input type="hidden" name="quantity">
      <thead>
          <tr>
            <th data-priority="1">Invoice No</th>
            <th>Line No</th>
            <th>Delivery No</th>
            <th>Delivery Items</th>
            <th>Quantity</th>
            <th>CBM</th>
            <th>Total Split</th>
            <th></th>
          </tr>
      </thead>
      <tbody>
      </tbody>
  </table>
</div>

<h6>CBM / Item : <span id="text-split-cbm-per-item"></span></h6>
<div class="section-data-tables">
  <table id="item-split-detail-table" class="display form-table" width="100%">
      <thead>
          <tr>
            <th data-priority="1">Invoice Line No</th>
            <th>DO Items.</th>
            <th>Quantity</th>
          </tr>
      </thead>
      <tbody>
      </tbody>
  </table>
</div>

<button type="submit" class="modal-action waves-effect waves-light indigo btn-small mt-2">Submit</button>
<a href="#!" class="modal-action modal-close waves-effect waves-light indigo btn-small mt-2">Cancel</a>

@push('vendor_js')
<script src="{{ asset('materialize/vendors/jquery-validation/jquery.validate.min.js') }}">
</script>
@endpush

@push('script_js')
<script type="text/javascript">
  $("#form-split-concept").validate({
    submitHandler: function(form) {
      setLoading(true); // Disable Button when ajax post data
      $.ajax({
        url: '{{ url("picking-list/split-concept") }}',
        type: 'POST',
        data: $(form).serialize(),
      })
      .done(function(result) { // selesai dan berhasil
        setLoading(false); // Enable Button when failed
        if (result.status) {
          showSwalAutoClose('Success', result.message)
          $('#modal-split-concept').modal('close')
          dtdatatable_do_for_picking.ajax.reload(null, false)
        } else {
          showSwalAutoClose('Warning', result.message)
        }
      })
      .fail(function(xhr) {
        setLoading(false); // Enable Button when failed
          showSwalError(xhr) // Custom function to show error with sweetAlert
      });
    }
  });

  function runSplitConceptTable(ths, data){
    var total_split = $(ths).parent().parent().find('[name="total_split"]').val();
    total_split = (total_split < 2) ? 2 : total_split;
    $('#item-split-detail-table tbody').empty();
    var quantity = $('#form-split-concept [name="quantity"]').val();
    console.log(data)

    for (var i = total_split; i > 0; i--) {
      data.max_delivery_items += 10;
      var tr = '';
      tr += '<tr>';
      @if(auth()->user()->cabang->hq)
      data.max_line_no += 1;
      tr += '<td>' + data.max_line_no + '</td>';
      @else
      tr += '<td>' + data.line_no + '</td>';
      @endif
      tr += '<td>' + data.max_delivery_items  + '</td>';
      tr += '<td><input type="number" name="quantity_split[]" value="' + Math.floor(quantity/total_split) + '"></td>';
      tr += '</tr>';

      $('#item-split-detail-table tbody').append(tr)
    }
  }
</script>
@endpush