<link rel="stylesheet" type="text/css" href="{{ url('materialize/css/custom/print.css') }}">

<table style="font-family: Arial;" width="100%">
  <tr>
    <td>
      <table style="width: 793.59px;">
        <tr>
          <td>
            <table width="100%" style=" font-size: 10pt;">
              <tr><td>&nbsp;</td></tr>
              <tr><td>&nbsp;</td></tr>
              <tr>
                <td style="width: 113.37px;">STS Schedule</td>
                <td style="width: 18.895px;">:</td>
                <td colspan="2" style="width: 188.95px;text-align: left;">{{$stockTakeSchedule->sto_id}}</td>
                <td style="width: 151.16px;"></td>
                <td style="width: 113.37px;">Description</td>
                <td style="width: 18.895px;">:</td>
                <td colspan="2" style="width: 188.95px;text-align: left;">{{$stockTakeSchedule->description}}</td>
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
                <td colspan="3" style="text-align: center; border: 1pt solid #000000; width: 226.74px;">Model</td>
                <td style="text-align: center; border: 1pt solid #000000; width: 113.37px;">SAP</td>
                <td style="text-align: center; border: 1pt solid #000000; width: 113.37px;">Input 1</td>
                <td style="text-align: center; border: 1pt solid #000000; width: 113.37px;">Input 2</td>
                <td colspan="2" style="text-align: center; border: 1pt solid #000000; width: 113.37px;">SAP vs Input 1</td>
                <td style="text-align: center; border: 1pt solid #000000; width: 113.37px;">SAP vs Input 2</td>
              </tr>
              {{-- Body --}}
              @foreach($stockTakeDetail AS $key => $value)
              <tr style='page-break-inside:aa;'>
                <td colspan="3" style="text-align: left; border: 1pt solid #000000;">{{$value->material_no}}</td>
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