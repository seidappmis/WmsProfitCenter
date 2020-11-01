@extends('layouts.materialize.index')
{{-- @include('admin.materi.modal_form_materi') --}}

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Summary Freight Cost Report Per Region</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Summary Freight Cost Report Per Region</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content ">
                     <form class="form-table" id="form-summary-freight-cost">
                            <table>
                              <tr>
                                <td>Periode</td>
                                <td>
                                  <div class="input-field col s6">
                                    <div class="col s3 m2 label">
                                      From
                                    </div>
                                    <div class="col s9 m10">
                                      <input placeholder="" name="start_date" type="text" class="validate datepicker" readonly required>
                                    </div>
                                  </div>
                                  <div class="input-field col s6">
                                    <div class="col s3 m2 label">
                                      To
                                    </div>
                                    <div class="col s9 m10">
                                      <input placeholder="" name="end_date" type="text" class="validate datepicker" readonly required>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td>Region</td>
                                <td>
                                  <div class="input-field col s4">
                                    <select name="region" class="select2-data-ajax browser-default">
                                    </select>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td>Branch</td>
                                <td>
                                    <select name="branch" class="select2-data-ajax browser-default">
                                    </select>
                                  </td>
                              </tr>
                              <tr >
                                <td>Sales Code</td>
                                <td>
                                  <div class="input-field col s5">
                                    <select name="code_sales" class="select2-data-ajax browser-default">
                                      {{-- <option value="" disabled selected>-All-</option> --}}
                                      <option></option>
                                      <option value="BR">BR</option>
                                      <option value="DS">DS</option>
                                    </select>
                                  </div>
                                </td>
                              </tr>
                              
                              <tr >
                                <td>Destination</td>
                                <td>
                                  <div class="input-field col s5">
                                    <select name="city_code" class="select2-data-ajax browser-default">
                                    </select>
                                  </div>
                                </td>
                              </tr>
                             
                            </table>
                            <div class="input-field col s12">
                              <button type="submit" class="waves-effect waves-light indigo btn">Print</button>
                            </div>
                         </form>
                   </div>
                </div>
                <div class="card">
                  <div class="card-content p-0">
                      <form class="form-table">
                          <table id="tabel-freight-cost-report-per-region" class="display" width="100%">
                              <thead>
                                  <tr>
                                    <th>REGION</th>
                                    <th>BRANCH DESC</th>
                                    <th>SALES CODE</th>
                                    <th>MONT</th>
                                    <th>YEAR</th>
                                    <th>DESTINATION</th>
                                    <th>FREIGHT COST</th>
                                    <th>MULTI DROP</th>
                                    <th>UNLOADING</th>
                                    <th>OVERSTAY</th>
                                  </tr>
                              </thead>
                              <tbody>
                              </tbody>
                          </table>
                      </form>
                   </div>
               </div>
            </div>
        </div>
        <div class="content-overlay"></div>
    </div>
</div>
@endsection


@push('vendor_js')
<script src="{{ asset('materialize/vendors/jquery-validation/jquery.validate.min.js') }}">
</script>
@endpush


@push('script_js')
<script type="text/javascript">
  var dttable_summary_incoming_report;
  jQuery(document).ready(function($) {
    dttable_summary_incoming_report = $('#tabel-freight-cost-report-per-region').DataTable({
      serverSide: true,
      scrollX: true,
      dom: 'Brtip',
      scrollY: '60vh',
      buttons: [
        {
          text: 'PDF',
          action: function ( e, dt, node, config ) {
              window.location.href = "{{url('summary-freight-cost-report-per-region/export?file_type=pdf')}}" + '&' + $('#form-summary-freight-cost').serialize();
          }
        },
         {
          text: 'EXCEL',
          action: function ( e, dt, node, config ) {
              window.location.href = "{{url('summary-freight-cost-report-per-region/export?file_type=xls')}}" + '&' + $('#form-summary-freight-cost').serialize();
          }
        }
      ],
      ajax: {
          url: '{{ url('summary-freight-cost-report-per-region') }}',
          type: 'GET',
          data: function(d) {
            d.start_date = $('#form-summary-freight-cost [name="start_date"]').val();
            d.end_date = $('#form-summary-freight-cost [name="end_date"]').val();
            d.region = $('#form-summary-freight-cost [name="region"]').val();
            d.city_code = $('#form-summary-freight-cost [name="city_code"]').val();
            d.code_sales = $('#form-summary-freight-cost [name="code_sales"]').val();
            d.branch = $('#form-summary-freight-cost [name="branch"]').val();
          }
      },
      columns: [
          {data: 'region'},
          {data: 'branch_short_description'},
          {data: 'code_sales'},
          {data: 'bulan'},
          {data: 'tahun'},
          {data: 'destination'},
          {data: 'freight_cost', className: 'right-align'},
          {data: 'multi_drop', className: 'right-align'},
          {data: 'unloading', className: 'right-align'},
          {data: 'overstay', className: 'right-align'},
      ]
    });
  });

  $('#form-summary-freight-cost').validate({
    submitHandler: function(form){
      dttable_summary_incoming_report.ajax.reload(null, false)
    }
  })

  $('#form-summary-freight-cost [name="code_sales"]').select2({
        placeholder: '-- ALL --',
        allowClear: true,
  })
  $('#form-summary-freight-cost [name="branch"]').select2({
        placeholder: '-- Select Branch --',
        allowClear: true,
        ajax: get_select2_ajax_options('{{url('/master-cabang/select2-grant-cabang')}}')
  })
  $('#form-summary-freight-cost [name="region"]').select2({
        placeholder: '-- Select Region --',
        allowClear: true,
        ajax: get_select2_ajax_options('{{url('/region/select2-region')}}')
  })
  $('#form-summary-freight-cost [name="city_code"]').select2({
    placeholder: '-- Select Destination --',
    allowClear: true,
    // ajax: get_select2_ajax_options('{{url('/master-expedition/select2-expedition-destination-city')}}')
    ajax: get_select2_ajax_options('{{url('/destination-city/select2-destination-city')}}')
  })
</script>
@endpush