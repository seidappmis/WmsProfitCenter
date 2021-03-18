<link rel="stylesheet" type="text/css" href="{{ url('materialize/css/custom/print.css') }}">

<table style="font-family: courier New; font-size: 8pt;">
  <tr>
    <td>
      <table style="width: 210.0003mm;">
        <tr>
          <td>
            <table width="100%" style="font-family: courier New; font-size: 8pt;">
              <tr><td>&nbsp;</td></tr>
              <tr><td>&nbsp;</td></tr>
              {{-- <tr><td style="height: 2px;"></td></tr> --}}
              <tr>
                <td style="font-size: 10pt;" rowspan="2" colspan="10"><strong>PT. SHARP ELECTRONICS INDONESIA <br> WAREHOUSE RECEIPT</strong></td>
                <td style="font-size: 10pt; text-align: right;"><strong>{{$incomingManualHeader->inc_type}}</strong></td>
              </tr>
              <tr><td></td></tr>
              <tr><td>&nbsp;</td></tr>
              <tr>
                <td colspan="2" style="width: 30mm; font-color:solid black;"><strong>Arrival No.</td>
                <td style="width: 5mm;"><strong>:</td>
                <td colspan="4" style="width: 60mm;"><strong>{{$incomingManualHeader->arrival_no}}</td>
                <td colspan="2" style="width: 40mm;"><strong>Vendor Name</td>
                <td style="width: 5mm;"><strong>N:</td>
                <td><strong>{{$incomingManualHeader->vendor_name}}</td>
              </tr>
              <tr>
                <td colspan="2"><strong>PO</td>
                <td><strong>:</td>
                <td colspan="4"><strong>{{$incomingManualHeader->po}}</td>
                <td colspan="2"><strong>Actual Arrive Date</td>
                <td><strong>:</td>
                <td><strong>{{format_tanggal_wms($incomingManualHeader->actual_arrival_date)}}</td>
              </tr>
              <tr>
                <td colspan="2"><strong>Invoice No.</td>
                <td><strong>:</td>
                <td colspan="4"><strong>{{$incomingManualHeader->invoice_no}}</td>
                <td colspan="2"><strong>Expedition Name</td>
                <td><strong>:</td>
                <td><strong>{{$incomingManualHeader->expedition_name}}</td>
              </tr>
              <tr>
                <td colspan="2"><strong>No. GR SAP</td>
                <td><strong>:</td>
                <td colspan="4" style="text-align: left;"><strong>{{$incomingManualHeader->no_gr_sap}}</td>
                <td colspan="2"><strong>Container No.</td>
                <td><strong>:</td>
                <td><strong>{{$incomingManualHeader->container_no}}</td>
              </tr>
              <tr>
                <td colspan="2"><strong>Document Date</td>
                <td><strong>:</td>
                <td colspan="4"><strong>{{format_tanggal_wms($incomingManualHeader->document_date)}}</strong></td>
              </tr>
              <tr><td>&nbsp;</td></tr>
            </table>
          </td>
        </tr>
        <tr>
          <td>
            <table width="100%" style="border-collapse: collapse; font-size: 8pt;">

              {{-- Judul Tabel --}}
              <tr>
                <td style="text-align: center; border: 1pt solid #000000; width: 10mm;"><strong>No.</strong></td>
                <td style="text-align: center; border: 1pt solid #000000; width: 50mm;" colspan="3"><strong>Model Name</strong></td>
                <td style="text-align: center; border: 1pt solid #000000; width: 30mm;" colspan="2"><strong>CBM</strong></td>
                <td style="text-align: center; border: 1pt solid #000000; width: 30mm;" colspan="2"><strong>Quantity</strong></td>
                <td style="text-align: center; border: 1pt solid #000000; width: 30mm;"><strong>SLoc</strong></td>
                <td style="text-align: center; border: 1pt solid #000000; width: 50mm;" colspan="2"><strong>Description</strong></td>
              </tr>
              {{-- AKHIR Judul Tabel --}}

              @php
              $total_cbm = 0;
              $total_quantity = 0;
              @endphp

              @foreach($incomingManualHeader->details AS $key => $detail)
              @php
              $total_cbm += $detail->total_cbm;
              $total_quantity += $detail->qty;
              @endphp

              <tr>
                <td style="text-align: right; border: 1pt solid black"><strong>{{$key + 1}}</td>
                <td style="text-align: left; border: 1pt solid #000000;" colspan="3"><strong>{{$detail->model}}</td>
                <td style="text-align: right; border: 1pt solid #000000;" colspan="2"><strong>{{$detail->total_cbm}}</td>
                <td style="text-align: right; border: 1pt solid #000000;" colspan="2"><strong>{{$detail->qty}}</td>
                <td style="text-align: right; border: 1pt solid #000000;"><strong>{{$detail->storage->sto_loc_code_long}}</td>
                <td style="text-align: left; border: 1pt solid #000000;" colspan="2"><strong>{{$detail->description}}</td>
                <td style="border-left: 1pt solid #000000;"></td>
              </tr>
              @endforeach

              <tr>
                <td style="text-align: center; border: 1pt solid #000000;" colspan="4"><strong>TOTAL</td>
                <td style="text-align: right; border: 1pt solid #000000;" colspan="2"><strong>{{$total_cbm}}</td>
                <td style="text-align: right; border: 1pt solid #000000;" colspan="2"><strong>{{$total_quantity}}</td>
                <td style="text-align: right; border: 1pt solid #000000;"></td>
                <td style="text-align: left; border: 1pt solid #000000;" colspan="2"></td>
              </tr>
              <tr><td>&nbsp;</td></tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td>
      <table style="width: 210.0003mm;">
        <tr>
          <td>
            <table style="font-family: courier New; font-size: 8pt;">
              <tr>
                <td colspan="3" style="width: 30mm;"><strong>TRANSFER BY</td>
                <td style="width: 30mm; text-align: left; border-bottom: 1px solid #000000;"><strong>{{ !empty($request['transfer_by']) ? $request['transfer_by'] : '' }}</td>
              </tr>
              <tr>
                <td colspan="3" style="width: 30mm;"><strong>CHECKED BY</td>
                <td style="width: 30mm; text-align: left; border-bottom: 1px solid #000000;"><strong>{{ !empty($request['checked_by']) ? $request['checked_by'] : '' }}</td>
              </tr>
              <tr>
                <td colspan="3" style="width: 30mm;"><strong>LOCATE</td>
                <td style="width: 30mm; text-align: left; border-bottom: 1px solid #000000;"><strong>{{ !empty($request['locate']) ? $request['locate'] : '' }}</td>
              </tr>
              <tr><td>&nbsp;</td></tr>
            </table>
          </td>
        </tr>
        <tr>
          <td>
            <table style="font-family: courier New; font-size: 8pt;">
              <tr>
                <td colspan="11" style=" width: 200mm;text-align: right;"><strong>{{date(' l, d-F-Y h:i:s A')}}</td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>