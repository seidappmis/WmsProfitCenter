@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Master Model Exception</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Master Model Exception</li>
                </ol>
            </div>
            <div class="col s12 m6">
            </div>
            <div class="col s12 m3">
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                  <div class="row">
                    <div class="col s12 m6 l6">
                      <!-- Input Form -->
                      <div class="card-content">
                        <h4 class="card-title">Input Model Exception</h4>
                        <form class="form-table">
                          <table>
                            <tr>
                              <td>Model Exception</td>
                              <td>
                                <div class="input-field col s12">
                                  <input type="text" id="excep" required>
                                </div>
                              </td>
                            </tr>
                          </table>
                          {!! get_button_save() !!}
                          {!! get_button_cancel(url('master-model-exception')) !!}
                        </form>
                      </div> 
                      <!-- End Input -->
                    </div>
                    <div class="col s12 m6 l6">
                      <div class="card-content">
                        <h4 class="card-title">Data Model Exception</h4>
                        <!-- <br> -->
                        <!-- Search -->
                        <div class="app-wrapper mr-2">
                          <div class="datatable-search">
                            <i class="material-icons mr-2 search-icon">search</i>
                            <input type="text" placeholder="Search" class="app-filter" id="global_filter">
                          </div>
                        </div>
                        <br>
                        <!-- Datatables Start -->
                        <div class="section-data-tables"> 
                          <table id="data-table-simple" class="display" width="100%">
                              <thead>
                                  <tr>
                                    <th data-priority="1" width="30px">NO.</th>
                                    <th>MODEL</th>
                                    <th width="50px;"></th>
                                  </tr>
                              </thead>
                              <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>ZADDON</td>
                                    <td>{!! get_button_delete() !!}</td>
                                  </tr>
                              </tbody>
                          </table>
                        </div>
                        <!-- Datatables End -->
                      </div>
                    </div>
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
  var table = $('#data-table-simple').DataTable({
    "responsive": true,
  });

  table.on('click', '.btn-delete', function(event) {
      event.preventDefault();
      /* Act on the event */
      // Ditanyain dulu usernya mau beneran delete data nya nggak.
      swal({
        text: "Delete the Model ZADDON?",
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