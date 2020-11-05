<form class="form-table" id="form-berita-acara-during">
    <table>
        <tr>
            <td>No. BERITA ACARA DURING</td>
            <td colspan="3">
                <input id="" name="berita_acara_during_no" type="text" class="validate" value="" placeholder="[AUTO]" readonly>
            </td>
        </tr>
        <tr>
            <td>TANGGAL BERITA ACARA</td>
            <td colspan="3">
                <input id="" name="tanggal_berita_acara" type="text" class="validate" value="" placeholder="[AUTO]" readonly>
            </td>
        </tr>
        <tr>
            <td>KAPAL</td>
            <td>
                <input type="text" name="ship_name">
            </td>
            <td>EKSPEDISI</td>
            <td>
                <select id="expedition_code" name="expedition_code" class="select2-data-ajax browser-default">
                </select>
            </td>
        </tr>
        <tr>
            <td>INVOICE NO</td>
            <td>
                <input type="text" name="invoice_no">
            </td>
            <td>TRUCK NO</td>
            <td>
                <select id="vehicle_number" name="vehicle_number" class="select2-data-ajax browser-default">
                </select>
            </td>
        </tr>
        <tr>
            <td>CONTAINER NO</td>
            <td>
                <input type="text" name="container_no">
            </td>
            <td>CUACA</td>
            <td>
                <input type="text" name="weather">
            </td>
        </tr>
        <tr>
            <td>B/L NO</td>
            <td>
                <input type="text" name="bl_no">
            </td>
            <td>JAM KERJA</td>
            <td>
                <input type="text" name="working_hour">
            </td>
        </tr>
        <tr>
            <td>SEAL NO</td>
            <td>
                <input type="text" name="seal_no">
            </td>
            <td>LOKASI</td>
            <td>
                <input type="text" name="location">
            </td>
        </tr>
        <tr>
            <td>JENIS KERUSAKAN</td>
            <td>
                <select id="" name="damage_type" class="select2-data-ajax browser-default">
                    <option value="Rusak EX Bea Cukai">Rusak EX Bea Cukai</option>
                    <option value="Rusak dari dalam container(Import)">Rusak dari dalam container(Import)</option>
                    <option value="Rusak sebelum di bongkar dari truck(Lokal)">Rusak sebelum di bongkar dari truck(Lokal)</option>
                    <option value="Kesalahan bongkar muat digudang oleh Nittsu">Kesalahan bongkar muat digudang oleh Nittsu</option>
                    <option value="Rusak selama penyimpanan di gudang">Rusak selama penyimpanan di gudang</option>
                    <option value="Pengecekan oleh QRCC">Pengecekan oleh QRCC</option>
                    <option value="Rusak karena gudang bocor">Rusak karena gudang bocor</option>
                    <option value="Rusak karena rayap">Rusak karena rayap</option>
                    <option value="Rusak dari produksi">Rusak dari produksi</option>
                    <option value="Different Model">Different Model</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="4" style="text-align: center;">
                <div class="mt-1 mb-1">
                    <strong>
                        ATTACHED FILE
                    </strong>
                </div>
            </td>
        </tr>
        <tr>
            <td>CONTAINER DATANG</td>
            <td>
                <div class="file-field input-field">
                    <div class="btn">
                        <span>Browse</span>
                        <input type="file" name="photo_container_came">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text">
                    </div>
                    <div id="img_file_photo_container_came" style="display: none;" class="text-center">
                        <img class="materialboxed" width="200" height="200" src="">
                        <a download="" href="/path/to/image" title="img_file_photo_container_came" class="btn mt-1">
                            Download
                        </a>
                    </div>
                </div>
            </td>
            <td>LOADING</td>
            <td>
                <div class="file-field input-field">
                    <div class="btn">
                        <span>Browse</span>
                        <input type="file" name="photo_loading">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text">
                    </div>
                    <div id="img_file_photo_loading" style="display: none;" class="text-center">
                        <img class="materialboxed" width="200" height="200" src="">
                        <a download="" href="/path/to/image" title="img_file_photo_loading" class="btn mt-1">
                            Download
                        </a>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td>SEAL NO</td>
            <td>
                <div class="file-field input-field">
                    <div class="btn">
                        <span>Browse</span>
                        <input type="file" name="photo_seal_no">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text">
                    </div>
                    <div id="img_file_photo_seal_no" style="display: none;" class="text-center">
                        <img class="materialboxed" width="200" height="200" src="">
                        <a download="" href="/path/to/image" title="img_file_photo_seal_no" class="btn mt-1">
                            Download
                        </a>
                    </div>
                </div>
            </td>
            <td>CONTAINER SESUDAH LOADING</td>
            <td>
                <div class="file-field input-field">
                    <div class="btn">
                        <span>Browse</span>
                        <input type="file" name="photo_container_loading">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text">
                    </div>
                    <div id="img_file_photo_container_loading" style="display: none;" class="text-center">
                        <img class="materialboxed" width="200" height="200" src="">
                        <a download="" href="/path/to/image" title="img_file_photo_container_loading" class="btn mt-1">
                            Download
                        </a>
                    </div>
                </div>
            </td>
        </tr>

    </table>
    {!! get_button_save() !!}
    <button type="button" class="waves-effect waves-light indigo btn-small btn-save mt-2" style="display: none;" id="btn-update">Update</button>
</form>

@push('script_js')
<script type="text/javascript">
    set_select_expedition()
    set_select_vehicle_number()

    $('#form-berita-acara-during [name="expedition_code"]').change(function(event) {
        /* Act on the event */
        var data = $(this).select2('data')[0]
        set_select_vehicle_number({
            expedition_code: $(this).val()
        })
        $('#form-berita-acara-during [name="expedition_name"]').val(data.text)
    });

    function set_select_expedition() {
        $('#form-berita-acara-during [name="expedition_code"]').select2({
            placeholder: '-- Select Expedition --',
            ajax: get_select2_ajax_options('/master-expedition/select2-active-expedition')
        })
    }

    function set_select_vehicle_number(filter = {
        expedition_code: ''
    }) {
        $('#form-berita-acara-during [name="vehicle_number"]').select2({
            placeholder: '-- Select Vehicle Number --',
            ajax: get_select2_ajax_options('/master-vehicle-expedition/select2-vehicle-number', filter)
        })
    }
</script>
@endpush