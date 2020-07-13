@extends('layouts.materialize.index')
{{-- @include('admin.materi.modal_form_materi') --}}

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6 l6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Standby Driver List</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Standby Driver List</li>
                </ol>
            </div>
            <div class="col s12 m3 l3">
              <div class="app-wrapper">
                  <div class="datatable-search">
                    <select id="area_filter"  class="select2-data-ajax browser-default app-filter">
                    </select>
                  </div>
                </div>
            </div>
            <div class="col s12 m3 l3">
              <div class="app-wrapper">
                  <div class="datatable-search">
                    <div class="datatable-search mb-0">
                      <i class="material-icons mr-2 search-icon">search</i>
                      <input type="text" placeholder="Search" class="app-filter" id="transporter_filter">
                    </div>
                  </div>
                </div>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
              <d{{-- iv class="card ">
                <div class="card-content">
                    <form class="form-table">
                        <table>
                          <tr>
                            <td>Area</td>
                            <td>
                              <div class="input-field col s12">
                                <select class="select2 browser-default">
                                  <option>- Select Area -</option>
                                  <option>ALL</option>
                                  <option>KARAWANG</option>
                                  <option>SURABAYA HUB</option>
                                  <option>SWADAYA</option>
                                  
                                </select>
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
              </div --}}>
              <div class="card ">
                <div class="card-content p-0">
                  <div class="section-data-tables">
                      <table id="data-table-transporter-list" class="display" width="100%">
                        <thead>
                            <tr>
                              <th width="30px">NO</th>
                              <th>VEHICLE NUMBER</th>
                              <th>DRIVER ID</th>
                              <th>DRIVER NAME</th>
                              <th>VEHICLE DESCRIPTION</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
              </div>
              </div>
            </div>
        </div>
        <div class="content-overlay"></div>
    </div>
</div>
@endsection

@push('script_js')
<script type="text/javascript">
  $('#area_filter').select2({
     placeholder: '-- Select Area --',
     allowClear: true,
     ajax: get_select2_ajax_options('/master-area/select2-area-only')
  });
  @if (auth()->user()->area != 'All')
    set_select2_value('#area_filter', '{{auth()->user()->area}}', '{{auth()->user()->area}}')
    $('#area_filter').attr('disabled','disabled')
  @endif
  var dt_table_transporter;
  jQuery(document).ready(function($) {
     dt_table_transporter = $('#data-table-transporter-list').DataTable({
      serverSide: true,
      scrollX: true,
      responsive: true,
      ajax: {
          url: '{{ url('picking-list/get-transporter-list') }}',
          type: 'GET',
          data: function(d) {
              d.search['value'] = $('#transporter_filter').val(),
              d.area = $('#area_filter').val()
            }
      },
      order: [1, 'asc'],
      columns: [
          {data: 'DT_RowIndex', orderable:false, searchable: false, className: 'center-align'},
          {data: 'vehicle_number', name: 'vehicle_number', className: 'detail'},
          {data: 'driver_id', name: 'driver_id', className: 'detail'},
          {data: 'driver_name', name: 'driver_name', className: 'detail'},
          {data: 'vehicle_description', name: 'vehicle_description', className: 'detail'},
      ]
    });

     $('#area_filter').change(function(event) {
      /* Act on the event */
      dt_table_transporter.ajax.reload(null, false);  // (null, false) => user paging is not reset on reload
    });

    $("input#transporter_filter").on("keyup click", function () {
      filterGlobal();
    });

    });
  function filterGlobal() {
      dt_table_transporter.search($("#transporter_filter").val(), $("#global_regex").prop("checked"), $("#global_smart").prop("checked")).draw();
  }
</script>
@endpush
