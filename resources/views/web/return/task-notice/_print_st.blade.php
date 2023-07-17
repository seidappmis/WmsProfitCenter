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
              <tr>
                <td colspan="7"><img src="{{asset('images/sharp-logo.png')}}" alt="Sharp Logo" width="30%"></td>
              </tr>
              <tr>
                <td colspan="7" style="font-size: 9pt;"><strong>PT. SHARP ELECTRONICS INDONESIA</strong></td>
              </tr>
              <tr>
                <td colspan="7">Jl. Swadaya IV, Rawaterate</td>
              </tr>
              <tr>
                <td colspan="7">Cakung, Jakarta Timur</td>
              </tr>
              <tr><td>&nbsp;</td></tr>
              <tr>
                <td>PHONE</td>
                <td style="width: 5mm;">:</td>
                <td>46824070</td>
                <td colspan="3"></td>
                <td>No. DO</td>
                <td style="width: 5mm;">:</td>
                <td>{{$plans[0]->no_do}}</td>
              </tr>
              <tr>
                <td>FAX</td>
                <td style="width: 5mm;">:</td>
                <td>46824066</td>
                <td colspan="3"></td>
                <td>No. Doc</td>
                <td style="width: 5mm;">:</td>
                <td>{{$plans[0]->no}}</td>
              </tr>
              <tr>
                <td colspan="2">Jakarta</td>
                <td>13920</td>
                <td colspan="3"></td>
                <td>Date</td>
                <td style="width: 5mm;">:</td>
                <td>{{$header->date}}</td>
              </tr>
              <tr>
                <td colspan="3">INDONESIA</td>
                <td colspan="3"></td>
                <td>No. App</td>
                <td style="width: 5mm;">:</td>
                <td>{{$header->no_document}}</td>
              </tr>
              <tr><td>&nbsp;</td></tr>
            </table>
          </td>
        </tr>
        <tr>
          <td>
            <table width="100%" style="font-family: Arial; font-size: 8pt;">
              <tr>
                <td colspan="7" style="font-size: 9pt; text-align: center;"><strong>SURAT TUGAS</strong></td>
              </tr>
              <tr>
                <td colspan="7" style="font-size: 9pt; text-align: center;"><strong>PENARIKAN BARANG RETUR</strong></td>
              </tr>
              <tr><td>&nbsp;</td></tr>
              <tr>
                <td colspan="7">BERSAMA INI KAMI DARI PT. SHARP ELECTRONICS INDONESIA MENUGASKAN KEPADA</td>
              </tr>
              <tr>
                <td style="width: 30mm;">EKSPEDISI</td>
                <td style="width: 5mm;">:</td>
                <td>{{ $request['expedition'] }}</td>
              </tr>
              <tr>
                <td style="width: 30mm;">NO. POLISI</td>
                <td style="width: 5mm;">:</td>
                <td>{{ $request['vehicle_no'] }}</td>
              </tr>
              <tr>
                <td style="width: 30mm;">SUPIR</td>
                <td style="width: 5mm;">:</td>
                <td>{{ $request['driver'] }}</td>
              </tr>
              <tr>
                <td colspan="7">UNTUK MENGAMBIL BARANG PRODUCT SHARP SEBAGAI BERIKUT</td>
              </tr>
              <tr><td>&nbsp;</td></tr>
            </table>
          </td>
        </tr>
        <tr>
          <td>
            <table width="100%" style="font-family: Arial; font-size: 8pt; border-collapse: collapse;">
              <tr>
                <td style="text-align: center; border: 1pt solid #000000; padding: 2pt;">NO</td>
                <td style="text-align: center; border: 1pt solid #000000; padding: 2pt;">MODEL</td>
                <td style="text-align: center; border: 1pt solid #000000; padding: 2pt;">DESCRIPTION</td>
                <td style="text-align: center; border: 1pt solid #000000; padding: 2pt;">NO. SERI</td>
                <td style="text-align: center; border: 1pt solid #000000; padding: 2pt;">QTY</td>
                <td style="text-align: center; border: 1pt solid #000000; padding: 2pt;">CBM</td>
                <td style="text-align: center; border: 1pt solid #000000; padding: 2pt;">KETERANGAN</td>
              </tr>
              @php
              $total_qty = 0;
              $total_cbm = 0;
              @endphp
              @foreach($plans AS $kPlan => $vPlan )
              @php
              $total_qty += $vPlan->qty;
              $total_cbm += ($vPlan->cbm * $vPlan->qty);
              @endphp
              <tr>
                <td style="border: 1pt solid #000000; text-align: center; padding: 2pt;">{{$kPlan + 1}}</td>
                <td style="border: 1pt solid #000000; padding: 2pt;">{{$vPlan->model}}</td>
                <td style="border: 1pt solid #000000; padding: 2pt;">{{$vPlan->description}}</td>
                <td style="border: 1pt solid #000000; padding: 2pt;">(TERLAMPIR)</td>
                <td style="border: 1pt solid #000000; text-align: center; padding: 2pt;">{{$vPlan->qty}}</td>
                <td style="border: 1pt solid #000000; text-align: center; padding: 2pt;">{{($vPlan->cbm * $vPlan->qty)}}</td>
                <td style="border: 1pt solid #000000; padding: 2pt;">{{$vPlan->remark}}</td>
              </tr>
              @endforeach
              <tr>
                <td colspan="3" style="border: 1pt solid #000000;"></td>
                <td style="border: 1pt solid #000000; text-align: center; padding: 2pt;">TOTAL</td>
                <td style="text-align: center; border: 1pt solid #000000; padding: 2pt;">{{$total_qty}}</td>
                <td style="text-align: center; border: 1pt solid #000000; padding: 2pt;">{{$total_cbm}}</td>
                <td style="border: 1pt solid #000000;"></td>
              </tr>
              <tr><td>&nbsp;</td></tr>
            </table>
          </td>
        </tr>
      </table>
      <?php /* <footer> */ ?>
      <table style="width: 210.0003mm;">
        <tr>
          <td>
            <table width="100%" style="font-family: Arial; font-size: 8pt;">
              <tr>
                <td colspan="7" style="padding: 2pt;">DARI :</td>
              </tr>
              <tr>
                <td style="padding: 2pt;">SHIP TO</td>
                <td style="padding: 2pt;">:</td>
                <td style="padding: 2pt;">{{$vPlan->costumer_name}}</td>
                <td style="padding: 2pt;">{{$vPlan->costumer_code}}</td>
              </tr>
              <tr>
                <td style="padding: 2pt;">TEMPAT</td>
                <td style="padding: 2pt;">:</td>
                <td style="padding: 2pt;">{{$vPlan->location}}</td>
              </tr>
              <tr>
                <td style="padding: 2pt;">DOKUMEN</td>
                <td style="padding: 2pt;">:</td>
                <td style="padding: 2pt;">{{$vPlan->document}}</td>
              </tr>
              <tr>
                <td style="padding: 2pt;">WAKTU</td>
                <td style="padding: 2pt;">:</td>
                <td style="padding: 2pt;">{{$vPlan->return_date != '0000-00-00' ? $vPlan->return_date : ''}}</td>
              </tr>
              <tr>
                <td colspan="7" style="padding: 2pt;">ATAS PERHATIAN DAN KERJASAMANYA KAMI UCAPKAN TERIMA KASIH.</td>
              </tr>
              <tr>
                <td style="padding: 2pt;">Remarks</td>
                <td style="padding: 2pt;">:</td>
                <td style="padding: 2pt;">{{$vPlan->remark}}</td>
              </tr>
              <tr><td>&nbsp;</td></tr>
            </table>
          </td>
        </tr>
        <tr>
          <td>
            <table width="100%" style="font-family: Arial; font-size: 8pt;">
              <tr>
                <td>HORMAT KAMI,</td>
              </tr>
              <tr style="height: 100px;">
                <td style="text-align: center; vertical-align: bottom; border: black solid 1px; width: 150px;">
                  {{ $request['allocation'] }}<br>
                  ALLOCATION
                </td>
                <td></td>
                <td style="text-align: center; vertical-align: bottom; border: black solid 1px; width: 150px;">
                  {{ $request['admin_warehouse'] }}<br>
                  ADMIN WAREHOUSE
                </td>
              </tr>
              <tr>
                <td>Page 1 of 1</td>
                <td>Print Date : {{date('d M, Y')}}</td>
              </tr>
              <tr>
                <td>Print by : {{auth()->user()->username}}</td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      <?php /* </footer> */ ?>
    </td>
  </tr>
</table>
