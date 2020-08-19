@extends('layouts.materialize.index')

@section('content')
<div class="row">

  @component('layouts.materialize.components.title-wrapper')
      <div class="row">
          <div class="col s12 m6">
              <h5 class="breadcrumbs-title mt-0 mb-0"><span>Stock Take Create Tag</span></h5>
              <ol class="breadcrumbs mb-0">
                  <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                  <li class="breadcrumb-item active">Stock Take Create Tag</li>
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
          <div class="col s12 m3"></div>
      </div>
      <div class="row">
        <div class="col s12 m4">
          <!---- Button Add ----->
          <a class="btn btn-large waves-effect waves-light btn-add" href="{{ url('stock-take-create-tag/create') }}">New Tag</a>
        </div>
      </div>
  @endcomponent

  <div class="col s12">
        <div class="container">
            <div class="section">
              <div class="card">
                <div class="card-content">
                  <form id="form-stock-take-create-tag">
                  <div class="row mb-5">
                    <div class="col s12 m2 pt-2">
                        <p>Periode STO</p>
                    </div>
                    <div class="col s12 m4">
                      <!---- Filter STO ID ----->
                      <div class="app-wrapper ml-3">
                        <div class="datatable-search">
                          <select id="sto_id" name="sto_id">
                            {{-- <option>-Select Schedule ID-</option>
                            <option>SBY-STO-200201-001</option>
                            <option>KRW-STO-199801-002</option> --}}
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Upload File -->
                  <div class="row">
                    <div class="col s12 m2 pt-2">
                        <p>Data File</p>
                    </div>
                    <div class="col s12 m10">
                      <div class="file-field input-field col s12 m6 l6">
                        <div class="btn btn-small waves-effect waves-light">
                          <span>Browse</span>
                          <input type="file" name="file-stock-take-tag">
                        </div>
                        <div class="file-path-wrapper">
                          <input class="file-path validate" type="text" placeholder="Select File..">
                        </div>
                      </div>
                      <div class="col s12 m6 l6 mt-4">
                        <p>Format File : .csv*</p>
                      </div>
                  </div>
                  </div>
                  <div class="row">
                    <div class="col s12 m6 mb-2">
                        {!! get_button_save('Submit') !!}
                        {!! get_button_print() !!}
                    </div>
                  </div>
                  </form>

                <!-- <div class="row">
                  <div class="display-flex">
                    Button Create 
                    <div class="col s12 m2">
                    <a class="btn btn-large waves-effect waves-light btn-add" href="{{ url('stock-take-create-tag/create') }}">New Tag</a>
                    </div>
                    <div class="col s12 m4"></div>
                    Search
                    <div class="col s12 m6">
                      <div class="app-wrapper">
                        <div class="datatable-search">
                          <i class="material-icons mr-2 search-icon">search</i>
                          <input type="text" placeholder="Search" class="app-filter" id="global_filter">
                        </div>
                      </div>
                    </div>
                  </div>
                </div> -->

                <!-- Main Table -->
                <div class="container">
                    <div class="section">
                        <div class="card">
                            <div class="card-content p-0">
                                <div class="section-data-tables">
                                  <table id="data-table-section-contents" class="display" width="100%">
                                      <thead>
                                          <tr>
                                            <th data-priority="1" width="30px">No.</th>
                                            <th>No Tag</th>
                                            <th>Model</th>
                                            <th>Location</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                        {{-- <tr>
                                          <td>1.</td>
                                          <td>ES-TT8902-PK</td>
                                          <td>A</td>
                                          <td>-</td>
                                        </tr> --}}
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
        </div>
      </div>
    </div>
  </div>
@endsection

@push('vendor_js')
<script src="{{ asset('materialize/vendors/jquery-validation/jquery.validate.min.js') }}">
</script>
@endpush

@push('script_js')
<script type="text/javascript">
    var dtdatatable;
    jQuery(document).ready(function($) {
      $("#form-stock-take-create-tag").validate({
        submitHandler: function(form) {
          setLoading(true); // Disable Button when ajax post data
          var fdata = new FormData(form);
          $.ajax({
            url: '{{ url("stock-take-create-tag") }}',
            type: 'POST',
            data: fdata,
            contentType: "application/json",
            dataType: "json",
            contentType: false,
            processData: false
          })
          .done(function(data) { // selesai dan berhasil
            console.log(data);
            if (data.status == false) {
              swal("Failed!", data.message, "warning");
              return;
            }
            swal("Good job!", "You clicked the button!", "success")
              .then((result) => {
                // Kalau klik Ok redirect ke index
                {{-- window.location.href = "{{ url('stock-take-create-tag') }}" --}}
              }) // alert success
          })
          .fail(function(xhr) {
              showSwalError(xhr) // Custom function to show error with sweetAlert
          });
        }
      });

      dtdatatable = $('#data-table-section-contents').DataTable({
        serverSide: true,
        scrollX: true,
        responsive: true,
        ajax: {
            url: '{{ url('stock-take-create-tag') }}',
            type: 'GET',
            data: function(d) {
                d.sto_id = $('#sto_id').val()
              }
        },
        order: [1, 'asc'],
        columns: [
            {data: 'DT_RowIndex', orderable:false, searchable: false, className: 'center-align'},
            {data: 'no_tag', name: 'no_tag', className: 'detail'},
            {data: 'model', name: 'model', className: 'detail'},
            {data: 'location', name: 'location', className: 'detail'},
        ]
      });

    });

    $('#sto_id').select2({
       placeholder: '-- Select Schedule ID --',
       allowClear: true,
       ajax: get_select2_ajax_options('/stock-take-schedule/select2-schedule')
    });

    $('#sto_id').change(function(event) {
        /* Act on the event */
        dtdatatable.ajax.reload(null, false)
      });
</script>
@endpush
