@push('page-modal')
<!-- Modal Structure -->
<div id="modal1" class="modal">
<form id="form-upload-model">
  <input type="hidden" name="arrival_no" value="{{$incomingManualHeader->arrival_no}}">
  <div class="modal-content">
        <h4>Upload Model</h4>
          <div class="row">
            
            <div class="col s12 m2">
              <p>Data File</p>
            </div>  
            
            <div class="col s12 m10">
              <div class="file-field input-field">
                <div class="btn indigo btn">
                  <span>Browse</span>
                  <input name="file_model" type="file">
                </div>
                <div class="file-path-wrapper">
                  <input class="file-path validate" type="text" placeholder="Select File   Format File : csv" required>
                </div>
              </div>
            </div>

            <div class="row">
            <div class="col s12 m2">
              <p></p>
            </div>  
            <div class="col s12 m10">
              <p>Format Layout coloumn : [Model],[Qty],[SLOC]</p>
            </div>
          </div>
      </div>
  <div class="modal-footer">
    <button type="submit" class="waves-effect waves-green btn indigo">Upload</button>
    <span class="modal-action modal-close waves-effect waves-green btn-flat">Cancel</span>
  </div>
</div>
</form>
</div>
@endpush

@push('script_js')
<script type="text/javascript">
  jQuery(document).ready(function($) {
    $("#form-upload-model").validate({
        submitHandler: function(form) {
          var fdata = new FormData(form);
          $.ajax({
            url: '{{ url("incoming-import-oem/upload-model") }}',
            type: 'POST',
            data: fdata,
            contentType: "application/json",
            dataType: "json",
            contentType: false,
            processData: false
          })
          .done(function(data) { // selesai dan berhasil
            $(form)[0].reset();
            $('#modal1').modal('close');
            if (data.status == false) {
              // $('#table-concept tbody').empty();
              swal("Failed!", data.message, "warning");
            } else {
              showSwalAutoClose('Success', 'Data uploaded.')
              dttable_incoming_detail.ajax.reload(null, false);  // (null, false) => user paging is not reset on reload
            }
           
          })
          .fail(function(xhr) {
              showSwalError(xhr) // Custom function to show error with sweetAlert
          });
        }
      });
  });
</script>
@endpush