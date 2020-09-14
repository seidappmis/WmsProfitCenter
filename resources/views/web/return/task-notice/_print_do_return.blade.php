<link rel="stylesheet" type="text/css" href="{{ url('materialize/css/custom/print.css') }}">

@php
$plans = $header->plans()->orderBy('model')->get();
@endphp

<table style="font-family: Arial;">
  <tr>
    <td>
      <table style="width: 210.0003mm;">
        <tr>
          <td>
            <table width="100%" style="font-family: Arial; font-size: 8pt;">
              <tr><td>&nbsp;</td></tr>
              <tr><td>&nbsp;</td></tr>
              <tr>
                <td colspan="12">Jl. Swadaya IV, Rawaterate</td>
              </tr>
              <tr>
                <td colspan="12">Cakung, Jakarta Timur</td>
              </tr>
              <tr><td>&nbsp;</td></tr>
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="4" style="width: 30mm;"></td>
                <td style="width: 20mm;">Sold-to</td>
                <td style="width: 5mm;">:</td>
                <td colspan="2" style="text-align: left;">{{$plans[0]->costumer_code}}</td>
              </tr>
              <tr>
                <td colspan="2" style="width: 20mm;">PHONE</td>
                <td style="width: 5mm;">:</td>
                <td style="text-align: left;">46824070</td>
              </tr>
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="4"></td>
                <td colspan="4">{{$plans[0]->costumer_name}}</td>
              </tr>
              <tr>
                <td colspan="2" style="width: 20mm;">FAX</td>
                <td style="width: 5mm;">:</td>
                <td style="text-align: left;">46824066</td>
              </tr>
              <tr>
                <td colspan="3">Jakarta</td>
                <td style="text-align: left;">13920</td>
              </tr>
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="4"></td>
                <td colspan="4" style="text-align: left;">{{$plans[0]->location}}</td>
              </tr>
              <tr>
                <td colspan="2">INDONESIA</td>
              </tr>
              <tr><td>&nbsp;</td></tr>
            </table>
          </td>
        </tr>
        <tr>
          <td>
            <table style="font-size: 7pt; font-family: Arial;">
              <tr>
                <td colspan="2" style="width: 40mm;">DELIVERY ORDER</td>
                <td style="width:5mm">:</td>
                <td>RETURN</td>
              </tr>
              <tr>
                <td colspan="2" style="width: 40mm;">D/O No.</td>
                <td style="width:5mm">:</td>
                <td>{{$plans[0]->no_do}}</td>
              </tr>
              <tr>
                <td colspan="2" style="width: 40mm;">D/O Date.</td>
                <td style="width:5mm">:</td>
                <td>{{$header->date}}</td>
              </tr>
              <tr>
                <td colspan="2" style="width: 40mm;">S/O No.</td>
                <td style="width:5mm">:</td>
                <td>{{$plans[0]->no_do}}</td>
              </tr>
              <tr>
                <td colspan="2" style="width: 40mm;">S/O Date.</td>
                <td style="width:5mm">:</td>
                <td></td>
              </tr>
              <tr>
                <td colspan="2" style="width: 40mm;">P/O No.</td>
                <td style="width:5mm">:</td>
                <td></td>
              </tr>
              <tr>
                <td colspan="2" style="width: 40mm;">P/O Date.</td>
                <td style="width:5mm">:</td>
                <td></td>
              </tr>
              <tr>
                <td colspan="2" style="width: 40mm;">Salesman</td>
                <td style="width:5mm">:</td>
                <td></td>
              </tr>
              <tr>
                <td colspan="2" style="width: 40mm;">Car No.</td>
                <td style="width:5mm">:</td>
                <td>{{ $request['vehicle_no'] }}</td>
              </tr>
              <tr>
                <td colspan="2" style="width: 40mm;">Driver</td>
                <td style="width:5mm">:</td>
                <td>{{ $request['driver'] }}</td>
              </tr>
              <tr>
                <td colspan="2" style="width: 40mm;">Transport</td>
                <td style="width:5mm">:</td>
                <td>{{ $request['expedition'] }}</td>
              </tr>
              <tr><td>&nbsp;</td></tr>
            </table>
          </td>
        </tr>
        <tr>
          <td>
            <table width="100%" style="font-family: Arial; font-size: 8pt;">
              <tr>
                <td style="text-align: center; width: 15mm;">No</td>
                <td colspan="2" style="text-align: center; width: 35mm;">Model</td>
                <td colspan="2" style="text-align: center; width: 35mm;">Description</td>
                <td style="text-align: center; width: 20mm;">Vol (M3)</td>
                <td colspan="2" style="text-align: center; width: 15mm;">Qty</td>
                <td style="text-align: center; width: 30mm;">No. Seri</td>
                <td  colspan="2" style="text-align: center; width: 30mm;">St.bin</td>
                <td style="text-align: center; width: 30mm;">Remark</td>
              </tr>
              @foreach($plans AS $kPlan => $vPlan)
              <tr>
                <td style="text-align: center;">{{$kPlan + 1}}</td>
                <td colspan="2">{{$vPlan->model}}</td>
                <td colspan="2" >{{$vPlan->description}}</td>
                <td style="text-align: right;">{{$vPlan->cbm}}</td>
                <td colspan="2" style="text-align: center;">{{$vPlan->qty}}</td>
                <td></td>
                <td colspan="2" ></td>
                <td></td>
              </tr>
              @endforeach
              <tr>
                <td></td>
                <td colspan="4">Total</td>
                <td style="text-align: right;">0.030</td>
                <td colspan="2" style="text-align: center;">1</td>
              </tr>
              <tr><td>&nbsp;</td></tr>
              <tr>
                <td></td>
                <td>REMARK</td>
                <td>:</td>
                <td style="text-align: left;">{{$vPlan->remark}}</td>
              </tr>
            </table>
          </td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
          <td>
            <table width="100%" style="font-size: 7pt; font-family: Arial; font-size: 8pt;">
              <tr>
                <td colspan="11"></td>
                <td style="text-align: center;"></td>
              </tr>
              <tr>
                <td></td>
                <td style="text-align: center;">{{ $request['security'] }}<br>Security</td>
                <td style="width: 20mm;"></td>
                <td colspan="5" style="text-align: center;"></td>
                <td style="text-align: center;">{{ $request['checker'] }}<br>Checker</td>
                <td colspan="2" style="text-align: center;">{{ $request['wh'] }}<br>W.H</td>
                <td style="text-align: center;">{{ $request['driver'] }}<br>Driver</td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>