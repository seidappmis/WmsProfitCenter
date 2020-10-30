<html>
<link rel="stylesheet" type="text/css" href="{{ url('materialize/css/custom/print1.css') }}">
<body style="font-family: Arial;">
    <table width="100%" style="font-size: 10pt;line-height: 1.4">
        <tr>
            <td colspan="15" style="text-align: right; font-size: 8pt;"><strong>PT. SHARP
                    ELECTRONICS INDONESIA</strong></td>
        </tr>
        <tr>
            <td colspan="15" style="text-align: center; font-size: 13pt;"><strong>LAPORAN MUATAN
                    BARANG</strong></td>
        </tr>
        <tr>
            <td colspan="15" style="text-align: center; font-size: 8pt;"><strong>(Loading Goods
                    Report)</strong></td>
        </tr>
        <tr>
            <td colspan="15" style="text-align: center; font-size: 12pt;"><strong>SHARP -
                    PRODUCT</strong></td>
        </tr>
        <tr>
            <td colspan="1" style="width: 33mm;">Tanggal</td>
            <td style="width: 5mm;">:</td>
            <td colspan="6" style="width: 66mm;">{{ date('d/m/Y h:i:s A', strtotime($lmbHeader->created_at)) }}</td>
            <td colspan="2" style="width: 33mm;">No. Mobil/Jenis</td>
            <td style="width: 6mm;">:</td>
            <td colspan="3">{{$lmbHeader->vehicle_number}}/{{$lmbHeader->destination_number != 'AS' ? $lmbHeader->picking->vehicle->vehicle_description : ''}}</td>
        </tr>
        <tr>
            <td colspan="1">Expedisi</td>
            <td>:</td>
            <td colspan="6">{{$lmbHeader->expedition_name}}</td>
            @if($lmbHeader->cabang->hq)
            <td colspan="2">No. Container</td>
            <td>:</td>
            <td colspan="3">{{$lmbHeader->container_no}}</td>
            @else 
            <td colspan="2">Customer</td>
            <td>:</td>
            <td colspan="3">{!! $lmbHeader->getCustomer() !!}</td>
            @endif
        </tr>
        <tr>
            <td colspan="1">Tujuan</td>
            <td>:</td>
            <td colspan="6">{{$lmbHeader->destination_name}}</td>
            <td colspan="2">No. Seal</td>
            <td>:</td>
            <td colspan="3">{{$lmbHeader->seal_no}}</td>
        </tr>
        <tr>
            <td colspan="1">Lokasi Gudang</td>
            <td>:</td>
            <td colspan="6">{{$lmbHeader->short_description_cabang}}</td>
            <td colspan="2">No. Picking</td>
            <td>:</td>
            <td colspan="3"><strong>{{$lmbHeader->picking->picking_no}}</strong></td>
        </tr>
    </table>
    {{-- Main Table --}}
    <table width="100%" style="border-collapse: collapse; font-size: 10pt;">
        {{-- Table Head --}}
        <thead>
        <tr>
            <td style="text-align: center; border: 1pt solid #000000; width: 9mm;">NO</td>
            <td style="text-align: center; border: 1pt solid #000000; width: 53mm;">MODEL</td>
            <td style="text-align: center; border: 1pt solid #000000; width: 13mm;">QTY</td>
            <td style="text-align: center; border: 1pt solid #000000;" colspan="12" >NO. SERI</td>
        </tr>
            
        </thead>
        <tbody>
        {{-- Table Body --}}
        @php
        $row_no = 1;
        @endphp
        @for($i=0;$i<100;$i++)
        @foreach($rs_details AS $k_model => $v_model)
        @php 
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
            ">
                {{$row_no}}
            </td>
            <td rowspan="{{$row_serial_total}}"  style="
            text-align: center; 
            border-left: 1pt solid #000000; 
            border-right: 1pt solid #000000; 
            vertical-align: top;
            ">
                {{$k_model}}
            </td>
            <td rowspan="{{$row_serial_total}}"  style="
            text-align: center; 
            border-left: 1pt solid #000000; 
            border-right: 1pt solid #000000; 
            vertical-align: top;
            ">
                {{$qty}}
            </td>
            <td style="text-align: center;" colspan="4">
                {{!empty($v_model['serial_numbers'][$serial_pointer]) ? $v_model['serial_numbers'][$serial_pointer++] : ''}}
            </td>
            <td style="text-align: center;" colspan="4">
                {{!empty($v_model['serial_numbers'][$serial_pointer]) ? $v_model['serial_numbers'][$serial_pointer++] : ''}}
            </td>
            <td style="text-align: center;border-right: 1pt solid #000000;" colspan="4">
                {{!empty($v_model['serial_numbers'][$serial_pointer]) ? $v_model['serial_numbers'][$serial_pointer++] : ''}}
            </td>
        </tr>

        @while($row_serial_pointer < $row_serial_total)
        <tr>
            <td style="text-align: center; " colspan="4">
                {{!empty($v_model['serial_numbers'][$serial_pointer]) ? $v_model['serial_numbers'][$serial_pointer++] : ''}}
            </td>
            <td style="text-align: center; " colspan="4">
                {{!empty($v_model['serial_numbers'][$serial_pointer]) ? $v_model['serial_numbers'][$serial_pointer++] : ''}}
            </td>
            <td style="text-align: center;  border-right: 1pt solid #000000;" colspan="4">
                {{!empty($v_model['serial_numbers'][$serial_pointer]) ? $v_model['serial_numbers'][$serial_pointer++] : ''}}
            </td>
        </tr>
        @php
        $row_serial_pointer ++;
        @endphp
        @endwhile
        <tr>
            <td style="border-left: 1pt solid #000000; 
            border-right: 1pt solid #000000;">&nbsp;</td>
            <td style="border-left: 1pt solid #000000; 
            border-right: 1pt solid #000000;">&nbsp;</td>
            <td style="border-left: 1pt solid #000000; 
            border-right: 1pt solid #000000;">&nbsp;</td>
            <td style="border-left: 1pt solid #000000; 
            border-right: 1pt solid #000000;" colspan="12">&nbsp;</td>
        </tr>
        <
        @php
        $row_no++;
        @endphp
        @endforeach
        @endfor
    </tbody>
    <tfoot>
        <tr><td style="border-top: 1pt solid #000000;" colspan="15">&nbsp;</td></tr> 
        
        <tr>
            <td colspan="15">&nbsp;</td>
        </tr>       
    </tfoot>
    </table>
    {{-- End Main Table --}}
    <footer >
        <table width="100%" style="font-size: 9pt;">
            <tr>
                <td rowspan="3" colspan="4"
                    style="font-style: italic; width: 50mm; word-wrap: break-word;">
                    Pengangkut diharap memeriksa &amp; menghitung barang yang diangkut. *Claim
                    kekurangan barang diluar areal pergudangan kami bukan menjadi tanggung jawab kami.
                </td>
                <td style="width: 5mm;"></td>
                <td colspan="2" style="text-align: center; border: 1pt solid #000000; width: 20mm;">
                    LOADING</td>
                <td colspan="2" style="text-align: center; border: 1pt solid #000000; width: 20mm;">ST.
                    KEEPER</td>
                <td colspan="2" style="text-align: center; border: 1pt solid #000000; width: 20mm;">
                    CHECKER</td>
                <td colspan="2" style="text-align: center; border: 1pt solid #000000; width: 20mm;">
                    DRIVER</td>
                <td colspan="2" style="text-align: center; border: 1pt solid #000000; width: 20mm;">
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
                <td colspan="2" style="font-style: italic; width: 25mm;">Asli - Putih</td>
                <td>:</td>
                <td style="font-style: italic; width: 25mm;">Transporter</td>
                <td></td>
            </tr>
            <tr>
                <td colspan="2" style="font-style: italic; width: 25mm;">Copy 1 - Merah</td>
                <td>:</td>
                <td style="font-style: italic; width: 25mm;">Customer</td>
                <td></td>
            </tr>
            <tr>
                <td colspan="2" style="font-style: italic; width: 25mm;">Copy 2 - Kuning</td>
                <td>:</td>
                <td style="font-style: italic; width: 25mm;">Cabang (Lampiran DO)</td>
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
    </footer>
</body>
