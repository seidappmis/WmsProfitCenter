<link rel="stylesheet" type="text/css" href="{{ url('materialize/css/custom/print.css') }}">

<table style="font-family: Arial;">
  <tr>
    <td>
      <table style="width: 210.0003mm;">
        <tr>
          <td>
            <table width="100%" style=" font-size: 10pt;">
              <tr><td>&nbsp;</td></tr>
              <tr><td>&nbsp;</td></tr>
              <tr>
                <td style="width: 30mm;">STS Schedule</td>
                <td style="width: 5mm;">:</td>
                <td colspan="2" style="width: 50mm;text-align: left;">{{$stockTakeSchedule->sto_id}}</td>
                <td style="width: 40mm;"></td>
                <td style="width: 30mm;">Description</td>
                <td style="width: 5mm;">:</td>
                <td colspan="2" style="width: 50mm;text-align: left;">{{$stockTakeSchedule->description}}</td>
              </tr>
              <tr>
                <td>Period</td>
                <td>:</td>
                <td colspan="2" style="text-align: left;">{{$stockTakeSchedule->schedule_start_date}} S/D {{$stockTakeSchedule->schedule_end_date}}</td>
                <td></td>
                <td>Print Date</td>
                <td>:</td>
                <td colspan="2" style="text-align: left;">{{date('Y-m-d')}}</td>
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
                <td colspan="3" style="text-align: center; border: 1pt solid #000000; width: 60mm;">Model</td>
                <td style="text-align: center; border: 1pt solid #000000; width: 30mm;">SAP</td>
                <td style="text-align: center; border: 1pt solid #000000; width: 30mm;">Input 1</td>
                <td style="text-align: center; border: 1pt solid #000000; width: 30mm;">Input 2</td>
                <td colspan="2" style="text-align: center; border: 1pt solid #000000; width: 30mm;">SAP vs Input 1</td>
                <td style="text-align: center; border: 1pt solid #000000; width: 30mm;">SAP vs Input 2</td>
              </tr>
              {{-- Body --}}
              @foreach($stockTakeDetail AS $key => $value)
              <tr>
                <td colspan="3" style="text-align: left; border: 1pt solid #000000;">{{$value->model}}</td>
                <td style="text-align: left; border: 1pt solid #000000;">{{$value->quantitySAP}}</td>
                <td style="text-align: left; border: 1pt solid #000000;">{{$value->quantity}}</td>
                <td style="text-align: left; border: 1pt solid #000000;">{{$value->quantity2}}</td>
                <td colspan="2" style="text-align: left; border: 1pt solid #000000;">{{!empty($value->quantity) ? $value->quantity - $value->quantitySAP : ''}}</td>
                <td style="text-align: left; border: 1pt solid #000000;">{{!empty($value->quantity2) ? $value->quantity2 - $value->quantitySAP : ''}}</td>
              </tr>
              @endforeach
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>