<!DOCTYPE html>
<html>
<head>
  <title></title>
  <link rel="stylesheet" type="text/css" href="{{ url('materialize/css/custom/print.css') }}">
</head>
<body>
<table>
  <tr>
    <td style="text-align: center;">
      <div class="title">PICKING LIST</div>
    </td>
    <td style="height: 10mm;">&nbsp;</td>
  </tr>
  <tr>
    <td>
      <table style="width: 210.0003mm;">
        <tr>
          <td>
            <table width="100%">
              <tr>
                <td style="text-align: right;">DATE OF DESPATCH :</td>
                <td>{{ date('d/m/Y', strtotime($pickinglistHeader->picking_date)) }}</td>
                <td></td>
                <td></td>
                <td style="text-align: right;">DATE :</td>
                <td>{{ date('d/m/Y', strtotime($pickinglistHeader->picking_date)) }}</td>
              </tr>
              <tr>
                <td style="text-align: right;">SHARP WAREHOUSE :</td>
                <td>SEID W/H JKT</td>
                <td></td>
                <td></td>
                <td style="text-align: right;">SHIPMENT NO :</td>
                <td>1130110259</td>
              </tr>
              <tr>
                <td style="text-align: right;">CUSTOMER :</td>
                <td></td>
                <td></td>
                <td></td>
                <td style="text-align: right;">GATE# :</td>
                <td>0</td>
              </tr>
              <tr>
                <td style="text-align: right;">SHIP TO :</td>
                <td>{{$pickinglistHeader->city_name}}</td>
                <td></td>
                <td></td>
                <td style="text-align: right;">ORDER NO :</td>
                <td><strong>{{$pickinglistHeader->picking_no}}</strong></td>
              </tr>
              <tr>
                <td colspan="4"></td>
                <td style="text-align: center;" colspan="2"><div class="barcode">{{$pickinglistHeader->picking_no}}</div></td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td>
            <table width="100%">
              <tr><td colspan="6" class="border-bottom">&nbsp;</td></tr>
              <tr>
                <td class="border-bottom" style="text-align: center;" colspan="3">MODEL NAME</td>
                <td class="border-bottom" style="text-align: center;">EAN CODE</td>
                <td class="border-bottom" style="text-align: center;">QUANTITY</td>
                <td class="border-bottom" style="text-align: center;">CBM</td>
              </tr>

              @php
              $total_quantity = 0;
              $total_cbm = 0;
              @endphp

              @foreach($pickinglistHeader->details AS $key => $detail)
              @php
              $total_quantity += $detail->quantity;
              $total_cbm += $detail->cbm;
              @endphp
              <tr>
                <td style="text-align: center;" colspan="3">{{$detail->model}}</td>
                <td style="text-align: center;">{{$detail->ean_code}}</td>
                <td style="text-align: center; width: 30mm;">{{$detail->quantity}}</td>
                <td style="text-align: center; width: 30mm;">{{$detail->cbm}}</td>
              </tr>
              @endforeach
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td>
      <table style="width: 210.0003mm;">
        <tr><td class="border-top" colspan="7">&nbsp;</td></tr>
        <tr>
          <td style="width: 30mm;">PICKED BY</td>
          <td></td>
          <td></td>
          <td colspan="2">GRAND TOTAL</td>
          <td style="text-align: center; width: 30mm;">{{$total_quantity}}</td>
          <td style="text-align: center; width: 30mm;">{{$total_cbm}}</td>
        </tr>
        <tr>
          <td></td>
          <td class="border-bottom" style="width: 32mm;">&nbsp;&nbsp;&nbsp;</td>
        </tr>
        <tr>
          <td rowspan="2">PACKED BY</td>
          <td>&nbsp;</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td class="border-bottom" style="width: 32mm;">&nbsp;&nbsp;&nbsp;</td>
        </tr>
        <tr>
          <td rowspan="2">CHECKED BY</td>
          <td></td>
          <td style="width: 10mm; padding-left: 5mm;" rowspan="2">SIGN</td>
          <td></td>
          <td style="width: 20mm;">SIGNATURE</td>
          <td class="border-bottom" colspan="2">&nbsp;&nbsp;&nbsp;</td>
        </tr>
        <tr>
          <td class="border-bottom" style="width: 32mm;">&nbsp;&nbsp;&nbsp;</td>
        </tr>
        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td class="border-bottom" style="width: 40mm;">&nbsp;&nbsp;&nbsp;</td>
          <td>OP.CODE</td>
        </tr>
        <tr>
          <td colspan="5"></td>
          <td style="text-align: center;">KOR</td>
          <td style="text-align: center;">VERIFIED</td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>