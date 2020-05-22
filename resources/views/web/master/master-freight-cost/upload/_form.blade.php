<form id="form-upload-freight-cost">
  <div class="row">
    <div class="input-field col s12">
      <div class="col s12 m4 l3">
        <p>Data File</p>
      </div>
      <div class="col s12 m8 l9">
        <input type="file" required id="input-file-now" class="dropify" name="file-freight-cost" data-default-file="" data-height="100"/>
        <p>Format File : .csv</p>
      </div>
    </div>
  </div>
  {!! get_button_save('Upload') !!}
</form>

@push('script_js')
<script type="text/javascript">
   jQuery(document).ready(function($) {
      //Upload File
      $('.dropify').dropify();
   });

   $("#form-upload-freight-cost").validate({
      submitHandler: function(form) {
        $.ajax({
          url: '{{ url("master-freight-cost/upload") }}',
          type: 'POST',
          data: $(form).serialize(),
        })
        .done(function() { // selesai dan berhasil
          swal("Good job!", "You clicked the button!", "success")
            .then((result) => {
              // Kalau klik Ok redirect ke index
              window.location.href = "{{ url('master-freight-cost') }}"
            }) // alert success
        })
        .fail(function(xhr) {
            showSwalError(xhr) // Custom function to show error with sweetAlert
        });
      }
    });
</script>
@endpush