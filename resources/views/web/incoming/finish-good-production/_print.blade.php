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
                <td style="font-size: 10pt;" rowspan="2" colspan="13"><strong>PT. SHARP ELECTRONICS INDONESIA <br> WAREHOUSE RECEIPT</strong></td>
                {{-- <td style="font-size: 10pt; text-align: right;"><strong>{{$incomingManualHeader->inc_type}}</strong></td> --}}
              </tr>
              <tr><td></td></tr>
              <tr><td>&nbsp;</td></tr>
              <tr>
                <td colspan="2" style="width: 20mm;">Warehouse</td>
                <td style="width: 5mm;">:</td>
                <td colspan="5" style="width: 120mm;">SHARP KARAWANG W/H</td>
                <td colspan="2" style="width: 20mm;">Factory</td>
                <td style="width: 5mm;">:</td>
                <td>TV</td>
              </tr>
              <tr>
                <td colspan="2">Ticket No.</td>
                <td>:</td>
                <td colspan="5">L-TV-1810010006</td>
                <td colspan="2">Date</td>
                <td>:</td>
                <td>03-10-2018</td>
              </tr>
              <tr>
                <td colspan="2">Arrival No.</td>
                <td>:</td>
                <td colspan="5">ARV-WHHYP-181003-019</td>
                <td colspan="2">Time</td>
                <td>:</td>
                <td>9:17:49 AM</td>
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
                <td style="text-align: center; border: 1pt solid #000000; width: 10mm;"><strong>NO</strong></td>
                <td style="text-align: center; border: 1pt solid #000000; width: 50mm;" colspan="3"><strong>MODEL NAME</strong></td>
                <td style="text-align: center; border: 1pt solid #000000; width: 40mm;" colspan="2"><strong>EAN</strong></td>
                <td style="text-align: center; border: 1pt solid #000000; width: 30mm;" colspan="2"><strong>QTY</strong></td>
                <td style="text-align: center; border: 1pt solid #000000; width: 80mm;" colspan="5"><strong>REMARKS</strong></td>
              </tr>
              {{-- AKHIR Judul Tabel --}}

              <tr>
                <td style="text-align: right; border: 1pt solid #000000;">1</td>
                <td style="text-align: left; border: 1pt solid #000000;" colspan="3">LC24LE175I</td>
                <td style="text-align: center; border: 1pt solid #000000;" colspan="2">8997401961233</td>
                <td style="text-align: right; border: 1pt solid #000000;" colspan="2">118</td>
                <td style="text-align: right; border: 1pt solid #000000;" colspan="5"></td>
                <td style="border-left: 1pt solid #000000; width: 5mm;"></td>
              </tr>
              

              <tr>
                <td style="text-align: center; border: 1pt solid #000000;" colspan="6">TOTAL</td>
                <td style="text-align: right; border: 1pt solid #000000;" colspan="2">118</td>
                <td style="text-align: right; border: 1pt solid #000000; width: 5mm;" colspan="5"></td>
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
                <td style="width: 30mm; text-align: left; border-bottom: 1px solid #000000;">123</td>
              </tr>
              <tr>
                <td colspan="3" style="width: 30mm;">CHECKED BY</td>
                <td style="width: 30mm; text-align: left; border-bottom: 1px solid #000000;">123</td>
              </tr>
              <tr>
                <td colspan="3" style="width: 30mm;">LOCATE</td>
                <td style="width: 30mm; text-align: left; border-bottom: 1px solid #000000;">123</td>
              </tr>
              <tr><td>&nbsp;</td></tr>
            </table>
          </td>
        </tr>
        <tr>
          <td>
            <table width="100%" style="font-family: courier New; font-size: 8pt;">
              <tr>
                <td colspan="13" style=" width: 210mm; text-align: right;">{{date(' l, d-F-Y h:i:s A')}}</td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>