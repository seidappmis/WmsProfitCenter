@extends('layouts.materialize.index')

@section('content')
<div class="row">

  @component('layouts.materialize.components.title-wrapper')
      <div class="row">
          <div class="col s12 m5">
              <h5 class="breadcrumbs-title mt-0 mb-0"><span>Overload Concept or DO</span></h5>
              <ol class="breadcrumbs mb-0">
                  <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                  <li class="breadcrumb-item active">Overload Concept or DO</li>
              </ol>
          </div>
          <div class="col s12 m3">
            <!---- Search ----->
                <div class="app-wrapper">
                  <div class="datatable-search">
                    <select id="area_filter">
                    </select>
                  </div>
                </div>
          </div>
          <div class="col s12 m4">
              <div class="display-flex">
                <!---- Search ----->
                <div class="app-wrapper mr-2">
                  <div class="datatable-search">
                    <i class="material-icons mr-2 search-icon">search</i>
                    <input type="text" placeholder="Search" class="app-filter" id="global_filter">
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
                    <div class="card-content p-0">
                        <div class="section-data-tables"> 
                          <table id="overload-concept-or-do-table" class="display" width="100%">
                              <thead>
                                  <tr>
                                    <th data-priority="1" width="30px">No.</th>
                                    <th>SHIPMENT NO</th>
                                    <th>LINE NO</th>
                                    <th>DELIVERY NO</th>
                                    <th>DELIVERY ITEMS</th>
                                    <th>QUANTITY</th>
                                    <th>MODEL</th>
                                    <th>CBM</th>
                                    <th>DESCRIPTION</th>
                                    <th>OVERLOAD DATE</th>
                                  </tr>
                              </thead>
                              <tbody>
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

@push('script_js')
<script type="text/javascript">
    var dttable_overload_concept_or_do;
    $('#area_filter').select2({
     placeholder: '-- Select Area --',
     allowClear: true,
     ajax: get_select2_ajax_options('{{url('/master-area/select2-area-only')}}')
  });
    jQuery(document).ready(function($) {
      
      @if (auth()->user()->area != 'All')
        set_select2_value('#area_filter', '{{auth()->user()->area}}', '{{auth()->user()->area}}')
        $('#area_filter').attr('disabled','disabled')
      @endif
      
      dttable_overload_concept_or_do = $('#overload-concept-or-do-table').DataTable({
          serverSide: true,
          scrollX: true,
          responsive: true,
          ajax: {
              url: "{{url('overload-concept-or-do')}}",
              type: 'GET',
              data: function(d) {
                  d.search['value'] = $('#global_filter').val()
                  d.area = $('#area_filter').val()
              }
          },
          order: [1, 'asc'],
          columns: [
              { data: 'DT_RowIndex', orderable:false, searchable: false, className: 'center-align'},
              { data: 'invoice_no', name: 'invoice_no', className: 'detail' },
              { data: 'line_no', name: 'line_no', className: 'detail' },
              { data: 'delivery_no', name: 'delivery_no', className: 'detail' },
              { data: 'delivery_items', name: 'delivery_items', className: 'detail' },
              { data: 'quantity', name: 'quantity', className: 'detail' },
              { data: 'model', name: 'model', className: 'detail' },
              { data: 'cbm', name: 'cbm', className: 'detail' },
              { data: 'overload_reason', name: 'overload_reason', className: 'detail' },
              { data: 'output_date', name: 'output_date', className: 'detail' },
          ]
      });

      $('#area_filter').change(function(event) {
        /* Act on the event */
        dttable_overload_concept_or_do.ajax.reload(null, false)
      });

      $("input#global_filter").on("keyup click", function () {
        filterGlobal();
      });
    });

    function filterGlobal() {
      dttable_overload_concept_or_do.search($("#global_filter").val(), $("#global_regex").prop("checked"), $("#global_smart").prop("checked")).draw();
  }
</script>
@endpush