@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Report Master Freight Cost</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Report Master Freight Cost</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content pb-1 pt-1 pl-1 pr-1">
                        <form class="form-table" id="form-report-master-freight-cost">
                            <table>
                                <tr>
                                    <td width="100px">Area</td>
                                    <td>
                                      <div class="input-field col s12">
                                        <select name="area" class="select2-data-ajax browser-default">
                                        </select>
                                      </div>
                                    </td>
                                </tr>
                                
                            </table>
                            <div class="input-field col s12">
                                <button type="submit" class="waves-effect waves-light indigo btn mt-1 mb-1">Submit</button>
                              </div>
                              <br>
                        </form>
                     </div>
                 </div>
                 <div class="card">
                    <div class="card-content p-0">
                        <form class="form-table">
                            <table id="table_report_master_freight_cost" class="display" width="100%">
                                <thead>
                                    <tr>
                                      <th>AREA</th>
                                      <th>CITY CODE</th>
                                      <th>CITY NAME</th>
                                      <th>EXPEDITION CODE</th>
                                      <th>EXPEDITION NAME</th>
                                      <th>VEHICLE CODE TYPE</th>
                                      <th>VEHICLE DESCRIPTION</th>
                                      <th>RITASE</th>
                                      <th>CBM</th>
                                      <th>LEADTIME</th>
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

@push('script_js')
<script type="text/javascript">
  var dttable_report_master_freight_cost;
  jQuery(document).ready(function($) {
    dttable_report_master_freight_cost = $('#table_report_master_freight_cost').DataTable({
      serverSide: true,
      scrollX: true,
      dom: 'Brtip',
      scrollY: '60vh',
      buttons: [
        {
          text: 'PDF',
          action: function ( e, dt, node, config ) {
              window.location.href = "{{url('report-master-freight-cost/export?file_type=pdf')}}" + '&area=' + $('#form-report-master-freight-cost [name="area"]').val();
          }
        },
         {
          text: 'EXCEL',
          action: function ( e, dt, node, config ) {
              window.location.href = "{{url('report-master-freight-cost/export?file_type=xls')}}" + '&area=' + $('#form-report-master-freight-cost [name="area"]').val();
          }
        }
      ],
      ajax: {
          url: '{{ url('report-master-freight-cost') }}',
          type: 'GET',
          data: function(d) {
            d.area = $('#form-report-master-freight-cost [name="area"]').val()
          }
      },
      columns: [
          {data: 'area'},
          {data: 'city_code'},
          {data: 'city_name'},
          {data: 'expedition_code'},
          {data: 'expedition_name'},
          {data: 'vehicle_code_type'},
          {data: 'vehicle_description'},
          {data: 'ritase'},
          {data: 'cbm'},
          {data: 'leadtime'},
      ]
    });

    $('#form-report-master-freight-cost').validate({
      submitHandler: function (form){
        dttable_report_master_freight_cost.ajax.reload(null, false)
      }
    })
  });

  $('#form-report-master-freight-cost [name="area"]').select2({
     placeholder: '-- Select Area --',
     allowClear: true,
     ajax: get_select2_ajax_options('/master-area/select2-area-only')
  });
</script>
@endpush