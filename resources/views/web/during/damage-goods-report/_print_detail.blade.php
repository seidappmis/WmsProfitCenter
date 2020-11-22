<table style="font-family: Arial;border-collapse: collapse;" width="100%">

   <tr>
      <td style="text-align: center; border: 1pt solid #000000; width: 10mm;"><strong>NO</strong></td>
      <td style="text-align: center; border: 1pt solid #000000; width: 20mm;"><strong>DATE</strong></td>
      <td style="text-align: center; border: 1pt solid #000000; width: 10mm;"><strong>NO DOC</strong></td>
      <td style="text-align: center; border: 1pt solid #000000; width: 35mm;"><strong>NO. BERITA ACARA</strong></td>
      <td style="text-align: center; border: 1pt solid #000000; width: 30mm;"><strong>INVOICE NO</strong></td>
      <td style="text-align: center; border: 1pt solid #000000; width: 30mm;"><strong>B/L NO</strong></td>
      <td style="text-align: center; border: 1pt solid #000000; width: 30mm;"><strong>CONTAINER NO</strong></td>
      <td style="text-align: center; border: 1pt solid #000000; width: 25mm;"><strong>VENDOR</strong></td>
      <td style="text-align: center; border: 1pt solid #000000; width: 25mm;"><strong>MODEL</strong></td>
      <td style="text-align: center; border: 1pt solid #000000; width: 15mm;"><strong>QTY</strong></td>
      <td style="text-align: center; border: 1pt solid #000000; width: 30mm;"><strong>NO. SERI</strong></td>
      <td style="text-align: center; border: 1pt solid #000000; width: 57mm;"><strong>CLAIM</strong></td>
      <td style="text-align: center; border: 1pt solid #000000; width: 57mm;"><strong>REMARKS</strong></td>
   </tr>
   @php $no=1; $total=0; @endphp
   @forelse($detail as $k =>$v)

   @php $total+=$v['ba_qty']; @endphp
   <tr>
      <td style="text-align: center; vertical-align: top; border: 1pt solid #000000;">{{$no++}}</td>
      <td style="text-align: center; vertical-align: top; border: 1pt solid #000000;">{{date('d M Y',strtotime($v['created_at']))}}</td>
      <td style="text-align: center; vertical-align: top; border: 1pt solid #000000;">{{$v['dgr_no']}}</td>
      <td style="text-align: center; vertical-align: top; border: 1pt solid #000000;">{{$v['berita_acara_during_no']}}</td>
      <td style="text-align: center; vertical-align: top; border: 1pt solid #000000;">{{$v['invoice_no']}}</td>
      <td style="text-align: center; vertical-align: top; border: 1pt solid #000000;">{{$v['bl_no']}}</td>
      <td style="text-align: center; vertical-align: top; border: 1pt solid #000000;">{{$v['container_no']}}</td>
      <td style="text-align: center; vertical-align: top; border: 1pt solid #000000;">{{$v['expedition_name']}}</td>
      <td style="text-align: center; vertical-align: top; border: 1pt solid #000000;">{{$v['model_name']}}</td>
      <td style="text-align: center; vertical-align: top; border: 1pt solid #000000;">{{$v['ba_qty']}}</td>
      <td style="text-align: center; vertical-align: top; border: 1pt solid #000000;">{{$v['serial_number']}}</td>
      <td style="text-align: center; vertical-align: top; border: 1pt solid #000000;">{{$v['claim']}}</td>
      <td style="text-align: center; vertical-align: top; border: 1pt solid #000000;"><strong>{{$v['damage']}}</strong></td>
   </tr>
   @empty
   <!-- <tr>
   <td style="text-align: center; vertical-align: middle; border: 1pt solid #000000;">{{$v['berita_acara_during_no']}}</td>
 </tr> -->
   @endforelse
   <tr>
      <td colspan="8" style="text-align: center; border: 1pt solid #000000;"><strong>TOTAL</strong></td>
      <td style="text-align: center; border: 1pt solid #000000;">{{$total}}</td>
      <td colspan="4" style="border: 1pt solid #000000;"></td>
   </tr>
</table>