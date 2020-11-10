<form class="form-table" id="form-berita-acara-during-detail">
    <input type="hidden" name="berita_acara_id" value="0" readonly>
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
                                        <th>FOTO SERIAL NUMBER</th>
                                        <th>FOTO KERUSAKAN</th>
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

@push('page-modal')
<div id="modal-update" class="modal modal-fixed-footer" style="">
    <form id="form-update" class="form-table">
        <div class="modal-content">
            <input type="hidden" name="id" readonly>
            <table>
                <tr>
                    <td>MODEL</td>
                    <td>
                        <select name="model_name" class="select2-data-ajax browser-default">
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
                            <div id="file_photo_serial_number" style="display: none;" class="text-center">
                                <img class="materialboxed" width="200" height="200" src="">
                                <a download="" href="/path/to/image" title="file_photo_serial_number" class="btn mt-1">
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
                            <div id="file_photo_damage" style="display: none;" class="text-center">
                                <img class="materialboxed" width="200" height="200" src="">
                                <a download="" href="/path/to/image" title="file_photo_damage" class="btn mt-1">
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
        </div>
        <div class="modal-footer">
            <button type="submit" class="waves-effect waves-light indigo btn-small btn-save">Save</button>
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Close</a>
        </div>
    </form>
</div>
@endpush
@push('script_js')
<script type="text/javascript">
    jQuery(document).ready(function($) {});
    var dtTableDetail = $('#table-detail').DataTable({
        serverSide: true,
        scrollX: true,
        responsive: true,
        ajax: {
            url: '{{ url("/berita-acara-during/detail-list") }}',
            type: 'GET',
            data: function(d) {
                d.search['value'] = $('#global_filter').val();
                d.beritaAcaraID = $('#form-berita-acara-during-detail [name="berita_acara_id"]').val();
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
                data: 'model_name',
                name: 'model_name',
                className: 'detail'
            },
            {
                data: 'qty',
                name: 'qty',
                className: 'detail'
            },
            {
                data: 'pom',
                name: 'pom',
                className: 'detail'
            },
            {
                data: 'serial_number',
                name: 'serial_number',
                className: 'detail'
            },
            {
                data: 'damage',
                name: 'damage',
                className: 'detail'
            },
            {
                data: 'photo_serial_number',
                name: 'photo_serial_number',
                render: function(data, type, row) {
                    if (data) {
                        return '<img class="materialboxed center-align" width="200" height="200" src="' + "{{asset('storage/')}}/" + data + '">';
                    }
                    return '-';
                },
                className: 'detail'
            },
            {
                data: 'photo_damage',
                name: 'photo_damage',
                render: function(data, type, row) {
                    if (data) {
                        return '<img class="materialboxed center-align" width="200" height="200" src="' + "{{asset('storage/')}}/" + data + '">';
                    }
                    return '-';
                },
                className: 'detail'
            },
            {
                data: 'id',
                orderable: false,
                searchable: false,
                render: function(data, type, row, meta) {
                    return ' ' + '<?= get_button_edit() ?>' + ' ' + '<?= get_button_delete() ?>';
                },
                className: "center-align"
            }
        ]
    });

    $('#table-detail tbody').on('click', '.btn-edit', function() {
        var tr = $(this).closest('tr');
        var d = dtTableDetail.row(tr).data();

        $('#form-update [name="id"]').val(d.id);
        $('#form-update [name="qty"]').val(d.qty);
        $('#form-update [name="pom"]').val(d.pom);
        $('#form-update [name="damage"]').val(d.damage);

        set_select2_value('#form-update [name="model_name"]', d.model_name, d.model_name);
        $('#form-update [name="model_name"]').select2({
            placeholder: '-- Select Model/Item No. --',
            ajax: get_select2_ajax_options('/master-model/select2-model2')
        });

        $('#form-update #file_photo_serial_number').show();
        $('#form-update #file_photo_serial_number img').attr("src", "{{asset('storage')}}" + '/' + d.photo_serial_number);
        $('#form-update #file_photo_serial_number a').attr("href", "{{asset('storage')}}" + '/' + d.photo_serial_number);

        $('#form-update #file_photo_damage').show();
        $('#form-update #file_photo_damage img').attr("src", "{{asset('storage')}}" + '/' + d.photo_damage);
        $('#form-update #file_photo_damage a').attr("href", "{{asset('storage')}}" + '/' + d.photo_damage);

        $('#modal-update').modal('open');
    })

    $('#form-berita-acara-during-detail [name="model_name"]').select2({
        placeholder: '-- Select Model/Item No. --',
        ajax: get_select2_ajax_options('/master-model/select2-model2')
    });

    $("#form-berita-acara-during-detail").validate({
        submitHandler: function(form) {
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
                        dtTableDetail.ajax.reload(null, false); // (null, false) => user paging is not reset on reload
                    } else {
                        showSwalAutoClose('Warning', result.message)
                    }
                    setLoading(false);
                })
                .fail(function() {
                    setLoading(false);
                })
                .always(function() {
                    setLoading(false);
                });
        }
    });

    // update
    $("#form-update").validate({
        submitHandler: function(form) {
            var formBiasa = $(form).serialize(); // form biasa
            var isiForm = new FormData($(form)[0]); // form data untuk browse file

            /* Act on the event */
            setLoading(true);
            $.ajax({
                    url: '{{ url("/berita-acara-during-detail/update") }}',
                    type: 'POST',
                    data: isiForm,
                    contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
                    processData: false, // NEEDED, DON'T OMIT THIS
                })
                .done(function(result) {
                    if (result.status) {
                        showSwalAutoClose('Success', result.message);
                        $('#modal-update').modal('close');
                        dtTableDetail.ajax.reload(null, false); // (null, false) => user paging is not reset on reload
                    } else {
                        showSwalAutoClose('Warning', result.message)
                    }
                    setLoading(false);
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