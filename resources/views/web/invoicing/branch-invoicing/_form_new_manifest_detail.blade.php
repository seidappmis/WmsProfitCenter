<div class="form-manifest-detail-wrapper hide">
  <h4 class="card-title">Manifest Details</h4>
  <hr>
  <div class="card">
    <div class="card-content pt-1 pb-1 pl-1 pr-1">
      <form id="form-new-manifest-receipt">
        <strong>NEW</strong>
        <input type="hidden" name="group_id" value="{{$group_id}}">
        <h5 class="card-title">List Manifest Receipt</h5>
        <table id="table-new-details">
          <thead>
            <tr>
              <th>NO.</th>
              <th>DO DATE</th>
              <th>DO NUMBER</th>
              <th>SHIP TO CODE</th>
              <th>SHIP TO DETAIL</th>
              <th>CITY</th>
              <th>MODEL</th>
              <th>QTY</th>
              <th>TOTAL CBM</th>
              <th>COST/CBM</th>
              <th>COST/COLLY(Ȼ)</th>
              <th>COST/TRIP (RIT)</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
        {!! get_button_save() !!}
      </form>
    </div>
  </div>
</div>

@push('vendor_js')
<script src="{{ asset('materialize/vendors/jquery-validation/jquery.validate.min.js') }}">
</script>
@endpush

@push('script_js')
<script type="text/javascript">
  jQuery(document).ready(function($) {
    $('#form-new-manifest-receipt').validate({
      submitHandler: function(form){
        setLoading(true); // Disable Button when ajax post data
        $.ajax({
          url: '{{ url("branch-invoicing") }}',
          type: 'POST',
          data: $(form).serialize(),
        })
        .done(function(result) { // selesai dan berhasil
          if (result.status) {
            window.location.href = '{{url("branch-invoicing/create/" . $group_id)}}'
            showSwalAutoClose('Success', result.message)
          } else {
            setLoading(false); // Enable Button when failed
            showSwalAutoClose('Warning', result.message)
          }
        })
        .fail(function(xhr) {
          setLoading(false); // Enable Button when failed
          showSwalError(xhr) // Custom function to show error with sweetAlert
        });
      }
    })
  });
</script>
@endpush

