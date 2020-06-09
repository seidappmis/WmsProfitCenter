@push('page-modal')
<!-- Modal Structure -->
<div id="modal1" class="modal">
<form id="form-upload-do-for-picking">
  <div class="modal-content">
        <h4>Upload DO Picking</h4>
          <div class="row">
            
            <div class="col s12 m2">
              <p>Data File</p>
            </div>  
            
            <div class="col s12 m10">
              <div class="file-field input-field">
                <div class="btn indigo btn">
                  <span>Browse</span>
                  <input name="file-do" type="file">
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
              <p>Format Layout coloumn :</p>
              <p>[Plant],[D/O No.],[D/O Date],[Posting Date],[Item],[S/O No.],[S/O Date],[Customer Code],[Customer Name],[Material],[Delivery Quantity],[SU],[Gross Weight],[Total Weight],[Un.],[Volume],[Total Volume],[VUn]</p>
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