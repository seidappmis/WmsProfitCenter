<div class="row">
  <div class="col s12">
    <form id="form-add-manifest">
      <div class="row form-table">
        <h4 class="card-title">Filter</h4>
        <hr>
        <div class="input-field col s4 mr-2">
          <br>
          <label for="">Expedition Name</label>
          <br>
          <select name="expedition_code" id="filter_expedition_code" class="select2-data-ajax browser-default" required="">
          </select>
          <input type="hidden" name="expedition_name">
        </div>
        <div class="input-field col s4">
          <br>
          <span for="">Manifest Date</span>
          <input type="text" id="filter_manifest_date" name="invoice_receipt_date" autocomplete="off" class="monthpicker" value="{{!empty($invoiceReceiptHeader) ? date('m/Y',strtotime($invoiceReceiptHeader->invoice_receipt_date)) : date('m/Y')}}" required>
        </div>
      </div>
      <div class="row">
        <h4 class="card-title">Manifest</h4>
        <div class="section-data-tables">
          <table id="table-list-manifest" class="display" width="100%">
            <thead>
              <tr>
                <th data-priority="1" width="30px">NO.</th>
                <th>DO MANIFEST</th>
                <th>DO MANIFEST DATE</th>
                <th>VEHICLE NO</th>
                <th>VEHICLE</th>
                <th>DESTINATION</th>
                <th>COUNT OF DO</th>
                <th>SUM OF CBM</th>
                <th data-priority="1" class="datatable-checkbox-cell" width="30px">
                  <label>
                    <input type="checkbox" class="select-all" />
                    <span></span>
                  </label>
                </th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
        {!! get_button_save() !!}
        {!! get_button_cancel(url('receipt-invoice'), 'Back') !!}
      </div>
    </form>
  </div>
</div>


@push('script_css')
<link rel="stylesheet" href="{{ asset('vendors/datepicker/datepicker.css') }}">
@endpush

@push('vendor_js')
<script src="{{ asset('vendors/datepicker/datepicker.js') }}"></script>
@endpush

@push('script_js')
<script type="text/javascript">
  var dttable_manifest
  jQuery(document).ready(function($) {
    dttable_manifest = $('#table-list-manifest').DataTable({
      serverSide: true,
      scrollX: true,
      responsive: true,
      ajax: {
        url: '{{url("receipt-invoice/manifest")}}',
        type: 'GET',
        data: function(d) {
          d.search['value'] = $('#global_filter').val();
          d.expedition_code = $('#filter_expedition_code').val();
          d.manifest_date = $('#filter_manifest_date').val();
        }
      },
      order: [1, 'asc'],
      columns: [{
          data: 'DT_RowIndex',
          orderable: false,
          searchable: false,
          className: 'center-align'
        },
        {
          data: 'do_manifest_no'
        },
        {
          data: 'do_manifest_date'
        },
        {
          data: 'vehicle_number'
        },
        {
          data: 'vehicle_description'
        },
        {
          data: 'city_name'
        },
        {
          data: 'count_of_do'
        },
        {
          data: 'sum_of_cbm',
          className: 'center-align'
        },
        {
          data: 'DT_RowIndex',
          orderable: false,
          searchable: false,
          render: function(data, type, row) {
            if (type === 'display') {
              return '<label><input type="checkbox" value="" class="checkbox"><span></span></label>';
            }
            return data;
          },
          className: "datatable-checkbox-cell"
        },
      ]
    });

    set_datatables_checkbox('#table-list-manifest', dttable_manifest)

    $('.monthpicker').datepicker({
      format: 'mm/yyyy',
      autoHide: true
    });
    $('#filter_expedition_code').select2({
      placeholder: '-- Select Expedition --',
      ajax: get_select2_ajax_options('/master-expedition/select2-all-expedition')
    })
    $('#filter_expedition_code').change(function(event) {
      /* Act on the event */
      var data = $(this).select2('data')[0]
      $('#form-add-manifest [name="expedition_name"]').val(data.text)
    });

    $('.monthpicker').change(function(event) {
      /* Act on the event */
      dttable_manifest.ajax.reload(null, false)
    });
    $('#filter_expedition_code').change(function(event) {
      /* Act on the event */
      dttable_manifest.ajax.reload(null, false)
    });

  });
</script>
@endpush