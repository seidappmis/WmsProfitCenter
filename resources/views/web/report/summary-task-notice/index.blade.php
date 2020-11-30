@extends('layouts.materialize.index')
{{-- @include('admin.materi.modal_form_materi') --}}

@section('content')
<div class="row">

  @component('layouts.materialize.components.title-wrapper')
  <div class="row">
    <div class="col s12">
      <h5 class="breadcrumbs-title mt-0 mb-0"><span>Summary Task Notice</span></h5>
      <ol class="breadcrumbs mb-0">
        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
        <li class="breadcrumb-item active">Summary Task Notice</li>
      </ol>
    </div>
  </div>
  @endcomponent

  <div class="col s12">
    <div class="container">
      <div class="section">
        <div class="card">
          <div class="card-content ">
            <form class="form-table" id="form-summary-task-notice">
              <table>
                <tr>
                  <td width="20%">Area</td>
                  <td>
                    <div class="input-field col s4">
                      <select id="area" name="area" class="select2-data-ajax browser-default">
                      </select>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td width="20%">No Document</td>
                  <td>
                    <div class="input-field col s4">
                      <input type="text" name="no_document">
                    </div>
                  </td>
                </tr>
                <tr>
                  <td width="20%">Upload Date</td>
                  <td>
                    <div class="input-field col 12">
                      <table>
                        <tr>
                          <td>START :</td>
                          <td><input type="text" name="start_date" class="validate datepicker"></td>
                          <td>END :</td>
                          <td><input type="text" name="end_date" class="validate datepicker"></td>
                        </tr>
                      </table>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td width="20%">Modified Date</td>
                  <td>
                    <div class="input-field col 12">
                      <table>
                        <tr>
                          <td>START :</td>
                          <td><input type="text" name="modified_start_date" class="validate datepicker"></td>
                          <td>END :</td>
                          <td><input type="text" name="modified_end_date" class="validate datepicker"></td>
                        </tr>
                      </table>
                    </div>
                  </td>
                </tr>
              </table>

              <div class="input-field col s12">
                <button type="submit" class="waves-effect waves-light indigo btn mt-1 mb-1">Submit</button>
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
            <form class="form-table">
              <table id="table_summary_task_notice" class="display" width="100%">
                <thead>
                  <tr>
                    <th>UPLOAD DATE</th>
                    <th>MODIFIED DATE</th>
                    <th>RECEIVE DATE</th>
                    <th>NO DOC</th>
                    <th>NO ST or NO URF</th>
                    <th>NO APPLY</th>
                    <th>CUSTOMER CODE</th>
                    <th>CUSTOMER NAME</th>
                    <th>MODEL PLAN</th>
                    <th>QTY PLAN</th>
                    <th>CBM</th>
                    <th>MODEL ACTUAL</th>
                    <th>QTY ACTUAL</th>
                    <th>CHECK</th>
                    <th>CATEGORY</th>
                    <th>DO NUMBER PLAN</th>
                    <th>DO NUMBER ACTUAL</th>
                    <th>NO SO</th>
                    <th>NO PO</th>
                    <th>RR</th>
                    <th>NO SERIAL</th>
                    <th>KONDISI</th>
                    <th>REMAK</th>
                    <th>NO MOBIL</th>
                    <th>EXPEDISI</th>
                    <th>DRIVER</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </form>
          </div>
        </div>
      </div>
      <div class="content-overlay"></div>
    </div>
  </div>
</div>
@endsection

@push('vendor_js')
<script src="{{ asset('materialize/vendors/jquery-validation/jquery.validate.min.js') }}">
</script>
@endpush

@php $area =auth()->user()->area; @endphp
@push('script_js')
<script type="text/javascript">
  var dttable_summary_task_notice;
  jQuery(document).ready(function($) {
    dttable_summary_task_notice = $('#table_summary_task_notice').DataTable({
      serverSide: true,
      responsive: false,
      scrollX: true,
      dom: 'Brtip',
      scrollY: '60vh',
      buttons: [{
          text: 'PDF',
          action: function(e, dt, node, config) {
            e.preventDefault();
            window.location.href = "{{url('summary-task-notice/export?filetype=pdf')}}" +
              '&no_document=' + $('#form-summary-task-notice [name="no_document"]').val() +
              '&start_date=' + $('#form-summary-task-notice [name="start_date"]').val() +
              '&end_date=' + $('#form-summary-task-notice [name="end_date"]').val() +
              '&modified_start_date=' + $('#form-summary-task-notice [name="modified_start_date"]').val() +
              '&modified_end_date=' + $('#form-summary-task-notice [name="modified_end_date"]').val() +
              '&area=' + $('#form-summary-task-notice [name="area"]').val();
          }

        },

        {

          text: 'EXCEL',
          action: function(e, dt, node, config) {
            window.location.href = "{{url('summary-task-notice/export?filetype=xls')}}" +
              '&no_document=' + $('#form-summary-task-notice [name="no_document"]').val() +
              '&start_date=' + $('#form-summary-task-notice [name="start_date"]').val() +
              '&end_date=' + $('#form-summary-task-notice [name="end_date"]').val() +
              '&modified_start_date=' + $('#form-summary-task-notice [name="modified_start_date"]').val() +
              '&modified_end_date=' + $('#form-summary-task-notice [name="modified_end_date"]').val() +
              '&area=' + $('#form-summary-task-notice [name="area"]').val();
          }
        }
      ],
      ajax: {
        url: "{{ url('summary-task-notice') }}",
        type: 'GET',
        data: function(d) {
          d.no_document = $('#form-summary-task-notice [name="no_document"]').val()
          d.start_date = $('#form-summary-task-notice [name="start_date"]').val()
          d.end_date = $('#form-summary-task-notice [name="end_date"]').val()
          d.modified_start_date = $('#form-summary-task-notice [name="modified_start_date"]').val()
          d.modified_end_date = $('#form-summary-task-notice [name="modified_end_date"]').val()
          d.area = $('#form-summary-task-notice [name="area"]').val()
        }
      },
      columns: [{
          data: 'upload_date',
          render: function(data, type, row) {
            return moment(data).format('d-MMM-YYYY');
          },
        }, {
          data: 'modify_date',
          render: function(data, type, row) {
            return data ? moment(data).format('d-MMM-YYYY') : '';
          },
        },
        {
          data: 'receive_date'
        },
        {
          data: 'no_doc'
        },
        {
          data: 'no_st_or_no_urf'
        },
        {
          data: 'no_apply'
        },
        {
          data: 'costumer_code'
        },
        {
          data: 'costumer_name'
        },
        {
          data: 'model_plan'
        },
        {
          data: 'qty_plan'
        },
        {
          data: 'cbm'
        },
        {
          data: 'model_actual'
        },
        {
          data: 'qty_actual'
        },
        {
          data: 'check'
        },
        {
          data: 'category'
        },
        {
          data: 'do_number_plan'
        },
        {
          data: 'do_number_actual'
        },
        {
          data: 'no_so'
        },
        {
          data: 'no_po'
        },
        {
          data: 'rr'
        },
        {
          data: 'no_serial'
        },
        {
          data: 'kondisi'
        },
        {
          data: 'remark'
        },
        {
          data: 'no_mobil'
        },
        {
          data: 'expedisi'
        },
        {
          data: 'driver'
        },
      ]
    });

    $('#form-summary-task-notice').validate({
      submitHandler: function(form) {
        dttable_summary_task_notice.ajax.reload(null, false)
      }
    })
    $('#form-summary-task-notice [name="area"]').select2({
      placeholder: '-- Select Area --',
      allowClear: true,
      ajax: get_select2_ajax_options('/master-area/select2-area-only')
    });

    @if($area != 'All')
    set_select2_value('#form-summary-task-notice [name="area"]', '{{auth()->user()->area}}', '{{auth()->user()->area}}')
    $('#form-summary-task-notice [name="area"]').attr('disabled', 'disabled')
    @endif
  });
</script>
@endpush