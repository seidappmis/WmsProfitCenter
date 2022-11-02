<link rel="stylesheet" type="text/css" href="{{ url('materialize/css/custom/print.css') }}">

@php
$plans = $header->plans()->orderBy('model')->get();
@endphp
<body>
  <htmlpageheader name="myHeader1">  
    <table style="font-family: Arial;">
      <tr><td>&nbsp;</td></tr>
      <tr>
        <td>
          <table style="width: 210.0003mm;">
            <tr>
              <td>
                <table width="100%" style="font-family: Arial; font-size: 8pt;">
                  <tr><td>&nbsp;</td></tr>
                  <tr><td>&nbsp;</td></tr>
                  <tr>
                    <td colspan="12" style="padding: 2pt;">Jl. Swadaya IV, Rawaterate</td>
                  </tr>
                  <tr>
                    <td colspan="12" style="padding: 2pt;">Cakung, Jakarta Timur</td>
                  </tr>
                  <tr><td>&nbsp;</td></tr>
                  <tr>
                    <td colspan="2" style="width: 20mm; padding: 2pt;">PHONE</td>
                    <td style="width: 5mm; padding: 2pt;">:</td>
                    <td style="text-align: left; padding: 2pt;">46824070</td>
                    <td></td>
                    <td colspan="4" style="width: 30mm;"></td>
                    <td style="width: 20mm; padding: 2pt;">Sold-to</td>
                    <td style="width: 5mm; padding: 2pt;">:</td>
                    <td colspan="2" style="text-align: left; padding: 2pt;">{{$plans[0]->costumer_code}}</td>
                  </tr>
                  <tr>
                    <td colspan="2" style="width : 20mm; padding: 2pt;">FAX</td>
                    <td style="width: 5mm; padding: 2pt;">:</td>
                    <td style="text-align: left; padding: 2pt;">46824066</td>
                    <td></td>
                    <td colspan="4"></td>
                    <td colspan="4" rowspan="2">{{$plans[0]->costumer_name}}</td>
                  </tr>
                  <tr>
                    <td colspan="3" style="padding: 2pt;">Jakarta</td>
                    <td style="text-align: left; padding: 2pt;">13920</td>
                  </tr>
                  <tr>
                    <td colspan="3" style="padding: 2pt;">INDONESIA</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td colspan="4"></td>
                    <td colspan="4" style="text-align: left; padding: 2pt;">{{$plans[0]->location}}</td>
                  </tr>
                  <!--<tr>
                    <td colspan="2">INDONESIA</td>
                  </tr>-->
                  <tr><td>&nbsp;</td></tr>
                </table>
              </td>
            </tr>
          </table>
    </table>
  </htmlpageheader>
  <sethtmlpageheader name="myHeader1" value="on" show-this-page="1"/>

  <!--<htmlpagefooter name="myFooter1">
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
  </htmlpagefooter>
  <sethtmlpagefooter name="myFooter1" value="on" />-->

    <table style="font-family: Arial;">
      <tr>
        <td>
          <table style="width: 210.0003mm;">
            <tr>
              <td>
                <table style="font-size: 8pt; font-family: Arial;">
                  <tr>
                    <td colspan="2" style="width: 40mm; padding: 2pt;">DELIVERY ORDER</td>
                    <td style="width:5mm; padding: 2pt;">:</td>
                    <td>RETURN</td>
                  </tr>
                  <tr>
                    <td colspan="2" style="width: 40mm; padding: 2pt;">D/O No.</td>
                    <td style="width:5mm; padding: 2pt;">:</td>
                    <td style="padding: 2pt;">{{$plans[0]->no_do}}</td>
                  </tr>
                  <tr>
                    <td colspan="2" style="width: 40mm; padding: 2pt;">D/O Date.</td>
                    <td style="width:5mm; padding: 2pt;">:</td>
                    <td style="padding: 2pt;">{{$header->date}}</td>
                  </tr>
                  <tr>
                    <td colspan="2" style="width: 40mm; padding: 2pt;">S/O No.</td>
                    <td style="width:5mm; padding: 2pt;">:</td>
                    <td style="padding: 2pt;">{{$plans[0]->no}}</td>
                  </tr>
                  <!--<tr>
                    <td colspan="2" style="width: 40mm; padding: 2pt;">S/O Date.</td>
                    <td style="width:5mm; padding: 2pt;">:</td>
                    <td></td>
                  </tr>-->
                  <tr>
                    <td colspan="2" style="width: 40mm; padding: 2pt;">P/O No.</td>
                    <td style="width:5mm; padding: 2pt;">:</td>
                    <td style="padding: 2pt;">{{$plans[0]->no_document}}</td>
                  </tr>
                  <!--<tr>
                    <td colspan="2" style="width: 40mm; padding: 2pt;">P/O Date.</td>
                    <td style="width:5mm; padding: 2pt;">:</td>
                    <td></td>
                  </tr>
                  <tr>
                    <td colspan="2" style="width: 40mm; padding: 2pt;">Salesman</td>
                    <td style="width:5mm; padding: 2pt;">:</td>
                    <td></td>
                  </tr>-->
                  <tr>
                    <td colspan="2" style="width: 40mm; padding: 2pt;">Car No.</td>
                    <td style="width:5mml; padding: 2pt;">:</td>
                    <td>{{ $request['vehicle_no'] }}</td>
                  </tr>
                  <tr>
                    <td colspan="2" style="width: 40mm; padding: 2pt;">Driver</td>
                    <td style="width:5mm; padding: 2pt;">:</td>
                    <td>{{ $request['driver'] }}</td>
                  </tr>
                  <tr>
                    <td colspan="2" style="width: 40mm; padding: 2pt;">Transport</td>
                    <td style="width:5mm; padding: 2pt;">:</td>
                    <td>{{ $request['expedition'] }}</td>
                  </tr>
                  <tr><td>&nbsp;</td></tr>
                  <tr><td>&nbsp;</td></tr>
                  <tr><td>&nbsp;</td></tr>
                </table>
              </td>
            </tr>
            <tr>
              <td>
                <table width="100%" style="font-family: Arial; font-size: 8pt;">
                  <tr>
                    <td style="text-align: center; width: 15mm; padding: 2pt;">No</td>
                    <td colspan="2" style="text-align: center; width: 35mm; padding: 2pt;">Model</td>
                    <td colspan="2" style="text-align: center; width: 35mm; padding: 2pt;">Description</td>
                    <td style="text-align: center; width: 20mm; padding: 2pt;">Vol (M3)</td>
                    <td colspan="2" style="text-align: center; width: 15mm; padding: 2pt;">Qty</td>
                    <td style="text-align: center; width: 30mm; padding: 2pt;">No. Seri</td>
                    <td  colspan="2" style="text-align: center; width: 30mm; padding: 2pt;">St.bin</td>
                    <td style="text-align: center; width: 30mm; padding: 2pt;">Remark</td>
                  </tr>
                  @php
                    $total_cbm = 0;
                    $total_qty = 0;
                  @endphp
                  @foreach($plans AS $kPlan => $vPlan)
                  @php
                    $total_cbm += ($vPlan->cbm * $vPlan->qty);
                    $total_qty += $vPlan->qty;
                  @endphp
                  <tr><td>&nbsp;</td></tr>
                  <tr>
                    <td style="text-align: center; padding: 2pt;">{{$kPlan + 1}}</td>
                    <td colspan="2" style="padding: 2pt;">{{$vPlan->model}}</td>
                    <td colspan="2" style="padding: 2pt;" >{{$vPlan->description}}</td>
                    <td style="text-align: right; padding: 2pt;">{{($vPlan->cbm * $vPlan->qty)}}</td>
                    <td colspan="2" style="text-align: center; padding: 2pt;">{{$vPlan->qty}}</td>
                    <td></td>
                    <td colspan="2" style="padding: 2pt;" ></td>
                    <td></td>
                  </tr>
									@if ((($kPlan + 1) % 15) = 0)
									<pagebreak/>
									@endif
                  @endforeach
                  <tr><td>&nbsp;</td></tr>
                  <tr>
                    <td></td>
                    <td colspan="4" style="padding: 2pt;">Total</td>
                    <td style="text-align: right; padding: 2pt;">{{ setDecimal($total_cbm) }}</td>
                    <td colspan="2" style="text-align: center; padding: 2pt;">{{ $total_qty }}</td>
                  </tr>
                  <tr><td>&nbsp;</td></tr>
                  <tr>
                    <td></td>
                    <td style="padding: 2pt;">REMARK</td>
                    <td style="padding: 2pt;">:</td>
                    <td style="text-align: left; padding: 2pt;">{{$vPlan->remark}}</td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
    <footer >   
	</footer>
</body>
