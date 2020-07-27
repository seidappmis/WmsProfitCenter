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
        @foreach($rs_loading_quantity AS $key => $loading)
        <tr>
          <td>{{$key +1}}</td>
          <td>{{$loading->invoice_no}}</td>
          <td>{{$loading->delivery_no}}</td>
          <td>{{$loading->model}}</td>
          <td>{{$loading->quantity}}</td>
          <td>{{$loading->code_sales}}</td>
          <td>{{$loading->qty_loading}}</td>
          <td>
            @php
            if ($loading->quantity_loading < $loading->quantity) {
              echo "OVERLOAD";
            } elseif ($loading->quantity_loading < $loading->quantity && $lmbHeader->expedition_code != 'AS') {
              echo "OK";
            } elseif ($loading->quantity_loading < $loading->quantity && $lmbHeader->expedition_code == 'AS'){
              $allowSubmit = false;
              echo "QTY MUST BE SAME IN PICKING AND LMB";
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