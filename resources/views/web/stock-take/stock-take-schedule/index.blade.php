@extends('layouts.materialize.index')

@section('content')
<div class="row">

  @component('layouts.materialize.components.title-wrapper')
      <div class="row">
          <div class="col s12 m12 mb-0">
              <h5 class="breadcrumbs-title mt-0 mb-0"><span>Stock Take Schedule</span></h5>
              <ol class="breadcrumbs mb-0">
                  <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                  <li class="breadcrumb-item active">Stock Take Schedule</li>
              </ol>
          </div>
        </div>

      <div class="row">
          <div class="col s12 m3">
            <!---- Filter Area ----->
                <div class="app-wrapper">
                  <div class="datatable-search">
                    <select id="area_filter"
                          class="select2-data-ajax browser-default app-filter">
                    </select>
                  </div>
                </div>
          </div>
          <div class="col s12 m3">
            <!---- Filter Cabang/Branch ----->
                <div class="app-wrapper">
                  <div class="datatable-search">
                    <select id="branch_filter"
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
                <a class="btn btn-large waves-effect waves-light btn-add" href="{{ url('stock-take-schedule/create') }}">New Stock Take Schedule</a>

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
                          <table id="data-table-stocktake-schedule" class="display" width="100%">
                              <thead>
                                  <tr>
                                    <th data-priority="1" width="30px">No.</th>
                                    <th>STO NO.</th>
                                    <th>DESCRIPTION</th>
                                    <th>SCHEDULE START DATE</th>
                                    <th>SCHEDULE END DATE</th>
                                    <th width="50px;"></th>
                                  </tr>
                              </thead>
                              <tbody><!-- 
                                <tr>
                                  <td>1.</td>
                                  <td>BTM-STO-200202-001</td>
                                  <td>Stock_Tacking_Before_Go_Live</td>
                                  <td>2020-02-02</td>
                                  <td>2020-02-02</td>
                                  <th width="50px;">
                                    {!! get_button_edit(url('stock-take-schedule/1/edit')) !!}
                                    {!! get_button_delete() !!}
                                    {!! get_button_view(url('stock-take-schedule/1'), 'View Detail') !!}
                                    {!! get_button_save('Finish') !!}
                                  </th>
                                </tr> -->
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
  jQuery(document).ready(function($) {
    setDataFilterToLocalStorage();
  });
    var dtdatatable = $('#data-table-stocktake-schedule').DataTable({
      serverSide: true,
      scrollX: true,
      responsive: true,
      ajax: {
        url: '{{ url('stock-take-schedule') }}',
        type: 'GET',
        data: function(d) {
            d.search['value'] = $('#global_filter').val(),
            d.area = $('#area_filter').val(),
            d.branch = $('#branch_filter').val()
          }
      },
      order: [1, 'asc'],
      columns: [
          {data: 'DT_RowIndex', orderable:false, searchable: false, className: 'center-align'},
          {data: 'sto_id', name: 'sto_id', className: 'detail'},
          {data: 'description', name: 'description', className: 'detail'},
          {data: 'schedule_start_date', name: 'schedule_start_date', className: 'detail'},
          {data: 'schedule_end_date', name: 'schedule_end_date', className: 'detail'},
          {data: 'action', className: 'center-align', searchable: false, orderable: false},
      ]
    });

    dtdatatable.on('click', '.btn-delete', function(event) {
      event.preventDefault();
      /* Act on the event */
      // Ditanyain dulu usernya mau beneran delete data nya nggak.
      var tr = $(this).parent().parent();
      var data = dtdatatable.row(tr).data();
      swal({
        text: "Delete the STO NO. " + data.sto_id + "?",
        icon: 'warning',
        buttons: {
          cancel: true,
          delete: 'Yes, Delete It'
        }
      }).then(function (confirm) { // proses confirm
        if (confirm) {
            $.ajax({
            url: '{{ url('stock-take-schedule') }}' + '/' + data.sto_id ,
            type: 'DELETE',
            dataType: 'json',
          })
          .done(function() {
            swal("Good job!", "You clicked the button!", "success") // alert success
            dtdatatable.ajax.reload(null, false);  // (null, false) => user paging is not reset on reload
          })
          .fail(function() {
            console.log("error");
          });
        }
      })
    });

  // Search
  $("input#global_filter").on("keyup click", function () {
    filterGlobal();
  });

  // Select Area
  $('#area_filter').select2({
       placeholder: '-- Select Area --',
       allowClear: true,
       ajax: get_select2_ajax_options('/master-area/select2-area-only')
    });

  // Select Branch/Cabang
  $('#branch_filter').select2({
       placeholder: '-- Select Branch --',
       allowClear: true,
       ajax: get_select2_ajax_options('/master-cabang/select2-branch')
    });

  // Custom search
  function filterGlobal() {
      table.search($("#global_filter").val(), $("#global_regex").prop("checked"), $("#global_smart").prop("checked")).draw();
  }

  // Custom Filter
  function setDataFilterToLocalStorage(){
    // Filter Area change event
    $('#area_filter').change(function(event) {
      /* Act on the event */
      // Cek kosong atau tidak
      // select filter area bisa berubah kosong oleh filter branch
      if ($(this).val() != '') {
        // filter value
        var stockTakeScheduleFilter = {
          type: 'area',
          value: $(this).val()
        }
        // store filter to localstorage
        localStorage.setItem("stockTakeScheduleFilter", JSON.stringify(stockTakeScheduleFilter));

        // change
        set_select2_value('#branch_filter', '', '');

        dtdatatable.ajax.reload(null, false);  // (null, false) => user paging is not reset on reload
      }
    });

    // filter branch change event
    $('#branch_filter').change(function(event) {
      /* Act on the event */
      // Cek kosong atau tidak
      // select filter branch bisa berubah kosong oleh filter area
      if ($(this).val() != '') {
        // filter value
        var stockTakeScheduleFilter = {
          type: 'branch',
          value: $(this).val(),
          text: $(this).find('option:selected').text()
        }
        // store filter to localstorage
        localStorage.setItem("stockTakeScheduleFilter", JSON.stringify(stockTakeScheduleFilter));

        // change
        set_select2_value('#area_filter', '', '');

        dtdatatable.ajax.reload(null, false);  // (null, false) => user paging is not reset on reload
      }
    });
  }
</script>
@endpush
