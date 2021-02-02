@push('page-modal')
<!---- Modal Upload ----->
<div id="modal-change-password" class="modal">
  <form id="form-change-password">
  <div class="modal-content p-0 mt-1 ml-1 mr-1">
    <div class="row">
      <div class="col s12 indigo">
        <div class="modal-action modal-close">
        <span class="white-text right">X</span>
        </div>
      </div>
    </div>
    <h5 class="mr-3 ml-3">Change Password</h5>
  </div>
  <div class="row">
   <div class="input-field col s8 m6 ml-3 mt-2">
         <input type="password" name="old_password" placeholder="Please Type Old Password ..." required>
         <label for="kwitansi_no">Old Password</label>
      </div>
      <div class="input-field col s8 m6 ml-3 mt-2">
         <input type="password" name="new_password" placeholder="Please Type New Password ..." required>
         <label for="kwitansi_no">New Password</label>
      </div>
      <div class="input-field col s8 m6 ml-3 mt-2">
         <input type="password" name="new_password_confirm" placeholder="Please Re-Type New Password ..." required>
         <label for="kwitansi_no">Re-Type New Password</label>
      </div>
  </div>
  <div class="input-field col s12 m12 ml-3 mb-2">
    {!! get_button_save('Submit') !!}
  </div>
  </form>
</div>
@endpush

@push('vendor_js')
<script src="{{ asset('materialize/vendors/jquery-validation/jquery.validate.min.js') }}">
</script>
@endpush

@push('script_js')
<script type="text/javascript">
    jQuery(document).ready(function($) {
      //Upload File
      $('#btn-change-password').click(function(){
         $('#modal-change-password').modal('open');
      })
   });

   $("#form-change-password").validate({
      submitHandler: function(form) {
       setLoading(true)
         $.ajax({
            url: '{{ url("change-password") }}',
            type: 'POST',
            data: $(form).serialize(),
         })
         .done(function(result) { // selesai dan berhasil
            setLoading(false)
            if (!result.status) {
               showSwalAutoClose("Warning", result.message)
               return;
            }
            showSwalAutoClose("Success", result.message)
            $('#modal-change-password').modal('close');
         })
         .fail(function(xhr) {
               setLoading(false); // Enable Button when failed
               showSwalError(xhr) // Custom function to show error with sweetAlert
         });
      }
    });
</script>
@endpush