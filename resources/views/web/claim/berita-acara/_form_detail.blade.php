<form class="form-table" id="form-berita-acara-detail">
    <table>
        <tr>
            <td>No. Do</td>
            <td>
                <input type="text" class="validate" >
            </td>
        </tr>
        <tr>
            <td>Model / Item No</td>
            <td>
                <input type="text" class="validate" >
            </td>
        </tr>
        <tr>
            <td>Quantity</td>
            <td>
                <input type="number" class="validate" >
            </td>
        </tr>
        <tr>
            <td>Jenis Kerusakan</td>
            <td>
                <input type="text" class="validate" >
            </td>
        </tr>
        <tr>
            <td>Damaged Unit Photo</td>
            <td>
                <div class="file-field input-field">
                  <div class="btn">
                    <span>Browse</span>
                    <input type="file">
                  </div>
                  <div class="file-path-wrapper">
                    <input class="file-path validate" type="text">
                  </div>
                </div>
            </td>
        </tr>
        <tr>
            <td>Keterangan</td>
            <td>
                <input type="text" class="validate" >
            </td>
        </tr>
    </table>
    {!! get_button_save('Add Detail') !!}
</form>

@push('script_js')
<script type="text/javascript">
</script>
@endpush