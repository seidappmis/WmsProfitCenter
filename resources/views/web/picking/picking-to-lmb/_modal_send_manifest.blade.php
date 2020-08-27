<h6>Set Loading Quantity</h6>
<div class="section-data-tables">
  <table id="item-split-detail-table" class="display form-table" width="100%">
      <thead>
          <tr>
            <th data-priority="1">NO.</th>
            <th>INVOICE NO</th>
            <th>DELIVERY NO</th>
            <th>MODEL</th>
            <th>QTY</th>
            <th>CODE SALES</th>
            <th>QTY LOADING</th>
            <th>ACT</th>
          </tr>
      </thead>
      <tbody>
        @php
        $allowSubmit = true;
        @endphp
        @foreach($pickingListDetail AS $key => $picking)
        <tr>
          <td>{{$key +1}}</td>
          <td>{{$picking->invoice_no}}</td>
          <td>{{$picking->delivery_no}}</td>
          <td>{{$picking->model}}</td>
          <td>{{$picking->quantity}}</td>
          <td>{{$picking->code_sales}}</td>
          <td>
            @php
            $qty_loading = empty($rsLoadingQuantity[$picking->invoice_no.$picking->delivery_no.$picking->model]) ? 0 :
             ($rsLoadingQuantity[$picking->invoice_no.$picking->delivery_no.$picking->model] >= 0 ? $rsLoadingQuantity[$picking->invoice_no.$picking->delivery_no.$picking->model] : 0);
            $rsLoadingQuantity[$picking->invoice_no.$picking->delivery_no.$picking->model] -= $picking->quantity;
            echo $qty_loading;
            @endphp
            <input type="hidden" name="picking_detail_id[]" value="{{$picking->id}}">
            <input type="hidden" name="picking_quantity[]" value="{{$picking->quantity}}">
            <input type="hidden" name="picking_quantity_loading[]" value="{{$qty_loading}}">
          </td>
          <td>
            @php
            if ($qty_loading == 0) {
              echo "DELETE IN PICKING";
            } elseif ($qty_loading < $picking->quantity && $lmbHeader->expedition_code == 'AS'){
              $allowSubmit = false;
              echo "QTY MUST BE SAME IN PICKING AND LMB";
            } elseif ($qty_loading < $picking->quantity) {
              echo "OVERLOAD";
            } elseif ($qty_loading == $picking->quantity) {
              echo "OK";
            }
            @endphp
          </td>
        </tr>
        @endforeach
      </tbody>
  </table>
</div>

@if($allowSubmit)
<button type="submit" class="modal-action waves-effect waves-light indigo btn-small mt-2">Submit</button>
@endif
<a href="#!" class="modal-action modal-close waves-effect waves-light indigo btn-small mt-2">Cancel</a>

@push('vendor_js')
<script src="{{ asset('materialize/vendors/jquery-validation/jquery.validate.min.js') }}">
</script>
@endpush

@push('script_js')
<script type="text/javascript">
 
</script>
@endpush