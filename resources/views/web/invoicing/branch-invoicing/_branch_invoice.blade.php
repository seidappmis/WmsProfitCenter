<div class="branch-invoice-wrapper hide">
  <h4 class="card-title">Branch Invoice</h4>
  <hr>
  {!! get_button_print('#', 'Print', 'btn-print mb-1') !!}
  <table id="table-branch-invoice">
    <thead>
      <tr>
        <th>NO.</th>
        <th>NO MANIFEST</th>
        <th>DO DATE</th>
        <th>DO NUMBER</th>
        <th>SHIP TO CODE</th>
        <th>SHIP TO DETAIL</th>
        <th>CITY</th>
        <th>MODEL</th>
        <th>QTY</th>
        <th>TOTAL CBM</th>
        <th>COST / CBM</th>
        <th>COST / COLLY(Ȼ)</th>
        <th>COST / TRIP (RIT)</th>
        <th>TOTAL COST</th>
        <th></th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @foreach($rs_freight_cost AS $key => $freight_cost)
      <tr>
        <td>{{$key+1}}</td>
        <td class="text-do_manifest_no">{{$freight_cost->do_manifest_no}}</td>
        <td>{{$freight_cost->do_manifest_date}}</td>
        <td class="text-delivery_no">{{$freight_cost->delivery_no}}</td>
        <td>{{$freight_cost->ship_to_code}}</td>
        <td>{{$freight_cost->ship_to}}</td>
        <td>{{$freight_cost->city_name}}</td>
        <td class="text-model">{{$freight_cost->model}}</td>
        <td>{{$freight_cost->quantity}}</td>
        <td>{{$freight_cost->cbm_total}}</td>
        <td><input type="number" min="0" name="cost_per_cbm" value="{{$freight_cost->cost_per_cbm}}"></td>
        <td><input type="number" min="0" name="cost_per_coli" value="{{$freight_cost->cost_per_coli}}"></td>
        <td><input type="number" min="0" name="cost_per_trip" value="{{$freight_cost->cost_per_trip}}"></td>
        <td class="text-cost_total">{{$freight_cost->cost_total}}</td>
        <td>{!! get_button_edit('#!', 'Update', 'btn-update') !!}</td>
        <td>{!! get_button_delete() !!}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

{{-- Load Modal Print --}}
@include('layouts.materialize.components.modal-print', [
  'title' => 'Print Branch Invoice',
  'url' => 'branch-invoicing/' . (!empty($group_id) ? $group_id : '') . '/export',
  'trigger' => '.btn-print'
  ])

@push('script_js')
<script type="text/javascript">
  jQuery(document).ready(function($) {
    @if($rs_freight_cost->count() > 0)
    $('.branch-invoice-wrapper').removeClass('hide')

    $('#table-branch-invoice .btn-update').click(function(event) {
      var tr = $(this).parent().parent()
      $.ajax({
        url: '{{url('branch-invoicing')}}',
        type: 'PUT',
        dataType: 'json',
        data: {
          do_manifest_no: $(tr).find('.text-do_manifest_no').text(),
          delivery_no: $(tr).find('.text-delivery_no').text(),
          model: $(tr).find('.text-model').text(),
          cost_per_cbm: $(tr).find('[name="cost_per_cbm"]').val(),
          cost_per_coli: $(tr).find('[name="cost_per_coli"]').val(),
          cost_per_trip: $(tr).find('[name="cost_per_trip"]').val()
        },
      })
      .done(function(result) {
        showSwalAutoClose('success', result.message)
        $(tr).find('.text-cost_total').text(result.data.cost_total)
        console.log("success");
      })
      .fail(function() {
        console.log("error");
      })
      .always(function() {
        console.log("complete");
      });
    });

    $('#table-branch-invoice .btn-delete').click(function(event) {
      /* Act on the event */
      var tr = $(this).parent().parent()
      $.ajax({
        url: '{{url('branch-invoicing')}}',
        type: 'DELETE',
        dataType: 'json',
        data: {
          do_manifest_no: $(tr).find('.text-do_manifest_no').text(),
          delivery_no: $(tr).find('.text-delivery_no').text(),
          model: $(tr).find('.text-model').text()
        },
      })
      .done(function() {
        $(tr).remove();
        dtdatatable_manifest.ajax.reload(null, false);
        console.log("success");
      })
      .fail(function() {
        console.log("error");
      })
      .always(function() {
        console.log("complete");
      });
      
    });
    @endif
  });
</script>
@endpush