<form class="form-table" id="">
    <table>
        <tr>
            <td>MODEL</td>
            <td>
                <input id="" name="" type="text" class="validate" value="" readonly>
            </td>
            <td rowspan="2">FOTO SERIAL NO</td>
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
            <td>QTY</td>
            <td>
                <input type="" name="">
            </td>
            <td>ini thumbnail foto</td>
        </tr>
        <tr>
            <td>POM</td>
            <td>
                <input type="" name="">
            </td>
            <td rowspan="2">FOTO KERUSAKAN</td>
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
            <td>SERIAL NO</td>
            <td>
                <input type="" name="">
            </td>
            <td>ini thumbnail foto</td>
        </tr>
        <tr>
            <td>KERUSAKAN</td>
            <td colspan="3">
                <input type="" name="">
            </td>
        </tr>
    </table>
    {!! get_button_save() !!}
</form>

<div class="row">
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content p-0">
                        <div class="section-data-tables"> 
                          <table id="data-table-berita-acara" class="display" width="100%">
                              <thead>
                                  <tr>
                                    <th data-priority="1" width="30px">NO.</th>
                                    <th>MODEL</th>
                                    <th>QTY</th>
                                    <th>POM</th>
                                    <th>SERIAL NO</th>
                                    <th>KERUSAKAN</th>
                                    <!-- <th>STATUS</th> -->
                                    <th width="50px;"></th>
                                    <th width="50px;"></th>
                                  </tr>
                              </thead>
                              <tbody>
                              </tbody>
                          </table>
                        </div>
                        <!-- datatable ends -->
                    </div>
                </div>
            </div>
        </div>
        <div class="content-overlay"></div>
    </div>
</div>