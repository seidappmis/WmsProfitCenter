<table>
  <tr>
    <td>Insurance Policy No</td>
    <td colspan="3">
      <input name="insurance_policy_no" type="text" class="validate" required>
    </td>
  </tr>
  <tr>
    <td>Damage Goods Report</td>
    <td colspan="3">
      <select name="dur_dgr_id" class="select2-data-ajax browser-default" required>
      </select>
    </td>
  </tr>
  <tr>
    <td>Vessel Name</td>
    <td colspan="3">
      <!-- <select name="vessel_name" class="select2-data-ajax browser-default" required>
         </select> -->
      <input name="vessel_name" type="text" readonly>
    </td>
  </tr>
  <tr>
    <td>Sailed On</td>
    <td colspan="3">
      <input type="text" name="sailed_on" required>
    </td>
  </tr>
  <tr>
    <td>Sailed Date</td>
    <td>
      <input type="text" name="sailed_date" class="datepicker" required>
    </td>
    <td>Arrived Date</td>
    <td>
      <input type="text" name="arrived_date" class="datepicker" required>
    </td>
  </tr>
  <tr>
    <td>Discharging Date</td>
    <td>
      <input type="text" name="discharging_date" class="datepicker" required>
    </td>
    <td>Delivery to the site </td>
    <td>
      <input type="text" name="delivery_date" class="datepicker" required>
    </td>
  </tr>
  <tr>
    <td>Cargo Description </td>
    <td colspan="3">
      <textarea class="materialize-textarea" name="cargo_description"
        style="resize: vertical;min-height:100px;"></textarea>
    </td>
  </tr>
  <tr>
    <td>Quantity</td>
    <td colspan="3">
      <input type="number" name="qty">
    </td>
  </tr>
  <tr>
    <td>Currency</td>
    <td colspan="3">
      <input type="text" name="currency">
    </td>
  </tr>
</table>

<div class="card mb-0">
  <div class="card-content p-0">
    <ul class="collapsible m-0">
      <li class="active">
        <div class="collapsible-header p-0">
          <div class="collapsible-main-header">
            <i class="material-icons expand">expand_less</i>
            <span>Unit Damage Detail Price</span>
          </div>
        </div>
        <div class="collapsible-body p-0">
          <div class="section-data-tables">
            <table id="table-unit-damage-price" class="display" width="100%">
              <thead>
                <tr>
                  <th data-priority="1" width="30px">No.</th>
                  <th>MODEL NAME</th>
                  <th>PRICE (USD)</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </li>
    </ul>
  </div>
</div>

@push('script_js')
  <script type="text/javascript">
    $(document).ready(function($) {
      $('[name="dur_dgr_id"]').select2({
        placeholder: '-- Select Damage Goods Report --',
        ajax: get_select2_ajax_options('/marine-cargo/select2-dgr')
      });
      // $('[name="vessel_name"]').select2({
      //    placeholder: '-- Select Vessel --',
      //    ajax: get_select2_ajax_options('/berita-acara-during-select2-kapal')
      // });
    });

    $('[name="dur_dgr_id"]').change(function() {
      var data = $(this).select2('data')[0];

      $('[name="vessel_name"]').val('');
      if (data.ship_name) {
        $('[name="vessel_name"]').val(data.ship_name)
      }

      reloadTabel(data.id);
    });

    var tbDamagePriceUnit;

    function reloadTabel(id) {
      if (tbDamagePriceUnit == null) {
        tbDamagePriceUnit = $("#table-unit-damage-price").DataTable({
          paging: false,
          serverSide: true,
          ajax: {
            url: '{{ url('/marine-cargo/get-detail-damage-unit') }}/' + id,
            type: 'GET'
          },
          columns: [{
              data: 'DT_RowIndex',
              orderable: false,
              searchable: false,
              className: 'center-align'
            },
            {
              data: 'model_name',
              name: 'dgr_no',
            },
            {
              data: 'price',
              render: function(data, type, row, meta) {
                return '<input name="price[' + row['id'] + ']" id="price_' + row['id'] + '" value="' + (data ?
                  data : 0) + '" />';
              }
            }
          ],
        });
      } else {
        tbDamagePriceUnit.ajax.url('{{ url('/marine-cargo/get-detail-damage-unit') }}/' + id).load();
      }
    }

  </script>
@endpush
