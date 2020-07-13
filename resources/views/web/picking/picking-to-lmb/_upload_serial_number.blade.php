<form id="form-upload-scan-serial-number">
    <div class="row mb-2">
        <div class="col s12 m2 pt-2">
            <p> Data File </p>
        </div>
        <div class="col s12 m10">
            <div class="file-field input-field">
                <div class="btn indigo btn">
                    <span>Browse</span>
                    <input type="file" name="file_scan">
                </div>
                <div class="file-path-wrapper">
                    <input class="file-path validate" type="text" placeholder="Select File Format File : txt" required="">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12">
            {!! get_button_save('Upload') !!}
        </div>
    </div>
</form>


<div id="upload-serial-number-wrapper" style="display: none;">
    <table id="table-serial-number" class="table striped bordered" width="100%">
      <thead>
        <tr>
          <th>MODEL</th>
          <th>QUANTITY SCAN</th>
          <th>QUANTITY PICKING</th>
          <th>QUANTITY EXISTING</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>
    <button class="waves-effect waves-light indigo btn-small btn-save mt-2 mr-1 mb-1" onclick="submit_scan_data()">Submit</button>
</div>

@push('script_js')
<script src="{{ asset('materialize/vendors/jquery-validation/jquery.validate.min.js') }}">
</script>
@endpush

@push('script_js')
<script type="text/javascript">
    var data_serial_numbers, data_scan_summaries;

    $("#form-upload-scan-serial-number").validate({
      submitHandler: function(form) {
        var fdata = new FormData(form);
        $.ajax({
          url: '{{ url("picking-to-lmb/upload") }}',
          type: 'POST',
          data: fdata,
          contentType: "application/json",
          dataType: "json",
          contentType: false,
          processData: false
        })
        .done(function(data) { // selesai dan berhasil
          if (data.status == false) {
            $('#table-serial-number tbody').empty();
            swal("Failed!", data.message, "warning");
            return;
          }
          data_serial_numbers = data.serial_numbers;
          data_scan_summaries = data.scan_summaries;
          swal("Good job!", "You clicked the button!", "success")
            .then((result) => {
              $('#upload-serial-number-wrapper').show();
              $('#table-serial-number tbody').empty();
              $.each(data_scan_summaries, function(index, val) {
                 /* iterate through array or object */
                 var row = '<tr>';
                 row += '<td>' + val.model + '</td>';
                 row += '<td>' + val.quantity_scan + '</td>';
                 row += '<td>' + val.quantity_picking + '</td>';
                 row += '<td>' + val.quantity_existing + '</td>';
                 row += '</tr>';

                 $('#table-serial-number tbody').append(row);
              });
            }) // alert success
        })
        .fail(function(xhr) {
            showSwalError(xhr) // Custom function to show error with sweetAlert
        });
      }
    });
function submit_scan_data(){
    $.ajax({
      url: '{{ url("picking-to-lmb/store-scan") }}',
      type: 'POST',
      data: 'data_serial_numbers=' + JSON.stringify(data_serial_numbers),
    })
    .done(function() { // selesai dan berhasil
      swal("Good job!", "You clicked the button!", "success")
        .then((result) => {
          $('#table-serial-number tbody').empty();
          $('#upload-serial-number-wrapper').hide();
          dttable_picking_list.ajax.reload(null, false)
        }) // alert success
    })
    .fail(function(xhr) {
        showSwalError(xhr) // Custom function to show error with sweetAlert
    });
  }
</script>
@endpush