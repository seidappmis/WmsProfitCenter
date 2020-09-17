@extends('layouts.materialize.index')

@section('content')
<div class="row">
    @component('layouts.materialize.components.title-wrapper')
    <div class="row">
        <div class="col s12 m3">
            <h5 class="breadcrumbs-title mt-0 mb-0">
                <span>
                    Master User Mobile
                </span>
            </h5>
            <ol class="breadcrumbs mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ url('/') }}">
                        Home
                    </a>
                </li>
                <li class="breadcrumb-item active">
                    Master User Mobile
                </li>
            </ol>
        </div>
        <div class="col s12 m3">
            <!---- Filter ----->
            <div class="app-wrapper mr-2">
                <div class="datatable-search">
                  <select id="cabang_filter"
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
                        <i class="material-icons mr-2 search-icon">
                            search
                        </i>
                        <input class="app-filter" id="global_filter" placeholder="Search" type="text">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col s12 m4">
            <!---- Button Add ----->
            <span class="btn btn-large waves-effect waves-light btn-add" onclick="createUserMobile()">
                New User Mobile
            </span>
        </div>
    </div>
    @endcomponent
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content p-0">
                        <div class="section-data-tables">
                            <table class="display" id="data-table-user-mobile" width="100%">
                                <thead>
                                    <tr>
                                        <th data-priority="1" width="30px">
                                            NO.
                                        </th>
                                        <th width="150px;">
                                            User
                                        </th>
                                        <th width="150px;">
                                            Roles
                                        </th>
                                        <th width="150px;">
                                            Active
                                        </th>
                                        <th width="50px;">
                                        </th>
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
        <div class="content-overlay">
        </div>
    </div>
</div>
@endsection

@push('script_js')
<script type="text/javascript">
    var table = $('#data-table-user-mobile').DataTable({
    serverSide: true,
    scrollX: true,
    responsive: true,
    ajax: {
        url: '{{ url('master-user-mobile') }}',
        type: 'GET',
        data: function(d) {
            d.search['value'] = $('#global_filter').val()
            d.cabang = $('#cabang_filter').val()
          }
    },
    order: [1, 'asc'],
    columns: [
        {data: 'DT_RowIndex', orderable:false, searchable: false, className: 'center-align'},
        {data: 'userid', name: 'userid', className: 'detail'},
        {data: 'roles', name: 'roles', className: 'detail'},
        {data: 'status_active', name: 'status_active', className: 'detail'},
        {data: 'action', className: 'center-align', searchable: false, orderable: false},
    ]
  });

  table.on('click', '.btn-delete', function(event) {
      event.preventDefault();
      /* Act on the event */
      var tr = $(this).parent().parent();
      var data = table.row(tr).data();

      // Ask user confirmation to delete the data.
      swal({
        text: "Delete the Area " + data.userid + "?",
        icon: 'warning',
        buttons: {
          cancel: true,
          delete: 'Yes, Delete It'
        }
      }).then(function (confirm) { // proses confirm
        if (confirm) { // if CONFIRMED send DELETE Request to endpoint
          $.ajax({
            url: '{{ url('master-user-mobile') }}' + '/' + data.userid ,
            type: 'DELETE',
            dataType: 'json',
          })
          .done(function() {
            showSwalAutoClose('Success', 'Data Deleted.')
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

  // Custom search
  function filterGlobal() {
      table.search($("#global_filter").val(), $("#global_regex").prop("checked"), $("#global_smart").prop("checked")).draw();
  }

  $('#cabang_filter').change(function(event) {
      /* Act on the event */
      table.ajax.reload(null, false);  // (null, false) => user paging is not reset on reload
    });

  $('#cabang_filter').select2({
       placeholder: '-- Select Cabang --',
       allowClear: true,
       ajax: get_select2_ajax_options('/master-cabang/select2-cabang-only')
    });

    function createUserMobile() {
        window.location.href = "{{ url('master-user-mobile/create') }}" + '?cabang=' + $('#cabang_filter').val()
    }
</script>
@endpush
