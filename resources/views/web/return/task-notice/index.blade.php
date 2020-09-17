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
                            <input type="file" required id="input-file-now" class="dropify" name="file_task_notice" data-default-file="" data-height="150"/>
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
                      <span class="btn waves-effect waves-light btn-small red darken-4 btn-multi-delete-selected-item mt-1 mb-1 ml-1">
                        Delete
                      </span>
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
                                    <th data-priority="1" class="datatable-checkbox-cell" width="30px">
                                      <label>
                                          <input type="checkbox" class="select-all" />
                                          <span></span>
                                      </label>
                                    </th>
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

@push('page-modal')
<div id="modal-form-print-st" class="modal" style="">
  <form id="form-print-st" class="form-table">
    <div class="modal-content">
        <input type="hidden" name="id_header">
        <table>
          <tr>
            <td width="150px">Expedition</td>
            <td>
              <div class="input-field">
                <input type="text" name="expedition">
              </div>
            </td>
          </tr>
          <tr>
            <td width="150px">Vehicle No</td>
            <td>
              <div class="input-field">
                <input type="text" name="vehicle_no">
              </div>
            </td>
          </tr>
          <tr>
            <td width="150px">Driver</td>
            <td>
              <div class="input-field">
                <input type="text" name="driver">
              </div>
            </td>
          </tr>
          <tr>
            <td width="150px">Allocation</td>
            <td>
              <div class="input-field">
                <input type="text" name="allocation">
              </div>
            </td>
          </tr>
          <tr>
            <td width="150px">Admin Warehouse</td>
            <td>
              <div class="input-field">
                <input type="text" name="admin_warehouse">
              </div>
            </td>
          </tr>
        </table>
    </div>
    <div class="modal-footer">
      <a href="#!" class="btn waves-effect waves-green btn-show-print-preview-st btn green darken-4">Print Report</a>
      <button type="submit" class="btn waves-effect waves-light indigo btn-small btn-save">Save</button>
      <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Close</a>
    </div>
  </form>
</div>

<div id="modal-form-print-do-return" class="modal" style="">
  <form id="form-print-do-return" class="form-table">
    <div class="modal-content">
        <input type="hidden" name="id_header">
        <table>
          <tr>
            <td width="150px">Expedition</td>
            <td>
              <div class="input-field">
                <input type="text" name="expedition">
              </div>
            </td>
          </tr>
          <tr>
            <td width="150px">Vehicle No</td>
            <td>
              <div class="input-field">
                <input type="text" name="vehicle_no">
              </div>
            </td>
          </tr>
          <tr>
            <td width="150px">Driver</td>
            <td>
              <div class="input-field">
                <input type="text" name="driver">
              </div>
            </td>
          </tr>
          <tr>
            <td width="150px">Security</td>
            <td>
              <div class="input-field">
                <input type="text" name="security">
              </div>
            </td>
          </tr>
          <tr>
            <td width="150px">Checker</td>
            <td>
              <div class="input-field">
                <input type="text" name="checker">
              </div>
            </td>
          </tr>
          <tr>
            <td width="150px">W.H</td>
            <td>
              <div class="input-field">
                <input type="text" name="wh">
              </div>
            </td>
          </tr>
        </table>
    </div>
    <div class="modal-footer">
      <a href="#!" class="btn waves-effect waves-green btn-show-print-preview-do-return btn green darken-4">Print Report</a>
      <button type="submit" class="btn waves-effect waves-light indigo btn-small btn-save">Save</button>
      <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Close</a>
    </div>
  </form>
</div>
@endpush

{{-- Load Modal Print --}}
@include('layouts.materialize.components.modal-print', [
  'title' => 'Print ST',
])
{{-- Load Modal Print --}}
@include('layouts.materialize.components.modal-print', [
  'title' => 'Print DO Return',
])

@push('vendor_js')
<script src="{{ asset('materialize/vendors/jquery-validation/jquery.validate.min.js') }}">
</script>
@endpush

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
          { data: 'no', name: 'no', className: 'detail' },
          { data: 'no_document', name: 'no_document', className: 'detail' },
          { data: 'costumer_po', name: 'costumer_po', className: 'detail' },
          { data: 'upload_date', name: 'upload_date', className: 'detail' },
          { data: 'action', className: 'center-align', orderable: false, searchable: false },
          {
            data: 'id_header',
            orderable: false,
            searchable: false,
            render: function ( data, type, row ) {
                if ( type === 'display' ) {
                    return '<label><input type="checkbox" name="id[]" value="" class="checkbox"><span></span></label>';
                }
                return data;
            },
            className: "datatable-checkbox-cell"
          },
      ]
  });

    set_datatables_checkbox('#data-table-simple', table)

    $('#form-task-notice [name="area"]').select2({
       placeholder: '-- Select Area --',
       allowClear: true,
       ajax: get_select2_ajax_options('/master-area/select2-area-only')
    });

    $('#form-task-notice').validate({
      submitHandler: function(form){
        setLoading(true);
        var fdata = new FormData(form);
        $.ajax({
          url: '{{'task-notice'}}',
          type: 'POST',
          data: fdata,
          contentType: "application/json",
          dataType: "json",
          contentType: false,
          processData: false
        })
        .done(function(result) {
          setLoading(false)
          if (result.status) {
            showSwalAutoClose('Success', result.message)
            table.ajax.reload(null, false)
          }
        })
        .fail(function(xhr) {
          setLoading(false)
          showSwalError(xhr)
        })
        .always(function() {
          console.log("complete");
        });
        
      }
    })

    $('.btn-multi-delete-selected-item').click(function(event) {
      /* Act on the event */
      swal({
        title: "Are you sure?",
        text: "Are you sure want delete this data?",
        icon: 'warning',
        buttons: {
          cancel: true,
          delete: 'Yes, Delete It'
        }
      }).then(function (confirm) { // proses confirm
        var data_header = [];
        table.$('input[type="checkbox"]').each(function() {
           /* iterate through array or object */
           if(this.checked){
            var row = $(this).closest('tr');
            var row_data = table.row(row).data();
            data_header.push(row_data);
           }
        });
        if (confirm) { // Bila oke post ajax ke url delete nya
          // Ajax Post Delete
          $.ajax({
            url: '{{ url('task-notice') }}' ,
            type: 'DELETE',
            data: 'data_header=' + JSON.stringify(data_header),
          })
          .done(function(result) { // Kalau ajax nya success
            if (result.status) {
              showSwalAutoClose('Success', result.message)
              if ($('thead input[type="checkbox"]', table.table().container()).attr("checked")) {
                $('thead input[type="checkbox"]', table.table().container()).trigger('click')
              }
              table.ajax.reload(null, false); // reload datatable
            } else {
              showSwalAutoClose('Warning', result.message)
            }
          })
          .fail(function() { // Kalau ajax nya gagal
            console.log("error");
          });
          
        }
      })
    });

    $('#form-print-st').validate({
      submitHandler: function(form){
        setLoading(true); // Disable Button when ajax post data
        $.ajax({
          url: '{{ url("task-notice") }}',
          type: 'PUT',
          data: $(form).serialize(),
        })
        .done(function(data) { // selesai dan berhasil
          setLoading(false); // Disable Button when ajax post data
          if (data.status) {
            showSwalAutoClose("Success", data.message)
            table.ajax.reload(null, false)
          }
        })
        .fail(function(xhr) {
            setLoading(false); // Enable Button when failed
            showSwalError(xhr) // Custom function to show error with sweetAlert
        });
      }
    })

    $('#form-print-do-return').validate({
      submitHandler: function(form){
        setLoading(true); // Disable Button when ajax post data
        $.ajax({
          url: '{{ url("task-notice") }}',
          type: 'PUT',
          data: $(form).serialize(),
        })
        .done(function(data) { // selesai dan berhasil
          setLoading(false); // Disable Button when ajax post data
          if (data.status) {
            showSwalAutoClose("Success", data.message)
            $(form)[0].reset();
            table.ajax.reload(null, false)
          }
        })
        .fail(function(xhr) {
            setLoading(false); // Enable Button when failed
            showSwalError(xhr) // Custom function to show error with sweetAlert
        });
      }
    })

    @if (auth()->user()->area != "All") 
      set_select2_value('#form-task-notice [name="area"]', '{{auth()->user()->area}}', '{{auth()->user()->area}}')
      $('#form-task-notice [name="area"]').attr('disabled', 'disabled');
    @endif

    table.on('click', '.btn-print-st', function(event) {
      var tr = $(this).parent().parent();
      var data = table.row(tr).data();
      $('#form-print-st [name="id_header"]').val(data.id_header)
      $('#form-print-st [name="expedition"]').val(data.expedition)
      $('#form-print-st [name="vehicle_no"]').val(data.vehicle_no)
      $('#form-print-st [name="driver"]').val(data.driver)
      $('#form-print-st [name="allocation"]').val(data.allocation)
      $('#form-print-st [name="admin_warehouse"]').val(data.admin_warehouse)
      $('#modal-form-print-st').modal('open')
    })

    $('.btn-show-print-preview-st').click(function(event) {
      /* Act on the event */
       initPrintPreviewPrintST('{{url("task-notice")}}' + '/' + $('#form-print-st [name="id_header"]').val() + '/export-st', $('#form-print-st').serialize())
    });

    table.on('click', '.btn-print-do-return', function(event) {
      var tr = $(this).parent().parent();
      var data = table.row(tr).data();
      $('#form-print-do-return [name="id_header"]').val(data.id_header)
      $('#form-print-do-return [name="expedition"]').val(data.expedition)
      $('#form-print-do-return [name="vehicle_no"]').val(data.vehicle_no)
      $('#form-print-do-return [name="driver"]').val(data.driver)
      $('#form-print-do-return [name="security"]').val(data.security)
      $('#form-print-do-return [name="checker"]').val(data.checker)
      $('#form-print-do-return [name="wh"]').val(data.wh)
      $('#modal-form-print-do-return').modal('open')
    });

    $('.btn-show-print-preview-do-return').click(function(event) {
      /* Act on the event */
      initPrintPreviewPrintDOReturn('{{url("task-notice")}}' + '/' + $('#form-print-do-return [name="id_header"]').val() + '/export-do-return', $('#form-print-do-return').serialize())
    });

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