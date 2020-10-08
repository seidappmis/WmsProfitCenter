<link rel="stylesheet" type="text/css" href="{{ url('materialize/css/custom/print1.css') }}">
{{-- @include('layouts.materialize.components.print-style') --}}

@php
$shipment_no = '';
$rs_shipment_no = [];
foreach ($pickinglistHeader->details as $key => $value) {
  $rs_shipment_no[$value->invoice_no] = $value->invoice_no;
}
foreach ($rs_shipment_no as $key => $value) {
  $shipment_no .= !empty($shipment_no) ? '<br>' : '';
  $shipment_no .= $value;
}
@endphp

<table style="font-family: courier New; font-size: 10pt;">
  <tr>
    <td>
      <table style="font-family: courier New; font-size: 10pt; width: 210.0003mm;">
        <tr>
          <td>
            <table width="100%">
              <tr><td>&nbsp;</td></tr>
              <tr><td>&nbsp;</td></tr>
              <tr><td style="height: 2px;"></td></tr>
              <tr>
                <td style="text-align: center; font-size: 12pt;" colspan="7"><strong>PICKING LIST</strong></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td style="text-align: right;">DATE OF DESPATCH :</td>
                <td>{{ date('d/m/Y', strtotime($pickinglistHeader->picking_date)) }}</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td style="text-align: right;">DATE :</td>
                <td>{{ date('d/m/Y', strtotime($pickinglistHeader->picking_date)) }}</td>
              </tr>
              <tr>
                <td style="text-align: right;">SHARP WAREHOUSE :</td>
                <td>SEID W/H {{auth()->user()->cabang->hq ? auth()->user()->area_data->code : auth()->user()->cabang->short_description}}</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td style="text-align: right;">SHIPMENT NO :</td>
                <td style="text-align: left;">{!!$shipment_no!!}</td>
              </tr>
              <tr>
                <td style="text-align: right;">CUSTOMER :</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td style="text-align: right;">GATE# :</td>
                <td style="text-align: left;">{{$pickinglistHeader->gate_number}}</td>
              </tr>
              <tr>
                <td style="text-align: right;">SHIP TO :</td>
                <td>{{$pickinglistHeader->city_name}}</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td style="text-align: right;">ORDER NO :</td>
                <td><strong>{{$pickinglistHeader->picking_no}}</strong></td>
              </tr>
              <tr>
                <td colspan="5"></td>
                <td style="text-align: center;" colspan="2">
                  {{-- <div class="barcode">*{{$pickinglistHeader->picking_no}}*</div> --}}
                  @php
                  $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
                  if ($excel != 1){
                    echo '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($pickinglistHeader->picking_no, $generator::TYPE_CODE_39)) . '" style="width: 230px; height: 35px;">';

                  }
                  @endphp
                </td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td>
            <table width="100%">

              {{-- Judul Tabel --}}
              <tr><td colspan="7" style="border-bottom: 1pt solid #000000;">&nbsp;</td></tr>
              <tr>
                <td style="text-align: center;  width: 85mm;" >MODEL NAME</td>
                <td>&nbsp;</td>
                <td style="text-align: center;  width: 50mm;" >EAN CODE</td>
                <td>&nbsp;</td>
                <td style="text-align: center;  width: 30mm;">QUANTITY</td>
                <td>&nbsp;</td>
                <td style="text-align: center;  width: 30mm;">CBM</td>
              </tr>
              <tr>
                <td colspan="7" style="border-top: 1pt solid #000000; height: 2px;"></td>
              </tr>
              {{-- AKHIR Judul Tabel --}}

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
                <td style="text-align: center;" >{{$detail->model}}</td>
                <td>&nbsp;</td>
                <td style="text-align: center;" >{{$detail->ean_code}}</td>
                <td>&nbsp;</td>
                <td style="text-align: center;">{{$detail->quantity}}</td>
                <td>&nbsp;</td>
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
      <footer>
        <table style="width: 210.0003mm;">
          <tr><td style="border-top: 1pt solid #000000;" colspan="7">&nbsp;</td></tr>
          <tr>
            <td style="width: 30mm;">PICKED BY</td>
            <td>&nbsp;</td>
            <td colspan="2">GRAND TOTAL</td>
            <td style="text-align: center; width: 30mm;">{{$total_quantity}}</td>
            <td>&nbsp;</td>
            <td style="text-align: center; width: 30mm;">{{$total_cbm}}</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td style="width: 32mm; border-bottom: 1px solid #000000;">&nbsp;&nbsp;&nbsp;</td>
          </tr>
          <tr>
            <td rowspan="2">PACKED BY</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td style="width: 32mm; border-bottom: 1px solid #000000;">&nbsp;&nbsp;&nbsp;</td>
          </tr>
          <tr>
            <td rowspan="2">CHECKED BY</td>
            <td>&nbsp;</td>
            <td style="width: 10mm; padding-left: 5mm;" rowspan="2">SIGN</td>
            <td>&nbsp;</td>
            <td style="width: 20mm;">SIGNATURE</td>
            <td style="border-bottom: 1px solid #000000;" colspan="2">&nbsp;&nbsp;&nbsp;</td>
          </tr>
          <tr>
            <td style="width: 32mm; border-bottom: 1px solid #000000;">&nbsp;&nbsp;&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="width: 40mm; border-bottom: 1px solid #000000;">&nbsp;&nbsp;&nbsp;</td>
            <td>OP.CODE</td>
          </tr>
          <tr>
            <td colspan="5"></td>
            <td style="text-align: center;">KOR</td>
            <td style="text-align: center;">VERIFIED</td>
          </tr>
        </table>
      </footer>
    </td>
  </tr>
</table>
<footer>
