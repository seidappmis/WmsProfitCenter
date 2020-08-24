<link rel="stylesheet" type="text/css" href="{{ url('materialize/css/custom/print.css') }}">

<table style="font-family: Arial;">
    <tr>
        <td>
            <table style="width: 210.0003mm;">
                <tr>
                    <td>
                        <table width="100%" style="font-size: 9pt;">
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="15" style="text-align: right; font-size: 8pt;"><strong>PT. SHARP
                                        ELECTRONICS INDONESIA</strong></td>
                            </tr>
                            <tr>
                                <td colspan="15" style="text-align: center; font-size: 14pt;"><strong>LAPORAN MUATAN
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
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="width: 30mm;">Tanggal</td>
                                <td style="width: 5mm;">:</td>
                                <td colspan="6" style="width: 60mm;">{{ date('d/m/Y h:i:s A', strtotime($lmbHeader->created_at)) }}</td>
                                <td colspan="2" style="width: 40mm;">No. Mobil/Jenis</td>
                                <td style="width: 5mm;">:</td>
                                <td colspan="3">{{$lmbHeader->vehicle_number}}</td>
                            </tr>
                            <tr>
                                <td colspan="2">Expedisi</td>
                                <td>:</td>
                                <td colspan="6">{{$lmbHeader->expedition_name}}</td>
                                @if($lmbHeader->cabang->hq)
                                <td colspan="2">No. Container</td>
                                <td>:</td>
                                <td colspan="3">{{$lmbHeader->container_no}}</td>
                                @else 
                                <td colspan="2">Customer</td>
                                <td>:</td>
                                <td colspan="3">{{$lmbHeader->container_no}}</td>
                                @endif
                            </tr>
                            <tr>
                                <td colspan="2">Tujuan</td>
                                <td>:</td>
                                <td colspan="6">{{$lmbHeader->destionation_name}}</td>
                                <td colspan="2">No. Seal</td>
                                <td>:</td>
                                <td colspan="3">{{$lmbHeader->seal_no}}</td>
                            </tr>
                            <tr>
                                <td colspan="2">Lokasi Gudang</td>
                                <td>:</td>
                                <td colspan="6">{{$lmbHeader->short_description_cabang}}</td>
                                <td colspan="2">No. Picking</td>
                                <td>:</td>
                                <td colspan="3"><strong>{{$lmbHeader->picking->picking_no}}</strong></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        {{-- Main Table --}}
                        <table width="100%" style="border-collapse: collapse; font-size: 9pt;">
                            {{-- Table Head --}}
                            <tr>
                                <td style="text-align: center; border: 1pt solid #000000; width: 10mm;">NO</td>
                                <td colspan="4" style="text-align: center; border: 1pt solid #000000; width: 50mm;">MODEL</td>
                                <td colspan="2" style="text-align: center; border: 1pt solid #000000; width: 30mm;">QTY</td>
                                <td style="text-align: center; border: 1pt solid #000000; width: 30mm;" colspan="8">NO. SERI</td>
                                <td style="text-align: center; border-left: 1pt solid #000000; width: 1mm;"></td>
                            </tr>
                            {{-- Table Body --}}
                            @foreach($rs_details AS $k_model => $v_model)
                            @php 
                            $row_serial_pointer = 1;
                            $row_serial_total = ceil(count($v_model['serial_numbers']) / 3);
                            $serial_pointer = 0;
                            $qty = count($v_model['serial_numbers']);
                            @endphp
                            <tr>
                                <td rowspan="{{$row_serial_total}}" style="text-align: center; border: 1pt solid #000000;">1</td>
                                <td rowspan="{{$row_serial_total}}" colspan="4" style="text-align: center; border: 1pt solid #000000;">{{$k_model}}</td>
                                <td rowspan="{{$row_serial_total}}" colspan="2"  style="text-align: center; border: 1pt solid #000000;">{{$qty}}</td>
                                <td style="text-align: center;" colspan="3">
                                    {{!empty($v_model['serial_numbers'][$serial_pointer]) ? $v_model['serial_numbers'][$serial_pointer++] : ''}}
                                </td>
                                <td style="text-align: center;" colspan="3">
                                    {{!empty($v_model['serial_numbers'][$serial_pointer]) ? $v_model['serial_numbers'][$serial_pointer++] : ''}}
                                </td>
                                <td style="text-align: center;" colspan="2">
                                    {{!empty($v_model['serial_numbers'][$serial_pointer]) ? $v_model['serial_numbers'][$serial_pointer++] : ''}}
                                </td>
                                <td style="text-align: center; border-left: 1pt solid #000000; width: 1mm;"></td>
                            </tr>

                            @while($row_serial_pointer < $row_serial_total)
                            <tr>
                                <td style="text-align: center; border-bottom: 1pt solid #000000;" colspan="3">
                                    {{!empty($v_model['serial_numbers'][$serial_pointer]) ? $v_model['serial_numbers'][$serial_pointer++] : ''}}
                                </td>
                                <td style="text-align: center; border-bottom: 1pt solid #000000;" colspan="3">
                                    {{!empty($v_model['serial_numbers'][$serial_pointer]) ? $v_model['serial_numbers'][$serial_pointer++] : ''}}
                                </td>
                                <td style="text-align: center; border-bottom: 1pt solid #000000;" colspan="2">
                                    {{!empty($v_model['serial_numbers'][$serial_pointer]) ? $v_model['serial_numbers'][$serial_pointer++] : ''}}
                                </td>
                                <td style="text-align: center; border-left: 1pt solid #000000; width: 1mm;"></td>
                            </tr>

                            @php
                            $row_serial_pointer ++;
                            @endphp
                            @endwhile

                            @endforeach
                            {{-- <tr>
                                <td rowspan="2" style="text-align: center; border: 1pt solid #000000;">1</td>
                                <td rowspan="2" colspan="4" style="text-align: center; border: 1pt solid #000000;">AH-A9SAY</td>
                                <td colspan="2" rowspan="2" style="text-align: center; border: 1pt solid #000000;">5</td>
                                <td style="text-align: center;" colspan="3">581910101</td>
                                <td style="text-align: center;" colspan="3">581910101</td>
                                <td style="text-align: center;" colspan="2">581910101</td>
                                <td style="text-align: center; border-left: 1pt solid #000000; width: 1mm;"></td>
                            </tr>
                            <tr>
                                <td style="text-align: center; border-bottom: 1pt solid #000000;" colspan="3">581910101
                                </td>
                                <td style="text-align: center; border-bottom: 1pt solid #000000;" colspan="3">581910101
                                </td>
                                <td style="text-align: center; border-bottom: 1pt solid #000000;" colspan="2"></td>
                                <td style="text-align: center; border-left: 1pt solid #000000; width: 1mm;"></td>
                            </tr> --}}
                            <tr>
                                <td colspan="11">&nbsp;</td>
                            </tr>
                        </table>
                        {{-- End Main Table --}}
                    </td>
                </tr>
                <tr>
                    <td>
                        <table width="100%" style="font-size: 9pt;">
                            <tr>
                                <td rowspan="3" colspan="4"
                                    style="font-style: italic; width: 105mm; word-wrap: break-word;">
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
                                <td colspan="2" style="font-style: italic; width: 40mm;">Asli - Putih</td>
                                <td>:</td>
                                <td style="font-style: italic; width: 50mm;">Transporter</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="font-style: italic; width: 40mm;">Copy 1 - Merah</td>
                                <td>:</td>
                                <td style="font-style: italic; width: 50mm;">Customer</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="font-style: italic; width: 40mm;">Copy 2 - Kuning</td>
                                <td>:</td>
                                <td style="font-style: italic; width: 50mm;">Cabang (Lampiran DO)</td>
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
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
