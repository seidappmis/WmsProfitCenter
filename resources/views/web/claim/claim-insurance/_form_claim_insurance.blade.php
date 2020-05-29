<form class="form-table" id="form-claim-insurance">
    <table>
        <tr>
            <td>Claim Report</td>
            <td>
                <input type="text" class="validate">
            </td>
        </tr>
        <tr>
            <td>Berita Acara</td>
            <td>
                <select name="berita_acara" class="select2-data-ajax browser-default" required>
                    </select>
            </td>
        </tr>
        <tr>
            <td>Branch</td>
            <td>
                <select name="Branch" class="select2-data-ajax browser-default" required>
                    <option></option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Keterangan</td>
            <td>
                <input type="text" class="validate">
            </td>
        </tr>
        <tr>
            <td>Date of Report</td>
            <td>
                <input type="text" class="validate">
            </td>
        </tr>
    </table>
    {!! get_button_view(url('claim-insurance/1'), 'Save') !!}
    {!! get_button_cancel(url('claim-insurance'), 'Back') !!}
</form>

@push('script_js')
<script type="text/javascript">
    $('#form-claim-insurance [name="Branch"]').select2({
     placeholder: '-- Select Branch --',
  });
    $('#form-claim-insurance [name="berita_acara"]').select2({
     placeholder: '-- Select Berita Acara --',
  });
</script>
@endpush