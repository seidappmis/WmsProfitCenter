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
                    <input type="text" placeholder="Search" class="app-filter" id="cancel-movement-filter">
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
                          <table id="cancel-movement-table" class="display" width="100%">
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
    var dttable_cancel_movement
    jQuery(document).ready(function($) {
      
      dttable_cancel_movement = $('#cancel-movement-table').DataTable({
        serverSide: true,
        scrollX: true,
        responsive: true,
        ajax: {
            url: '{{ url('cancel-movement') }}',
            type: 'GET',
            data: function(d) {
                d.search['value'] = $('#cancel-movement-filter').val()
              }
        },
        order: [1, 'asc'],
        columns: [
            {data: 'DT_RowIndex', orderable:false, searchable: false, className: 'center-align'},
            {data: 'status', name: 'status', className: 'detail'},
            {data: 'vehicle_number', name: 'vehicle_number', className: 'detail'},
            {data: 'vehicle_number', name: 'vehicle_number', className: 'detail'},
            {data: 'expedition_name', name: 'expedition_name', className: 'detail'},
            {data: 'do_manifest_no', name: 'do_manifest_no', className: 'detail'},
            {data: 'action', className: 'center-align', searchable: false, orderable: false},
        ]
      });
      $("input#cancel-movement-filter").on("keyup click", function () {
        filterCancelMovement();
      });
    });

  function filterCancelMovement(){
    dttable_cancel_movement.search($("#cancel-movement-filter").val(), $("#global_regex").prop("checked"), $("#global_smart").prop("checked")).draw();
  }
</script>
@endpush