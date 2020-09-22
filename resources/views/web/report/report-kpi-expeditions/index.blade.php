@extends('layouts.materialize.index')
{{-- @include('admin.materi.modal_form_materi') --}}

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Report KPi Expeditions</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Report KPi Expeditions</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content pt-1 pb-1 pl-1 pr-1">
                        <form class="form-table" id="form-report-kpi-expedition">
                            <table>
                                <tr>
                                    <td>Area</td>
                                    <td>
                                      <div class="input-field col s12">
                                        <div class="input-field col s12">
                                            <select name="area" class="select2-data-ajax browser-default">
                                            </select>
                                          </div>
                                      </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Periode</td>
                                    <td>
                                      <div class="col s9 m10">
                                        <input placeholder="" name="periode" type="text" class="validate monthpicker" autocomplete="off">
                                      </div>
                                    </td>
                                </tr>
                            </table>
                            <div class="input-field col s12">
                                <button type="submit" class="waves-effect waves-light indigo btn">Submit</button>
                              </div>
                        </form>
                        <br>
                    </div>
                </div>
                <div class="card report-kpi-expedition-wrapper hide">
                    <div class="card-content center-align p-0">
                        <table id="table_report_kpi_expedition" class="display" width="100%">
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

    $('#form-report-kpi-expedition [name="area"]').select2({
         placeholder: '-- Select Area --',
         allowClear: true,
         ajax: get_select2_ajax_options('/master-area/select2-area-only')
      });

    var dttable_report_kpi_expedition
    jQuery(document).ready(function($) {
        dttable_report_kpi_expedition = $('#table_report_kpi_expedition').DataTable({
      serverSide: true,
      scrollX: true,
      dom: 'Brtip',
      pageLength: 1,
      scrollY: '60vh',
      buttons: [
              {
                  text: 'PDF',
                  action: function ( e, dt, node, config ) {
                      window.location.href = "{{url('report-kpi-expeditions/export?file_type=pdf')}}" + '&area=' + $('#area_filter').val();
                  }
              },
               {
                  text: 'EXCEL',
                  action: function ( e, dt, node, config ) {
                      window.location.href = "{{url('report-kpi-expeditions/export?file_type=xls')}}" + '&area=' + $('#area_filter').val();
                  }
              }
          ],
      ajax: {
          url: '{{ url('report-kpi-expeditions') }}',
          type: 'GET',
          data: function(d) {
            d.area = $('#form-report-kpi-expedition [name="area"]').val()
            d.periode = $('#form-report-kpi-expedition [name="periode"]').val()
          }
      },
      columns: [
          {data: 'tabeldata'},
      ]
    });

        $('#form-report-kpi-expedition').validate({
            submitHandler: function (form){
                $('.report-kpi-expedition-wrapper').removeClass('hide')
                dttable_report_kpi_expedition.ajax.reload(null, false)
            }
        })
    });
</script>
@endpush