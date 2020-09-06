@push('page-modal')
<!-- Modal Structure -->
<div id="modal-edit-do" class="modal">
<form id="form-edit-do">
  <input type="hidden" name="id">
  <div class="modal-content">
    <h4>Edit DO</h4>
    <table class="form-table">
      <tr>
        <td>No. Shipment</td>
        <td><div class="input-field col s12"><input type="text" class="validate" name="invoice_no" readonly=""></div></td>
        <td>DO No.</td>
        <td><div class="input-field col s12"><input type="text" class="validate" name="delivery_no" readonly=""></div></td>
      </tr>
      <tr>
        <td>Destination</td>
        <td colspan="3">
          <div class="input-field col s12">
          <select id="city_code"
                  name="city_code"
                  class="select2-data-ajax browser-default" required>
          </select>
          <input type="hidden" name="city_name">
          </div> 
        </td>
      </tr>
      <tr>
        <td>Internal DO</td>
        <td colspan="3">
          <div class="input-field col s12"><input type="text" class="validate" name="do_internal">
        </td>
      </tr>
      <tr>
        <td>Customer Code</td>
        <td colspan="3">
          <div class="input-field col s12"><input type="text" class="validate" name="sold_to_code">
        </td>
      </tr>
    </table>
  </div>
  <div class="modal-footer">
    <button type="submit" class="waves-effect waves-green btn indigo">Save</button>
    <span class="modal-action modal-close waves-effect waves-green btn-flat">Cancel</span>
  </div>
</form>
</div>
@endpush

@push('script_js')
<script type="text/javascript">
  jQuery(document).ready(function($) {
    $('#table-do').on('click', '.btn-change-do', function(event) {
      event.preventDefault();
      /* Act on the event */
      var tr = $(this).parent().parent();
      var data = dttable_do.row(tr).data();
      var modal = '#modal-edit-do'

      $('#form-edit-do [name="id"]').val(data.id)
      $('#form-edit-do [name="invoice_no"]').val(data.invoice_no)
      $('#form-edit-do [name="delivery_no"]').val(data.delivery_no)
      $('#form-edit-do [name="do_internal"]').val(data.do_internal)
      $('#form-edit-do [name="sold_to_code"]').val(data.sold_to_code)
      set_select2_value('#form-edit-do [name="city_code"]', data.city_code, data.city_name)
      $('#form-edit-do [name="city_name"]').val(data.city_name)

      $(modal).modal('open')
    });

    $('#form-edit-do').validate({
      submitHandler: function (form){
        $.ajax({
          url: '{{ url("update-manifest/update-do") }}',
          type: 'PUT',
          data: $(form).serialize(),
        })
        .done(function(result) { // selesai dan berhasil
          showSwalAutoClose('', result.message);
          dttable_do.ajax.reload(null, false)
          $('#modal-edit-do').modal('close')
        })
        .fail(function(xhr) {
            showSwalError(xhr) // Custom function to show error with sweetAlert
        });
      }
    })

    $('#form-edit-do [name="city_code"]').change(function(event) {
      /* Act on the event */
      var data = $(this).select2('data')[0]
      $('#form-edit-do [name="city_name"]').val(data.text)
    });

  });

  function set_select2_destination(expedition_code){
    $('#form-edit-do [name="city_code"]').select2({
        placeholder: '-- Select Ship to City --',
        allowClear: true,
        ajax: get_select2_ajax_options('/master-expedition/select2-expedition-destination-city', {expedition_code: expedition_code})
      })
  }
</script>
@endpush