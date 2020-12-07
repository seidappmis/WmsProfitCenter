<html>

<head>
   <link rel="stylesheet" type="text/css" href="{{ url('materialize/css/custom/print1-a4.css') }}">
   {{-- @include('layouts.materialize.components.print-style') --}}

</head>

<body style="font-family: courier New; font-size: 10pt;">

   <table width="100%" style="border-collapse: collapse;">
      <!-- <tr><td>&nbsp;</td></tr> -->
      <!-- <tr><td>&nbsp;</td></tr> -->
      <tr>
         <td style="text-align: center; font-size: 12pt;" colspan="7"><strong>BERITA ACARA</strong></td>
      </tr>
      <tr>
         <td colspan="3">
            Kepada Yth <br>
            Bp. Firman / Chairul A. (Logistic) <br>
            PT. Sharp Electronic Indonesia <br>
            Jakarta
         </td>
      </tr>
      <tr>
         <td>&nbsp;</td>
      </tr>
      <tr>
         <td style="text-align: left; width: 40mm;"><strong>Hal</strong></td>
         <td style="width: 3mm;"><strong>:</strong></td>
         <td><strong>BERITA ACARA KARTON BOX DAN UNIT RUSAK</strong></td>
      </tr>
      <tr>
         <td style="text-align: left; width: 40mm;"><strong>No. Berita Acara</strong></td>
         <td style="width: 3mm;"><strong>:</strong></td>
         <td><strong>{{$beritaAcara->berita_acara_no}}</strong></td>
      </tr>

      <tr>
         <td>&nbsp;</td>
      </tr>
      <tr>
         <td>Dengan hormat,</td>
      </tr>
      <tr>
         <td>&nbsp;</td>
      </tr>
      <tr>
         <td>&nbsp;</td>
      </tr>
      <tr>
         <td>Tgl Terima</td>
         <td>:</td>
         <td>{{ date('d/m/Y', strtotime($beritaAcara->date_of_receipt)) }}</td>
      </tr>
      <tr>
         <td>Nama Ekspedisi</td>
         <td>:</td>
         <td>{{$beritaAcara->expedition_code}}</td>
      </tr>
      <tr>
         <td>Nama Pengemudi</td>
         <td>:</td>
         <td>{{$beritaAcara->driver_name}}</td>
      </tr>
      <tr>
         <td>No. Polisi</td>
         <td>:</td>
         <td>{{$beritaAcara->vehicle_number}}</td>
      </tr>
      <tr>
         <td>&nbsp;</td>
      </tr>
      <tr>
         {{-- Detail Table --}}
      <tr>
         <td style="border: 1pt solid #000000; text-align:center;">No.</td>
         <td style="border: 1pt solid #000000; text-align:center;width: 15mm;">No. DO</td>
         <td style="border: 1pt solid #000000; text-align:center;">Model/Item No.</td>
         <td style="border: 1pt solid #000000; text-align:center;">No. Seri</td>
         <td style="border: 1pt solid #000000; text-align:center;">Qty</td>
         <td style="border: 1pt solid #000000; text-align:center;">Jenis Kerusakan</td>
         <td style="border: 1pt solid #000000; text-align:center; width: 50mm;">Keterangan</td>
      </tr>
      {{-- Body --}}
      @php
      $no = 1;
      $qty = 0;
      @endphp
      @if(!empty($beritaAcaraDetail))
      @forelse($beritaAcaraDetail as $key => $value)
      <tr>
         <td style="border: 1pt solid #000000;">{{$no}}.</td>
         <td style="border: 1pt solid #000000;">{{$value['do_no']}}</td>
         <td style="border: 1pt solid #000000;">{{$value['model_name']}}</td>
         <td style="border: 1pt solid #000000;">{{$value['serial_number']}}</td>
         <td style="border: 1pt solid #000000;">{{$value['qty']}}</td>
         <td style="border: 1pt solid #000000;">{{$value['description']}}</td>
         <td style="border: 1pt solid #000000; width: 50mm;">{{$value['keterangan']}}</td>
      </tr>
      @php
      $no ++;
      $qty+=$value['qty'];
      @endphp
      @empty
      <tr>
         <td colspan="7" style="border: 1pt solid #000000;text-align:center;"><i>no data avalaible</i></td>
      </tr>
      @endforelse
      @endif
      <tr>
         <td>&nbsp;</td>
      </tr>
      <tr>
         <td colspan="4" style="border: 1pt solid #000000;"><strong>Total</strong></td>
         <td style="border: 1pt solid #000000;">{{$qty}}</td>
      </tr>
      <tr>
         <td>&nbsp;</td>
      </tr>
      <tr>
         <td>&nbsp;</td>
      </tr>
      <tr>
         <td colspan="7">
            Demikian pemberitahuan ini kami sampaikan agar dapat di proses secepatnya,
         </td>
      </tr>
      <tr>
         <td colspan="7">
            Atas kerjasamanya kami ucapkan terima kasih
         </td>
      </tr>
      <tr>
         <td colspan="7">
            {{$detail['area']}} , {{date('d M Y', strtotime($beritaAcara->date_of_receipt))}} <br><br>
         </td>
      </tr>
      <tr>
         <td colspan="7">
            Mengetahui,
         </td>
      </tr>
      <tr>
         <td style="text-align:center; height: 40mm; vertical-align: bottom;" colspan="2">
            {{$detail['branch_manager']}}
         </td>
         <td style="text-align:center; height: 40mm; vertical-align: bottom;" colspan="1">
            {{$detail['chief_admin']}}
         </td>
         <td style="text-align:center; height: 40mm; vertical-align: bottom;" colspan="3">
            {{$detail['chief_warehouse']}}
         </td>
         <td style="text-align:center; height: 40mm; vertical-align: bottom;">
            {{$detail['supir']}}
         </td>
      </tr>
      <tr>
         <td style="text-align:center;" colspan="2">
            <div width="100%" style="margin: auto;border-top: 1pt solid #000000;">
               Branch Manager
            </div>
         </td>
         <td style="text-align:center;" colspan="1">
            <div width="100%" style="margin: auto;border-top: 1pt solid #000000;">
               Chief Admin
            </div>
         </td>
         <td style="text-align:center;" colspan="3">
            <div width="100%" style="margin: auto;border-top: 1pt solid #000000;">
               Chief Warehouse
            </div>
         </td>
         <td style="text-align:center;">
            <div width="100%" style="margin: auto;border-top: 1pt solid #000000;">
               Supir
            </div>
         </td>
      </tr>
   </table>

   <footer>
   </footer>

</body>

</html>