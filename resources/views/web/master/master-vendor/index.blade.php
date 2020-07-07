@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Master Vendor</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Master Vendor</li>
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
            <div class="col s12 m3">
            </div>
        </div>
      </div>
      <div class="row">
        <div class="col s12 m4">
                <!---- Button Add ----->
                <a class="btn btn-large waves-effect waves-light btn-add" href="{{ url('master-vendor/create') }}">New Vendor</a>
        </div>
      </div>
    @endcomponent

    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content p-0">
                        <div class="section-data-tables">
                          <table id="data-table-master-vendor" class="display" width="100%">
                              <thead>
                                  <tr>
                                    <th data-priority="1" width="30px">NO.</th>
                                    <th>VENDOR CODE</th>
                                    <th>VENDOR NAME</th>
                                    <th>DESCRIPTION</th>
                                    <th>VENDOR ADDRESS</th>
                                    <th>CONTACT PERSON NAME</th>
                                    <th>CONTACT PERSON PHONE</th>
                                    <th>CONTACT PERSON EMAIL</th>
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
  var table = $('#data-table-master-vendor').DataTable({
    serverSide: true,
    scrollX: true,
    responsive: true,
    ajax: {
        url: '{{ url('master-vendor') }}',
        type: 'GET',
        data: function(d) {
            d.search['value'] = $('#global_filter').val()
          }
    },
    order: [1, 'asc'],
    columns: [
        {data: 'DT_RowIndex', orderable:false, searchable: false, className: 'center-align'},
        {data: 'vendor_code', name: 'vendor_code', className: 'detail'},
        {data: 'vendor_name', name: 'vendor_name', className: 'detail'},
        {data: 'description', name: 'description', className: 'detail'},
        {data: 'vendor_address', name: 'vendor_address', className: 'detail'},
        {data: 'contact_person_name', name: 'contact_person_name', className: 'detail'},
        {data: 'contact_person_phone', name: 'contact_person_phone', className: 'detail'},
        {data: 'contact_person_email', name: 'contact_person_email', className: 'detail'},
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
        text: "Delete the Vendor " + data.vendor_code + "?",
        icon: 'warning',
        buttons: {
          cancel: true,
          delete: 'Yes, Delete It'
        }
      }).then(function (confirm) { // proses confirm
        if (confirm) { // if CONFIRMED send DELETE Request to endpoint
          $.ajax({
            url: '{{ url('master-vendor') }}' + '/' + data.vendor_code ,
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
