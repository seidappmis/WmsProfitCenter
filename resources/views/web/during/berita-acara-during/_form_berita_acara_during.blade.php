<form class="form-table" id="">
    <table>
        <tr>
            <td>No. BERITA ACARA DURING</td>
            <td colspan="3">
                <input id="" name="" type="text" class="validate" value="" readonly>
            </td>
        </tr>
        <tr>
            <td>TANGGAL BERITA ACARA</td>
            <td colspan="3">
                <input id="" name="" type="text" class="validate" value="" readonly>
            </td>
        </tr>
        <tr>
            <td>KAPAL</td>
            <td>
                <input type="" name="">
            </td>
            <td>EKSPEDISI</td>
            <td>
                <input type="" name="">
            </td>
        </tr>
        <tr>
            <td>INVOICE NO</td>
            <td>
                <input type="" name="">
            </td>
            <td>TRUCK NO</td>
            <td>
                <input type="" name="">
            </td>
        </tr>
        <tr>
            <td>CONTAINER NO</td>
            <td>
                <input type="" name="">
            </td>
            <td>CUACA</td>
            <td>
                <input type="" name="">
            </td>
        </tr>
        <tr>
            <td>B/L NO</td>
            <td>
                <input type="" name="">
            </td>
            <td>JAM KERJA</td>
            <td>
                <input type="" name="">
            </td>
        </tr>
        <tr>
            <td>SEAL NO</td>
            <td>
                <input type="" name="">
            </td>
            <td>LOKASI</td>
            <td>
                <input type="" name="">
            </td>
        </tr>
        <tr>
            <td>JENIS KERUSAKAN</td>
            <td>
                <select id="" name="" class="select2-data-ajax browser-default" >
                </select>
                <input type="hidden" name="">
            </td>
        </tr>
        <tr>
            <td colspan="4" style="text-align: center;"><strong>ATTACHED FILE</strong></td>
        </tr>
        <tr>
            <td rowspan="2">CONTAINER DATANG</td>
            <td>
                <div class="file-field input-field">
                  <div class="btn">
                    <span>Browse</span>
                    <input type="file" name="">
                  </div>
                  <div class="file-path-wrapper">
                    <input class="file-path validate" type="text">
                  </div>
                </div>
            </td>
            <td rowspan="2">LOADING</td>
            <td>
                <div class="file-field input-field">
                  <div class="btn">
                    <span>Browse</span>
                    <input type="file" name="">
                  </div>
                  <div class="file-path-wrapper">
                    <input class="file-path validate" type="text">
                  </div>
                </div>
            </td>
        </tr>
        <tr>
            <td>ini thumbnail foto</td>
            <td>ini thumbnail foto</td>
        </tr>
        <tr>
            <td rowspan="2">SEAL NO</td>
            <td>
                <div class="file-field input-field">
                  <div class="btn">
                    <span>Browse</span>
                    <input type="file" name="">
                  </div>
                  <div class="file-path-wrapper">
                    <input class="file-path validate" type="text">
                  </div>
                </div>
            </td>
            <td rowspan="2">CONTAINER SESUDAH LOADING</td>
            <td>
                <div class="file-field input-field">
                  <div class="btn">
                    <span>Browse</span>
                    <input type="file" name="">
                  </div>
                  <div class="file-path-wrapper">
                    <input class="file-path validate" type="text">
                  </div>
                </div>
            </td>
        </tr>
        <tr>
            <td>ini thumbnail foto</td>
            <td>ini thumbnail foto</td>
        </tr>
        
    </table>
    {!! get_button_save() !!}
    {!! get_button_cancel(url('berita-acara-during'), 'Back') !!}
</form>