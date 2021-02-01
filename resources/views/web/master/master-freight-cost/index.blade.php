@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m3">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Master Freight Cost</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Master Freight Cost</li>
                </ol>
            </div>
            <div class="col s12 m3">
              <!---- Filter ----->
              <div class="app-wrapper mr-2">
                <div class="datatable-search">
                  <select id="area_filter"
                          class="select2-data-ajax browser-default app-filter">
                  </select>
                </div>
              </div>
            </div>
            <div class="col s12 m6">
              <div class="display-flex">
                <!---- Search ----->
                <div class="app-wrapper mr-2">
                  <div class="datatable-search">
                    <i class="material-icons mr-2 search-icon">search</i>
                    <input type="text" placeholder="Search" class="app-filter" id="global_filter">
                  </div>
                </div>
              </div>
            </div>
            <div class="col s12 m3">
            </div>
        </div>
        <div class="row">
          <div class="col s12 m4">
                <!---- Button Add ----->
                {!! get_button_create(url('master-freight-cost/create'), 'New Freight Cost') !!}
                {{-- <a class="btn btn-large waves-effect waves-light btn-add" href="{{ url('master-freight-cost/create') }}">New Freight Cost</a> --}}
          </div>
        </div>
    @endcomponent
    <div class="row">
    <div class="col s12">
        <div class="container">
            <div class="section">
              <div class="card-content p-0">
                <!-- Upload Data -->
                <ul class="collapsible">
                  <li>
                    <div class="collapsible-header">UPLOAD DATA</div>
                    <div class="collapsible-body white">
                      @include('web.master.master-freight-cost.upload._form')
                    </div>
                  </li>
                </ul>
                </div>

                <!-- Main Table -->
                <div class="card">
                    <div class="card-content p-0">
                      <div class="section-data-tables"> 
                        <table id="data-table-freight-cost" class="display" width="100%">
                            <thead>
                                <tr>
                                  <th data-priority="1" width="30px">NO.</th>
                                  <th>Origin Area</th>
                                  <th class="center-align">
                                  Transporter
                                  <p><input type="text" class="input-filter-column" id="filter-transporter"></p>
                                  </th>
                                  <th class="center-align"> Destination
                                  <p><input type="text" class="input-filter-column" id="filter-destination"></p>
                                  </th>
                                  <th class="center-align">Truck Type
                                  <p><input type="text" class="input-filter-column" id="filter-truck-type"></p>
                                  </th>
                                  <th>Ritase</th>
                                  <th>CBM <p>(M3)</p></th>
                                  <th>Lead Time <p>(Days)</p></th>
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
        </div>
        <div class="content-overlay"></div>
    </div>
</div>
@endsection

@push('script_js')
<script type="text/javascript">
  var table = $('#data-table-freight-cost').DataTable({
    serverSide: true,
    scrollX: true,
    responsive: true,
    ajax: {
        url: '{{ url('master-freight-cost') }}',
        type: 'GET',
        data: function(d) {
            d.search['value'] = $('#global_filter').val()
            d.columns[2]['search']['value'] = $('#filter-transporter').val()
            d.columns[3]['search']['value'] = $('#filter-destination').val()
            d.columns[4]['search']['value'] = $('#filter-truck-type').val()
            d.area = $('#area_filter').val()
          }
    },
    order: [1, 'asc'],
    columns: [
        {data: 'DT_RowIndex', orderable:false, searchable: false, className: 'center-align'},
        {data: 'area', name: 'area', className: 'detail'},
        {data: 'expedition_name', name: 'tr_expedition.expedition_name', className: 'detail'},
        {data: 'destination_city_name', name: 'log_destination_city.city_name', className: 'detail'},
        {data: 'vehicle_description', name: 'tr_vehicle_type_detail.vehicle_description', className: 'detail'},
        {data: 'ritase', name: 'ritase', className: 'detail'},
        {data: 'cbm', name: 'cbm', className: 'detail'},
        {data: 'leadtime', name: 'leadtime', className: 'detail'},
        {data: 'action', className: 'center-align', searchable: false, orderable: false},
    ]
  });

  // Filter event handler
    $( table.table().container() ).on( 'keyup', 'thead input', function () {
      table.ajax.reload(null, false);  // (null, false) => user paging is not reset on reload
    } );

  $("input#global_filter").on("keyup click", function () {
    filterGlobal();
  });

  $('#area_filter').change(function(event) {
      /* Act on the event */
      table.ajax.reload(null, false);  // (null, false) => user paging is not reset on reload
    });

  $('#area_filter').select2({
       placeholder: '-- Select Area --',
       allowClear: true,
       ajax: get_select2_ajax_options('/master-area/select2-area-only')
    });

  @if (auth()->user()->area != 'All')
    set_select2_value('#area_filter', '{{auth()->user()->area}}', '{{auth()->user()->area}}')
    $('#area_filter').attr('disabled','disabled')
  @endif

  // Custom search
  function filterGlobal() {
      table.search($("#global_filter").val(), $("#global_regex").prop("checked"), $("#global_smart").prop("checked")).draw();
  }

  table.on('click', '.btn-delete', function(event) {
      event.preventDefault();
      /* Act on the event */
      var tr = $(this).parent().parent();
      var data = table.row(tr).data();

      // Ask user confirmation to delete the data.
      swal({
        text: "Delete the Warehouse " + data.area + "?",
        icon: 'warning',
        buttons: {
          cancel: true,
          delete: 'Yes, Delete It'
        }
      }).then(function (confirm) { // proses confirm
        if (confirm) { // if CONFIRMED send DELETE Request to endpoint
          $.ajax({
            url: '{{ url('master-freight-cost') }}' + '/' + data.id ,
            type: 'DELETE',
            dataType: 'json',
          })
          .done(function() {
            showSwalAutoClose('Success', 'Data Deleted')
            table.ajax.reload(null, false);  // (null, false) => user paging is not reset on reload
          })
          .fail(function() {
            console.log("error");
          });
        }
      })
    });
</script>
@endpush