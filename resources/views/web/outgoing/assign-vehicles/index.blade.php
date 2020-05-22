@extends('layouts.materialize.index')

@section('content')
<div class="row">

  @component('layouts.materialize.components.title-wrapper')
      <div class="row">
          <div class="col s12 m5">
              <h5 class="breadcrumbs-title mt-0 mb-0"><span>Assign Vehicles</span></h5>
              <ol class="breadcrumbs mb-0">
                  <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                  <li class="breadcrumb-item active">Assign Vehicles</li>
              </ol>
          </div>
          <div class="col s12 m3">
            <!---- Search ----->
                <div class="app-wrapper">
                  <div class="datatable-search">
                    <select id="area_filter"  class="select2-data-ajax browser-default app-filter">
                    </select>
                  </div>
                </div>
          </div>
          <div class="col s12 m4">
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
        </div>
  @endcomponent

  <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content p-0">
                        <div class="section-data-tables"> 
                          <table id="data-table-assign-vehicles" class="display" width="100%">
                              <thead>
                                  <tr>
                                    <th data-priority="1" width="30px">No.</th>
                                    <th>VEHICLE NO.</th>
                                    <th>DRIVER ID</th>
                                    <th>VEHICLE TYPE</th>
                                    <th>CBM</th>
                                    <th>DESTINATION</th>
                                    <th>TRANSPORTER</th>
                                    <th>CHECKIN TIME</th>
                                    <th width="50px;"></th>
                                  </tr>
                              </thead>
                              <tbody>
                                {{-- <tr>
                                  <td>1.</td>
                                  <td>B 9166 BYT</td>
                                  <td>MTM-19-001 UYE M</td>
                                  <td>Colt Diesel 4 Wheel capacity 10 - 25 Cbm</td>
                                  <td>25.000</td>
                                  <td>Jakarta</td>
                                  <td>MARC TRI MANUNGGAL, PT.</td>
                                  <td>2020-02-06 11:27:25</td>
                                  <td>
                                    {!! get_button_view(url('#'),'Select DO') !!}
                                    {!! get_button_edit() !!}
                                    {!! get_button_delete('Is Leave') !!}
                                  </td>
                                </tr> --}}
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
@endsection

@push('script_js')
<script type="text/javascript">
    var table = $('#data-table-assign-vehicles').DataTable({
    serverSide: true,
    scrollX: true,
    responsive: true,
    ajax: {
        url: '{{ url('assign-vehicles') }}',
        type: 'GET',
        data: function(d) {
            d.search['value'] = $('#global_filter').val(),
            d.area = $('#area_filter').val()
          }
    },
    order: [1, 'asc'],
    columns: [
        {data: 'DT_RowIndex', orderable:false, searchable: false, className: 'center-align'},
        {data: 'vehicle_number', name: 'vehicle_number', className: 'detail'},
        {data: 'driver_id', name: 'driver_id', className: 'detail'},
        {data: 'vehicle_description', name: 'vehicle_description', className: 'detail'},
        {data: 'cbm_max', name: 'cbm_max', className: 'detail'},
        {data: 'destination_name', name: 'destination_name', className: 'detail'},
        {data: 'expedition_name', name: 'expedition_name', className: 'detail'},
        {data: 'datetime_in', name: 'datetime_in', className: 'detail'},
        {data: 'action', className: 'center-align', searchable: false, orderable: false},
    ]
  });

  table.on('click', '.btn-delete', function(event) {
      event.preventDefault();
      /* Act on the event */
      // Ditanyain dulu usernya mau beneran delete data nya nggak.
      var tr = $(this).parent().parent();
      var data = table.row(tr).data();
      swal({
        text: "Are you sure No. " + data.vehicle_number + " has living?",
        icon: 'warning',
        buttons: {
          cancel: true,
          delete: 'Yes, Delete It'
        }
      }).then(function (confirm) { // proses confirm
        if (confirm) {
            $.ajax({
            url: '{{ url('assign-vehicles') }}' + '/' + data.id ,
            type: 'DELETE',
            dataType: 'json',
          })
          .done(function() {
            swal("Good job!", "Vehicle No. " + data.vehicle_number + " has been deleted.", "success") // alert success
            table.ajax.reload(null, false);  // (null, false) => user paging is not reset on reload
          })
          .fail(function() {
            console.log("error");
          });
        }
      })
    });

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

  // Custom search
  function filterGlobal() {
      table.search($("#global_filter").val(), $("#global_regex").prop("checked"), $("#global_smart").prop("checked")).draw();
  }
</script>
@endpush