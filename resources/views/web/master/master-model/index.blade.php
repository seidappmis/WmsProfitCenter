@extends('layouts.materialize.index')

@include('web.master.master-model.modal-form')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m12 mb-2">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Master Model</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Master Model</li>
                </ol>
            </div>
        </div>
        <div class="row">
          <div class="col s12 m7">
            <div class="display-flex">
              <!---- Search ----->
              <div class="app-wrapper mr-4">
                <div class="datatable-search">
                  <i class="material-icons mr-2 search-icon">search</i>
                  <input type="text" placeholder="Search" class="app-filter" id="global_filter">
                </div>
              </div>
              <!---- Button Add ----->
                <a class="btn btn-large waves-effect waves-light btn-add" href="{{ url('master-model/create') }}">New Model</a>
            </div>
          </div>
          <div class="col s12 m3 ml-0">
            <!---- Upload Button ----->
            <a class="btn btn-large waves-effect waves-light btn-add white-text modal-trigger" href="#modal-upload">Upload Model</a>
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
                              <tbody><!-- 
                                <td>1</td>
                                <td>14A20D2</td>
                                <td></td>
                                <td>8997401917117</td>
                                <td>0.100</td>
                                <td>MH</td>
                                <td>TV</td>
                                <td>LOCAL</td>
                                <td>TV 14 LOCAL</td>
                                <td>0</td>
                                <td>
                                  {!! get_button_edit(url('master-model/1')) !!}
                                  {!! get_button_delete() !!}
                                </td> -->
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
  var table = $('#data-table-master-model').DataTable({
    serverSide: true,
    scrollX: true,
    responsive: true,
  });

  table.on('click', '.btn-delete', function(event) {
      event.preventDefault();
      /* Act on the event */
      // Ditanyain dulu usernya mau beneran delete data nya nggak.
      swal({
        text: "Delete Model COde : 14A20D2?",
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