@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Damage Goods Report</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Damage Goods Report</li>
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
              </div>
            </div>
        </div>
        <div class="row">
          <div class="col s12 m4">
            <a href="{{ url('berita-acara/create') }}" class="btn btn-large waves-effect waves-light btn-add">
              New DGR
            </a>
          </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content p-0">
                        <div class="section-data-tables"> 
                          <table id="data-table-berita-acara" class="display" width="100%">
                              <thead>
                                  <tr>
                                    <th data-priority="1" width="30px">NO.</th>
                                    <th>NO DGR</th>
                                    <th>CATEGORY DAMAGE</th>
                                    <th>INVOICE NO</th>
                                    <th>B/L NO</th>
                                    <th>CONTAINER NO</th>
                                    <th>CLAIM NO</th>
                                    <th width="50px;"></th>
                                    <th width="50px;"></th>
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
  var dtdatatable = $('#data-table-berita-acara').DataTable({
    serverSide: true,
    scrollX: true,
    responsive: true,
    ajax: {
        url: '{{ url('berita-acara') }}',
        type: 'GET',
        data: function(d) {
            d.search['value'] = $('#global_filter').val()
          }
    },
    order: [1, 'asc'],
    columns: [
        {data: 'DT_RowIndex', orderable:false, searchable: false, className: 'center-align'},
        {data: 'berita_acara_no'},
        {data: 'date_of_receipt'},
        {data: 'expedition_name'},
        {data: 'driver_name'},
        {data: 'vehicle_number'},
        {data: 'vehicle_number'},
        {data: 'vehicle_number'},
        {data: 'vehicle_number'},
        {data: 'action', className: 'center-align', searchable: false, orderable: false},
    ]
  });

  dtdatatable.on('click', '.btn-print', function(event) {
    var tr = $(this).parent().parent();
    var data = dtdatatable.row(tr).data();
    swal({
      text: "Are you sure want to print Damage Goods Report No. " + data.berita_acara_no + " and the details?",
      icon: 'warning',
      buttons: {
        cancel: true,
        delete: 'Yes, Print It'
      }
    }).then(function (confirm) { // proses confirm
      if (confirm) {
        $.ajax({
          url: '{{ url('berita-acara') }}' + '/' + data.id + '/print',
          type: 'GET',
          dataType: 'json',
        })
        .done(function() {
          swal("Good job!", "Damage Goods Report No. " + data.berita_acara_no + " has been printed.", "success") // alert success
          // table.ajax.reload(null, false);  // (null, false) => user paging is not reset on reload
        })
        .fail(function() {
          console.log("error");
        });
      }
    })
  });

  dtdatatable.on('click', '.btn-delete', function(event) {
      event.preventDefault();
      /* Act on the event */
      // Ditanyain dulu usernya mau beneran delete data nya nggak.
      var tr = $(this).parent().parent();
      var data = dtdatatable.row(tr).data();
      swal({
        text: "Are you sure want to delete " + data.berita_acara_no + " and the details?",
        icon: 'warning',
        buttons: {
          cancel: true,
          delete: 'Yes, Delete It'
        }
      }).then(function (confirm) { // proses confirm
        if (confirm) {
            $.ajax({
            url: '{{ url('berita-acara') }}' + '/' + data.id ,
            type: 'DELETE',
            dataType: 'json',
          })
          .done(function() {
            swal("Good job!", "Damage Goods Report with Damage Goods Report No. " + data.berita_acara_no + " has been deleted.", "success") // alert success
            dtdatatable.ajax.reload(null, false);  // (null, false) => user paging is not reset on reload
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