@extends('layouts.materialize.index')

@section('content')
<div class="row">
    @component('layouts.materialize.components.title-wrapper')
    <div class="row">
        <div class="col s12 m12 mb-0">
            <h5 class="breadcrumbs-title mt-0 mb-0">
                <span>
                    Stock Take Compare SAP
                </span>
            </h5>
            <ol class="breadcrumbs mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ url('/') }}">
                        Home
                    </a>
                </li>
                <li class="breadcrumb-item active">
                    Stock Take Compare SAP
                </li>
            </ol>
        </div>
    </div>
    @endcomponent
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content">
                        <div class="row mb-5">
                            <div class="col s12 m2">
                                <p>
                                    Periode STO
                                </p>
                            </div>
                            <div class="col s12 m4">
                                <!---- Search ----->
                                <div class="app-wrapper">
                                    <div class="datatable-search">
                                        <select id="sto_id" name="sto_id">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col s12 m6">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12">
                              {!! get_button_view('#', 'Compare', 'btn-compare') !!}
                              {!! get_button_print('#', 'Print', 'btn-print hide') !!}
                            </div>
                        </div>
                        {{-- Load Modal Print --}}
                      @include('layouts.materialize.components.modal-print', [
                        'title' => 'Print',
                        'url' => 'stock-take-compare-sap/1/export',
                        'trigger' => '.btn-print'
                        ])
                        <div class="container">
                            <div class="section">
                                <div class="card">
                                    <div class="card-content p-0">
                                        <div class="section-data-tables">
                                            <table class="display" id="table-compare-sap" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th data-priority="1" width="30px">
                                                            NO.
                                                        </th>
                                                        <th>
                                                            Model
                                                        </th>
                                                        <th>
                                                            SAP
                                                        </th>
                                                        <th>
                                                            Input 1
                                                        </th>
                                                        <th>
                                                            Input 2
                                                        </th>
                                                        <th>
                                                            SAP vs Input 1
                                                        </th>
                                                        <th>
                                                            SAP vs Input 2
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
                        <div class="content-overlay">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script_js')
<script type="text/javascript">
    var dtdatatable

    jQuery(document).ready(function($) {
      dtdatatable = $('#table-compare-sap').DataTable({
        serverSide: true,
        scrollX: true,
        responsive: true,
        ajax: {
            url: '{{ url('stock-take-compare-sap') }}',
            type: 'GET',
            data: function(d) {
                d.sto_id = $('#sto_id').val()
              }
        },
        order: [1, 'asc'],
        columns: [
            {data: 'DT_RowIndex', orderable:false, searchable: false, className: 'center-align'},
            {data: 'material_no', name: 'material_no', className: 'detail'},
            {data: 'quantitySAP', name: 'quantitySAP', className: 'detail'},
            {data: 'quantity', name: 'quantity', className: 'detail'},
            {data: 'quantity2', name: 'quantity2', className: 'detail'},
            {data: 'sap_vs_input_1', name: 'sap_vs_input_1', className: 'detail'},
            {data: 'sap_vs_input_2', name: 'sap_vs_input_2', className: 'detail'},
        ]
      });
      $('.btn-compare').click(function(event) {
        /* Act on the event */
        dtdatatable.ajax.reload(null, false)
      });

      $('.btn-print').click(function(event) {
          /* Act on the event */
          initPrintPreviewPrint(
            '{{url("stock-take-compare-sap")}}' + '/' + $('#sto_id').val() + '/export'
          )
      });

      dtdatatable.on('draw', function (data) {
        if (dtdatatable.page.info().recordsDisplay > 0) {
          $('.btn-print').removeClass('hide')
        } else {
          $('.btn-print').addClass('hide')
        }
      });
    });
    $('#sto_id').select2({
       placeholder: '-- Select Schedule ID --',
       allowClear: true,
       ajax: get_select2_ajax_options('{{url('stock-take-schedule/select2-schedule')}}')
    });
</script>
@endpush
