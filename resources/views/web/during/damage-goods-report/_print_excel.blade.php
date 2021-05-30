<table style="font-family: Arial;border-collapse: collapse;" width="100%">
   <tr>
      <td>&nbsp;</td>
   </tr>
   <tr>
      <td>&nbsp;</td>
   </tr>
   <tr>
      <td colspan="11" style="text-align: center;"><strong>DAMAGE GOODS REPORT</strong></td>
   </tr>
   <tr>
      <td colspan="11" style="font-size: 9pt; text-align: center;"><strong>{{$dgr['dgr_no']}}</strong></td>
   </tr>
   <tr>
      <td>&nbsp;</td>
   </tr>
   <tr>
      <td colspan="11">Dear Sirs,</td>
   </tr>
   <tr>
      <td colspan="11">We would like inform you about the damage goods as location</td>
   </tr>
   <tr>
      <td colspan="11">Please rever to the attached file regarding return/damage report</td>
   </tr>
   <tr>
      <td>&nbsp;</td>
   </tr>
   <tr>
      <td colspan="11">Best Regards</td>
   </tr>
   <tr>
      <td colspan="11">ADMIN NITTSULEMO</td>
   </tr>
   <tr>
      <td>&nbsp;</td>
   </tr>
   <tr>
      <td colspan="11">DAMAGE GOODS DETAIL AS FOLLOW</td>
   </tr>


   <tr>
      <td style="text-align: center; border: 1pt solid #000000; width: 37.8px;"><strong>NO</strong></td>
      <td style="text-align: center; border: 1pt solid #000000; width: 75.6px;"><strong>DATE</strong></td>
      <td style="text-align: center; border: 1pt solid #000000; width: 132.3px;"><strong>NO. BERITA ACARA</strong></td>
      <td style="text-align: center; border: 1pt solid #000000; width: 113.4px;"><strong>INVOICE NO</strong></td>
      <td style="text-align: center; border: 1pt solid #000000; width: 113.4px;"><strong>B/L NO</strong></td>
      <td style="text-align: center; border: 1pt solid #000000; width: 113.4px;"><strong>CONTAINER NO</strong></td>
      <td style="text-align: center; border: 1pt solid #000000; width: 94.5px;"><strong>MODEL</strong></td>
      <td style="text-align: center; border: 1pt solid #000000; width: 56.7px;"><strong>POM</strong></td>
      <td style="text-align: center; border: 1pt solid #000000; width: 56.7px;"><strong>QTY</strong></td>
      <td style="text-align: center; border: 1pt solid #000000; width: 113.4px;"><strong>NO. SERI</strong></td>
      <td style="text-align: center; border: 1pt solid #000000; width: 215.46px;"><strong>REMARKS</strong></td>
   </tr>
   @php $no=1; $total=0; @endphp
   @forelse($detail as $k =>$v)

   @php $total+=$v['ba_qty']; @endphp
   <tr>
      <td style="text-align: center; vertical-align: top; border: 1pt solid #000000;">{{$no++}}</td>
      <td style="text-align: center; vertical-align: top; border: 1pt solid #000000;">{{date('d M Y',strtotime($v['created_at']))}}</td>
      <td style="text-align: center; vertical-align: top; border: 1pt solid #000000;">{{$v['berita_acara_during_no']}}</td>
      <td style="text-align: center; vertical-align: top; border: 1pt solid #000000;">{{$v['invoice_no']}}</td>
      <td style="text-align: center; vertical-align: top; border: 1pt solid #000000;">{{$v['bl_no']}}</td>
      <td style="text-align: center; vertical-align: top; border: 1pt solid #000000;">{{$v['container_no']}}</td>
      <td style="text-align: center; vertical-align: top; border: 1pt solid #000000;">{{$v['model_name']}}</td>
      <td style="text-align: center; vertical-align: top; border: 1pt solid #000000;">{{$v['pom']}}</td>
      <td style="text-align: center; vertical-align: top; border: 1pt solid #000000;">{{$v['ba_qty']}}</td>
      <td style="text-align: center; vertical-align: top; border: 1pt solid #000000;">{{$v['serial_number']}}</td>
      <td style="font-size: 7pt; text-align: center; vertical-align: top; border: 1pt solid #000000;"><strong>{{$v['damage']}}</strong></td>
   </tr>
   @empty
   <!-- <tr>
      <td style="text-align: center; vertical-align: middle; border: 1pt solid #000000;">{{$v['berita_acara_during_no']}}</td>
    </tr> -->
   @endforelse
   <tr>
      <td colspan="8" style="text-align: center; border: 1pt solid #000000;"><strong>TOTAL</strong></td>
      <td style="text-align: center; border: 1pt solid #000000;">{{$total}}</td>
      <td style="border: 1pt solid #000000;"></td>
      <td style="border: 1pt solid #000000;"></td>
   </tr>


   <tr>
      <td colspan="11">
         &nbsp;
      </td>
   </tr>
   <tr>
      <td colspan="9"></td>
      <td colspan="2" style="text-align: center;">Jakarta, {{date('d F Y')}}</td>
   </tr>
   <tr>
      <td>&nbsp;</td>
   </tr>
   <tr>
      <td colspan="7" style="text-align: center;">Approved,</td>
      <td colspan="2"></td>
      <td colspan="2" style="text-align: center;">PT. SHARP ELECTRONIC INDONESIA</td>
   </tr>
   <tr>
      <td colspan="7" style="text-align: center;">NITTSU LEMO INDONESIA LOGISTIC</td>
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
      <td>&nbsp;</td>
   </tr>
   <tr>
      <td colspan="2"></td>
      <td style="text-align: center;border-bottom: 1px solid #000000;">
      </td>
      <td></td>
      <td colspan="2" style="text-align: center;border-bottom: 1px solid #000000;">
      </td>
      <td colspan="3"></td>
      <td colspan="2" style="text-align: center;border-bottom: 1px solid #000000;">
      </td>
   </tr>
   <tr>
      <td colspan="2"></td>
      <td style="text-align: center;">SITE SUPERVISOR</td>
      <td></td>
      <td colspan="2" style="text-align: center;">LEADER</td>
      <td colspan="3" style="text-align: center;"></td>
      <td colspan="2" style="text-align: center;">STAFF LOGISTIC</td>
   </tr>

</table>