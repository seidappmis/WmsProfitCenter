@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Master Cabang</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Master Cabang</li>
                </ol>
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
                <!---- Button Add ----->
                <a class="btn btn-large waves-effect waves-light btn-add" href="{{ url('master-cabang/create') }}">New Cabang</a>
              </div>
            </div>
            <div class="col s12 m3">
            </div>
        </div>
    @endcomponent

    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content p-0">
                        <div class="section-data-tables">
                          <table id="data-table-master-cabang" class="display" width="100%">
                              <thead>
                                  <tr>
                                    <th data-priority="1" width="30px">NO.</th>
                                    <th width="150px;">Kode Customer</th>
                                    <th width="150px;">Kode Cabang</th>
                                    <th width="150px;">Short Description</th>
                                    <th width="150px;">Long Description</th>
                                    <th>REGION</th>
                                    <th width="50px;">Type</th>
                                    <th width="50px;">HQ</th>
                                    <th width="150px;">WMS START</th>
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
  var table = $('#data-table-master-cabang').DataTable({
    serverSide: true,
    scrollX: true,
    responsive: true,
    ajax: {
        url: '{{ url('master-cabang') }}',
        type: 'GET',
        data: function(d) {
            d.search['value'] = $('#global_filter').val()
          }
    },
    order: [1, 'asc'],
    columns: [
        {data: 'DT_RowIndex', orderable:false, searchable: false, className: 'center-align'},
        {data: 'kode_customer', name: 'kode_customer', className: 'detail'},
        {data: 'kode_cabang', name: 'kode_cabang', className: 'detail'},
        {data: 'short_description', name: 'sdes', className: 'detail'},
        {data: 'long_description', name: 'ldes', className: 'detail'},
        {data: 'region', name: 'region', className: 'detail'},
        {data: 'type', name: 'tycode', className: 'detail'},
        {data: 'hq', name: 'hq', className: 'detail'},
        {data: 'start_wms', name: 'start_wms', className: 'detail'},
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
        text: "Delete the Kode Cabang " + data.kode_cabang + "?",
        icon: 'warning',
        buttons: {
          cancel: true,
          delete: 'Yes, Delete It'
        }
      }).then(function (confirm) { // proses confirm
        if (confirm) {
            $.ajax({
            url: '{{ url('master-cabang') }}' + '/' + data.kode_customer ,
            type: 'DELETE',
            dataType: 'json',
          })
          .done(function() {
            swal("Good job!", "You clicked the button!", "success") // alert success
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
</script>
@endpush
