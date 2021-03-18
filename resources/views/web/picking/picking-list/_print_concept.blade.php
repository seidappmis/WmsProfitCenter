<link rel="stylesheet" type="text/css" href="{{ url('materialize/css/custom/print-lanscape.css') }}">

<body style="font-family: courier New; font-size: 6pt; padding-top: 20mm;">
  <table width="100%" style="border-collapse: collapse; font-size: 6pt; margin-left: 5mm; margin-right: 5mm; margin-top: 20mm; margin-bottom: 20mm;">
    <thead>
      <tr><td colspan="4">&nbsp;</td></tr>
      <tr><td colspan="4">&nbsp;</td></tr>
      <tr>
        <td><strong>{{ date('d-M-y') }}</td>
        <td><strong>{{ $pickinglistHeader->picking_no }}</td>
        <td style="text-align: center;"><strong>{{ date('H:i') }}</td>
        <td colspan="7"></td>
      </tr>
      <tr>
        <td style="border: 1px solid #000;"><strong>INVOICENUMBER</td>
        <td style="border: 1px solid #000;"><strong>Destination</td>
        <td style="border: 1px solid #000;"><strong>Expedition</td>
        <td style="border: 1px solid #000;"><strong>Delivery No.</td>
        <td style="border: 1px solid #000;"><strong>MODEL</td>
        <td style="border: 1px solid #000;"><strong>Qty</td>
        <td style="border: 1px solid #000;"><strong>CBM</td>
        <td style="border: 1px solid #000;"><strong>CONSIGNEE(SHIP TO)</td>
        <td style="border: 1px solid #000;"><strong>DISTRICT(SHIP TO)</td>
        <td style="border: 1px solid #000;"><strong>STREET(SHIP TO)</td>
        <td style="border: 1px solid #000;"><strong>REMARKS</td>
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
        <td style="border: 1px solid #000;"><strong>{{$detail->invoice_no}}</td>
        <td style="border: 1px solid #000;"><strong>{{$pickinglistHeader->city_name}}</td>
        <td style="border: 1px solid #000;"><strong>{{$pickinglistHeader->expedition_name}}</td>
        <td style="border: 1px solid #000;"><strong>{{$detail->delivery_no}}</td>
        <td style="border: 1px solid #000; font-size: 8pt; font-weight: bold;"><strong>{{$detail->model}}</td>
        <td style="border: 1px solid #000; font-size: 8pt; font-weight: bold; text-align: right;"><strong>{{$detail->quantity}}</td>
        <td style="border: 1px solid #000; text-align: right;"><strong>{{$detail->cbm}}</td>
        <td style="border: 1px solid #000;"><strong>{{$detail->ship_to}}</td>
        <td style="border: 1px solid #000;"><strong>{{$detail->ship_to_district}}</td>
        <td style="border: 1px solid #000;"><strong>{{$detail->ship_to_street}}</td>
        <td style="border: 1px solid #000;"><strong>{{$detail->remarks}}</td>
      </tr>
      @endforeach
      <tr>
        <td colspan="5"></td>
        <td style="border: 1px solid #000; font-size: 8pt; font-weight: bold; text-align: right;"><strong>{{$total_quantity}}</td>
        <td style="border: 1px solid #000; font-size: 8pt; font-weight: bold; text-align: right;"><strong>{{$total_cbm}}</td>
        <td colspan="3"></td>
      </tr>
    </tbody>
  </table>
</body>