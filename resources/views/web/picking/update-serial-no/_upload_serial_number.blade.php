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
    <button class="waves-effect waves-light indigo btn-small btn-submit-upload-data mt-2 mr-1 mb-1" onclick="submit_scan_data()">Submit</button>
</div>

<div id="model-not-exist-in-pickinglist-wrapper" class="hide">
  <h5>Model Not Exist in Picking List</h5>
    <table id="table-model-not-exist-in-pickinglist" class="table striped bordered" width="100%">
      <thead>
        <tr>
          <th>PICKING NO</th>
          <th>MODEL</th>
          <th>TOTAL SN</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>
    <br>
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
        setLoading(true); // Disable Button when ajax post data
        var fdata = new FormData(form);
        $.ajax({
          url: '{{ url("update-serial-no/upload") }}',
          type: 'POST',
          data: fdata,
          contentType: "application/json",
          dataType: "json",
          contentType: false,
          processData: false
        })
        .done(function(data) { // selesai dan berhasil
          setLoading(false); // Enable Button when failed
          $(form)[0].reset()
          if (data.status == false) {
            $('#table-serial-number tbody').empty();
            swal("Failed!", data.message, "warning");
            return;
          }
          showSwalAutoClose('Success', data.message)
          // data_serial_numbers = data.serial_numbers;
          // data_scan_summaries = data.scan_summaries;

          // $('#upload-serial-number-wrapper').show();
          // $('#table-serial-number tbody').empty();
          // $.each(data_scan_summaries, function(index, val) {
          //    /* iterate through array or object */
          //    var row = '<tr>';
          //    row += '<td>' + val.model + '</td>';
          //    row += '<td>' + val.quantity_scan + '</td>';
          //    row += '<td>' + val.quantity_picking + '</td>';
          //    row += '<td>' + val.quantity_existing + '</td>';
          //    row += '</tr>';

          //    $('#table-serial-number tbody').append(row);
          // });

          // if (Object.keys(data.model_not_exist_in_pickinglist).length > 0) {
          //   $('.btn-submit-upload-data').addClass('hide')
          //   $('#model-not-exist-in-pickinglist-wrapper').removeClass('hide')
          //   $('#table-model-not-exist-in-pickinglist tbody').empty()
          //   $.each(data.model_not_exist_in_pickinglist, function(index, val) {
          //      /* iterate through array or object */
          //      var row = '<tr>';
          //      row += '<td>' + val.picking_no + '</td>';
          //      row += '<td>' + val.model + '</td>';
          //      row += '<td>' + val.total_sn + '</td>';
          //      row += '</tr>';

          //      $('#table-model-not-exist-in-pickinglist tbody').append(row);
          //   });
          // }else {
          //   $('.btn-submit-upload-data').removeClass('hide')
          //   $('#model-not-exist-in-pickinglist-wrapper').addClass('hide')
          // }
        })
        .fail(function(xhr) {
            setLoading(false); // Enable Button when failed
            showSwalError(xhr) // Custom function to show error with sweetAlert
        });
      }
    });
function submit_scan_data(){
  setLoading(true); // Disable Button when ajax post data
    $.ajax({
      url: '{{ url("update-serial-no/store-scan") }}',
      type: 'POST',
      data: 'data_serial_numbers=' + JSON.stringify(data_serial_numbers),
    })
    .done(function(result) { // selesai dan berhasil
      setLoading(false); // Enable Button when failed
      if (result.status) {
        showSwalAutoClose('Success', result.message)
        $('#table-serial-number tbody').empty();
        $('#upload-serial-number-wrapper').hide();
        dttable_picking_list.ajax.reload(null, false)
      } else {
        showSwalAutoClose('Warning', result.message)
      }
    })
    .fail(function(xhr) {
      setLoading(false); // Enable Button when failed
        showSwalError(xhr) // Custom function to show error with sweetAlert
    });
  }
</script>
@endpush