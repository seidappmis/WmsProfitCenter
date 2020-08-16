<form id="form-upload-freight-cost">
  <div class="file-field input-field">
    <div class="row">
      <div class="col s12 m2 l2">
        <p>Data File</p>
      </div>
      <div class="col s12 m5 l5">
        <div class="btn btn-small waves-effect waves-light">
          <span>Browse</span>
          <input type="file" name="file-freight-cost">
        </div>
        <div class="file-path-wrapper">
          <input class="file-path validate" type="text" placeholder="Select file.."/>
        </div>
      </div>
      <div class="col s12 m5 l5">
        <p>Format File : .csv</p>
      </div>
    </div>
  </div>
  {!! get_button_save('Upload') !!}
</form>

@push('vendor_js')
<script src="{{ asset('materialize/vendors/jquery-validation/jquery.validate.min.js') }}">
</script>
@endpush

@push('script_js')
<script type="text/javascript">
   jQuery(document).ready(function($) {
      //Upload File
      // $('.dropify').dropify();
   });

   $("#form-upload-freight-cost").validate({
      submitHandler: function(form) {
        setLoading(true); // Disable Button when ajax post data
        var fdata = new FormData(form);
        $.ajax({
          url: '{{ url("master-freight-cost/upload") }}',
          type: 'POST',
          data: fdata,
          contentType: "application/json",
          dataType: "json",
          contentType: false,
          processData: false
        })
        .done(function(data) { // selesai dan berhasil
          console.log(data);
          if (data.status == false) {
            setLoading(false); // Enable Button when failed
            swal("Failed!", data.message, "warning");
            return;
          }
          showSwalAutoClose('Success', 'Data Uploaded')
          window.location.href = "{{ url('master-freight-cost') }}"
        })
        .fail(function(xhr) {
          setLoading(false); // Enable Button when failed
          showSwalError(xhr) // Custom function to show error with sweetAlert
        });
      }
    });
</script>
@endpush