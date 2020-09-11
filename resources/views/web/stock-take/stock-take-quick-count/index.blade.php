@extends('layouts.materialize.index')

@section('content')
<div class="row">

  @component('layouts.materialize.components.title-wrapper')
      <div class="row">
          <div class="col s12 m12 mb-0">
              <h5 class="breadcrumbs-title mt-0 mb-0"><span>Stock Take Quick Count</span></h5>
              <ol class="breadcrumbs mb-0">
                  <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                  <li class="breadcrumb-item active">Stock Take Quick Count</li>
              </ol>
          </div>
      </div>


  @endcomponent

  @include('web.stock-take.stock-take-quick-count._periode_filter')

    <div class="col s12">
        <div class="container quick-count-wrapper hide">
            <div class="section">
              <div class="card">
                <div class="card-content">
                <div class="row">
                    <div class="col s12 m6">
                      <h4 class="card-title">Only in Input 1</h4>
                      <hr>
                      <div class="section-data-tables">
                          <table class="display" id="table-only-input-1" width="100%">
                              <thead>
                                  <tr>
                                      <th data-priority="1" width="30px">No.</th>
                                      <th>No Tag</th>
                                      <th>Model</th>
                                      <th>Location</th>
                                      <th>Quantity</th>
                                  </tr>
                              </thead>
                              <tbody>
                              </tbody>
                          </table>
                      </div>
                      <!-- datatable ends -->
                    </div>
                    <div class="col s12 m6 mb-10">
                      <h4 class="card-title">Only in Input 2</h4>
                      <hr>
                      <div class="section-data-tables">
                          <table class="display" id="table-only-input-2" width="100%">
                              <thead>
                                  <tr>
                                      <th data-priority="1" width="30px">No.</th>
                                      <th>No Tag</th>
                                      <th>Model</th>
                                      <th>Location</th>
                                      <th>Quantity</th>
                                  </tr>
                              </thead>
                              <tbody>
                              </tbody>
                          </table>
                      </div>
                      <!-- datatable ends -->
                    </div>

                    <div class="col s12 mb-10">
                      <h4 class="card-title">Different Quantity</h4>
                      <hr>
                      <div class="section-data-tables">
                          <table class="display" id="table-different-in-quantity" width="100%">
                              <thead>
                                  <tr>
                                      <th data-priority="1" width="30px">No.</th>
                                      <th>No Tag</th>
                                      <th>Model</th>
                                      <th>Location</th>
                                      <th>Quantity</th>
                                      <th>No Tag</th>
                                      <th>Model</th>
                                      <th>Location</th>
                                      <th>Quantity</th>
                                  </tr>
                              </thead>
                              <tbody>
                              </tbody>
                          </table>
                      </div>
                      <!-- datatable ends -->
                    </div>
                </div>
                <div class="row">
                  <div class="col s12">
                  <form class="form-table" id="form-stock-take-summary">
                      <table>
                        <tr>
                          <td>Total All Tag no</td>
                          <td>
                            <div class="input-field col s12">
                              <input value="" id="atn" type="text" class="validate" name="total_all_tag_no" required>
                            </div>
                          </td>
                             <td>Total All Models</td>
                          <td>
                            <div class="input-field col s12">
                              <input value="" id="tam" type="text" class="validate" name="total_all_models" required>
                            </div>
                          </td>
                             <td>Total All Location</td>
                          <td>
                            <div class="input-field col s12">
                              <input value="" id="tal" type="text" class="validate" name="total_all_location" required>
                            </div>
                          </td>
                        </tr>

                        <tr>
                          <td colspan="2" >Summary tag Compared Match</td>
                          <td colspan="2">
                            <div class="input-field col s12">
                              <input value="" id="loca" type="text" class="validate" name="summary_tag_compared_matched" required>
                            </div>
                          </td>
                            <td>Diff Qty</td>
                          <td>
                            <div class="input-field col s12">
                              <input value="0" id="loca" type="text" class="validate" name="diff_qty" required>
                            </div>
                          </td>
                        </tr>

                        <tr>
                          <td colspan="2" >Only Input 1</td>
                          <td colspan="2">
                            <div class="input-field col s12">
                              <input value="" id="loca" type="text" class="validate" name="only_input_1" required>
                            </div>
                          </td>
                            <td>Only Input 2</td>
                          <td>
                            <div class="input-field col s12">
                              <input value="" id="loca" type="text" class="validate" name="only_input_2" required>
                            </div>
                          </td>
                        </tr>
                    </table>

                </form>
                  </div>

                </div>
              </div>
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
  $('#sto_id').select2({
       placeholder: '-- Select Schedule ID --',
       allowClear: true,
       ajax: get_select2_ajax_options('/stock-take-schedule/select2-schedule')
    });

  var dttable_input_1
  var dttable_input_2
  var dttable_different_quantity
  jQuery(document).ready(function($) {
    dttable_input_1 = $('#table-only-input-1').DataTable({
        serverSide: true,
        scrollX: true,
        responsive: true,
        ajax: {
            url: '{{ url('stock-take-input-1') }}',
            type: 'GET',
            data: function(d) {
                d.sto_id = $('#sto_id').val()
              }
        },
        order: [1, 'asc'],
        columns: [
            {data: 'DT_RowIndex', orderable:false, searchable: false, className: 'center-align'},
            {data: 'no_tag', name: 'no_tag', className: 'detail'},
            {data: 'model', name: 'model', className: 'detail'},
            {data: 'location', name: 'location', className: 'detail'},
            {data: 'quantity', name: 'quantity', className: 'detail'},
        ]
      });
    dttable_input_2 = $('#table-only-input-2').DataTable({
        serverSide: true,
        scrollX: true,
        responsive: true,
        ajax: {
            url: '{{ url('stock-take-input-2') }}',
            type: 'GET',
            data: function(d) {
                d.sto_id = $('#sto_id').val()
              }
        },
        order: [1, 'asc'],
        columns: [
            {data: 'DT_RowIndex', orderable:false, searchable: false, className: 'center-align'},
            {data: 'no_tag', name: 'no_tag', className: 'detail'},
            {data: 'model', name: 'model', className: 'detail'},
            {data: 'location', name: 'location', className: 'detail'},
            {data: 'quantity', name: 'quantity', className: 'detail'},
        ]
      });

    dttable_different_quantity = $('#table-different-in-quantity').DataTable({
        serverSide: true,
        scrollX: true,
        responsive: true,
        ajax: {
            url: '{{ url('stock-take-quick-count/different-quantity') }}',
            type: 'GET',
            data: function(d) {
                d.sto_id = $('#sto_id').val()
              }
        },
        order: [1, 'asc'],
        columns: [
            {data: 'DT_RowIndex', orderable:false, searchable: false, className: 'center-align'},
            {data: 'no_tag', name: 'no_tag', className: 'detail'},
            {data: 'model', name: 'model', className: 'detail'},
            {data: 'location', name: 'location', className: 'detail'},
            {data: 'quantity', name: 'quantity', className: 'detail'},
            {data: 'no_tag', name: 'no_tag', className: 'detail'},
            {data: 'model', name: 'model', className: 'detail'},
            {data: 'location', name: 'location', className: 'detail'},
            {data: 'quantity', name: 'quantity', className: 'detail'},
        ]
      });
  });
</script>
@endpush
