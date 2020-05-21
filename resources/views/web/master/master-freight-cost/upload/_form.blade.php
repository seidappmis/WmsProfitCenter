<form id="form-upload-freight-cost">
  <div class="row">
    <div class="input-field col s12">
      <div class="col s12 m4 l3">
        <p>Data File</p>
      </div>
      <div class="col s12 m8 l9">
        <input type="file" required id="input-file-now" class="dropify" name="file" data-default-file="" data-height="100"/>
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
</script>
@endpush