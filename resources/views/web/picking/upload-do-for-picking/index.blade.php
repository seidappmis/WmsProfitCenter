@extends('layouts.materialize.index')
{{-- @include('admin.materi.modal_form_materi') --}}

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m8 l8">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Upload DO for Picking</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Upload DO for Picking</li>
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
                                <!-- Modal Trigger -->
                                <a class="waves-effect waves-light btn modal-trigger indigo btn mt-2 mr-1 mb-1" href="#modal1">Upload DO</a>
                                {!! get_button_save('Multi Delete Selected Items') !!}
                              </div>
                            </div>
                        </div>
                        
                        <div class="section-data-tables"> 
                          <table id="multi-select" class="display" width="100%">
                              <thead>
                                  <tr>
                                    <th data-priority="1" width="30px">No.</th>
                                    <th>DELIVERY NO.</th>
                                    <th>DELIVERY ITEM</th>
                                    <th>DO DATE</th>
                                    <th>CUSTOMER CODE</th>
                                    <th>CUSTOMER NAME</th>
                                    <th>MODEL</th>
                                    <th>EAN CODE</th>
                                    <th>QUANTITY</th>
                                    <th width="50px;"></th>
                                  </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td>1</td>
                                  <td>21600161467</td>
                                  <td>10</td>
                                  <td>26.11.2019</td>
                                  <td>16A120000</td>
                                  <td>PT.ATAKRIB GROUP</td>
                                  <td>S1316MG-GB</td>
                                  <td>8997878549879754</td>
                                  <td>7</td>
                                  <td width="50px;">
                                    {!! get_button_delete() !!}
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
            <!-- <div style="bottom: 50px; right: 19px;" class="fixed-action-btn direction-top"><a href="#" class="btn-floating indigo darken-2 gradient-shadow modal-trigger"><i class="material-icons">add</i></a>
            </div> -->
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
    <span class="modal-action modal-close waves-effect waves-green btn-flat">Cancel</span>
  </div>
</div>
</div>
@endpush

@push('script_js')
<script type="text/javascript">
    var dtdatatable = $('#multi-select').DataTable({
        serverSide: false,
        scrollX: true,
        // responsive: true,
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