<!DOCTYPE html>
<html>
<head>
  <title></title>
  <style type="text/css">
    table {
      font-family: courier New;
      font-size: 10pt;
    }
    .border-bottom {
      border: 1pt none Black;
      border-bottom: 1pt solid Black;
    }
    .border-top {
      border-top: 1pt solid Black;
    }
    .title {
      font-size: 12pt;
      font-weight: 700;
    }
  </style>
</head>
<body>
<table>
  <tr>
    <td style="text-align: center;">
      <div class="title">PICKING LIST</div>
    </td>
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
                <td style="text-align: center;">{{$detail->quantity}}</td>
                <td style="text-align: center;">{{$detail->cbm}}</td>
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
        <tr><td class="border-top" colspan="6">&nbsp;</td></tr>
        <tr>
          <td style="width: 50mm;">PICKED BY</td>
          <td class="border-bottom">&nbsp;&nbsp;&nbsp;</td>
          <td>GRAND TOTAL</td>
          <td>{{$total_quantity}}</td>
          <td>{{$total_cbm}}</td>
        </tr>
        <tr>
          <td>PACKED BY</td>
          <td class="border-bottom">&nbsp;&nbsp;&nbsp;</td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td>CHECKED BY</td>
          <td class="border-bottom">&nbsp;&nbsp;&nbsp;</td>
          <td>SIGN</td>
          <td class="border-bottom">&nbsp;&nbsp;&nbsp;</td>
          <td>SIGNATURE</td>
          <td class="border-bottom">&nbsp;&nbsp;&nbsp;</td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>