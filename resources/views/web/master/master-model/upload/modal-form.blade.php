@push('page-modal')
<!---- Modal Upload ----->
<div id="modal-upload" class="modal">
  <!-- <form onsubmit="return false;" enctype="multipart/form-data"> -->
  <div class="modal-content p-0 mt-1 ml-1 mr-1">
    <div class="row">
      <div class="col s12 indigo">
        <div class="modal-action modal-close">
        <span class="white-text right">X</span>
        </div>
      </div>
    </div>
    @include('web.master.master-model.upload._form')
  </div>
  <div class="input-field col s12 m12 ml-3 mb-2">
    {!! get_button_save('Upload') !!}
  </div>
  <!-- </form> -->
</div>
@endpush

@push('script_js')
<script type="text/javascript">
    jQuery(document).ready(function($) {
      //Upload File
      // $('.dropify').dropify();
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