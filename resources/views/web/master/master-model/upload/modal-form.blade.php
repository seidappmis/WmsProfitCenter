@push('page-modal')
<!---- Modal Upload ----->
<div id="modal-upload" class="modal">
  <form id="form-menu" onsubmit="return false;" enctype="multipart/form-data">
  <div class="modal-content">
    <h4>Upload Model</h4>
    @include('web.master.master-model.upload._form')
  </div>
  <div class="modal-footer">
    {!! get_button_save('Upload') !!}
    {!! get_button_cancel_modal() !!}
  </div>
  </form>
</div>
@endpush

@push('script_js')
<script type="text/javascript">
    jQuery(document).ready(function($) {
      //Upload File
      $('.dropify').dropify();
   });

   $("#form-upload-master-model").validate({
      submitHandler: function(form) {
        $.ajax({
          url: '{{ url("master-model/upload") }}',
          type: 'POST',
          data: $(form).serialize(),
        })
        .done(function() { // selesai dan berhasil
          swal("Good job!", "You clicked the button!", "success")
            .then((result) => {
              // Kalau klik Ok redirect ke index
              window.location.href = "{{ url('master-model') }}"
            }) // alert success
        })
        .fail(function(xhr) {
            showSwalError(xhr) // Custom function to show error with sweetAlert
        });
      }
    });
</script>
@endpush