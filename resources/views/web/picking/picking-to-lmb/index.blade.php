@extends('layouts.materialize.index')
{{-- @include('admin.materi.modal_form_materi') --}}

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Picking to LMB</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Picking to LMB</li>
                </ol>
            </div>

        </div>
    @endcomponent

    <div class="row">
        <div class="col s12">
          <div class="container">
              <div class="section">
                  <div class="card">
                      <div class="card-content p-0">
                        <ul class="collapsible m-0">
                          <li class="active">
                            <div class="collapsible-header"><i class="material-icons">keyboard_arrow_right</i>Upload Serial Number for LMB</div>
                            <div class="collapsible-body">
                            <div class="row mb-2">

                            <div class="col s12 m2 pt-2" >
                                <p> Data File </p>
                            </div>
                            <div class="col s12 m10">
                                <div class="file-field input-field">
                                    <div class="btn indigo btn">
                                        <span>Browse</span>
                                        <input type="file">
                                    </div>
                                    <div class="file-path-wrapper">
                                        <input class="file-path validate" type="text" placeholder="Select File       Format File : csv">
                                    </div>
                                </div>
                            </div>
                            </div>


                              <div class="row">
                                <div class="input-field col s12">
                                  {!! get_button_save('Upload') !!}
                                </div>
                              </div>

                              <h5>Picking List</h5>


                                <!---- Search ----->
                                <div class="app-wrapper">
                                  <div class="datatable-search">
                                    <i class="material-icons mr-2 search-icon">search</i>
                                    <input type="text" placeholder="Search" class="app-filter" id="global_filter">
                                  </div>
                               </div>

                               <h5>Picking to LMB</h5>

                                <!---- Search ----->
                                <div class="app-wrapper">
                                  <div class="datatable-search">
                                    <i class="material-icons mr-2 search-icon">search</i>
                                    <input type="text" placeholder="Search" class="app-filter" id="global_filter">
                                  </div>
                               </div>


                            </div>
                          </li>
                        </ul>
                      </div>
                  </div>
              </div>
              </div>
          </div>
    </div>
</div>
@endsection

@push('script_js')
<script type="text/javascript">
    var dtdatatable = $('#data-table-section-contents').DataTable({
        serverSide: false,
        scrollX: true,
        responsive: true,
        ajax: {
            url: '/',
            type: 'GET',
            data: function(d) {
                d.search['value'] = $('#global_filter').val()
              }
        },
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
