@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>View Finish Good Production</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('finish-good-production') }}">Finish Good Production</a></li>
                    <li class="breadcrumb-item active">{{$finishGoodHeader->receipt_no}}</li>
                </ol>
            </div>
            <div class="col s12 m2"></div>
            <div class="col s12 m4">
              <div class="display-flex">
                 <div class="app-wrapper mr-2">
                   <div class="datatable-search">
                    <select id="area_filter"
                          class="select2-data-ajax browser-default app-filter">
                    </select>
                  </div>
                 </div>
                <!---- Button Back ----->
                <a class="btn btn-large waves-effect waves-light indigo" href="{{ url('finish-good-production') }}">Back</a>
              </div>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content">
                      <p>Receipt No &ensp;: <b class="green-text text-darken-3">{{$finishGoodHeader->receipt_no}}</b></p>
                      <p>Ticket No &emsp;&nbsp;: <b class="green-text text-darken-3">{{$finishGoodHeader->ticketNo()}}</b></p>
                      <p>Warehouse &nbsp;: <b class="green-text text-darken-3">{{$finishGoodHeader->warehouse}}</b></p>
                      <p>Factory &emsp;&emsp;: <b class="green-text text-darken-3">{{$finishGoodHeader->supplier}}</b></p>
                      <br>

                      <!-- List Barcode -->
                      <h4 class="card-title">List Barcode Detailed from Factory</h4>
                      <hr>
                      <div class="section-data-tables"> 
                        <table id="data-table-list-barcode" class="display" width="100%">
                            <thead>
                                <tr>
                                  <th data-priority="1" width="30px">No.</th>
                                  <th>RECEIPT NO</th>
                                  <th>DELIVERY TICKET</th>
                                  <th>MODEL</th>
                                  <th>QUANTITY</th>
                                  <th>EAN</th>
                                  <th>TYPE</th>
                                  <th>Storage Location</th>
                                  <th width="50px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                      </div>
                      <!-- datatable ends -->
                    </div>
                    <div class="card-content p-0">

                    </div>
                </div>
            </div>
        </div>
        <div class="content-overlay"></div>
    </div>
</div>
@endsection

@push('script_js')
<script type="text/javascript">
    $('#area_filter').select2({
       placeholder: '-- Select Area --',
       allowClear: true,
       ajax: get_select2_ajax_options('/master-area/select2-area-only')
    });

    set_select2_value('#area_filter', '{{$finishGoodHeader->area}}', '{{$finishGoodHeader->area}}')
    $('#area_filter').attr('disabled', 'disabled');

    var dtdatatable = $('#data-table-list-barcode').DataTable({
        serverSide: true,
        scrollX: true,
        responsive: true,
        ajax: {
          url: '{{ url("finish-good-production/" . $finishGoodHeader->receipt_no) }}',
          type: 'GET',
          data: function(d) {
              d.search['value'] = $('#global_filter').val(),
              d.area = $('#area_filter').val()
            }
      },
      order: [1, 'asc'],
      columns: [
          {data: 'DT_RowIndex', orderable:false, searchable: false, className: 'center-align'},
          {data: 'receipt_no_header', className: 'detail'},
          {data: 'bar_ticket_header', className: 'detail'},
          {data: 'model', className: 'detail'},
          {data: 'quantity', className: 'detail'},
          {data: 'ean_code', className: 'detail'},
          {data: 'print_type', className: 'detail'},
          {data: 'sto_type_desc', className: 'detail'},
          {data: 'action', className: 'center-align', searchable: false, orderable: false},
      ]
    });

</script>
@endpush