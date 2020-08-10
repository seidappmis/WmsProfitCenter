<style type="text/css">
  @font-face {
    font-family: CCode39;
    src: url(/fonts/ConnectCode39.ttf);
  }
  body {
      background-color: #fff;
  }
  .title {
      font-size: 12pt;
      font-weight: 700;
  }
  .barcode {
    font-family: CCode39;
    font-size: 11pt;
  }
</style>

<table style="font-family: courier New; font-size: 10pt;">
  <tr>
    <td>
      <table style="width: 210.0003mm;">
        <tr>
          <td>
            <table width="100%">
              <tr><td></td></tr>
              <tr><td></td></tr>
              <tr><td style="height: 2px;"></td></tr>
              <tr>
                <td style="text-align: center; font-size: 12pt;" colspan="7"><strong>PICKING LIST</strong></td>
              </tr>
              <tr>
                <td></td>
              </tr>
              <tr>
                <td style="text-align: right;">DATE OF DESPATCH :</td>
                <td>{{ date('d/m/Y', strtotime($pickinglistHeader->picking_date)) }}</td>
                <td></td>
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
                <td></td>
                <td style="text-align: right;">SHIPMENT NO :</td>
                <td>1130110259</td>
              </tr>
              <tr>
                <td style="text-align: right;">CUSTOMER :</td>
                <td></td>
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
                <td></td>
                <td style="text-align: right;">ORDER NO :</td>
                <td><strong>{{$pickinglistHeader->picking_no}}</strong></td>
              </tr>
              <tr>
                <td colspan="5"></td>
                <td style="text-align: center;" colspan="2"><div class="barcode">*{{$pickinglistHeader->picking_no}}*</div></td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td>
            <table width="100%">
              <tr><td colspan="7" style="border-bottom: 1pt solid #000000;">&nbsp;</td></tr>
              <tr>
                <td style="text-align: center; border-bottom: 1pt solid #000000;" colspan="3">MODEL NAME</td>
                <td style="text-align: center; border-bottom: 1pt solid #000000;" colspan="2">EAN CODE</td>
                <td style="text-align: center; border-bottom: 1pt solid #000000;">QUANTITY</td>
                <td style="text-align: center; border-bottom: 1pt solid #000000;">CBM</td>
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
                <td style="text-align: center;" colspan="2">{{$detail->ean_code}}</td>
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
        <tr><td style="border-top: 1pt solid #000000;" colspan="7">&nbsp;</td></tr>
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
          <td style="width: 32mm; border-bottom: 1px solid #000000;">&nbsp;&nbsp;&nbsp;</td>
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
          <td style="width: 32mm; border-bottom: 1px solid #000000;">&nbsp;&nbsp;&nbsp;</td>
        </tr>
        <tr>
          <td rowspan="2">CHECKED BY</td>
          <td></td>
          <td style="width: 10mm; padding-left: 5mm;" rowspan="2">SIGN</td>
          <td></td>
          <td style="width: 20mm;">SIGNATURE</td>
          <td style="border-bottom: 1px solid #000000;" colspan="2">&nbsp;&nbsp;&nbsp;</td>
        </tr>
        <tr>
          <td style="width: 32mm; border-bottom: 1px solid #000000;">&nbsp;&nbsp;&nbsp;</td>
        </tr>
        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td style="width: 40mm; border-bottom: 1px solid #000000;">&nbsp;&nbsp;&nbsp;</td>
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