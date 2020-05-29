<form class="form-table" id="form-berita-acara">
    <table>
        <tr>
            <td>No. Berita Acara</td>
            <td>
                <input type="text" class="validate" readonly>
            </td>
        </tr>
        <tr>
            <td>Tanggal Terima</td>
            <td>
                <input type="text" class="validate" readonly>
            </td>
        </tr>
        <tr>
            <td>Expedition</td>
            <td>
                <select name="expedition" class="select2-data-ajax browser-default" required>
                    </select>
            </td>
        </tr>
        <tr>
            <td>Driver</td>
            <td>
                <select name="driver" class="select2-data-ajax browser-default" required>
                    </select>
            </td>
        </tr>
        <tr>
            <td>Vehicle Number</td>
            <td>
                <select name="vehicle_number" class="select2-data-ajax browser-default" required>
                    </select>
            </td>
        </tr>
    </table>
    {!! get_button_view(url('berita-acara/1'), 'Save') !!}
    {!! get_button_cancel(url('berita-acara'), 'Back') !!}
</form>

@push('script_js')
<script type="text/javascript">
  $('#form-berita-acara [name="expedition"]').select2({
    placeholder: '-- Select Expedition --'
  })
  $('#form-berita-acara [name="driver"]').select2({
    placeholder: '-- Select Driver --'
  })
  $('#form-berita-acara [name="vehicle_number"]').select2({
    placeholder: '-- Select Vehicle Number --'
  })
</script>
@endpush