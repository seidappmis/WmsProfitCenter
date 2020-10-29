<html>

<head>
   <link rel="stylesheet" type="text/css" href="{{ url('materialize/css/custom/print1-a4.css') }}">
   {{-- @include('layouts.materialize.components.print-style') --}}

</head>

<body style="font-family: courier New; font-size: 10pt;">
   <!--mpdf
<htmlpagefooter name="myheader">
  <div style="position:absolute;top:5mm;right:10mm;" v="Page {PAGENO} of {nb}">
  
  </div>
  </htmlpagefooter>
<sethtmlpagefooter name="myheader" value="on" />
mpdf-->

   <table width="100%">
      <!-- <tr><td>&nbsp;</td></tr> -->
      <!-- <tr><td>&nbsp;</td></tr> -->
      <tr>
         <td style="text-align: center; font-size: 12pt;" colspan="7"><strong>BERITA ACARA</strong></td>
      </tr>
      <tr>
         <td>&nbsp;</td>
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
         <table width="100%" style="border-collapse: collapse; text-align: center;">
            {{-- Head --}}
            <tr>
               <td style="border: 1pt solid #000000;">No.</td>
               <td style="border: 1pt solid #000000;">No. DO</td>
               <td style="border: 1pt solid #000000;">Model/Item No.</td>
               <td style="border: 1pt solid #000000;">No. Seri</td>
               <td style="border: 1pt solid #000000;">Qty</td>
               <td style="border: 1pt solid #000000;">Jenis Kerusakan</td>
               <td style="border: 1pt solid #000000; width: 50mm;">Keterangan</td>
            </tr>
            {{-- Body --}}
            @php
            $no = 1;
            $qty = 0;
            @endphp
            @if(!empty($beritaAcaraDetail))
            @foreach($beritaAcaraDetail as $key => $value)
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
            @endforeach
            @endif
            <tr>
               <td>&nbsp;</td>
            </tr>
            <tr>
               <td colspan="4" style="border: 1pt solid #000000;"><strong>Total</strong></td>
               <td style="border: 1pt solid #000000;">{{$qty}}</td>
            </tr>
         </table>
      </tr>
   </table>

   <footer>
   </footer>

</body>

</html>