<link rel="stylesheet" type="text/css" href="{{ url('materialize/css/custom/print.css') }}">

@foreach($tag AS $key => $value)
<table style="font-family: Arial; {{ $key % 2 == 1 ? 'page-break-after: always;' : '' }}">
  <tr>
    <td>
      <table style="width: 793.8px;">
        <tr>
          <td>
            <table width="100%" style=" font-size: 10pt;">
              <tr><td>&nbsp;</td></tr>
              <tr><td>&nbsp;</td></tr>
              <tr><td colspan="7" style="text-align: center;">Stock Take Card</td></tr>
              <tr><td>&nbsp;</td></tr>
              <tr>
                <td style="width: 113.4px;">Area</td>
                <td style="width: 18.9px;">:</td>
                <td style="width: 151.2px; text-align: left;">{{$value->warehouse}}</td>
                <td style="width: 226.8px; text-align: center;">{{$value->area != '' ? $value->area : $value->short_description}}</td>
                <td style="width: 113.4px;">Tag No</td>
                <td style="width: 18.9px;">:</td>
                <td style="width: 151.2px; text-align: left;">{{$value->no_tag}}</td>
              </tr>
              <tr>
                <td>Model</td>
                <td>:</td>
                <td style="text-align: left;">{{$value->model}}</td>
                <td></td>
                <td>ST Date</td>
                <td>:</td>
                <td style="text-align: left;">{{date('d-m-Y')}}</td>
              </tr>
              <tr>
                <td>Location</td>
                <td>:</td>
                <td style="text-align: left;">{{$value->location}}</td>
                <td></td>
                <td>STS Schedule</td>
                <td>:</td>
                <td style="text-align: left;">{{$value->sto_id}}</td>
              </tr>
              <tr><td>&nbsp;</td></tr>
            </table>
          </td>
        </tr>
        <tr>
          <td>
            {{-- Main Table --}}
            <table width="100%" style="font-size: 10pt; border-collapse: collapse;">
              {{-- Head --}}
              <tr>
                <td colspan="2" style="width: 132.3px; text-align: center; border: 1pt solid #000000;">Nomor Jalur</td>
                <td style="width: 132.3px; text-align: center; border: 1pt solid #000000;">Jumlah Pallet</td>
                <td style="width: 132.3px; text-align: center; border: 1pt solid #000000;">Qty/Pallet</td>
                <td style="width: 132.3px; text-align: center; border: 1pt solid #000000;">Total</td>
                <td colspan="2" style="width: 264.6px; text-align: center; border: 1pt solid #000000;">Remark</td>
              </tr>
              {{-- Body --}}
              <tr>
                <td colspan="2" style="border: 1pt solid #000000;">&nbsp;</td>
                <td style="border: 1pt solid #000000;">&nbsp;</td>
                <td style="border: 1pt solid #000000;">&nbsp;</td>
                <td style="border: 1pt solid #000000;">&nbsp;</td>
                <td colspan="2" style="border: 1pt solid #000000;">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="2" style="border: 1pt solid #000000;">&nbsp;</td>
                <td style="border: 1pt solid #000000;">&nbsp;</td>
                <td style="border: 1pt solid #000000;">&nbsp;</td>
                <td style="border: 1pt solid #000000;">&nbsp;</td>
                <td colspan="2" style="border: 1pt solid #000000;">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="2" style="border: 1pt solid #000000;">&nbsp;</td>
                <td style="border: 1pt solid #000000;">&nbsp;</td>
                <td style="border: 1pt solid #000000;">&nbsp;</td>
                <td style="border: 1pt solid #000000;">&nbsp;</td>
                <td colspan="2" style="border: 1pt solid #000000;">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="2" style="border: 1pt solid #000000;">&nbsp;</td>
                <td style="border: 1pt solid #000000;">&nbsp;</td>
                <td style="border: 1pt solid #000000;">&nbsp;</td>
                <td style="border: 1pt solid #000000;">&nbsp;</td>
                <td colspan="2" style="border: 1pt solid #000000;">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="2" style="border: 1pt solid #000000;">&nbsp;</td>
                <td style="border: 1pt solid #000000;">&nbsp;</td>
                <td style="border: 1pt solid #000000;">&nbsp;</td>
                <td style="border: 1pt solid #000000;">&nbsp;</td>
                <td colspan="2" style="border: 1pt solid #000000;">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="2" style="border: 1pt solid #000000;">&nbsp;</td>
                <td style="border: 1pt solid #000000;">&nbsp;</td>
                <td style="border: 1pt solid #000000;">&nbsp;</td>
                <td style="border: 1pt solid #000000;">&nbsp;</td>
                <td colspan="2" style="border: 1pt solid #000000;">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="2" style="border: 1pt solid #000000;">&nbsp;</td>
                <td style="border: 1pt solid #000000;">&nbsp;</td>
                <td style="border: 1pt solid #000000;">&nbsp;</td>
                <td style="border: 1pt solid #000000;">&nbsp;</td>
                <td colspan="2" style="border: 1pt solid #000000;">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="2" style="border: 1pt solid #000000;">&nbsp;</td>
                <td style="border: 1pt solid #000000;">&nbsp;</td>
                <td style="border: 1pt solid #000000;">&nbsp;</td>
                <td style="border: 1pt solid #000000;">&nbsp;</td>
                <td colspan="2" style="border: 1pt solid #000000;">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="3" style="text-align: center; border: 1pt solid #000000;">Grand Total</td>
                <td style="border: 1pt solid #000000;"></td>
                <td style="border: 1pt solid #000000;"></td>
                <td colspan="2" style="border: 1pt solid #000000;"></td>
              </tr>
              <tr><td>&nbsp;</td></tr>
            </table>
          </td>
        </tr>
        <tr>
          <td>
            <table width="100%" style=" font-size: 10pt; border-collapse: collapse;">
              <tr>
                <td colspan="2" style="border: 1pt solid #000000; text-align: center;">Counter</td>
                <td style="border: 1pt solid #000000; text-align: center;">Recorder</td>
              </tr>
              <tr>
                <td colspan="2" rowspan="5" style="border: 1pt solid #000000;">&nbsp;</td>
                <td rowspan="5" style="border: 1pt solid #000000;">&nbsp;</td>
              </tr>
              <tr><td>&nbsp;</td></tr>
              <tr><td>&nbsp;</td></tr>
              <tr><td>&nbsp;</td></tr>
              <tr><td>&nbsp;</td></tr>
              <tr>
                <td colspan="2" style="width: 151.2px; border: 1pt solid #000000; text-align: center;">&nbsp;</td>
                <td style="width: 151.2px; border: 1pt solid #000000; text-align: center;">&nbsp;</td>
                <td colspan="2" style="width: 226.8px;"></td>
                <td colspan="2" style="width: 264.6px; text-align: center;">Printed Date : {{date('d-m-Y')}}</td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
@endforeach