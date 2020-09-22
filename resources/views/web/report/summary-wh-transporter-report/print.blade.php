<link rel="stylesheet" type="text/css" href="{{ url('materialize/css/custom/print.css') }}">

<table style="font-family: Arial;">
  <tr>
    <td>
      <table style="width: 210.0003mm;">
        <tr>
          <td>
            <table width="100%" style="font-size: 9pt;">
              <tr><td>&nbsp;</td></tr>
              <tr><td>&nbsp;</td></tr>
              <tr>
                <td colspan="2" style="width: 30mm;"><strong>DAILY OUTGOING TO</strong></td>
                <td colspan="2" style="width: 30mm;"><strong>LOMBOK</strong></td>
                <td colspan="2" style="width: 30mm;"><strong>FINISHED GOODS REPORT,</strong></td>
                <td colspan="2" style="width: 30mm;"><strong>Sep 2020</strong></td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td>
            <table width="100%" style="font-size: 9pt; border-collapse: collapse;">
              <tr>
                <td rowspan="2" style="text-align: center; border: 1pt solid #000000; width: 28mm;"><strong>DATE</strong></td>
                <td colspan="2" style="text-align: center; border: 1pt solid #000000; width: 52mm;"><strong>KARAWANG</strong></td>
                <td colspan="2" style="text-align: center; border: 1pt solid #000000; width: 52mm;"><strong>SURABAYA HUB</strong></td>
                <td colspan="2" style="text-align: center; border: 1pt solid #000000; width: 52mm;"><strong>SWADAYA</strong></td>
                <td style="text-align: center; border: 1pt solid #000000; width: 26mm;"><strong>RITASE</strong></td>
              </tr>
              <tr>
                <td style="text-align: center; border: 1pt solid #000000;"><strong>QTY</strong></td>
                <td style="text-align: center; border: 1pt solid #000000;"><strong>CBM</strong></td>
                <td style="text-align: center; border: 1pt solid #000000;"><strong>QTY</strong></td>
                <td style="text-align: center; border: 1pt solid #000000;"><strong>CBM</strong></td>
                <td style="text-align: center; border: 1pt solid #000000;"><strong>QTY</strong></td>
                <td style="text-align: center; border: 1pt solid #000000;"><strong>CBM</strong></td>
                <td style="text-align: center; border: 1pt solid #000000;"><strong>QTY</strong></td>
              </tr>
              @foreach($rs_details AS $key => $value)
              <tr style="{{ $value['isWeekend'] ? 'background-color: red;' : '' }}">
                <td style="text-align: center; border: 1pt solid #000000;">{{ $value['date'] }}</td>
                <td style="text-align: right; border: 1pt solid #000000;">0</td>
                <td style="text-align: right; border: 1pt solid #000000;">0.000</td>
                <td style="text-align: right; border: 1pt solid #000000;">0</td>
                <td style="text-align: right; border: 1pt solid #000000;">0.000</td>
                <td style="text-align: right; border: 1pt solid #000000;">0</td>
                <td style="text-align: right; border: 1pt solid #000000;">0.000</td>
                <td style="text-align: right; border: 1pt solid #000000;">0</td>
              </tr>
              @endforeach
              <tr>
                <td style="text-align: center; border: 1pt solid #000000;">TOTAL</td>
                <td style="text-align: right; border: 1pt solid #000000;">0</td>
                <td style="text-align: right; border: 1pt solid #000000;">0.000</td>
                <td style="text-align: right; border: 1pt solid #000000;">0</td>
                <td style="text-align: right; border: 1pt solid #000000;">0.000</td>
                <td style="text-align: right; border: 1pt solid #000000;">0</td>
                <td style="text-align: right; border: 1pt solid #000000;">0.000</td>
                <td style="text-align: right; border: 1pt solid #000000;">0</td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>