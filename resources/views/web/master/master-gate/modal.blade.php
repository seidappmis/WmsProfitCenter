@push('page-modal')
<!-- Modal Structure Add-->
<div id="modal-add" class="modal">
  <form id="form-kelas" onsubmit="return false;">
  <div class="modal-content">
    <h4>New Gate</h4>
    @csrf
    <input type="hidden" name="id">
    <div class="row">
      <div class="input-field col s12">
        <input id="number" type="text" class="validate" name="gate_number" required>
        <label for="number">Gate Number</label>
      </div>
      <div class="input-field col s12">
        <input id="description" type="text" class="validate" name="description" required>
        <label for="description">Description</label>
      </div>
      <div class="input-field col m6 s12">
        <select>
            <option value="" disabled selected>-- Select --</option>
            <option value="1">KARAWANG</option>
            <option value="2">SURABAYA HUB</option>
            <option value="3">SWADAYA</option>
        </select>
        <label>Area</label>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="submit" class="modal-action waves-effect waves-green btn-flat">Save</button>
    <span class="modal-action modal-close waves-effect waves-green btn-flat">Cancel</span>
  </div>
  </form> 
</div>

<!-- Modal Structure Edit-->
<div id="modal-edit" class="modal">
  <form id="form-edit" onsubmit="return false;">
  <div class="modal-content">
    <h4>Edit Gate</h4>
    @csrf
    <input type="hidden" name="id">
    <div class="row">
      <div class="input-field col s12">
        <input id="number" type="text" class="validate" name="gate_number" required>
        <label for="number">Gate Number</label>
      </div>
      <div class="input-field col s12">
        <input id="description" type="text" class="validate" name="description" required>
        <label for="description">Description</label>
      </div>
      <div class="input-field col m6 s12">
        <select>
            <option value="" disabled>-- Select --</option>
            <option value="1" selected>KARAWANG</option>
            <option value="2">SURABAYA HUB</option>
            <option value="3">SWADAYA</option>
        </select>
        <label>Area</label>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="submit" class="modal-action waves-effect waves-green btn-flat">Update</button>
    <span class="modal-action modal-close waves-effect waves-green btn-flat">Cancel</span>
  </div>
  </form>
</div>
@endpush