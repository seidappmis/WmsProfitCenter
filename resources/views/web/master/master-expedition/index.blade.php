@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Master Expedition</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Master Expedition</li>
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
                <a class="btn btn-large waves-effect waves-light btn-add" href="{{ url('master-expedition/create') }}">New Expedition</a>
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
                          <table id="data-table-expedition" class="display" width="100%">
                              <thead>
                                  <tr>
                                    <th data-priority="1" width="30px">NO.</th>
                                    <th>NAME</th>
                                    <th>ADDRESS</th>
                                    <th width="50px;">CODE</th>
                                    <th width="150px;">SAP VENDOR CODE</th>
                                    <th width="60px;">STATUS</th>
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
  var table = $('#data-table-expedition').DataTable({
  serverSide: true,
  scrollX: true,
  responsive: true,
  ajax: {
      url: '{{ url('master-expedition') }}',
      type: 'GET',
      data: function(d) {
          d.search['value'] = $('#global_filter').val()
        }
  },
  order: [1, 'asc'],
  columns: [
      {data: 'DT_RowIndex', orderable:false, searchable: false, className: 'center-align'},
      {data: 'code', name: 'code', className: 'detail'},
      {data: 'expedition_name', name: 'expedition_name', className: 'detail'},
      {data: 'address', name: 'address', className: 'detail'},
      {data: 'sap_code', name: 'sap_code', className: 'detail'},
      // {data: 'contact_pesrson', name: 'contact_person', className: 'detail'},
      // {data: 'phone1', name: 'phone1', className: 'detail'},
      // {data: 'phone2', name: 'phone2', className: 'detail'},
      // {data: 'fax', name: 'fax', className: 'detail'},
      // {data: 'bank', name: 'bank', className: 'detail'},
      // {data: 'currency', name: 'currency', className: 'detail'},
      {data: 'status_active', name: 'status_active', className: 'detail'},

      {data: 'action', className: 'center-align', searchable: false, orderable: false},
  ]
});

$("input#global_filter").on("keyup click", function () {
  filterGlobal();
});

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
      text: "Delete thema Expedition" + data.expedition_name + "?",
      icon: 'warning',
      buttons: {
        cancel: true,
        delete: 'Yes, Delete It'
      }
    }).then(function (confirm) { // proses confirm
      if (confirm) { // if CONFIRMED send DELETE Request to endpoint
        $.ajax({
          url: '{{ url('master-expedition') }}' + '/' + data.expedition_name ,
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

</script>
@endpush