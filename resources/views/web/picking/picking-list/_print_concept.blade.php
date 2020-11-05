<link rel="stylesheet" type="text/css" href="{{ url('materialize/css/custom/print-lanscape.css') }}">

<body style="font-family: courier New; font-size: 9pt; width: 290mm;">
  <table width="100%" style="border-collapse: collapse; font-size: 9pt;">
    <thead>
      <tr>
        <td>{{ date('d-M-y') }}</td>
        <td>{{ $pickinglistHeader->picking_no }}</td>
        <td style="text-align: center;">{{ date('H:i') }}</td>
        <td colspan="7"></td>
      </tr>
      <tr>
        <td style="border: 1px solid #000;">INVOICENUMBER</td>
        <td style="border: 1px solid #000;">Destination</td>
        <td style="border: 1px solid #000;">Expedition</td>
        <td style="border: 1px solid #000;">Delivery No.</td>
        <td style="border: 1px solid #000;">MODEL</td>
        <td style="border: 1px solid #000;">Qty</td>
        <td style="border: 1px solid #000;">CBM</td>
        <td style="border: 1px solid #000;">CONSIGNEE(SHIP TO)</td>
        <td style="border: 1px solid #000;">DISTRICT(SHIP TO)</td>
        <td style="border: 1px solid #000;">STREET(SHIP TO)</td>
        <td style="border: 1px solid #000;">REMARKS</td>
      </tr>
    </thead>
    <tbody>
      @php
      $total_quantity = 0;
      $total_cbm = 0;
      @endphp
      @foreach($details AS $key => $detail)
      @php
      $total_quantity += $detail->quantity;
      $total_cbm += $detail->cbm;
      @endphp
      <tr>
        <td style="border: 1px solid #000;">{{$detail->invoice_no}}</td>
        <td style="border: 1px solid #000;">{{$pickinglistHeader->city_name}}</td>
        <td style="border: 1px solid #000;">{{$pickinglistHeader->expedition_name}}</td>
        <td style="border: 1px solid #000;">{{$detail->delivery_no}}</td>
        <td style="border: 1px solid #000;">{{$detail->model}}</td>
        <td style="border: 1px solid #000; text-align: right;">{{$detail->quantity}}</td>
        <td style="border: 1px solid #000; text-align: right;">{{$detail->cbm}}</td>
        <td style="border: 1px solid #000;">{{$detail->ship_to}}</td>
        <td style="border: 1px solid #000;">{{$detail->ship_to_district}}</td>
        <td style="border: 1px solid #000;">{{$detail->ship_to_street}}</td>
        <td style="border: 1px solid #000;">{{$detail->remarks}}</td>
      </tr>
      @endforeach
      <tr>
        <td colspan="5"></td>
        <td style="border: 1px solid #000; text-align: right;">{{$total_quantity}}</td>
        <td style="border: 1px solid #000; text-align: right;">{{$total_cbm}}</td>
        <td colspan="3"></td>
      </tr>
    </tbody>
  </table>
</body>