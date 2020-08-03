@extends('layouts.materialize.index')
{{-- @include('admin.materi.modal_form_materi') --}}

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6 l6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Report Master Users</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Report Master Users</li>
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
                      <input type="text" placeholder="Search" class="app-filter" id="report-user-filter">
                    </div>
                  </div>
                </div>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                  <div class="card-content">
                        <table id="data-table-report-master-user" class="display" width="100%">
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

  var table;

  jQuery(document).ready(function($) {
    table = $('#data-table-report-master-user').DataTable({
      serverSide: true,
      scrollX: true,
      dom: 'Brtip',
      pageLength: 1,
      scrollY: '60vh',
      buttons: [
              {
                  text: 'PDF',
                  action: function ( e, dt, node, config ) {
                      window.location.href = "{{url('report-master-users/export?file_type=pdf')}}" + '&area=' + $('#area_filter').val();
                  }
              },
               {
                  text: 'EXCEL',
                  action: function ( e, dt, node, config ) {
                      window.location.href = "{{url('report-master-users/export?file_type=xls')}}" + '&area=' + $('#area_filter').val();
                  }
              }
          ],
      ajax: {
          url: '{{ url('report-master-users') }}',
          type: 'GET',
          data: function(d) {
            d.area = $('#area_filter').val()
            d.search['value'] = $('#report-user-filter').val()
          }
      },
      columns: [
          {data: 'username', className: 'detail'},
      ]
    });

    $("#area_filter").on("change", function () {
      filterGlobal()
    });
     $("#report-user-filter").on("keyup click", function () {
      filterGlobal();
    });
  });
  function filterGlobal(){
    table.ajax.reload(null, false);
  }
</script>
@endpush