@push('page-modal')
<!-- Modal Structure -->
<div id="modal-upload-bulk" class="modal">
   <form id="form-upload-bulk">
      <div class="modal-content">
         <h4>Upload Bulk</h4>
         <div class="row">

            <div class="col s12 m2">
               <p>Data File</p>
            </div>

            <div class="col s12 m10">
               <div class="file-field input-field">
                  <div class="btn indigo btn">
                     <span>Browse</span>
                     <input name="file-bulk" type="file">
                  </div>
                  <div class="file-path-wrapper">
                     <input class="file-path validate" type="text" placeholder="Select File   Format File : excel" required>
                  </div>
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