@push('page-modal')
<!-- Modal Structure -->
<div id="modal-upload-do" class="modal">
<form id="form-upload-do">
  <div class="modal-content">
    <h4>Upload</h4>
    <table class="form-table">
      <tr>
        <td width="120px">Upload Type</td>
        <td>Manual <input type="hidden" name="type" value="manual"></td>
      </tr>
      <tr>
        <td width="120px">Data File</td>
        <td>
          <div class="file-field input-field">
            <div class="btn indigo btn">
              <span>Browse</span>
              <input name="file-do" type="file">
            </div>
            <div class="file-path-wrapper">
              <input class="file-path validate" type="text" placeholder="Select File   Format File : csv" required>
            </div>
          </div>
        </td>
      </tr>
      <tr>
        <td width="120px">City Ship To.</td>
        <td>
          <div class="input-field col s12">
            <select name="ship_to" class="select2-data-ajax browser-default" required>
            </select>
            <input type="hidden" name="city_name">
            </div>
        </td>
      </tr>
      <tr>
        <td width="120px">DO Internal</td>
        <td>
          <div class="input-field col s12">
            <input type="text" class="validate" name="do_internal" />
          </div>
        </td>
      </tr>
      <tr>
        <td width="120px">Reservasi No.</td>
        <td>
          <div class="input-field col s12">
            <input type="text" class="validate" name="reservasi_no" />
          </div>
        </td>
      </tr>
    </table>
  </div>
  <div class="modal-footer">
    <button type="submit" class="waves-effect waves-green btn indigo">Submit</button>
    <span class="modal-action modal-close waves-effect waves-green btn-flat">Cancel</span>
  </div>
</div>
</form>
</div>
@endpush

@push('script_js')
<script type="text/javascript">
  jQuery(document).ready(function($) {
    $('#form-upload-do [name="ship_to"]').select2({
        placeholder: '-- Select Ship to City --',
        allowClear: true,
        ajax: get_select2_ajax_options('{{url('/master-expedition/select2-expedition-destination-city')}}', {expedition_code: '{{$lmbHeader->expedition_code}}'})
      })
    $('#form-upload-do [name="ship_to"]').change(function(event) {
      /* Act on the event */
      var data = $(this).select2('data')[0]
      $('#form-upload-do [name="city_name"]').val(data.text)
    });

    $("#form-upload-do").validate({
        submitHandler: function(form) {
          var fdata = new FormData(form);
          $.ajax({
            url: '{{ url("manifest-regular/" . $manifestHeader->do_manifest_no . "/upload-do") }}',
            type: 'POST',
            data: fdata,
            contentType: "application/json",
            dataType: "json",
            contentType: false,
            processData: false
          })
          .done(function(data) { // selesai dan berhasil
            data_concept = data;
            $(form)[0].reset();
             $('#modal-upload-do').modal('close');
             window.location.href = '{{ url("manifest-regular/" . $manifestHeader->do_manifest_no . '/edit') }}';
            if (data.status == false) {
              // $('#table-concept tbody').empty();
              swal("Failed!", data.message, "warning");
              return;
            }
            showSwalAutoClose('Success', 'Data uploaded.')
          })
          .fail(function(xhr) {
              showSwalError(xhr) // Custom function to show error with sweetAlert
          });
        }
      });
  });
</script>
@endpush