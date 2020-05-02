@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m8 l8">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Picking List</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Picking List</li>
                </ol>
            </div>
            <div class="col s12 m4 l4">
                <!---- Search ----->
                <div class="app-wrapper">
                  <div class="datatable-search">
                    <i class="material-icons mr-2 search-icon">search</i>
                    <input type="text" placeholder="Search" class="app-filter" id="global_filter">
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
                        <div class="row">
                            <div class="col s12 m6 mt-2">
                              <div class="display-flex">
                                <!---- Search ----->
                                {!! get_button_view(url('picking-list/create'),'New Picking List') !!}
                              </div>
                            </div>
                        </div>

                        <div class="section-data-tables">
                          <table id="multi-select" class="display" width="100%">
                              <thead>
                                  <tr>
                                    <th data-priority="1">PICKING DATE</th>
                                    <th>PICKING NO.</th>
                                    <th>DRIVER NAME</th>
                                    <th>SHIP TO CITY</th>
                                    <th>EXPEDITION NAME</th>
                                    <th>STORAGE</th>
                                    <th>DO STATUS</th>
                                    <th>LMB</th>
                                    <th width="150px;"></th>
                                  </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td>2020-04-27</td>
                                  <td>162002121244</td>
                                  <td>AD 2323 JP</td>
                                  <td>WONOGIRI</td>
                                  <td>PUTRA NAGITA PRATAMA</td>
                                  <td>[1601]YGY 1st Class</td>
                                  <td>DO Already</td>
                                  <td>-</td>
                                  <td width="150px;">
                                    {!! get_button_edit(url('picking-list/create')) !!}
                                    {!! get_button_view('Cancel') !!}
                                  </td>
                                </tr>
                              </tbody>
                          </table>
                        </div>
                        <!-- datatable ends -->
                    </div>
                </div>
            </div>
            <!---- Button Add ----->
            <div style="bottom: 50px; right: 19px;" class="fixed-action-btn direction-top"><a href="#" class="btn-floating indigo darken-2 gradient-shadow modal-trigger"><i class="material-icons">add</i></a>
            </div>
        </div>
        <div class="content-overlay"></div>
    </div>
</div>
@endsection

@push('page-modal')
<!-- Modal Structure -->
<div id="modal1" class="modal">
  <div class="modal-content">
    <h4>Upload DO Picking</h4>
      <div class="row">

        <div class="col s12 m2">
          <p>Data File</p>
        </div>

        <div class="col s12 m10">
          <div class="file-field input-field">
            <div class="btn indigo btn">
              <span>Browse</span>
              <input type="file">
            </div>
            <div class="file-path-wrapper">
              <input class="file-path validate" type="text" placeholder="Select File   Format File : csv">
            </div>
          </div>
        </div>

        <div class="row">
        <div class="col s12 m2">
          <p></p>
        </div>
        <div class="col s12 m10">
          <p>Format Layout coloumn :</p>
          <p>[Plant],[D/O,Date],[Posting Date]</p>
          <p>[Material]</p>
        </div>
      </div>
  </div>
  <div class="modal-footer">
    <a href="#!" class="modal-close waves-effect waves-green btn indigo">Upload</a>
  </div>
</div>
</div>
@endpush

@push('script_js')
<script type="text/javascript">
    var dtdatatable = $('#multi-select').DataTable({
        serverSide: false,
        scrollX: true,
        responsive: true,
        // ajax: {
        //     url: '/',
        //     type: 'GET',
        //     data: function(d) {
        //         d.search['value'] = $('#global_filter').val()
        //       }
        // },
        order: [1, 'asc'],
        // columns: [
        //     {data: 'DT_RowIndex', orderable:false, searchable: false, className: 'center-align'},
        //     {data: 'content_title', name: 'content_title', className: 'detail'},
        //     {data: 'video', name: 'video', className: 'detail', orderable: false, searchable: false},
        //     {data: 'summary_title', name: 'summary_title', className: 'detail'},
        //     {data: 'question_package_id', name: 'question_package_id', className: 'detail'},
        //     {data: 'action', className: 'center-align'},
        // ]
    });

    dtdatatable.on('click', '.btn-edit', function(event) {
      var id = $(this).data('id');
      window.location.href = '' ;
    });

    dtdatatable.on('click', '.btn-delete', function(event) {
      var id = $(this).data('id');
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
        if (confirm) { // Bila oke post ajax ke url delete nya
          // Ajax Post Delete
          $.ajax({
            url: id,
            type: 'DELETE',
          })
          .done(function() { // Kalau ajax nya success
            swal("Good job!", "You clicked the button!", "success") // alert success
            dtdatatable.ajax.reload(null, false); // reload datatable
          })
          .fail(function() { // Kalau ajax nya gagal
            console.log("error");
          });

        }
      })
    });
</script>
@endpush
