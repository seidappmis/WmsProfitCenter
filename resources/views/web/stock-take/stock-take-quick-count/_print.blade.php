<link rel="stylesheet" type="text/css" href="{{ url('materialize/css/custom/print.css') }}">

<table style="font-family: Arial; font-size: 10pt;">
  <tr>
    <td>
      <table style="width: 793.59px;">
        <tr>
          <td>
            <table width="100%">
              <tr><td>&nbsp;</td></tr>
              <tr><td>&nbsp;</td></tr>
              <tr>
                <td style="width: 113.37px">STS Schedule</td>
                <td style="width: 37.79px">:</td>
                <td colspan="2" style="width: 264.53px">{{$schedule->sto_id}}</td>
                <td style="width: 113.37px">Description</td>
                <td style="width: 37.79px">:</td>
                <td colspan="2">{{$schedule->description}}</td>
              </tr>
              <tr>
                <td>Period</td>
                <td>:</td>
                <td colspan="2">{{$schedule->schedule_start_date}} S/D {{$schedule->schedule_end_date}}</td>
                <td>Print Date</td>
                <td>:</td>
                <td colspan="2">{{ date('Y-m-d') }}</td>
              </tr>
              <tr><td>&nbsp;</td></tr>
            </table>
          </td>
        </tr>
        <tr>
          <td>
            {{-- Main Table --}}
            <table width="100%" style="border-collapse: collapse;">
              {{-- Table Head --}}
              <tr>
                <td style="border: 1pt solid #000000; text-align: center; width: 113.37px;">Tag No</td>
                <td colspan="2" style="border: 1pt solid #000000; text-align: center; width: 170.055px;">Model</td>
                <td style="border: 1pt solid #000000; text-align: center; width: 170.055px;">Location</td>
                <td style="border: 1pt solid #000000; text-align: center; width: 113.37px;">Input 1</td>
                <td colspan="2" style="border: 1pt solid #000000; text-align: center; width: 113.37px;">Input 2</td>
                <td style="border: 1pt solid #000000; text-align: center; width: 113.37px;">Diff</td>
              </tr>
              @foreach($details AS $key => $value)
              <tr>
                <td style="border: 1pt solid #000000; text-align: left;">{{$value->no_tag}}</td>
                <td colspan="2" style="border: 1pt solid #000000; text-align: left;">{{$value->model}}</td>
                <td style="border: 1pt solid #000000; text-align: left;">{{$value->location}}</td>
                <td style="border: 1pt solid #000000; text-align: left;">{{$value->quantity}}</td>
                <td colspan="2" style="border: 1pt solid #000000; text-align: left;">{{$value->quantity2}}</td>
                <td style="border: 1pt solid #000000; text-align: left;">{{!empty($value->quantity) && !empty($value->quantity2) ? $value->quantity - $value->quantity2 : ''}}</td>
              </tr>
              @endforeach
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>