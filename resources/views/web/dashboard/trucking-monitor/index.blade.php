@extends('layouts.materialize.index')

@section('content')
@component('layouts.materialize.components.title-wrapper')
      <div class="row">
          <div class="col s12 m8 mb-1">
              <h5 class="breadcrumbs-title mt-0 mb-0"><span>Trucking Monitor</span></h5>
              <ol class="breadcrumbs mb-0">
                  <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                  <li class="breadcrumb-item active">Trucking Monitor</li>
              </ol>
          </div>
          <div class="col s12 m4">
            <!---- Search ----->
                <div class="app-wrapper">
                  <div class="datatable-search">
                    <select id="area_filter" class="select2-data-ajax browser-default app-filter">
                    </select>
                  </div>
                </div>
          </div>
      </div>
  @endcomponent
<div class="row">
    <div class="col s12">
        <div class="">
            <div class="section">
                <div class="card mb-0">
                    <div class="card-content">
                        <h4 class="header m-0 center-align">Loading Status</h4>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    
    <div class="col s12">
        <div class="">
            <div class="section">
                <div class="card m-0">
                    <div class="card-content">
                        <h4 class="header m-0 center-align">After Loading Status</h4>
                        <hr>
                        <table>
                            <thead>
                                <tr>
                                    <th>STATUS</th>
                                    <th>MANIFEST NO</th>
                                    <th>VEHICLE NO</th>
                                    <th>DESTINATION</th>
                                    <th>TOTAL CBM</th>
                                    <th>EXPEDITION NAME</th>
                                    <th>VEHICLE TYPE</th>
                                    <th>VEHICLE GROUP</th>
                                    <th>CAPACITY</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- <tr>
                                    <td>Waiting D/O</td>
                                    <td>SBY-200207-001</td>
                                    <td>L 9624_VZ</td>
                                    <td>SURABAYA HUB-SURABAYA34</td>
                                    <td>3.650</td>
                                    <td>NITTSU LEMO INDONESIA LOGISTIK, PT.</td>
                                    <td>CD 6 BAN (CDD)</td>
                                    <td>SMALL TRUCK</td>
                                    <td>32.000</td>
                                </tr>
                                <tr>
                                    <td>Waiting D/O</td>
                                    <td>SBY-200207-002</td>
                                    <td>L 9255_J</td>
                                    <td>SURABAYA HUB-SURABAYA34</td>
                                    <td>3.285</td>
                                    <td>NITTSU LEMO INDONESIA LOGISTIK, PT.</td>
                                    <td>PICK UP</td>
                                    <td>SMALL TRUCK</td>
                                    <td>7.000</td>
                                </tr> --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col s12 m6 mt-2">
        <div class="">
            <div class="section">
                <div class="card m-0">
                    <div class="card-content pl-2 pr-2 pt-2 pb-2">
                        <h4 class="header m-0">List of vehicle that already standby (top 15 of last ID Driver Scan)</h4>
                        <h6 class="red-text" style="font-weight: 600;">TOTAL VEHICLE : <span id="text-total-vehicle-standby"></span></h6>
                        <hr>
                        <div style="overflow-x: auto; height: 300px; overflow-y: auto;">
                            <table class="table striped" id="table-vehicle-standby">
                                <thead>
                                    <tr>
                                        <th>VEHICLE NO</th>
                                        <th>TC NUMBER</th>
                                        <th>DRIVER NAME</th>
                                        <th>EXPEDITON NAME</th>
                                        <th>VEHICLE DESC</th>
                                        <th>DESTINATION</th>
                                        <th>CAPACITY</th>
                                        <th>DATE IN</th>
                                        <th>TIME IN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col s12 m6 mt-2">
        <div class="">
            <div class="section">
                <div class="card m-0">
                    <div class="card-content pl-2 pr-2 pt-2 pb-2">
                        <h4 class="header m-0">Delivery Order List (top 15 of last upload)</h4>
                        <h6 class="red-text" style="font-weight: 600;">Total Shipment : <span id="text-total-shipment">0</span></h6>
                        <hr>
                        <div style="overflow-x: auto; height: 300px; overflow-y: auto;">
                            <table class="table striped" id="table-delivery-order">
                                <thead>
                                    <tr>
                                        <th>SHIPMENT NO</th>
                                        <th>DELIVERY NO</th>
                                        <th>TOTAL ITEMS DO</th>
                                        <th>TOTAL CBM</th>
                                        <th>DESTIONATION</th>
                                        <th>EXPEDITION NAME</th>
                                        <th>UPLOAD DATE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script_js')
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('#area_filter').select2({
           placeholder: '-- Select Area --',
           allowClear: true,
           ajax: get_select2_ajax_options('/master-area/select2-area-only')
        });
        @if (auth()->user()->area != 'All')
        set_select2_value('#area_filter', '{{auth()->user()->area}}', '{{auth()->user()->area}}')
        $('#area_filter').attr('disabled','disabled')
      @endif

      loadDeliveryOrderList();
      setInterval( loadDeliveryOrderList, 60000 );
      loadVehicleStandby();
      setInterval( loadVehicleStandby, 60000 );
    });

    function loadDeliveryOrderList(){
        $.ajax({
            url: '{{url("trucking-monitor/delivery-order")}}',
            type: 'GET',
            dataType: 'json',
            data: {area:  $('#area_filter').val()},
        })
        .done(function(result) {
            if (result.status) {
                var row = '';
                $.each(result.data.top15, function(index, val) {
                     /* iterate through array or object */
                    row += '<tr>';
                    row += '<td>' + val.invoice_no + '</td>';
                    row += '<td>' + val.delivery_no + '</td>';
                    row += '<td>' + val.total_do_items + '</td>';
                    row += '<td>' + setDecimal(val.total_cbm) + '</td>';
                    row += '<td>' + val.destination_name + '</td>';
                    row += '<td>' + val.expedition_name + '</td>';
                    row += '<td>' + moment(val.created_at).format('HH:mm:ss') + '</td>';
                    row += '</tr>';
                });

                $('#table-delivery-order tbody').empty();
                $('#table-delivery-order tbody').append(row)

                $('#text-total-shipment').text(result.data.shipment.total_shipment)
            }
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
        
    }

    function loadVehicleStandby(){
        $.ajax({
            url: '{{url("trucking-monitor/vehicle-standby")}}',
            type: 'GET',
            dataType: 'json',
            data: {area: $('#area_filter').val()},
        })
        .done(function(result) {
            if (result.status) {
                var row = '';
                $.each(result.data.top15, function(index, val) {
                     /* iterate through array or object */
                    row += '<tr>';
                    row += '<td>' + val.vehicle_number + '</td>';
                    row += '<td>' + val.driver_id + '</td>';
                    row += '<td>' + val.driver_name + '</td>';
                    row += '<td>' + val.expedition_name + '</td>';
                    row += '<td>' + val.vehicle_description + ' capacity ' + setDecimal(val.cbm_min) + ' - ' + setDecimal(val.cbm_max) + '</td>';
                    row += '<td>' + val.destination_name + '</td>';
                    row += '<td>' + setDecimal(val.cbm_max) + '</td>';
                    row += '<td>' + moment(val.datetime_in).format('YYYY-MM-DD') + '</td>';
                    row += '<td>' + moment(val.datetime_in).format('HH:mm:ss') + '</td>';
                    row += '</tr>';
                });

                $('#table-vehicle-standby tbody').empty();
                $('#table-vehicle-standby tbody').append(row)

                $('#text-total-vehicle-standby').text(result.data.total_vehicle)
            }
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
        
    }
</script>
@endpush