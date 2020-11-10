<link rel="stylesheet" type="text/css" href="{{ url('materialize/css/custom/print1-a4.css') }}">
{{-- @include('layouts.materialize.components.print-style') --}}

<body style="font-family: courier New; font-size: 10pt;">
   <table style="font-family: Arial;">
      <tr>
         <td>
            <table style="width: 210.0003mm;">
               <tr>
                  <td>
                     <table width="100%" style=" font-size: 10pt;">
                        <tr>
                           <td>&nbsp;</td>
                        </tr>
                        <tr>
                           <td>&nbsp;</td>
                        </tr>
                        <tr>
                           <td colspan="8" style="font-size: 12pt; text-align: center;"><strong>BERITA ACARA BARANG DURING</strong></td>
                        </tr>
                        <tr>
                           <td colspan="8" style="font-size: 12pt; text-align: center;"><strong>No : {{!empty($berita_acara->berita_acara_during_no)?$berita_acara->berita_acara_during_no:'-'}}</strong></td>
                        </tr>
                        <tr>
                           <td>&nbsp;</td>
                        </tr>
                        <tr>
                           <td colspan="4" style="width: 120mm;"></td>
                           <td style="width: 35mm;">No. Container</td>
                           <td style="width: 5mm;">:</td>
                           <td colspan="2" style="width: 50mm;">{{!empty($berita_acara->container_no)?$berita_acara->container_no:'-'}}</td>
                        </tr>
                        <tr>
                           <td colspan="4"></td>
                           <td>Jenis Kerusakan</td>
                           <td>:</td>
                           <td colspan="2">{{!empty($berita_acara->damage_type)?$berita_acara->damage_type:'-'}}</td>
                        </tr>
                        <tr>
                           <td colspan="4">Logistic &amp; Distribution Section</td>
                           <td colspan="4"></td>
                        </tr>
                        <tr>
                           <td colspan="4">PT.Sharp Trading Indonesia</td>
                           <td></td>
                           <td></td>
                           <td colspan="2"></td>
                        </tr>
                        <tr>
                           <td colspan="4">Jakarta</td>
                           <td><strong>Tanggal Report</strong></td>
                           <td><strong>:</strong></td>
                           <td colspan="2"><strong>{{!empty($berita_acara->tanggal_berita_acara)?date('d M Y',strtotime($berita_acara->tanggal_berita_acara)):'-'}}</strong></td>
                        </tr>
                        <tr>
                           <td>&nbsp;</td>
                        </tr>
                     </table>
                  </td>
               </tr>
               <tr>
                  <td>
                     <table width="100%" style="font-size: 10pt; border-collapse: collapse;">
                        <tr>
                           <td style="text-align: center; border: 1pt solid #000000; width: 20mm;"><strong>No</strong></td>
                           <td colspan="2" style="text-align: center; border: 1pt solid #000000; width: 40mm;"><strong>Model</strong></td>
                           <td style="text-align: center; border: 1pt solid #000000; width: 15mm;"><strong>Qty</strong></td>
                           <td style="text-align: center; border: 1pt solid #000000; width: 20mm;"><strong>P.O.M</strong></td>
                           <td style="text-align: center; border: 1pt solid #000000; width: 50mm;"><strong>Serie No</strong></td>
                           <td colspan="2" style="text-align: center; border: 1pt solid #000000; "><strong>Kerusakan</strong></td>
                        </tr>
                        @php
                        $no=1;
                        @endphp
                        @if (!empty($detail))
                        @foreach($detail as $k =>$v)
                        <tr>
                           <td style="text-align: center; border: 1pt solid #000000;"><strong>{{$no}}</strong></td>
                           <td colspan="2" style="text-align: center; border: 1pt solid #000000;">{{!empty($v['model_name'])?$v['model_name']:'-'}}</td>
                           <td style="text-align: center; border: 1pt solid #000000;">{{!empty($v['qty'])?$v['qty']:'-'}}</td>
                           <td style="text-align: center; border: 1pt solid #000000;">{{!empty($v['pom'])?$v['pom']:'-'}}</td>
                           <td style="text-align: center; border: 1pt solid #000000;">{{!empty($v['serial_number'])?$v['serial_number']:'-'}}</td>
                           <td colspan="2" style="text-align: center; border: 1pt solid #000000;"><strong>{{!empty($v['damage'])?$v['damage']:'-'}}</strong></td>
                        </tr>
                        @php
                        $no++;
                        @endphp
                        @endforeach
                        @else
                        <tr>
                           <td colspan="8" style="text-align: center; border: 1pt solid #000000;"><i>No Data</i></td>
                        </tr>
                        @endif
                     </table>
                  </td>
               </tr>
            </table>
         </td>
      </tr>
   </table>