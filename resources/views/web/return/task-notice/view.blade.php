@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>View Detail Task Notice</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('picking-to-lmb') }}">Task Notice</a></li>
                    <li class="breadcrumb-item active">View Detail Task Notice</li>
                </ol>
            </div>
        </div>
    @endcomponent

    <div class="col s12">
        <div class="container">
            <div class="section">
              <div class="card">
                <div class="card-content p-0">
                  <ul class="collapsible m-0">
                    <li class="active">
                      <div class="collapsible-header"><i class="material-icons">keyboard_arrow_right</i>List Task Notice Plan</div>
                      <div class="collapsible-body padding-1">
                        {!! get_button_cancel(url('task-notice'), 'Back' , 'mb-1') !!}
                        <div class="section-data-tables"> 
                          <table id="task-notice-plan-table" class="display" width="100%">
                              <thead>
                                  <tr>
                                    <th>Approval Number.</th>
                                    <th>Model Plan</th>
                                    <th>QTY Plan</th>
                                    <th>Count of Actual</th>
                                    <th width="50px;"></th>
                                  </tr>
                              </thead>
                              <tbody>
                              </tbody>
                          </table>
                        </div>
                        <!-- datatable ends -->
                      </div>
                    </li>
                  </ul>
                </div>
                <div class="content-overlay"></div>
            </div>
          </div>
        </div>
      </div>

       <div class="col s12 container-input-task-notice-actual-wrapper hide">
        <div class="container">
            <div class="section">
              <div class="card">
                <div class="card-content p-0">
                  <ul class="collapsible m-0">
                    <li class="active">
                      <div class="collapsible-header"><i class="material-icons">keyboard_arrow_right</i>Input Task Notice Actual</div>
                      <div class="collapsible-body padding-1">
                        {!! get_button_save('Add', 'btn-add-input-actual') !!}
                        {!! get_button_save('Save', 'btn-save-input-actual hide') !!}
                        {!! get_button_save('Cancel', 'btn-cancel-input-actual hide') !!}
                        <h5 class="card-title" style="text-weight: 900 !important;">Model Plan: <span id="text-input-actual-model-plan"></span> &nbsp; &nbsp;&nbsp; &nbsp; Quantity Plan : <span id="text-input-actual-quantity-plan"></span></h5>
                        <input type="hidden" name="id_header" id="id_header">
                        <input type="hidden" name="id_detail_plan" id="id_detail_plan">
                        <div class="section-data-tables input-task-notice-actual-wrapper hide"> 
                          <form id="form-task-notice-actual">
                            <input type="hidden" name="id_header">
                            <input type="hidden" name="id_detail_plan">
                            <table id="task-notice-actual-input-table" class="display form-table" width="100%">
                                <thead>
                                    <tr>
                                      <th>Model Actual</th>
                                      <th width="20px">QTY Actual</th>
                                      <th>Serial Number</th>
                                      <th>NO SO</th>
                                      <th>NO DO</th>
                                      <th>NO PO</th>
                                      <th>RR</th>
                                      <th>KONDISI</th>
                                      <th>REMAK</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td>
                                      <div class="input-field col s12">
                                        <input id="area" type="text" name="model">
                                      </div>
                                    </td>
                                    <td>
                                      <div class="input-field col s12">
                                        <input id="area" type="number" min="0" name="qty">
                                      </div>
                                    </td>
                                    <td>
                                      <div class="input-field col s12">
                                        <input id="area" type="text" name="serial_number" required="">
                                      </div>
                                    </td>
                                    <td>
                                      <div class="input-field col s12">
                                        <input id="area" type="text" name="no_so">
                                      </div>
                                    </td>
                                    <td>
                                      <div class="input-field col s12">
                                        <input id="area" type="text" name="no_do">
                                      </div>
                                    </td>
                                    <td>
                                      <div class="input-field col s12">
                                        <input id="area" type="text" name="no_po">
                                      </div>
                                    </td>
                                    <td>
                                      <div class="input-field col s12">
                                        <input id="area" type="text" name="rr">
                                      </div>
                                    </td>
                                    <td>
                                      <div class="input-field col s12">
                                        <input id="area" type="text" name="kondisi">
                                      </div>
                                    </td>
                                    <td>
                                      <div class="input-field col s12">
                                        <input id="area" type="text" name="remark">
                                      </div>
                                    </td>
                                  </tr>
                                </tbody>
                            </table>
                          </form>
                        </div>
                        <!-- datatable ends -->
                      </div>
                    </li>
                  </ul>
                </div>
                <div class="content-overlay"></div>
            </div>
          </div>
        </div>
      </div>

      <div class="col s12 container-list-task-notice-actual-wrapper hide">
        <div class="container">
            <div class="section">
              <div class="card">
                <div class="card-content p-0">
                  <ul class="collapsible m-0">
                    <li class="active">
                      <div class="collapsible-header"><i class="material-icons">keyboard_arrow_right</i>List Task Notice Actual</div>
                      <div class="collapsible-body padding-1">
                        <div class="section-data-tables"> 
                          <table id="task-notice-actual-table" class="form-table" width="100%">
                              <thead>
                                  <tr>
                                    <th>Model Actual</th>
                                    <th width="20px">QTY Actual</th>
                                    <th>Serial Number</th>
                                    <th>NO SO</th>
                                    <th>NO DO</th>
                                    <th>NO PO</th>
                                    <th>RR</th>
                                    <th>KONDISI</th>
                                    <th>REMAK</th>
                                    <th width="50px;"></th>
                                    <th width="50px;"></th>
                                    <th width="50px;"></th>
                                  </tr>
                              </thead>
                              <tbody>
                              </tbody>
                          </table>
                        </div>
                        <!-- datatable ends -->
                      </div>
                    </li>
                  </ul>
                </div>
                <div class="content-overlay"></div>
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
  var dttable_plan;
  jQuery(document).ready(function($) {
    dttable_plan = $('#task-notice-plan-table').DataTable({
      serverSide: true,
      scrollX: true,
      responsive: true,
      ajax: {
          url: "{{url('task-notice/' . $suratTugasHeader->id_header)}}",
          type: 'GET'
      },
      order: [1, 'asc'],
      columns: [
          { data: 'no_document', name: 'no_document', className: 'detail' },
          { data: 'model', name: 'model', className: 'detail' },
          { data: 'qty', name: 'qty', className: 'detail' },
          { data: 'count_of_actual', name: 'count_of_actual', className: 'detail' },
          { data: 'action', className: 'center-align', orderable: false, searchable: false }
      ]
    });

    dttable_plan.on('click', '.btn-view', function(event) {
      event.preventDefault();
      /* Act on the event */
      var tr = $(this).parent().parent();
      var data = dttable_plan.row(tr).data();

      $('#id_header').val(data.id_header)
      $('#id_detail_plan').val(data.id_detail_plan)
      $('#text-input-actual-model-plan').text(data.model)
      $('#text-input-actual-quantity-plan').text(data.qty)
      $('.container-input-task-notice-actual-wrapper').removeClass('hide');
      $('.btn-cancel-input-actual').trigger('click')
      loadListTaskNoticeActual();
    });

    $('.btn-add-input-actual').click(function(event) {
      /* Act on the event */
      $('.input-task-notice-actual-wrapper').removeClass('hide')
      $('.btn-add-input-actual').addClass('hide')
      $('.btn-save-input-actual').removeClass('hide')
      $('.btn-cancel-input-actual').removeClass('hide')

      $('#form-task-notice-actual [name="id_header"]').val($('#id_header').val())
      $('#form-task-notice-actual [name="id_detail_plan"]').val($('#id_detail_plan').val())
      $('#form-task-notice-actual [name="model"]').val($('#text-input-actual-model-plan').text())
      $('#form-task-notice-actual [name="qty"]').val($('#text-input-actual-quantity-plan').text())
    });

    $('.btn-cancel-input-actual').click(function(event) {
      /* Act on the event */
      $('.input-task-notice-actual-wrapper').addClass('hide')
      $('.btn-add-input-actual').removeClass('hide')
      $('.btn-save-input-actual').addClass('hide')
      $('.btn-cancel-input-actual').addClass('hide')

      $('#form-task-notice-actual')[0].reset()
    });

    $('.btn-save-input-actual').click(function(event) {
      $('#form-task-notice-actual').submit();
    })

    $('#form-task-notice-actual').validate({
      submitHandler: function(form){
        setLoading(true); // Disable Button when ajax post data
        $.ajax({
          url: '{{ url("task-notice/actual") }}',
          type: 'POST',
          data: $(form).serialize(),
        })
        .done(function(data) { // selesai dan berhasil
          setLoading(false); // Disable Button when ajax post data
          if (data.status) {
            showSwalAutoClose("Success", data.message)
            $('#form-task-notice-actual')[0].reset()
            $('.btn-cancel-input-actual').trigger('click')
            dttable_plan.ajax.reload(null, false)
            loadListTaskNoticeActual();
          }
        })
        .fail(function(xhr) {
            setLoading(false); // Enable Button when failed
            showSwalError(xhr) // Custom function to show error with sweetAlert
        });
      }
    })

    $('#task-notice-actual-table').on('click', '.btn-edit', function(event) {
      var tr = $(this).parent().parent();
      $(tr).find('.text-display').addClass('hide')
      $(tr).find('.text-input').removeClass('hide')
      $(tr).find('.btn-update').removeClass('hide')
      $(tr).find('.btn-cancel').removeClass('hide')
      $(tr).find('.btn-edit').addClass('hide')
    })

    $('#task-notice-actual-table').on('click', '.btn-cancel', function(event) {
      var tr = $(this).parent().parent();
      $(tr).find('.text-display').removeClass('hide')
      $(tr).find('.text-input').addClass('hide')
      $(tr).find('.btn-update').addClass('hide')
      $(tr).find('.btn-cancel').addClass('hide')
      $(tr).find('.btn-edit').removeClass('hide')
    })

    $('#task-notice-actual-table').on('click', '.btn-update', function(event) {
      setLoading(true); // Disable Button when ajax post data
      var tr = $(this).parent().parent();
      $.ajax({
        url: '{{ url("task-notice/actual") }}',
        type: 'PUT',
        data: {
          id_detail_actual: $(tr).find('[name="id_detail_actual"]').val(),
          model: $(tr).find('[name="model"]').val(),
          qty: $(tr).find('[name="qty"]').val(),
          serial_number: $(tr).find('[name="serial_number"]').val(),
          no_so: $(tr).find('[name="no_so"]').val(),
          no_do: $(tr).find('[name="no_do"]').val(),
          no_po: $(tr).find('[name="no_po"]').val(),
          rr: $(tr).find('[name="rr"]').val(),
          kondisi: $(tr).find('[name="kondisi"]').val(),
          remark: $(tr).find('[name="remark"]').val(),
        },
      })
      .done(function(data) { // selesai dan berhasil
        setLoading(false); // Disable Button when ajax post data
        if (data.status) {
          showSwalAutoClose("Success", data.message)
          loadListTaskNoticeActual();
        }
      })
      .fail(function(xhr) {
          setLoading(false); // Enable Button when failed
          showSwalError(xhr) // Custom function to show error with sweetAlert
      });
      
    })

    $('#task-notice-actual-table').on('click', '.btn-delete', function(event) {
      event.preventDefault();
      /* Act on the event */
      var tr = $(this).parent().parent();

      swal({
        title: "Are you sure?",
        icon: 'warning',
        buttons: {
          cancel: true,
          delete: 'Yes, Delete It'
        }
      }).then(function (confirm) { // proses confirm
        if (confirm) { // Bila oke post ajax ke url delete nya
          // Ajax Post Delete
          $.ajax({
            url: '{{ url('task-notice/delete-actual') }}',
            type: 'DELETE',
            data: 'id_detail_actual=' + $(tr).find('[name="id_detail_actual"]').val()
          })
          .done(function(result) { // Kalau ajax nya success
            if (result.status) {
              showSwalAutoClose('Success', result.message)
              $(tr).remove();
              dttable_plan.ajax.reload(null, false); // reload datatable
            }
          })
          .fail(function() { // Kalau ajax nya gagal
            console.log("error");
          });
          
        }
      })
    });

  });

  function loadListTaskNoticeActual(){
    $.ajax({
      url: '{{url('task-notice/actual')}}',
      type: 'GET',
      dataType: 'json',
      data: {id_detail_plan: $('#id_detail_plan').val()},
    })
    .done(function(result) {
      if (result.data.length > 0) {
        $('.container-list-task-notice-actual-wrapper').removeClass('hide');

         $('#task-notice-actual-table tbody').empty();
        $.each(result.data, function(index, val) {
           /* iterate through array or object */
           var row = '';
           row += '<tr>';
           row += '<td style="padding: 0px;">'
           row += '<div class="input-field col s12" style="padding: 0;"><input id="area" class="text-input hide" type="text" name="model" value="' + val.model + '"></div>'
           row += '<span class="text-display">' + val.model + '</span>'
           row += '</td>';
           row += '<td style="padding: 0px;">'
           row += '<div class="input-field col s12" style="padding: 0;"><input id="area" class="text-input hide" type="number" min="0" name="qty" value="' + val.qty + '"></div>'
           row += '<span class="text-display">' + val.qty + '</span>'
           row += '</td>';
           row += '<td style="padding: 0px;">'
           row += '<div class="input-field col s12" style="padding: 0;"><input id="area" class="text-input hide" type="text" name="serial_number" value="' + val.serial_number + '" required=""></div>'
           row += '<span class="text-display">' + val.serial_number + '</span>'
           row += '</td>';
           row += '<td style="padding: 0px;">'
           row += '<div class="input-field col s12" style="padding: 0;"><input id="area" class="text-input hide" type="text" name="no_so" value="' + val.no_so + '"></div>'
           row += '<span class="text-display">' + val.no_so + '</span>'
           row += '</td>';
           row += '<td style="padding: 0px;">'
           row += '<div class="input-field col s12" style="padding: 0;"><input id="area" class="text-input hide" type="text" name="no_do" value="' + val.no_do + '"></div>'
           row += '<span class="text-display">' + val.no_do + '</span>'
           row += '</td>';
           row += '<td style="padding: 0px;">'
           row += '<div class="input-field col s12" style="padding: 0;"><input id="area" class="text-input hide" type="text" name="no_po" value="' + val.no_po + '"></div>'
           row += '<span class="text-display">' + val.no_po + '</span>'
           row += '</td>';
           row += '<td style="padding: 0px;">'
           row += '<div class="input-field col s12" style="padding: 0;"><input id="area" class="text-input hide" type="text" name="rr" value="' + val.rr + '"></div>'
           row += '<span class="text-display">' + val.rr + '</span>'
           row += '</td>';
           row += '<td style="padding: 0px;">'
           row += '<div class="input-field col s12" style="padding: 0;"><input id="area" class="text-input hide" type="text" name="kondisi" value="' + val.kondisi + '"></div>'
           row += '<span class="text-display">' + val.kondisi + '</span>'
           row += '</td>';
           row += '<td style="padding: 0px;">'
           row += '<div class="input-field col s12" style="padding: 0;"><input id="area" class="text-input hide" type="text" name="remark" value="' + val.remark + '"></div>'
           row += '<span class="text-display">' + val.remark + '</span>'
           row += '</td>';
           row += '<td style="padding: 0px;">'
           row += '<input type="hidden" name="id_detail_actual" value="' + val.id_detail_actual + '"></input>'
           row += '{!! get_button_edit() !!}'
           row += '{!! get_button_save("Update", "btn-update hide") !!}'
           row +='</td>';
           row += '<td style="padding: 0px;">'
           row += '{!! get_button_cancel("#!", "Cancel", "btn-cancel hide") !!}'
           row +='</td>';
           row += '<td>{!! get_button_delete() !!}</td>';
           row += '</tr>';

           $('#task-notice-actual-table tbody').append(row)
        });
      }
    })
    .always(function() {
      console.log("complete");
    });
    
  }
</script>
@endpush