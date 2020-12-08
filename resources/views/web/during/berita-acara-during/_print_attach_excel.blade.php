<table width="100%" style=" font-size: 8pt;border-collapse: collapse;">
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
      <td><strong>Tanggal Kejadian</strong></td>
      <td><strong>:</strong></td>
      <td colspan="2"><strong>{{!empty($berita_acara->tanggal_kejadian)?date('d M Y',strtotime($berita_acara->tanggal_kejadian)):'-'}}</strong></td>
   </tr>
   <tr>
      <td colspan="4"></td>
      <td><strong>Tanggal Report</strong></td>
      <td><strong>:</strong></td>
      <td colspan="2"><strong>{{!empty($berita_acara->tanggal_berita_acara)?date('d M Y',strtotime($berita_acara->tanggal_berita_acara)):'-'}}</strong></td>
   </tr>
   <tr>
      <td>&nbsp;</td>
   </tr>
</table>
<table width="100%" style="border-collapse: collapse;">
   <tr>
      <td style="text-align: center;vertical-align: text-top;" class="border" colspan="2">
         CONTAINER DATANG
         <br>


         <img class="materialboxed" width="200px" src="{{'storage/'. $berita_acara->photo_container_came}}">
      </td>
      <td style="text-align: center;vertical-align: text-top;" class="border" colspan="2">
         SEAL NO
         <br>
         <br>
         <img class="materialboxed" width="200px" src="{{'storage/'. $berita_acara->photo_seal_no}}">
      </td>
      <td style="text-align: center;vertical-align: text-top;" class="border" colspan="2">
         LOADING
         <br>
         <br>
         <img class="materialboxed" width="200px" src="{{'storage/'. $berita_acara->photo_loading}}">
      </td>
      <td style="text-align: center;vertical-align: text-top;" class="border" colspan="2">
         CONTAINER SESUDAH LOADING
         <br>
         <br>
         <img class="materialboxed" width="200px" src="{{'storage/'. $berita_acara->photo_container_loading}}">
      </td>
   </tr>

   <tr>
      <td colspan="4" style="text-align: center;" class="border">
         &nbsp;
      </td>
   </tr>
   <!-- <tr> -->
   @php $count=-1;@endphp
   @forelse($detail as $k =>$v)
   @php $count++;@endphp
   @if($count%2 == 0)
   <tr>
      @endif
      <td style="text-align: center;vertical-align: text-top;" class="border" colspan="2">
         {{$v['model_name']}}
         <br>
         <br>
         <img class="materialboxed" width="200px" src="{{'storage/'. $v['photo_damage']}}">
      </td>
      <td style="text-align: center;vertical-align: text-top;" class="border" colspan="2">
         {{$v['serial_number']}}
         <br>
         <br>
         <img class="materialboxed" width="200px" src="{{'storage/'. $v['photo_serial_number']}}">
      </td>
      @empty
      @endforelse

      @if($count%2 == 0)
      <td colspan="2" style="text-align: center;vertical-align: text-top;" class="border">
      </td>
      @endif
</table>