@extends('layouts.materialize.index')

@section('content')
<div class="row">
  @component('layouts.materialize.components.title-wrapper')
  <div class="row">
    <div class="col s12 m10">
      <h5 class="breadcrumbs-title mt-0 mb-0"><span>Detail Claim Note {{$claimNote->claim_note_no}}</span></h5>
      <ol class="breadcrumbs mb-0">
        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ url('claim-notes') }}">Claim Notes</a></li>
        <li class="breadcrumb-item active">Detail Claim Note {{$claimNote->claim_note_no}}</li>
      </ol>
    </div>
  </div>
  @endcomponent
  <div class="col s12">
    <div class="container">
      <div class="section">
        <!-- <div class="card"> -->
        <div class="card-content">
          <ul class="collapsible">
            <li class="active">
              <div class="collapsible-header p-0">
                <div class="row">
                  <div class="col s12 m8">
                    <div class="collapsible-main-header">
                      <i class="material-icons expand">expand_less</i>
                      <span>Berita Acara Detail</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="collapsible-body white p-0">
                <div class="section-data-tables">
                  <div class="pl-2 pr-2 pb-2">
                    <table id="table-claim-notes" class="bordered striped" width="100%">
                      <thead>
                        <tr>
                          <th data-priority="1" width="30px">No.</th>
                          <th>Berita Acara</th>
                          <th>Expediton Name</th>
                          <th>Driver</th>
                          <th>Car No</th>
                          <th>DO NO</th>
                          <th>Model</th>
                          <th>Serial No</th>
                          <th>Damage Description</th>
                          <th>Reason</th>
                          <th>Destination</th>
                          <th>Warehouse</th>
                          <th>Photo</th>
                          <th>Qty</th>
                          <th>Price {{ ($claimNote->claim == 'unit') ? '(condition)' : '' }}</th>
                          @if($claimNote->claim == 'unit')
                          <th>Price</th>
                          @endif
                          <th>Total</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                    <a class="waves-effect waves-light btn btn-small indigo darken-4 mt-2" href="{{ url('claim-notes') }}">Back</a>
                    @if($claimNote->submit_date == null)
                    {!! get_button_view(url('claim-notes/1'), 'Save', 'btn-save mt-2') !!}
                    @endif
                  </div>
                </div>
              </div>
            </li>
          </ul>
        </div>
        <!-- </div> -->
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
@php $claimReason=$claimNote->claim;@endphp
<script type="text/javascript">
  jQuery(document).ready(function() {
    $('.mask-currency').inputmask('currency');
    dtdatatable_claim_note = $('#table-claim-notes').DataTable({
      serverSide: true,
      scrollX: true,
      responsive: false,
      paging: false,
      ajax: {
        url: '{{url("claim-notes/".$claimNote->id."/list-claim-notes")}}',
        type: 'GET',
      },
      columns: [{
          data: 'DT_RowIndex',
          orderable: false,
          searchable: false,
          className: 'center-align'
        }, {
          data: 'berita_acara_no',
          name: 'berita_acara_no',
          className: 'detail'
        }, {
          data: 'expedition_name',
          name: 'expedition_name',
          className: 'detail'
        }, {
          data: 'driver_name',
          name: 'driver_name',
          className: 'detail'
        }, {
          data: 'vehicle_number',
          name: 'vehicle_number',
          className: 'detail'
        }, {
          data: 'do_no',
          name: 'do_no',
          className: 'center-align'
        }, {
          data: 'model_name',
          name: 'model_name',
          className: 'center-align'
        }, {
          data: 'serial_number',
          name: 'serial_number',
          className: 'center-align',
          render: function(data, type, row) {
            return data ? data.split(",").join("<br>") : '';
          }
        }, {
          data: 'description',
          name: 'description',
          className: 'center-align'
        },
        {
          data: 'reason',
          name: 'reason',
          width: '70px',
          render: function(data, type, row, meta) {
            var val = data;
            if (row.submit_date == null) {
              val = '<select id="select-reason-' + row.id + '" style="display: block; width: 150px;     background-color: #ffffff91;" class="reason">';
              val += '<option value="" disabled selected>-- Reason --</option>';
              @if($claimReason == 'unit')
              val += '<option ' + (data == 'Unit of F/G Damaged' ? 'selected' : '') + '>Unit of F/G Damaged</option>';
              val += '<option ' + (data == 'Unit of F/G Scratched' ? 'selected' : '') + '>Unit of F/G Scratched</option>';
              val += '<option ' + (data == 'Unit of F/G Dented' ? 'selected' : '') + '>Unit of F/G Dented</option>';
              val += '<option ' + (data == 'Unit of F/G Broken' ? 'selected' : '') + '>Unit of F/G Broken</option>';
              @else
              val += '<option ' + (data == 'Wet Carton Box' ? 'selected' : '') + '>Wet Carton Box</option>';
              val += '<option ' + (data == 'Damage Carton Box' ? 'selected' : '') + '>Damage Carton Box</option>';
              @endif
              val += '</select>';
            }
            return val;
          }
        },
        {
          data: 'destination',
          name: 'destination',
          className: 'center-align',
          render: function(data, type, row, meta) {
            var val = data;
            if (row.submit_date == null) {
              val = '<textarea id="destination' + row.id + '" class="destination materialize-textarea" placeholder="destination" style="resize: vertical;" data-id="' + row.claim_note_detail + '">' + (data ? data : '') + '</textarea>';
            }
            return val;
          }
        },
        {
          data: 'warehouse',
          name: 'warehouse',
          className: 'center-align',
          render: function(data, type, row, meta) {
            var val = data;
            if (row.submit_date == null) {
              val = '<textarea id="warehouse' + row.id + '" class="warehouse materialize-textarea" placeholder="warehouse" style="resize: vertical;" data-id="' + row.claim_note_detail + '">' + (data ? data : '') + '</textarea>';
            }
            return val;
          }
        },
        {
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
          data: 'qty',
          name: 'qty',
          className: 'center-align',
          render: function(data, type, row, meta) {
            var val = data;
            if (row.submit_date == null) {
              val = '<input placeholder="Qty" data-id="' + row.claim_note_detail + '" type="number" onChange="calculate(this)" class="qty" value="' + data + '">';
            }
            return val;
          }
        },
        {
          data: 'price',
          name: 'price',
          render: function(data, type, row, meta) {
            let price = data;
            if (row.description == 'Carton Box Damage' && !data) {
              price = row.price_carton_box;
            }
            if (row.submit_date == null) {
              val = '<input placeholder="Price" data-id="' + row.claim_note_detail + '" type="text" onChange="calculate(this)" class="price mask-currency" value="' + price + '">';
            } else {
              val = price;
            }
            return format_currency(val);
          },
          className: 'right-align'
        },
        @if($claimReason == 'unit') {
          data: 'claim_note_detail',
          orderable: false,
          searchable: false,
          render: function(data, type, row, meta) {
            let price = row.price;
            if (row.description == 'Carton Box Damage' && !row.price) {
              price = row.price_carton_box;
            }
            return '<tag class="price-10"> ' + format_currency((price * 110 / 100));
          },
          className: "right-align"
        },
        @endif {
          data: 'claim_note_detail',
          orderable: false,
          searchable: false,
          render: function(data, type, row, meta) {

            let price = row.price;
            if (row.description == 'Carton Box Damage' && !row.price) {
              price = row.price_carton_box;
            }

            @if($claimReason == 'unit')
            return '<tag class="sub-total"> ' + format_currency(row.qty * (price * 110 / 100));
            @else
            return '<tag class="sub-total"> ' + format_currency(row.qty * price);
            @endif
          },
          className: "center-align"
        }
      ],
      initComplete: setInitComplete
    });

  });

  var setInitComplete = function() {
    $('.mask-currency').inputmask({
      alias: 'currency',
      autoUnmask: true
    });
  };

  function calculate(ths) {
    var input = $(ths),
      td = input.parent(),
      tr = td.parent(),
      classQty = tr.find('.qty'),
      classPrice = tr.find('.price'),
      classSubTotal = tr.find('.sub-total'),
      qty = classQty.val(),
      price = classPrice.val();

    @if($claimReason == 'unit')
    tr.find('.price-10').html(format_currency(price * 110 / 100))
    classSubTotal.html(format_currency(qty * (price * 110 / 100)));
    @else
    classSubTotal.html(format_currency(qty * price));
    @endif
  };

  $('.btn-save').click(function(e) {
    e.preventDefault();

    var array = $();

    $('#table-claim-notes .qty').each(function() {
      var input = $(this),
        td = input.parent(),
        tr = td.parent(),
        id = input.attr('data-id');

      if (typeof array[id] === 'undefined') {
        array[id] = {
          destination: tr.find('.destination').val(),
          reason: tr.find('.reason').val(),
          location: tr.find('.warehouse').val(),
          qty: tr.find('.qty').val(),
          price: tr.find('.price').val(),
          total_price: tr.find('.qty').val() * tr.find('.price').val()
        }
      }
    })

    setLoading(true);
    $.ajax({
        type: "POST",
        url: "{{ url('claim-notes', $claimNote->id) }}" + '/update',
        data: {
          data: JSON.stringify(array),
        },
        cache: false,
      })
      .done(function(result) {
        if (result.status) {
          swal("Success!", result.message)
            .then((response) => {
              // Kalau klik Ok redirect ke view
              dtdatatable_claim_note.ajax.reload(setInitComplete, false); // (null, false) => user paging is not reset on reload
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