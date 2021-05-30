<link rel="stylesheet" type="text/css" href="{{ url('materialize/css/custom/print1-a4.css') }}">
{{-- @include('layouts.materialize.components.print-style') --}}

<body style="font-family: courier New; font-size: 10pt;">

   <table style="font-family: Arial;">
      <tr>
         <td>
            <table style="width: 793.8px;">
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
                           <td colspan="8" style="font-size: 12pt; text-align: center; font-style: italic;"><strong>No : {{!empty($berita_acara->berita_acara_during_no)?$berita_acara->berita_acara_during_no:'-'}}</strong></td>
                        </tr>
                        <tr>
                           <td>&nbsp;</td>
                        </tr>
                        <tr>
                           <td colspan="8">Kepada Yth.</td>
                        </tr>
                        <tr>
                           <td colspan="8">Logistic &amp; Distribution Section</td>
                        </tr>
                        <tr>
                           <td colspan="8">PT.Sharp Trading Indonesia</td>
                        </tr>
                        <tr>
                           <td colspan="8">Jakarta</td>
                        </tr>
                        <tr>
                           <td>&nbsp;</td>
                        </tr>
                     </table>
                  </td>
               </tr>
               <tr>
                  <td>
                     <table width="100%" style=" font-size: 10pt;">
                        <tr>
                           <td colspan="8">Pada hari kami menemukan barang rusak dengan data sebagai berikut :</td>
                        </tr>
                        <tr>
                           <td style="width: 94.5px;">Tanggal</td>
                           <td style="width: 18.9px;">:</td>
                           <td colspan="3" style="width: 226.8px;"><strong>{{!empty($berita_acara->tanggal_berita_acara)?date('d M Y',strtotime($berita_acara->tanggal_berita_acara)):'-'}}</strong></td>
                           <td colspan="3">Jenis Kerusakan :</td>
                        </tr>
                        <tr>
                           <td>Kapal</td>
                           <td>:</td>
                           <td colspan="3"><strong>{{!empty($berita_acara->ship_name)?$berita_acara->ship_name:'-'}}</strong></td>
                           <td colspan="3">{{!empty($berita_acara->damage_type)?$berita_acara->damage_type:'-'}}</td>
                        </tr>
                        <tr>
                           <td>Invoice No</td>
                           <td>:</td>
                           <td colspan="3"><strong>{{!empty($berita_acara->invoice_no)?$berita_acara->invoice_no:'-'}}</strong></td>
                           <td colspan="3" style="font-weight: bold;"></td>
                        </tr>
                        <tr>
                           <td>Contr No</td>
                           <td>:</td>
                           <td colspan="3"><strong>{{!empty($berita_acara->container_no)?$berita_acara->container_no:'-'}}</strong></td>
                           <td colspan="3"></td>
                        </tr>
                        <tr>
                           <td>B/L No</td>
                           <td>:</td>
                           <td colspan="3"><strong>{{!empty($berita_acara->bl_no)?$berita_acara->bl_no:'-'}}</strong></td>
                           <td colspan="3"></td>
                        </tr>
                        <tr>
                           <td>Seal No</td>
                           <td>:</td>
                           <td colspan="3"><strong>{{!empty($berita_acara->seal_no)?$berita_acara->seal_no:'-'}}</strong></td>
                           <td colspan="3"></td>
                        </tr>
                        <tr>
                           <td>Truck No</td>
                           <td>:</td>
                           <td colspan="3"><strong>{{!empty($berita_acara->vehicle_number)?$berita_acara->vehicle_number:'-'}}</strong></td>
                           <td colspan="3"></td>
                        </tr>
                        <tr>
                           <td>Ekspedisi</td>
                           <td>:</td>
                           <td colspan="3"><strong>{{!empty($berita_acara->expedition_name)?$berita_acara->expedition_name:'-'}}</strong></td>
                           <td colspan="3"></td>
                        </tr>
                        <tr>
                           <td>Cuaca</td>
                           <td>:</td>
                           <td colspan="3"><strong>{{!empty($berita_acara->weather)?$berita_acara->weather:'-'}}</strong></td>
                           <td colspan="3"></td>
                        </tr>
                        <tr>
                           <td>Jam Kerja</td>
                           <td>:</td>
                           <td colspan="3"><strong>{{!empty($berita_acara->working_hour)?$berita_acara->working_hour:'-'}}</strong></td>
                           <td colspan="3"></td>
                        </tr>
                        <tr>
                           <td>Lokasi</td>
                           <td>:</td>
                           <td colspan="3"><strong>{{!empty($berita_acara->location)?$berita_acara->location:'-'}}</strong></td>
                           <td colspan="3"></td>
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
                           <td style="text-align: center; border: 1pt solid #000000; width: 75.6px;"><strong>No</strong></td>
                           <td colspan="2" style="text-align: center; border: 1pt solid #000000; width: 151.2px;"><strong>Model</strong></td>
                           <td style="text-align: center; border: 1pt solid #000000; width: 56.7px;"><strong>Qty</strong></td>
                           <td style="text-align: center; border: 1pt solid #000000; width: 75.6px;"><strong>P.O.M</strong></td>
                           <td style="text-align: center; border: 1pt solid #000000; width: 189px;"><strong>Serie No</strong></td>
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
                        <tr>
                           <td>&nbsp;</td>
                        </tr>
                     </table>
                  </td>
               </tr>
               <tr>
                  <td>
                     <table width="100%" style=" font-size: 10pt;">
                        <tr>
                           <td style="width: 94.5px;"><strong>KET</strong></td>
                           <td style="width: 18.9px;"><strong>:</strong></td>
                           <td colspan="6" style="width: ;"><strong>Kemasan Rusak/Basah Dari dalam Container</strong></td>
                        </tr>
                        <tr>
                           <td>&nbsp;</td>
                        </tr>
                        <tr>
                           <td colspan="8">Demikian Berita Acara ini kami buat dengan sebenarnya.</td>
                        </tr>
                        <tr>
                           <td colspan="8">Jakarta, {{date('d M Y', strtotime($berita_acara->tanggal_kejadian))}}</td>
                        </tr>
                        <tr>
                           <td>&nbsp;</td>
                        </tr>
                     </table>
                  </td>
               </tr>
               <tr>
                  <td>
                     <table width="100%" style=" font-size: 10pt;">
                        <tr>
                           <td colspan="7" style="text-align: center;">Mengetahui</td>
                        </tr>
                        <tr>
                           <td>&nbsp;</td>
                        </tr>
                        <tr>
                           <td>&nbsp;</td>
                        </tr>
                        <tr>
                           <td>&nbsp;</td>
                        </tr>
                        <tr>
                           <td>&nbsp;</td>
                        </tr>
                        <tr>
                           <td colspan="2" style="text-align: center; width: 113.4px; text-decoration: underline;"><strong>SULAM</strong></td>
                           <td style="text-align: center; width: 113.4px; text-decoration: underline;"><strong>RIYAN</strong></td>
                           <td colspan="2" style="text-align: center; width: 226.8px; text-decoration: underline;"><strong>RONY PASLAH</strong></td>
                           <td style="width: 113.4px;"></td>
                           <td style="text-align: center; width: 113.4px; text-decoration: underline;"><strong>HARDIAN</strong></td>
                           <td style="text-align: center; width: 113.4px; text-decoration: underline;"><strong>KUKUH</strong></td>
                        </tr>
                        <tr>
                           <td colspan="2" style="text-align: center;">Checker</td>
                           <td style="text-align: center;">Driver/Operator</td>
                           <td colspan="2" style="text-align: center;">Kepala Operasional</td>
                           <td></td>
                           <td style="text-align: center;">Staf Logistik</td>
                           <td style="text-align: center;">Staf Exim</td>
                        </tr>
                        <tr>
                           <td>&nbsp;</td>
                        </tr>
                     </table>
                  </td>
               </tr>
            </table>
         </td>
      </tr>
   </table>