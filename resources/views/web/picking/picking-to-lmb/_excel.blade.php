<link rel="stylesheet" type="text/css" href="{{ url('materialize/css/custom/print1.css') }}">
<body style="font-family: Arial;" width="100%">

<table width="100%" style="font-size: 10pt;">
<tr>
    <td>&nbsp;</td>
</tr>
<tr>
    <td>&nbsp;</td>
</tr>
<tr>
    <td colspan="15" style="text-align: right; font-size: 10pt;"><strong>PT. SHARP
            ELECTRONICS INDONESIA</strong></td>
</tr>
<tr>
    <td colspan="15" style="text-align: center; font-size: 14pt;"><strong>LAPORAN MUATAN
            BARANG</strong></td>
</tr>
<tr>
    <td colspan="15" style="text-align: center; font-size: 10pt;"><strong>(Loading Goods
            Report)</strong></td>
</tr>
<tr>
    <td colspan="15" style="text-align: center; font-size: 12pt;"><strong>SHARP -
            PRODUCT</strong></td>
</tr>
<tr>
    <td>&nbsp;</td>
</tr>
<tr>
    <td colspan="2" style="width: 113.4px;">Tanggal</td>
    <td style="width: 18.9px;">:</td>
    <td colspan="4" style="width: 226.8px;">{{ date('d/m/Y h:i:s A', strtotime($lmbHeader->created_at)) }}</td>
    <td colspan="4" style="width: 151.2px;">No. Mobil/Jenis</td>
    <td style="width: 18.9px;">:</td>
    <td colspan="3">{{$lmbHeader->vehicle_number}}/{{$lmbHeader->destination_number != 'AS' ? $lmbHeader->picking->vehicle->vehicle_description : ''}}</td>
</tr>
<tr>
    <td colspan="2">Expedisi</td>
    <td>:</td>
    <td colspan="4">{{$lmbHeader->expedition_name}}</td>
    @if($lmbHeader->cabang->hq)
    <td colspan="4">No. Container</td>
    <td>:</td>
    <td colspan="3">{{$lmbHeader->container_no}}</td>
    @else 
    <td colspan="2">Customer</td>
    <td>:</td>
    <td colspan="3">{!! $lmbHeader->getCustomer() !!}</td>
    @endif
</tr>
<tr>
    <td colspan="2">Tujuan</td>
    <td>:</td>
    <td colspan="4">{{$lmbHeader->destination_name}}</td>
    <td colspan="4">No. Seal</td>
    <td>:</td>
    <td colspan="3">{{$lmbHeader->seal_no}}</td>
</tr>
<tr>
    <td colspan="2">Lokasi Gudang</td>
    <td>:</td>
    <td colspan="4">{{$lmbHeader->short_description_cabang}}</td>
    <td colspan="4">No. Picking</td>
    <td>:</td>
    <td colspan="3"><strong>{{$lmbHeader->picking->picking_no}}</strong></td>
</tr>
<tr>
    <td>&nbsp;</td>
</tr>
</table>
{{-- Main Table --}}
<table width="100%" style="border-collapse: collapse; font-size: 10pt;">
{{-- Table Head --}}
@php
$totaldata=0;
$list=[];
$s_row_total=0;
$chunk=[];
$chunks=[];
$c_row_size=0;
foreach($rs_details as $c=>$v){
    $totaldata++;
    $s_row_total = ceil(count($v['serial_numbers']) / 3);
    $cc=50;
    if(count($chunks)==0){
        $cc=43;
    }
    if(($c_row_size+=$s_row_total)>$cc){
        $chunks[]=$chunk;
        $chunk=[];
        $c_row_size=0;
    }
    $chunk[$c]=$v;
}
if(count($chunk)>0){
    $chunks[]=$chunk;
}
$row_no = 1;

@endphp
@foreach($chunks as $index=>$rs_details)
<tr>
    <td style="text-align: center; border: 1pt solid #000000; width: 37.8px;">NO</td>
    <td colspan="4" style="text-align: center; border: 1pt solid #000000; width: 1898px;">MODEL</td>
    <td colspan="2" style="text-align: center; border: 1pt solid #000000; width: 113.4px;">QTY</td>
    <td style="text-align: center; border: 1pt solid #000000; width: 113.4px;" colspan="8">NO. SERI</td>
    <td style="text-align: center; border-left: 1pt solid #000000; width: 3.78px;"></td>
</tr>
{{-- Table Body --}}
@php
$row_c=0;
@endphp
@foreach($rs_details AS $k_model => $v_model)
@php 
$row_c++;
$row_serial_pointer = 1;
$row_serial_total = ceil(count($v_model['serial_numbers']) / 3);
$serial_pointer = 0;
$qty = count($v_model['serial_numbers']);
@endphp
<tr>
    <td rowspan="{{$row_serial_total}}" style="
    text-align: center; 
    border-left: 1pt solid #000000; 
    border-right: 1pt solid #000000; 
    vertical-align: top;
    {{$row_no == $totaldata ? 'border-bottom: 1pt solid #000000;' : ''}}">
        {{$row_no}}
    </td>
    <td rowspan="{{$row_serial_total}}" colspan="4" style="
    text-align: center; 
    border-left: 1pt solid #000000; 
    border-right: 1pt solid #000000; 
    vertical-align: top;
    {{$row_no == $totaldata ? 'border-bottom: 1pt solid #000000;' : ''}}">
        {{$k_model}}
    </td>
    <td rowspan="{{$row_serial_total}}" colspan="2"  style="
    text-align: center; 
    border-left: 1pt solid #000000; 
    border-right: 1pt solid #000000; 
    vertical-align: top;
    {{$row_no == $totaldata ? 'border-bottom: 1pt solid #000000;' : ''}}">
        {{$qty}}
    </td>
    <td style="text-align: center;" colspan="3">
        {{!empty($v_model['serial_numbers'][$serial_pointer]) ? $v_model['serial_numbers'][$serial_pointer++] : ''}}
    </td>
    <td style="text-align: center;" colspan="3">
        {{!empty($v_model['serial_numbers'][$serial_pointer]) ? $v_model['serial_numbers'][$serial_pointer++] : ''}}
    </td>
    <td style="text-align: center; border-right: 1pt solid #000000; width: 3.78px;" colspan="2">
        {{!empty($v_model['serial_numbers'][$serial_pointer]) ? $v_model['serial_numbers'][$serial_pointer++] : ''}}
    </td>
    <td style="text-align: center; border-left: 1pt solid #000000; width: 3.78px;  width: 3.78px;"></td>
</tr>

@while($row_serial_pointer < $row_serial_total)
<tr>
    <td style="text-align: center; border-bottom: 1pt solid #000000;" colspan="3">
        {{!empty($v_model['serial_numbers'][$serial_pointer]) ? $v_model['serial_numbers'][$serial_pointer++] : ''}}
    </td>
    <td style="text-align: center; border-bottom: 1pt solid #000000;" colspan="3">
        {{!empty($v_model['serial_numbers'][$serial_pointer]) ? $v_model['serial_numbers'][$serial_pointer++] : ''}}
    </td>
    <td style="text-align: center; border-bottom: 1pt solid #000000;border-right: 1pt solid #000000; " colspan="2">
        {{!empty($v_model['serial_numbers'][$serial_pointer]) ? $v_model['serial_numbers'][$serial_pointer++] : ''}}
    </td>
    <td style="text-align: center; border-left: 1pt solid #000000; width: 3.78px;"></td>
</tr>

@php
$row_serial_pointer ++;
$row_c++;
@endphp
@endwhile

@php
$row_no++;
@endphp
@endforeach
    <tr>
        <td style="border-top: 1pt solid #000000;" colspan="16">&nbsp;</td></tr>
@php
$row_no++;
$c=57;
if($index==0){
  $c=36;
}else if($index==(count($chunks)-1)){
    $c=50;
}
@endphp

@for($i=0;$i<($c-($row_c));$i++)
<tr><td>&nbsp;</td></tr>
@endfor
@if(($c-($row_c)<=0) && $index==(count($chunks)-1))
    @for($b=0;$b<52;$b++)
    <tr><td>&nbsp;</td></tr>
    @endfor
@endif
@endforeach
</table>
{{-- End Main Table --}}

<!-- <footer> -->
<table width="100%" style="font-size: 10pt;">
<tr>
    <td rowspan="3" colspan="4"
        style="font-style: italic; width: 396.9px; word-wrap: break-word;">
        Pengangkut diharap memeriksa &amp; menghitung barang yang diangkut. *Claim
        kekurangan barang diluar areal pergudangan kami bukan menjadi tanggung jawab kami.
    </td>
    <td style="width: 18.9px;"></td>
    <td colspan="2" style="text-align: center; border: 1pt solid #000000; width: 75.6px;">
        LOADING</td>
    <td colspan="2" style="text-align: center; border: 1pt solid #000000; width: 75.6px;">ST.
        KEEPER</td>
    <td colspan="2" style="text-align: center; border: 1pt solid #000000; width: 75.6px;">
        CHECKER</td>
    <td colspan="2" style="text-align: center; border: 1pt solid #000000; width: 75.6px;">
        DRIVER</td>
    <td colspan="2" style="text-align: center; border: 1pt solid #000000; width: 75.6px;">
        DEALER</td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td colspan="2" rowspan="4" style="border: 1pt solid #000000;"></td>
    <td colspan="2" rowspan="4" style="border: 1pt solid #000000;"></td>
    <td colspan="2" rowspan="4" style="border: 1pt solid #000000;"></td>
    <td colspan="2" rowspan="4" style="border: 1pt solid #000000;"></td>
    <td colspan="2" rowspan="4" style="border: 1pt solid #000000;"></td>
</tr>
<tr>
    <td></td>
</tr>
<tr>
    <td colspan="2" style="font-style: italic; width: 151.2px;">Asli - Putih</td>
    <td>:</td>
    <td style="font-style: italic; width: 1898px;">Transporter</td>
    <td></td>
</tr>
<tr>
    <td colspan="2" style="font-style: italic; width: 151.2px;">Copy 1 - Merah</td>
    <td>:</td>
    <td style="font-style: italic; width: 1898px;">Customer</td>
    <td></td>
</tr>
<tr>
    <td colspan="2" style="font-style: italic; width: 151.2px;">Copy 2 - Kuning</td>
    <td>:</td>
    <td style="font-style: italic; width: 1898px;">Cabang (Lampiran DO)</td>
    <td></td>
</tr>

{{-- <tr><td>&nbsp;</td></tr>
  <tr>
    <td colspan="2" style="font-style: italic;">Asli - Putih</td>
    <td>:</td>
    <td style="font-style: italic;">Transporter</td>
  </tr>
  <tr>
    <td colspan="2" style="font-style: italic;">Copy 1 - Merah</td>
    <td>:</td>
    <td style="font-style: italic;">Customer</td>
  </tr>
  <tr>
    <td colspan="2" style="font-style: italic;">Copy 2 - Kuning</td>
    <td>:</td>
    <td style="font-style: italic;">Cabang (Lampiran DO)</td>
  </tr> --}}
</table>
<!-- </footer> -->

</body>