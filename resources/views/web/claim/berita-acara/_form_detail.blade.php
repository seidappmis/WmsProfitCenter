<form class="form-table" id="form-berita-acara-detail">
    <table>
        <tr>
            <td>No. Do</td>
            <td>
                <input type="hidden" name="berita_acara_no" value="{{$beritaAcara->berita_acara_no}}">
                <input type="text" class="validate" name="do_no" value="{{old('do_no', !empty($beritaAcaraDetail) ? $beritaAcaraDetail->do_no : '')}}">
            </td>
        </tr>
        <tr>
            <td>Model / Item No</td>
            <td>
                <!-- <input type="text" class="validate" name="model_name"> -->
                <select id="model_name" name="model_name" class="select2-data-ajax browser-default">
                </select>
            </td>
        </tr>
        <tr>
            <td>No. Seri</td>
            <td>
                <input type="text" class="validate" name="serial_number" value="{{old('serial_number', !empty($beritaAcaraDetail) ? $beritaAcaraDetail->serial_number : '')}}">
            </td>
        </tr>
        <tr>
            <td>Quantity</td>
            <td>
                <input type="number" class="validate" name="qty" value="{{old('qty', !empty($beritaAcaraDetail) ? $beritaAcaraDetail->qty : '')}}">
            </td>
        </tr>
        <tr>
            <td>Jenis Kerusakan</td>
            <td>
                <!-- <input type="text" class="validate" name="description" value="{{old('description', !empty($beritaAcaraDetail) ? $beritaAcaraDetail->description : '')}}"> -->
                <select name="description" class="select2-data-ajax browser-default">
                    <option value=""></option>
                    <option value="Carton Box Damage">Carton Box Damage</option>
                    <option value="Unit Damage">Unit Damage</option>
                    <option value="Unit Damage">Unit Damage</option>
                    <option value="Others">Others</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Damaged Unit Photo</td>
            <td>
                @if(isset($beritaAcaraDetail->photo_url))
                <div id="img_file_photo" style="display: none;" class="text-center">
                    <img class="materialboxed" width="200" height="200" src="">
                </div>
                <input type="hidden" name="old_file" value="{{$beritaAcaraDetail->photo_url}}">
                @endif
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
                <input type="text" class="validate" name="keterangan" value="{{old('keterangan', !empty($beritaAcaraDetail) ? $beritaAcaraDetail->keterangan : '')}}">
            </td>
        </tr>
    </table>
    {!! get_button_save('Add Detail') !!}
    {!! get_button_cancel(url('berita-acara/' . $beritaAcara->id)) !!}
</form>

@push('script_js')
<script type="text/javascript">
    $('#form-berita-acara-detail [name="description"]').select2();
    $('#form-berita-acara-detail [name="model_name"]').select2({
        placeholder: '-- Select Model/Item No. --',
        ajax: get_select2_ajax_options('/master-model/select2-model2')
    });
</script>
@endpush