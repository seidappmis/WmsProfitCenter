<div class="branch-invoice-wrapper hide">
  <h4 class="card-title">Branch Invoice</h4>
  <hr>
  {!! get_button_print('#', 'Print', 'btn-print mb-1') !!}
  <table>
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
        <td>{{$freight_cost->do_manifest_no}}</td>
        <td>{{$freight_cost->do_manifest_date}}</td>
        <td>{{$freight_cost->delivery_no}}</td>
        <td>{{$freight_cost->ship_to_code}}</td>
        <td>{{$freight_cost->ship_to}}</td>
        <td>{{$freight_cost->city_name}}</td>
        <td>{{$freight_cost->model}}</td>
        <td>{{$freight_cost->quantity}}</td>
        <td>{{$freight_cost->cbm_total}}</td>
        <td><input type="number" min="0" name="cost_per_cbm" value="{{$freight_cost->cost_per_cbm}}"></td>
        <td><input type="number" min="0" name="cost_per_coli" value="{{$freight_cost->cost_per_coli}}"></td>
        <td><input type="number" min="0" name="cost_per_trip" value="{{$freight_cost->cost_per_trip}}"></td>
        <td>{{$freight_cost->cost_total}}</td>
        <td></td>
        <td></td>
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
    @endif
  });
</script>
@endpush