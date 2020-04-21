@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Cancel Movement</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Cancel Movement</li>
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
                                    <th width="100px;">ARRIVAL NO. / RECEIPT NO.</th>
                                    <th width="50px;">DO MANIFEST NO.</th>
                                    <th width="50px;">PICKING NO</th>
                                    <th width="50px;">STORAGE LOCATION FROM</th>
                                    <th width="50px;">STORAGE LOCATION TO</th>
                                    <th width="50px;"></th>
                                  </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <th>1.</th>
                                  <th>OTHERS-WHJKT-181004-001</th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th>1001</th>
                                  <th>
                                    <span class="waves-effect red darken-4 btn-small btn-delete">Cancel Movement</span>
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

    $("input#global_filter").on("keyup click", function () {
        filterGlobal();
      });

      // Custom search
      function filterGlobal() {
          table.search($("#global_filter").val(), $("#global_regex").prop("checked"), $("#global_smart").prop("checked")).draw();
      }
</script>
@endpush