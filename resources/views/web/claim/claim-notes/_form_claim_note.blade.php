<form class="form-table" id="form-claim-note">
    <table>
        <tr>
            <td>Claim Note</td>
            <td>
                <input type="text" class="validate" readonly>
            </td>
        </tr>
        <tr>
            <td>Date</td>
            <td>
                <input type="text" class="validate" readonly>
            </td>
        </tr>
        <tr>
            <td>Type</td>
            <td>
                <select name="type" class="select2-data-ajax browser-default" required>
                    <option></option>
                    <option>Carton Box</option>
                    <option>Unit</option>
                </select>
            </td>
        </tr>
    </table>
    {!! get_button_view(url('claim-notes/1'), 'Save') !!}
    {!! get_button_cancel(url('claim-notes'), 'Back') !!}
</form>

@push('script_js')
<script type="text/javascript">
    $('#form-claim-note [name="type"]').select2({
     placeholder: '-- Select Type --',
  });
</script>
@endpush