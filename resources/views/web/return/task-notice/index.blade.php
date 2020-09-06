@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Task Notice</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Task Notice</li>
                </ol>
            </div>
          <div class="col s12 m6">
            {{-- <div class="display-flex">
              <!---- Search ----->
              <div class="app-wrapper mr-2">
                <div class="datatable-search">
                  <i class="material-icons mr-2 search-icon">search</i>
                  <input type="text" placeholder="Search" class="app-filter" id="global_filter">
                </div>
              </div>
            </div> --}}
          </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
              <div class="card">
                <div class="card-content pb-2 pt-1">
                  <form id="form-task-notice">
                      <div class="row mb-0">
                        <div class="input-field col s12">
                          <div class="col s12 m4 l2">
                            <p>Area</p>
                          </div>
                          <div class="col s12 m6 l5">
                            <select name="area" class="select2-data-ajax browser-default app-filter" required>
                                  </select>
                          </div>
                        </div>
                        <div class="input-field col s12">
                          <div class="col s12 m4 l2">
                            <p>Data File</p>
                          </div>
                          <div class="col s12 m8 l6">
                            <input type="file" required id="input-file-now" class="dropify" name="file_inventory_storage" data-default-file="" data-height="150"/>
                            <br>
                          </div>
                          <div class="col s12 m12 l4">
                            <p>Format File : .csv</p>
                          </div>
                        </div>
                      </div>
                      <div class="row mb-0">
                        <div class="input-field col s12 mt-1">
                          <button type="submit" class="waves-effect waves-light indigo btn">Submit</button>
                        </div>
                      </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        <div class="content-overlay"></div>
    </div>

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
                                    <th>TASK NOTICE NO</th>
                                    <th>APPROVAL NUMBER</th>
                                    <th>CUSTOMER PO</th>
                                    <th>UPLOAD DATE</th>
                                    <th width="50px;"></th>
                                    <th width="20px;"></th>
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

{{-- Load Modal Print --}}
@include('layouts.materialize.components.modal-print', [
  'title' => 'Print ST',
])
{{-- Load Modal Print --}}
@include('layouts.materialize.components.modal-print', [
  'title' => 'Print DO Return',
])

@push('script_js')
<script type="text/javascript">

  var table
  jQuery(document).ready(function($) {
    table = $('#data-table-simple').DataTable({
      serverSide: true,
      scrollX: true,
      responsive: true,
      ajax: {
          url: "{{url('task-notice')}}",
          type: 'GET',
          data: function(d) {
              d.search['value'] = $('#task-notice-filter').val()
          }
      },
      order: [1, 'desc'],
      columns: [
          { data: 'DT_RowIndex', orderable:false, searchable: false, className: 'center-align'},
          { data: 'task_notice_no', name: 'task_notice_no', className: 'detail' },
          { data: 'no_document', name: 'no_document', className: 'detail' },
          { data: 'costumer_po', name: 'costumer_po', className: 'detail' },
          { data: 'upload_date', name: 'upload_date', className: 'detail' },
          { data: 'action', className: 'center-align', orderable: false, searchable: false },
          { data: 'action', className: 'center-align', orderable: false, searchable: false },
      ]
  });

    $('#form-task-notice [name="area"]').select2({
       placeholder: '-- Select Area --',
       allowClear: true,
       ajax: get_select2_ajax_options('/master-area/select2-area-only')
    });

    @if (auth()->user()->area != "All") 
      set_select2_value('#form-task-notice [name="area"]', '{{auth()->user()->area}}', '{{auth()->user()->area}}')
      $('#form-task-notice [name="area"]').attr('disabled', 'disabled');
    @endif

    table.on('click', '.btn-delete', function(event) {
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
          if (confirm) {
            $(".btn-delete").closest("tr").remove();
            showSwalAutoClose('Success', 'Data deleted')
            //datatable memunculkan no data available in table
          }
        })
      });

    table.on('click', '.btn-print-st', function(event) {
        initPrintPreviewPrintST(
          '{{url("task-notice")}}' + '/123/export-st')
      })

    table.on('click', '.btn-print-do-return', function(event) {
        initPrintPreviewPrintDOReturn(
          '{{url("task-notice")}}' + '/123/export-do-return')
      })

    $("input#global_filter").on("keyup click", function () {
      filterGlobal();
    });
  });


  // Custom search
  function filterGlobal() {
      table.search($("#global_filter").val(), $("#global_regex").prop("checked"), $("#global_smart").prop("checked")).draw();
  }
</script>
@endpush