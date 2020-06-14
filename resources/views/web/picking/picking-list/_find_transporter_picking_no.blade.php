<hr>
<h4 class="card-title">Find Picking No</h4>
<table class="form-table">
  <tr>
    <td width="20%">Gate</td>
    <td>
      <div class="input-field col s12">
      <select id="gate"
              name="gate"
              class="select2-data-ajax browser-default" required>
      </select>
      </div> 
    </td>
  </tr>
  <tr>
    <td width="20%">Ship to City</td>
    <td>
      <div class="input-field col s12">
      <select id="ship_to"
              name="ship_to"
              class="select2-data-ajax browser-default" required>
      </select>
      </div> 
    </td>
  </tr>
</table>
{!! get_button_save('Save Selected Item', 'btn-save-selected-item mt-1 mb-1') !!}
<table id="picking-list-table" class="display" width="100%">
    <thead>
        <tr>
          <th data-priority="1" class="datatable-checkbox-cell" width="30px">
            <label>
                <input type="checkbox" class="select-all" />
                <span></span>
            </label>
          </th>
          <th>PICKING DATE</th>
          <th>PICKING NO.</th>
          <th>SHIP TO CITY</th>
          <th width="50px;"></th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>

{!! get_button_cancel(url('picking-list'), 'Back', 'mt-1') !!}

@push('script_js')
<script type="text/javascript">
  $('#gate').select2({
     placeholder: '-- Select Gate --',
     ajax: get_select2_ajax_options('/master-cabang/select2-cabang')
  });
  $('#ship_to').select2({
     placeholder: '-- Select Ship To City --',
     ajax: get_select2_ajax_options('/master-cabang/select2-cabang')
  });
</script>
@endpush