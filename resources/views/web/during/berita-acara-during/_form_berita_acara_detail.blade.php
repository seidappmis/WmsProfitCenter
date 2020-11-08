<form class="form-table" id="form-berita-acara-during-detail">
    <input type="hidden" name="berita_acara_id" readonly>
    <table>
        <tr>
            <td>MODEL</td>
            <td>
                <select id="model_name" name="model_name" class="select2-data-ajax browser-default">
                </select>
            </td>
            <td rowspan="2">FOTO SERIAL NO</td>
            <td>
                <div class="file-field input-field">
                    <div class="btn">
                        <span>Browse</span>
                        <input type="file" name="photo_serial_number">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text">
                    </div>
                    <div id="img_file_photo_serial_number" style="display: none;" class="text-center">
                        <img class="materialboxed" width="200" height="200" src="">
                        <a download="" href="/path/to/image" title="img_file_photo_serial_number" class="btn mt-1">
                            Download
                        </a>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td>QTY</td>
            <td>
                <input type="number" name="qty">
            </td>
        </tr>
        <tr>
            <td>POM</td>
            <td>
                <input type="text" name="pom">
            </td>
            <td rowspan="2">FOTO KERUSAKAN</td>
            <td>
                <div class="file-field input-field">
                    <div class="btn">
                        <span>Browse</span>
                        <input type="file" name="photo_damage">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text">
                    </div>
                    <div id="img_file_photo_damage" style="display: none;" class="text-center">
                        <img class="materialboxed" width="200" height="200" src="">
                        <a download="" href="/path/to/image" title="img_file_photo_damage" class="btn mt-1">
                            Download
                        </a>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td>SERIAL NO</td>
            <td>
                <input type="text" name="serial_number">
            </td>
        </tr>
        <tr>
            <td>KERUSAKAN</td>
            <td colspan="3">
                <textarea class="materialize-textarea" name="damage" placeholder="damage" style="resize: vertical;"></textarea>
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
                            <table id="table-detail" class="display" width="100%">
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

@push('script_js')
<script type="text/javascript">
    jQuery(document).ready(function($) {});
    var dtTableDetail = $('#table-detail').DataTable({
        serverSide: true,
        scrollX: true,
        responsive: true,
        ajax: {
            url: "{{ url('berita-acara') }}",
            type: 'GET',
            data: function(d) {
                d.search['value'] = $('#global_filter').val()
            }
        },
        order: [1, 'asc'],
        columns: [{
                data: 'DT_RowIndex',
                orderable: false,
                searchable: false,
                className: 'center-align'
            },
            {
                data: 'berita_acara_no',
                name: 'berita_acara_no',
                className: 'detail'
            },
            {
                data: 'berita_acara_no',
                name: 'berita_acara_no',
                className: 'detail'
            },
            {
                data: 'date_of_receipt',
                name: 'date_of_receipt',
                className: 'detail'
            },
            {
                data: 'expedition_name',
                name: 'expedition_name',
                className: 'detail'
            },
            {
                data: 'driver_name',
                name: 'driver_name',
                className: 'detail'
            },
            {
                data: 'vehicle_number',
                name: 'vehicle_number',
                className: 'detail'
            },
            {
                data: 'action',
                className: 'center-align',
                searchable: false,
                orderable: false
            },
        ]
    });

    $('#form-berita-acara-during-detail [name="model_name"]').select2({
        placeholder: '-- Select Model/Item No. --',
        ajax: get_select2_ajax_options('/master-model/select2-model2')
    });

    $("#form-berita-acara-during-detail").validate({
        submitHandler: function(form) {
            console.log("dad");
            var formBiasa = $(form).serialize(); // form biasa
            var isiForm = new FormData($(form)[0]); // form data untuk browse file

            /* Act on the event */
            setLoading(true);
            $.ajax({
                    url: ('{{ url("/berita-acara-during/:id/create") }}').replace(':id', $('#form-berita-acara-during-detail [name="berita_acara_id"]').val()),
                    type: 'POST',
                    data: isiForm,
                    contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
                    processData: false, // NEEDED, DON'T OMIT THIS
                })
                .done(function(result) {
                    if (result.status) {
                        showSwalAutoClose('Success', result.message);
                        set_form_data(result.data.during);
                    } else {
                        setLoading(false);
                        showSwalAutoClose('Warning', result.message)
                    }
                })
                .fail(function() {
                    setLoading(false);
                })
                .always(function() {
                    setLoading(false);
                });
        }
    });
</script>
@endpush