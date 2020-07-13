<form class="form-table" id="form-berita-acara-detail">
    <table>
        <tr>
            <td>No. Do</td>
            <td>
                <input type="hidden" name="berita_acara_no" value="{{$beritaAcara->berita_acara_no}}">
                <input type="text" class="validate" name="do_no" >
            </td>
        </tr>
        <tr>
            <td>Model / Item No</td>
            <td>
                <input type="text" class="validate" name="model_name">
            </td>
        </tr>
         <tr>
            <td>No. Seri</td>
            <td>
                <input type="number" class="validate" name="serial_number">
            </td>
        </tr>
        <tr>
            <td>Quantity</td>
            <td>
                <input type="number" class="validate" name="qty">
            </td>
        </tr>
        <tr>
            <td>Jenis Kerusakan</td>
            <td>
                <input type="text" class="validate" name="description">
            </td>
        </tr>
        <tr>
            <td>Damaged Unit Photo</td>
            <td>
                <div class="file-field input-field">
                  <div class="btn">
                    <span>Browse</span>
                    <input type="file" name="photo">
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
                <input type="text" class="validate" name="keterangan">
            </td>
        </tr>
    </table>
    {!! get_button_save('Add Detail') !!}
</form>

@push('script_js')
<script type="text/javascript">
</script>
@endpush