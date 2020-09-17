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
                        @include('web.master.master-model-exception._form')
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
                          <table id="data-table-model-exception" class="display" width="100%">
                              <thead>
                                  <tr>
                                    <th data-priority="1" width="30px">NO.</th>
                                    <th>MODEL</th>
                                    <th width="50px;"></th>
                                  </tr>
                              </thead>
                              <tbody>
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

@push('vendor_js')
<script src="{{ asset('materialize/vendors/jquery-validation/jquery.validate.min.js') }}">
</script>
@endpush

@push('script_js')
<script type="text/javascript">
  var table = $('#data-table-model-exception').DataTable({
    serverSide: true,
    scrollX: true,
    responsive: true,
    ajax: {
        url: '{{ url('master-model-exception') }}',
        type: 'GET',
        data: function(d) {
            d.search['value'] = $('#global_filter').val()
          }
    },
    order: [1, 'asc'],
    columns: [
        {data: 'DT_RowIndex', orderable:false, searchable: false, className: 'center-align'},
        {data: 'model', name: 'model', className: 'detail'},
        {data: 'action', className: 'center-align', searchable: false, orderable: false},
    ]
  });

  $("#form-model-exception").validate({
      submitHandler: function(form) {
        setLoading(true); // Disable Button when ajax post data
        $.ajax({
          url: '{{ url("master-model-exception") }}',
          type: 'POST',
          data: $(form).serialize(),
        })
        .done(function() { // selesai dan berhasil
          showSwalAutoClose('Success', 'Data Created')
          window.location.href = "{{ url('master-model-exception') }}"
        })
        .fail(function(xhr) {
            setLoading(false); // Enable Button when failed
            showSwalError(xhr) // Custom function to show error with sweetAlert
        });
      }
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
        text: "Delete the Model " + data.model + "?",
        icon: 'warning',
        buttons: {
          cancel: true,
          delete: 'Yes, Delete It'
        }
      }).then(function (confirm) { // proses confirm
        if (confirm) { // if CONFIRMED send DELETE Request to endpoint
          $.ajax({
            url: '{{ url('master-model-exception') }}' + '/' + data.model ,
            type: 'DELETE',
            dataType: 'json',
          })
          .done(function() {
            showSwalAutoClose('Success', 'Data Deleted.')
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