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
                <td colspan="2" style="width: 30mm;">Arrival No.</td>
                <td style="width: 5mm;">:</td>
                <td colspan="4" style="width: 60mm;">{{$incomingManualHeader->arrival_no}}</td>
                <td colspan="2" style="width: 40mm;">Vendor Name</td>
                <td style="width: 5mm;">:</td>
                <td>{{$incomingManualHeader->vendor_name}}</td>
              </tr>
              <tr>
                <td colspan="2">PO</td>
                <td>:</td>
                <td colspan="4">{{$incomingManualHeader->po}}</td>
                <td colspan="2">Actual Arrive Date</td>
                <td>:</td>
                <td>{{format_tanggal_wms($incomingManualHeader->actual_arrival_date)}}</td>
              </tr>
              <tr>
                <td colspan="2">Invoice No.</td>
                <td>:</td>
                <td colspan="4">{{$incomingManualHeader->invoice_no}}</td>
                <td colspan="2">Expedition Name</td>
                <td>:</td>
                <td>{{$incomingManualHeader->expedition_name}}</td>
              </tr>
              <tr>
                <td colspan="2">No. GR SAP</td>
                <td>:</td>
                <td colspan="4" style="text-align: left;">{{$incomingManualHeader->no_gr_sap}}</td>
                <td colspan="2">Container No.</td>
                <td>:</td>
                <td>{{$incomingManualHeader->container_no}}</td>
              </tr>
              <tr>
                <td colspan="2">Document Date</td>
                <td>:</td>
                <td colspan="4">{{format_tanggal_wms($incomingManualHeader->document_date)}}</td>
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
              $total_cbm += $detail->cbm;
              $total_quantity += $detail->qty;
              @endphp

              <tr>
                <td style="text-align: right; border: 1pt solid #000000;">{{$key + 1}}</td>
                <td style="text-align: left; border: 1pt solid #000000;" colspan="3">{{$detail->model}}</td>
                <td style="text-align: right; border: 1pt solid #000000;" colspan="2">{{$detail->cbm}}</td>
                <td style="text-align: right; border: 1pt solid #000000;" colspan="2">{{$detail->qty}}</td>
                <td style="text-align: right; border: 1pt solid #000000;">{{$detail->storage->sto_loc_code_long}}</td>
                <td style="text-align: left; border: 1pt solid #000000;" colspan="2">{{$detail->description}}</td>
                <td style="border-left: 1pt solid #000000;"></td>
              </tr>
              @endforeach

              <tr>
                <td style="text-align: center; border: 1pt solid #000000;" colspan="4">TOTAL</td>
                <td style="text-align: right; border: 1pt solid #000000;" colspan="2">{{$total_cbm}}</td>
                <td style="text-align: right; border: 1pt solid #000000;" colspan="2">{{$total_quantity}}</td>
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
                <td colspan="3" style="width: 30mm;">TRANSFER BY</td>
                <td style="width: 30mm; text-align: left; border-bottom: 1px solid #000000;">{{ !empty($request['transfer_by']) ? $request['transfer_by'] : '' }}</td>
              </tr>
              <tr>
                <td colspan="3" style="width: 30mm;">CHECKED BY</td>
                <td style="width: 30mm; text-align: left; border-bottom: 1px solid #000000;">{{ !empty($request['checked_by']) ? $request['checked_by'] : '' }}</td>
              </tr>
              <tr>
                <td colspan="3" style="width: 30mm;">LOCATE</td>
                <td style="width: 30mm; text-align: left; border-bottom: 1px solid #000000;">{{ !empty($request['locate']) ? $request['locate'] : '' }}</td>
              </tr>
              <tr><td>&nbsp;</td></tr>
            </table>
          </td>
        </tr>
        <tr>
          <td>
            <table style="font-family: courier New; font-size: 8pt;">
              <tr>
                <td colspan="11" style=" width: 200mm;text-align: right;">{{date(' l, d-F-Y h:i:s A')}}</td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>