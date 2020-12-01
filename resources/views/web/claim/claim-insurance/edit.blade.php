@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
    <div class="row">
        <div class="col s12 m6">
            <h5 class="breadcrumbs-title mt-0 mb-0"><span>Claim Insurance</span></h5>
            <ol class="breadcrumbs mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ url('claim-insurance') }}">Claim Insurances</a></li>
                <li class="breadcrumb-item active">Claim Insurance</li>
            </ol>
        </div>
    </div>
    @endcomponent

    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card-content">
                    <ul class="collapsible">
                        <li class="active">
                            <div class="collapsible-header">Detail</div>
                            <div class="collapsible-body white p-0">
                                <form id="form-claim-insurance" class="form-table">
                                    <div class="modal-content">
                                        <input type="hidden" name="id" value="{{$claimInsurance->id}}" readonly>
                                        <table>
                                            <tr>
                                                <td width="200px">Claim Report</td>
                                                <td>
                                                    <div class="input-field">
                                                        <input value="{{$claimInsurance->claim_report}}" type="text" name="claim_report">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="200px">Branch</td>
                                                <td>
                                                    <div class="input-field">
                                                        <input value="{{$claimInsurance->branch}}" type="text" name="branch">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="200px">Date of Loss</td>
                                                <td>
                                                    <div class="input-field">
                                                        <input value="{{!empty($claimInsurance->date_of_loss)?date('Y-m-d',strtotime($claimInsurance->date_of_loss)):''}}" type="text" name="date_of_loss" class="datepicker">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="200px">Keterangan Kejadian</td>
                                                <td>
                                                    <div class="input-field">
                                                        <input value="{{$claimInsurance->keterangan_kejadian}}" type="text" name="keterangan_kejadian">
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="content-overlay"></div>
    </div>

    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card-content">
                    <ul class="collapsible">
                        <li class="active">
                            <div class="collapsible-header">Item</div>
                            <div class="collapsible-body white p-0">
                                <div class="section-data-tables">
                                    <div class="pl-2 pr-2 pb-2">
                                        <table id="data-table-section-contents" class="display" width="100%">
                                            <thead>
                                                <tr>
                                                    <th data-priority="1" width="30px">No.</th>
                                                    <th>Serial Number</th>
                                                    <th>Product</th>
                                                    <th>Unit</th>
                                                    <th>Price/Unit</th>
                                                    <th>Total</th>
                                                    <th>Nature of Loss</th>
                                                    <th>Location</th>
                                                    <th>Photo</th>
                                                    <th>Remarks</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                        <a class="waves-effect waves-light btn btn-small indigo darken-4 mt-2" href="{{ url('claim-insurance') }}">Back</a>
                                        {!! get_button_view(url('claim-insurance'), 'Save', 'btn-save mt-2') !!}
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="content-overlay"></div>
    </div>
</div>
@endsection

@push('vendor_js')
<script src="{{ asset('materialize/vendors/jquery-validation/jquery.validate.min.js') }}">
</script>
@endpush

@push('script_js')
<script type="text/javascript">
    jQuery(document).ready(function() {
        dataTable = $('#data-table-section-contents').DataTable({
            serverSide: true,
            scrollX: true,
            responsive: true,
            paging: false,
            ajax: {
                url: '{{url("claim-insurance/".$claimInsurance->id."/list-claim-insurance")}}',
                type: 'GET',
            },
            columns: [{
                data: 'DT_RowIndex',
                orderable: false,
                searchable: false,
                className: 'center-align'
            }, {
                data: 'serial_number',
                name: 'serial_number',
                className: 'center-align',
                render: function(data, type, row) {
                    return data ? data.split(",").join("<br>") : '';
                }
            }, {
                data: 'model_name',
                name: 'model_name',
                className: 'center-align'
            }, {
                data: 'qty',
                name: 'qty',
                className: 'center-align',
                render: function(data, type, row, meta) {
                    return '<input placeholder="Qty" data-id="' + row.claim_insurance_detail + '" type="number" onChange="calculate(this)" class="qty" value="' + data + '">';
                }
            }, {
                data: 'price',
                name: 'price',
                render: function(data, type, row, meta) {

                    let price = data;
                    if (row.description == 'Carton Box Damage' && !data) {
                        price = row.price_carton_box;
                    }
                    return '<input placeholder="Price" data-id="' + row.claim_note_detail + '" type="text" onChange="calculate(this)" class="price mask-currency" value="' + price + '">';
                },
                className: 'center-align'
            }, {
                data: 'claim_insurance_detail',
                orderable: false,
                searchable: false,
                render: function(data, type, row, meta) {

                    let price = row.price;
                    if (row.description == 'Carton Box Damage' && !row.price) {
                        price = row.price_carton_box;
                    }

                    return '<tag class="sub-total"> ' + format_currency(row.qty * price) + '</tag>';
                },
                className: "center-align"
            }, {
                data: 'description',
                name: 'description',
                className: 'center-align'
            }, {
                data: 'location',
                name: 'location',
                className: 'center-align',
                render: function(data, type, row, meta) {
                    return '<textarea  class="location materialize-textarea" placeholder="location" style="resize: vertical;" data-id="' + row.claim_note_detail + '">' + (data ? data : '') + '</textarea>';
                }
            }, {
                data: 'photo_url',
                orderable: false,
                render: function(data, type, row) {
                    if (data) {
                        return '<img class="materialboxed center-align" width="200" height="200" src="' + "{{asset('storage/')}}/" + data + '">';
                    }
                    return '-';
                },
                className: "center-align"
            }, {
                data: 'keterangan',
                name: 'keterangan',
                className: 'detail'
            }],
            initComplete: setInitComplete
        });

    });

    var setInitComplete = function() {
        $('.mask-currency').inputmask('currency');
    };

    function calculate(ths) {
        var input = $(ths),
            td = input.parent(),
            tr = td.parent(),
            classQty = tr.find('.qty'),
            classPrice = tr.find('.price'),
            classSubTotal = tr.find('.sub-total');

        classSubTotal.html(format_currency(classQty.val() * classPrice.val()));
    };

    $('.btn-save').click(function(e) {
        e.preventDefault();

        var array = $();

        $('#data-table-section-contents .qty').each(function() {
            var input = $(this),
                td = input.parent(),
                tr = td.parent(),
                id = input.attr('data-id');

            if (typeof array[id] === 'undefined') {
                array[id] = {
                    location: tr.find('.location').val(),
                    qty: tr.find('.qty').val(),
                    price: tr.find('.price').val(),
                    total_price: tr.find('.qty').val() * tr.find('.price').val()
                }
            }
        })

        setLoading(true);
        $.ajax({
                type: "POST",
                url: "{{ url('claim-insurance', $claimInsurance->id) }}" + '/update',
                data: $('#form-claim-insurance').serialize() + '&data=' + JSON.stringify(array),
                cache: false,
            })
            .done(function(result) {
                if (result.status) {
                    swal("Success!", result.message)
                        .then((response) => {
                            // Kalau klik Ok redirect ke view
                            dataTable.ajax.reload(setInitComplete, false); // (null, false) => user paging is not reset on reload
                        }) // alert success
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
    });
    // convert to format currency
    function format_currency(nStr) {
        if (nStr === null) return '0,00';
        nStr += '';
        x = nStr.split(',');
        x1 = x[0];
        x2 = x.length > 1 ? ',' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return 'Rp. ' + x1 + x2;
    }

    $('.collapsible').collapsible({
        accordion: true
    });
</script>
@endpush