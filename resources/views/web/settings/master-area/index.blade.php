@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Master Area</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Master Area</li>
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
                <a class="btn btn-large waves-effect waves-light btn-add" href="{{ url('master-area/create') }}">New Area</a>
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
                          <table id="data-table-simple" class="display" width="100%">
                              <thead>
                                  <tr>
                                    <th data-priority="1" width="30px">NO.</th>
                                    <th>CODE</th>
                                    <th>AREA</th>
                                    <th width="50px;"></th>
                                  </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <th>1.</th>
                                  <th>-- No Code --</th>
                                  <th>All</th>
                                  <th>
                                    <span class="waves-effect btn-floating btn-small amber darken-4 btn-edit" href="#"><i class="material-icons">edit</i></span>
                                  </th>
                                </tr>
                                <tr>
                                  <th>2.</th>
                                  <th>KRW</th>
                                  <th>KARAWANG</th>
                                  <th>
                                    <span class="waves-effect btn-floating btn-small amber darken-4 btn-edit" href="#"><i class="material-icons">edit</i></span>
                                    <span class="waves-effect btn-floating red darken-4 btn-small btn-delete"><i class="material-icons">delete</i></span>
                                  </th>
                                </tr>
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
  var table = $('#data-table-simple').DataTable({
    "responsive": true,
  });

  table.on('click', '.btn-delete', function(event) {
      event.preventDefault();
      /* Act on the event */
      // Ditanyain dulu usernya mau beneran delete data nya nggak.
      swal({
        title: "Are you sure?",
        text: "You will not be able to recover this imaginary file!",
        icon: 'warning',
        buttons: {
          cancel: true,
          delete: 'Yes, Delete It'
        }
      }).then(function (confirm) { // proses confirm
        if (confirm) {
          $(".btn-delete").closest("tr").remove();
          swal("Good job!", "You clicked the button!", "success") // alert success
          //datatable memunculkan no data available in table
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