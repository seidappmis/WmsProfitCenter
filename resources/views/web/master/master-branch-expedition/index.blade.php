@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Master Branch Expedition</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Master Branch Expedition</li>
                </ol>
            </div>
            <div class="col s12 m6">
              <div class="display-flex">
                <!---- Search ----->
                <div class="app-wrapper mr-2">
                  <!-- <div class="datatable-search">
                    <i class="material-icons mr-2 search-icon">search</i>
                    <input type="text" placeholder="Search" class="app-filter" id="global_filter">
                  </div> -->
                </div>
                <!---- Button Modal Add ----->
                <!-- <a class="btn btn-large waves-effect waves-light btn-add modal-trigger" href="#modal-add">New Gate</a> -->
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
                        <!-- <div class="section-data-tables"> 
                          <table id="data-table-simple" class="display" width="100%">
                              <thead>
                                  <tr>
                                    <th data-priority="1" width="30px">NO.</th>
                                    <th>GATE</th>
                                    <th>DESCRIPTION</th>
                                    <th>AREA</th>
                                    <th width="50px;"></th>
                                  </tr>
                              </thead>
                              <tbody></tbody>
                          </table>
                        </div> -->
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
  swal({
    title: 'Sorry, HQ cannot access this page',
    icon: 'warning'
  })
  // var table = $('#data-table-simple').DataTable({
  //   "responsive": true,
  // });

  // $("input#global_filter").on("keyup click", function () {
  //   filterGlobal();
  // });

  // Custom search
  // function filterGlobal() {
  //     table.search($("#global_filter").val(), $("#global_regex").prop("checked"), $("#global_smart").prop("checked")).draw();
  // }
</script>
@endpush