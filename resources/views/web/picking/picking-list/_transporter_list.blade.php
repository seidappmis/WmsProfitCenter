<div class="col s12">
<div class="container">
    <div class="section">
        <div class="card">
            <div class="card-content p-0">
              <div class="row m-0 pt-1">
                <div class="col m3">
                  <h4 class="card-title">Transporter List</h4>
                </div>
                <div class="col m3">
                  <div class="app-wrapper">
                    <div class="datatable-search">
                      <select id="area_filter"  class="select2-data-ajax browser-default app-filter">
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col m6">
                  <div class="app-wrapper ml-2 mr-2">
                          <div class="datatable-search mb-0">
                            <i class="material-icons mr-2 search-icon">search</i>
                            <input type="text" placeholder="Search" class="app-filter" id="transporter_filter">
                          </div>
                        </div>
                      </div>
                </div>
              </div>
                <div class="section-data-tables"> 
                  <table id="data-table-transporter-list" class="display" width="100%">
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
                      </tbody>
                  </table>
                </div>
                <!-- datatable ends -->
            </div>
        </div>
    </div>
</div>
<div class="content-overlay"></div>

@push('script_js')
<script type="text/javascript">
    $('#area_filter').select2({
       placeholder: '-- Select Area --',
       allowClear: true,
       ajax: get_select2_ajax_options('/master-area/select2-area-only')
    });
  @if (auth()->user()->area != 'All')
    set_select2_value('#area_filter', '{{auth()->user()->area}}', '{{auth()->user()->area}}')
    $('#area_filter').attr('disabled','disabled')
  @endif
  var dt_table_transporter = $('#data-table-transporter-list').DataTable({
    serverSide: true,
    scrollX: true,
    responsive: true,
    ajax: {
        url: '{{ url('picking-list/get-transporter-list') }}',
        type: 'GET',
        data: function(d) {
            d.search['value'] = $('#transporter_filter').val(),
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

  dt_table_transporter.on('click', '.btn-delete', function(event) {
      event.preventDefault();
      /* Act on the event */
      // Ditanyain dulu usernya mau beneran delete data nya nggak.
      var tr = $(this).parent().parent();
      var data = dt_table_transporter.row(tr).data();
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
            dt_table_transporter.ajax.reload(null, false);  // (null, false) => user paging is not reset on reload
          })
          .fail(function() {
            console.log("error");
          });
        }
      })
    });

  $('#area_filter').change(function(event) {
    /* Act on the event */
    dt_table_transporter.ajax.reload(null, false);  // (null, false) => user paging is not reset on reload
  });

  $("input#transporter_filter").on("keyup click", function () {
    filterGlobal();
  });

  function filterGlobal() {
      dt_table_transporter.search($("#transporter_filter").val(), $("#global_regex").prop("checked"), $("#global_smart").prop("checked")).draw();
  }
</script>
@endpush