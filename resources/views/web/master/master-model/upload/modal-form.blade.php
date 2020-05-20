@push('page-modal')
<!---- Modal Upload ----->
<div id="modal-upload" class="modal">
  <form id="form-menu" onsubmit="return false;" enctype="multipart/form-data">
  <div class="modal-content">
    <h4>Upload Model</h4>
    @include('web.master.master-model.upload._form')
  </div>
  <div class="modal-footer">
    <button type="submit" class="modal-action waves-effect waves-green btn-flat">Upload</button>
    <span class="modal-action modal-close waves-effect waves-green btn-flat">Cancel</span>
  </div>
  </form>
</div>
@endpush

@push('script_js')
<script type="text/javascript">
    //Upload File
    $('.dropify').dropify();
</script>
@endpush