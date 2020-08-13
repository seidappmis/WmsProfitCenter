@extends('layouts.materialize.index')

@section('content')
<div class="row">

  @component('layouts.materialize.components.title-wrapper')
      <div class="row">
          <div class="col s12 m3 mb-0">
              <h5 class="breadcrumbs-title mt-0 mb-0"><span>Stock Take Schedule</span></h5>
              <ol class="breadcrumbs mb-0">
                  <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                  <li class="breadcrumb-item active">Stock Take Schedule</li>
              </ol>
          </div>
          <div class="col s12 m3">
            <!---- Filter Area ----->
                <div class="app-wrapper">
                  <div class="datatable-search">
                    <input type="hidden" id="area_name_filter">
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
          <div class="col s12 m3">
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

      <div class="row">
        <div class="col s12 m4">
            <span class="btn btn-large waves-effect waves-light btn-add">New Stock Take Schedule</span>
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
@endsection

@push('script_js')
<script type="text/javascript">
  var dtdatatable;
  jQuery(document).ready(function($) {
    dtdatatable = $('#data-table-stocktake-schedule').DataTable({
      serverSide: true,
      scrollX: true,
      responsive: true,
      ajax: {
        url: '{{ url('stock-take-schedule') }}',
        type: 'GET',
        data: function(d) {
            d.search['value'] = $('#global_filter').val(),
            d.area_name = $('#area_name_filter').val(),
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
              showSwalAutoClose('Success', "STO No. " + data.sto_id + " has been deleted!") // alert success
              dtdatatable.ajax.reload(null, false);  // (null, false) => user paging is not reset on reload
            })
            .fail(function() {
              console.log("error");
            });
          }
        })
      });

      dtdatatable.on('click', '.btn-finish', function(event) {
        event.preventDefault();
        /* Act on the event */
        // Ditanyain dulu usernya mau beneran delete data nya nggak.
        var tr = $(this).parent().parent();
        var data = dtdatatable.row(tr).data();
        swal({
          text: "Finish the STO NO. " + data.sto_id + "?",
          icon: 'warning',
          buttons: {
            cancel: true,
            delete: 'Yes, Finish It'
          }
        }).then(function (confirm) { // proses confirm
          if (confirm) {
              $.ajax({
              url: '{{ url('stock-take-schedule') }}' + '/' + data.sto_id + '/finish',
              type: 'PUT',
              dataType: 'json',
            })
            .done(function() {
              showSwalAutoClose('Success', "STO No. " + data.sto_id + " has been finished!")
              dtdatatable.ajax.reload(null, false);  // (null, false) => user paging is not reset on reload
            })
            .fail(function() {
              console.log("error");
            });
          }
        })
      });


    $('.btn-add').click(function(event) {
      /* Act on the event */
      if ($('#area_filter').val() == null && $('#branch_filter').val() == null) {
        swal("Warning!", "Please select area / branch first !", "warning") // alert success
      } else {
        window.location.href = '{{url('stock-take-schedule/create?')}}' + 'area=' + $('#area_filter').val() + '&branch=' + $('#branch_filter').val()
      }
    });

    $('#area_filter').change(function(event) {
      /* Act on the event */
      if ($(this).val() !== '') {
        $('#area_name_filter').val($(this).select2('data')[0].text)
        set_select2_value('#branch_filter', '', '')
        dtdatatable.ajax.reload(null, false);  // (null, false) => user paging is not reset on reload
      }
    });
    $('#branch_filter').change(function(event) {
      /* Act on the event */
      if ($(this).val() !== '') {
        $('#area_name_filter').val('')
        set_select2_value('#area_filter', '', '')
        dtdatatable.ajax.reload(null, false);  // (null, false) => user paging is not reset on reload
      }
    });
    // setDataFilterToLocalStorage();
    // set_select_data();
  });

  // Search
  $("input#global_filter").on("keyup click", function () {
    filterGlobal();
  });

  // Select Area
  $('#area_filter').select2({
       placeholder: '-- Select Area --',
       allowClear: true,
       ajax: get_select2_ajax_options('/master-area/select2-code-area')
    });

  // Select Branch/Cabang
  $('#branch_filter').select2({
       placeholder: '-- Select Branch --',
       allowClear: true,
       ajax: get_select2_ajax_options('/master-cabang/select2-branch')
    });

  // Custom search
  function filterGlobal() {
      dtdatatable.search($("#global_filter").val(), $("#global_regex").prop("checked"), $("#global_smart").prop("checked")).draw();
  }

  // // Custom Filter
  // function setDataFilterToLocalStorage(){
  //   // Filter Area change event
  //   $('#area_filter').change(function(event) {
  //     /* Act on the event */
  //     // Cek kosong atau tidak
  //     // select filter area bisa berubah kosong oleh filter branch
  //     if ($(this).val() != '') {
  //       // filter value
  //       var stockTakeScheduleFilter = {
  //         type: 'area',
  //         value: $(this).val(),
  //         text: $(this).find('option:selected').text()
  //       }
  //       // store filter to localstorage
  //       localStorage.setItem("stockTakeScheduleFilter", JSON.stringify(stockTakeScheduleFilter));

  //       // change
  //       set_select2_value('#branch_filter', '', '');

  //       dtdatatable.ajax.reload(null, false);  // (null, false) => user paging is not reset on reload
  //     }
  //   });

  //   // filter branch change event
  //   $('#branch_filter').change(function(event) {
  //     /* Act on the event */
  //     // Cek kosong atau tidak
  //     // select filter branch bisa berubah kosong oleh filter area
  //     if ($(this).val() != '') {
  //       // filter value
  //       var stockTakeScheduleFilter = {
  //         type: 'branch',
  //         value: $(this).val(),
  //         text: $(this).find('option:selected').text()
  //       }
  //       // store filter to localstorage
  //       localStorage.setItem("stockTakeScheduleFilter", JSON.stringify(stockTakeScheduleFilter));

  //       // change
  //       set_select2_value('#area_filter', '', '');

  //       dtdatatable.ajax.reload(null, false);  // (null, false) => user paging is not reset on reload
  //     }
  //   });
  // }

  // // data select filter from localstorage
  // function set_select_data() {
  //   var stockTakeScheduleFilter = JSON.parse(localStorage.getItem('stockTakeScheduleFilter'));

  //   if (stockTakeScheduleFilter.type == 'area') {
  //     set_select2_value('#area_filter', stockTakeScheduleFilter.value, stockTakeScheduleFilter.text);
  //   } else if (stockTakeScheduleFilter.type == 'branch'){
  //    set_select2_value('#branch_filter', stockTakeScheduleFilter.value, stockTakeScheduleFilter.text);
  //   }
  // }
</script>
@endpush
