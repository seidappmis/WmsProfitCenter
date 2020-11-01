@extends('layouts.materialize.index')
{{-- @include('admin.materi.modal_form_materi') --}}

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Report Loading Summary</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Report Loading Summary</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content p-3">
                        <form class="form-table" id="form-report-loading-summary">
                            <table>
                                <tr>
                                    <td>Area</td>
                                    <td>
                                      <div class="input-field col s12">
                                        <select name="area" class="select2-data-ajax browser-default" required="">
                                        </select>
                                      </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Period</td>
                                    <td>
                                        <input placeholder="" name="periode" type="text" class="validate monthpicker" required autocomplete="off">
                                    </td>
                                </tr>
                            </table>
                            <div class="input-field col s12">
                               <button type="submit" class="waves-effect waves-light indigo btn mt-1 mb-1">Submit</button>
                             </div>
                        </form>
                    </div>
                </div>

                <div class="card report-loading-summary-wrapper hide">
                    <div class="card-content center-align p-0">
                        <table id="table_report_loading_summary" class="display" width="100%">
                            <thead>
                                <tr>
                                  <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <!-- datatable ends -->
                    </div>
                </div>

            </div>
        </div>
        <div class="content-overlay"></div>
    </div>
</div>
@endsection

@push('script_css')
<link rel="stylesheet" href="{{ asset('vendors/datepicker/datepicker.css') }}">
@endpush

@push('vendor_js')
<script src="{{ asset('vendors/datepicker/datepicker.js') }}"></script>
<script src="{{ asset('materialize/vendors/jquery-validation/jquery.validate.min.js') }}">
</script>
@endpush

@push('script_js')
<script type="text/javascript">
    $('.monthpicker').datepicker({
      format: 'mm/yyyy',
      autoHide: true
    });

    $('#form-report-loading-summary [name="area"]').select2({
     placeholder: '-- Select Area --',
     allowClear: true,
     ajax: get_select2_ajax_options('/master-area/select2-area-only')
  });

    var dttable_report_loading_summary
    jQuery(document).ready(function($) {
        dttable_report_loading_summary = $('#table_report_loading_summary').DataTable({
          serverSide: true,
          scrollX: true,
          dom: 'Brtip',
          pageLength: 1,
          scrollY: '60vh',
          buttons: [
                  {
                      text: 'PDF',
                      action: function ( e, dt, node, config ) {
                          window.location.href = "{{url('report-loading-summary/export?file_type=pdf')}}" + '&' + $('#form-report-loading-summary').serialize();
                      }
                  },
                   {
                      text: 'EXCEL',
                      action: function ( e, dt, node, config ) {
                          window.location.href = "{{url('report-loading-summary/export?file_type=xls')}}" + '&' + $('#form-report-loading-summary').serialize();
                      }
                  }
              ],
          ajax: {
              url: '{{ url('report-loading-summary') }}',
              type: 'GET',
              data: function(d) {
                d.area = $('#form-report-loading-summary [name="area"]').val()
                d.periode = $('#form-report-loading-summary [name="periode"]').val()
              }
          },
          columns: [
              {data: 'tabeldata'},
          ]
        });

        $('#form-report-loading-summary').validate({
            submitHandler: function(form){
                $('.report-loading-summary-wrapper').removeClass('hide')
                dttable_report_loading_summary.ajax.reload(null, false)
            }
        })
    });
</script>
@endpush
