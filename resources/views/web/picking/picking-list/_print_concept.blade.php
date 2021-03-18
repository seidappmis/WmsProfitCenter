<link rel="stylesheet" type="text/css" href="{{ url('materialize/css/custom/print-lanscape.css') }}">

<body style="font-family: courier New; font-size: 6pt; padding-top: 20mm;">
  <table width="100%" style="border-collapse: collapse; font-size: 6pt; margin-left: 5mm; margin-right: 5mm; margin-top: 20mm; margin-bottom: 20mm;">
    <thead>
      <tr><td colspan="4">&nbsp;</td></tr>
      <tr><td colspan="4">&nbsp;</td></tr>
      <tr>
        <td><strong>{{ date('d-M-y') }}</strong></td>
        <td><strong>{{ $pickinglistHeader->picking_no }}</strong></td>
        <td style="text-align: center;"><strong>{{ date('H:i') }}</strong></td>
        <td colspan="7"></td>
      </tr>
      <tr>
        <td style="border: 1px solid #000;"><strong>INVOICENUMBER</strong></td>
        <td style="border: 1px solid #000;"><strong>Destination</strong></td>
        <td style="border: 1px solid #000;"><strong>Expedition</strong></td>
        <td style="border: 1px solid #000;"><strong>Delivery No.</strong></td>
        <td style="border: 1px solid #000;"><strong>MODEL</strong></td>
        <td style="border: 1px solid #000;"><strong>Qty</strong></td>
        <td style="border: 1px solid #000;"><strong>CBM</strong></td>
        <td style="border: 1px solid #000;"><strong>CONSIGNEE(SHIP TO)</strong></td>
        <td style="border: 1px solid #000;"><strong>DISTRICT(SHIP TO)</strong></td>
        <td style="border: 1px solid #000;"><strong>STREET(SHIP TO)</strong></td>
        <td style="border: 1px solid #000;"><strong>REMARKS</strong></td>
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
        <td style="border: 1px solid #000;"><strong>{{$detail->invoice_no}}</strong></td>
        <td style="border: 1px solid #000;"><strong>{{$pickinglistHeader->city_name}}</strong></td>
        <td style="border: 1px solid #000;"><strong>{{$pickinglistHeader->expedition_name}}</strong></td>
        <td style="border: 1px solid #000;"><strong>{{$detail->delivery_no}}</strong></td>
        <td style="border: 1px solid #000; font-size: 8pt; font-weight: bold;"><strong>{{$detail->model}}</strong></td>
        <td style="border: 1px solid #000; font-size: 8pt; font-weight: bold; text-align: right;"><strong>{{$detail->quantity}}</strong></td>
        <td style="border: 1px solid #000; text-align: right;"><strong>{{$detail->cbm}}</strong></td>
        <td style="border: 1px solid #000;"><strong>{{$detail->ship_to}}</strong></td>
        <td style="border: 1px solid #000;"><strong>{{$detail->ship_to_district}}</strong></td>
        <td style="border: 1px solid #000;"><strong>{{$detail->ship_to_street}}</strong></td>
        <td style="border: 1px solid #000;"><strong>{{$detail->remarks}}</strong></td>
      </tr>
      @endforeach
      <tr>
        <td colspan="5"></td>
        <td style="border: 1px solid #000; font-size: 8pt; font-weight: bold; text-align: right;"><strong>{{$total_quantity}}</strong></td>
        <td style="border: 1px solid #000; font-size: 8pt; font-weight: bold; text-align: right;"><strong>{{$total_cbm}}</strong></td>
        <td colspan="3"></td>
      </tr>
    </tbody>
  </table>
</body>