@extends('layouts.materialize.index')

@include('web.master.master-model.upload.modal-form')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Master Model</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Master Model</li>
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
          <div class="col s12 m3">
          </div>
        </div>
        <div class="row">
          <div class="col s12 m3">
              <!---- Button Add ----->
                <a class="btn btn-large waves-effect waves-light btn-add" href="{{ url('master-model/create') }}">New Model</a>
          </div>
          <div class="col s12 m4">
            <!---- Upload Button ----->
            <a class="btn btn-large waves-effect waves-light btn-add modal-trigger" href="#modal-upload">Upload Model</a>
          </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content p-0">
                        <div class="section-data-tables"> 
                          <table id="data-table-master-model" class="display" width="100%">
                              <thead>
                                  <tr>
                                    <th data-priority="1" width="30px">NO.</th>
                                    <th>MODEL NAME</th>
                                    <th>MODEL BPROD</th>
                                    <th>EAN CODE</th>
                                    <th>CBM</th>
                                    <th>MATERIAL GROUP</th>
                                    <th>CATEGORY</th>
                                    <th>TYPE</th>
                                    <th>DESCRIPTION</th>
                                    <th>PALET</th>
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
@endsection

@push('script_js')
<script type="text/javascript">
  var table = $('#data-table-master-model').DataTable({
    serverSide: true,
    scrollX: true,
    responsive: true,
    ajax: {
        url: '{{ url('master-model') }}',
        type: 'GET',
        data: function(d) {
            d.search['value'] = $('#global_filter').val()
          }
    },
    order: [1, 'asc'],
    columns: [
        {data: 'DT_RowIndex', orderable:false, searchable: false, className: 'center-align'},
        {data: 'model_name', name: 'model_name', className: 'detail'},
        {data: 'model_from_apbar', name: 'model_from_apbar', className: 'detail'},
        {data: 'ean_code', name: 'ean_code', className: 'detail'},
        {data: 'cbm', name: 'cbm', className: 'detail'},
        {data: 'material_group_description', name: 'wms_model_material_group.description', className: 'detail'},
        {data: 'category', name: 'category', className: 'detail'},
        {data: 'model_type', name: 'model_type', className: 'detail'},
        {data: 'description', name: 'description', className: 'detail'},
        {data: 'max_pallet', name: 'max_pallet', className: 'detail'},
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
        text: "Delete Model Code : " + data.ean_code + "?",
        icon: 'warning',
        buttons: {
          cancel: true,
          delete: 'Yes, Delete It'
        }
      }).then(function (confirm) { // proses confirm
        if (confirm) { // if CONFIRMED send DELETE Request to endpoint
          $.ajax({
            url: '{{ url('master-model') }}' + '/' + data.id ,
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