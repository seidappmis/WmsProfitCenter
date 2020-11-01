<link rel="stylesheet" type="text/css" href="{{ url('materialize/css/custom/print-lanscape.css') }}">
<style type="text/css">
@page {
    size: A3 !important;
    margin: 2mm 2mm 2mm 2mm;
    size: landscape !important;
}
@media print {
    html, body {
        width: 550mm;
        height: 420mm;
    }
}
</style>
<table style="font-family: Arial;">
    <tr>
        <td>
            <table style="width: 550mm;">
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
                                <td colspan="24">
                                    &nbsp;
                                </td>
                            </tr>
                            <tr>
                                <td rowspan="28">
                                    &nbsp;
                                </td>
                                <td rowspan="4">
                                    &nbsp;
                                </td>
                                <td colspan="2" style="text-align: left; font-size: 10pt;"><strong>
                                        ReceiptID</strong>
                                </td>
                                <td style="width: 5mm;">:</td>
                                <td colspan="5" style="text-align: left; font-size: 10pt;"><strong>
                                        {{$invoiceReceiptHeader->invoice_receipt_id}}</strong>
                                </td>
                                <td rowspan="4" colspan="14"
                                    style="text-align: left; font-size: 14pt; vertical-align: top;"><strong>
                                        PT. SHARP ELECTRONICS INDONESIA - TRUCKING CHARGES OF TRANSPORTER</strong>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align: left; font-size: 10pt;"><strong>No Tanda
                                        Terima</strong>
                                </td>
                                <td style="width: 5mm;">:</td>
                                <td colspan="4" style="text-align: left; font-size: 10pt;"><strong>
                                        {{$invoiceReceiptHeader->invoice_receipt_no}}</strong>
                                </td>
                                <td style="text-align: left; font-size: 10pt;">
                                    <strong>K{{date('Y-m-d')}}</strong>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align: left; font-size: 10pt;">
                                    <strong>No Kwitansi</strong>
                                </td>
                                <td style="width: 5mm;">:</td>
                                <td colspan="5" style="text-align: left; font-size: 10pt;">
                                    <strong>{{$invoiceReceiptHeader->kwitansi_no}}</strong>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align: left; font-size: 10pt;">
                                    <strong>Ekspedisi</strong>
                                </td>
                                <td style="width: 5mm;">:</td>
                                <td colspan="5" style="text-align: left; font-size: 10pt;">
                                    <strong>{{$invoiceReceiptHeader->expedition_name}}</strong>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="23" style="text-align: left; font-size: 12pt;">&nbsp;
                                </td>
                            </tr>
                            <tr>
                                {{-- <td colspan="22"> --}}

                                <td colspan="23">
                                    {{-- Main Table --}}

                                    <table width="100%" style="border-collapse: collapse; font-size: 9pt;">


                                        {{-- Table Head --}}
                                        <tr>
                                            <td colspan="23" style="text-align: left; font-size: 12pt;">&nbsp;
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"
                                                style="text-align: center; vertical-align: top; font-size: 10pt; border: 1pt solid black;">
                                                <strong>No.</strong>

                                            </td>
                                            <td
                                                style="text-align: center; vertical-align: top; font-size: 10pt;width: 60mm;border: 1pt solid black;">
                                                <strong>NO MANIFEST</strong>

                                            </td>
                                            <td colspan="2"
                                                style="text-align: center; vertical-align: top; font-size: 10pt;width: 40mm;border: 1pt solid black;">
                                                <strong>TANGGAL</strong>

                                            </td>
                                            <td colspan="2"
                                                style="text-align: center; vertical-align: top; font-size: 10pt;width: 40mm;border: 1pt solid black;">
                                                <strong>TUJUAN</strong>

                                            </td>
                                            <td
                                                style="text-align: center; vertical-align: top; font-size: 10pt;width: 40mm;border: 1pt solid black;">
                                                <strong>KENDARAAN</strong>

                                            </td>
                                            <td
                                                style="text-align: center; vertical-align: top; font-size: 10pt;width: 40mm;border: 1pt solid black;">
                                                <strong>NO POLISI</strong>

                                            </td>
                                            <td
                                                style="text-align: center; vertical-align: top; font-size: 10pt;width: 40mm;border: 1pt solid black;">
                                                <strong>RITASE</strong>

                                            </td>
                                            <td
                                                style="text-align: center; vertical-align: top; font-size: 10pt;border: 1pt solid black;">
                                                <strong>CBM</strong>

                                            </td>
                                            <td
                                                style="text-align: center; vertical-align: top; font-size: 10pt;width: 40mm;border: 1pt solid black;">
                                                <strong>RITASE2</strong>

                                            </td>
                                            <td
                                                style="text-align: center; vertical-align: top; font-size: 10pt;width: 40mm;border: 1pt solid black;">
                                                <strong>MULTIDROP</strong>

                                            </td>
                                            <td
                                                style="text-align: center; vertical-align: top; font-size: 10pt;width: 40mm;border: 1pt solid black;">
                                                <strong>UNLOADING</strong>

                                            </td>
                                            <td
                                                style="text-align: center; vertical-align: top; font-size: 10pt;width: 40mm;border: 1pt solid black;">
                                                <strong>OVERSTAY</strong>

                                            </td>
                                            <td
                                                style="text-align: center; vertical-align: top; font-size: 10pt; width: 40mm;border: 1pt solid black;">
                                                <strong>NO DO SAP</strong>

                                            </td>
                                            <td
                                                style="text-align: center; vertical-align: top; font-size: 10pt; width: 40mm;border: 1pt solid black;">
                                                <strong>TGL DO SAP</strong>

                                            </td>
                                            <td
                                                style="text-align: center; vertical-align: top; font-size: 10pt; width: 40mm;border: 1pt solid black;">
                                                <strong>SHIP TO</strong>

                                            </td>
                                            <td
                                                style="text-align: center; vertical-align: top; font-size: 10pt; width: 70mm;border: 1pt solid black;">
                                                <strong>SHIP TO DETAIL</strong>

                                            </td>
                                            <td
                                                style="text-align: center; vertical-align: top; font-size: 10pt; width: 40mm;border: 1pt solid black;">
                                                <strong>ACC CODE</strong>

                                            </td>
                                            <td
                                                style="text-align: center; vertical-align: top; font-size: 10pt; width: 40mm;border: 1pt solid black;">
                                                <strong>MODEL</strong>

                                            </td>
                                            <td
                                                style="text-align: center; vertical-align: top; font-size: 10pt;border: 1pt solid black;">
                                                <strong>QTY</strong>

                                            </td>
                                            <td
                                                style="text-align: center; vertical-align: top; font-size: 10pt;width: 40mm;border: 1pt solid black;">
                                                <strong>TOTAL CBM</strong>

                                            </td>
                                        </tr>
                                        {{-- Table Body --}}

                                        @php
                                        $noUrutManifest = 1;
                                        $printData = $invoiceReceiptHeader->getPrintReceiptData();
                                        @endphp
                                        @foreach( $printData['list'] AS $kManifest => $vManifest)
                                        @php
                                        $subTotalQty = 0;
                                        $subTotalCbm = 0;
                                        @endphp
                                        <tr>
                                            <td rowspan="{{ ($vManifest['total_model'] + 1) }}" colspan="2"
                                                style="text-align: center; vertical-align: top; font-size: 10pt;border: 1pt solid black;">
                                                {{$noUrutManifest++}}.

                                            </td>
                                            <td rowspan="{{ ($vManifest['total_model'] + 1) }}"
                                                style="text-align: left; vertical-align: top; font-size: 10pt;border: 1pt solid black;">
                                                {{$vManifest['do_manifest_no']}}
                                            </td>
                                            <td rowspan="{{ ($vManifest['total_model'] + 1) }}" colspan="2"
                                                style="text-align: center; vertical-align: top; font-size: 10pt;border: 1pt solid black;">
                                                {{date('d/m/Y', strtotime($vManifest['do_manifest_date']))}}

                                            </td>
                                            <td rowspan="{{ ($vManifest['total_model'] + 1) }}" colspan="2"
                                                style="text-align: left; vertical-align: top; font-size: 10pt;border: 1pt solid black;">
                                                {{ $vManifest['city_name'] }}
                                            </td>
                                            <td rowspan="{{ ($vManifest['total_model'] + 1) }}"
                                                style="text-align: left; vertical-align: top; font-size: 10pt;border: 1pt solid black;">
                                                {{ $vManifest['vehicle_description'] }}
                                            </td>
                                            <td rowspan="{{ ($vManifest['total_model'] + 1) }}"
                                                style="text-align: left; vertical-align: top; font-size: 10pt;border: 1pt solid black;">
                                                {{ $vManifest['vehicle_number'] }}
                                            </td>
                                            <td rowspan="{{ ($vManifest['total_model'] + 1) }}"
                                                style="text-align: right; vertical-align: top; font-size: 10pt;border: 1pt solid black;">
                                                {{ thousand_reformat($vManifest['ritase']) }}
                                            </td>
                                            <td rowspan="{{ ($vManifest['total_model'] + 1) }}"
                                                style="text-align: right; vertical-align: top; font-size: 10pt;border: 1pt solid black;">
                                                {{ thousand_reformat($vManifest['cbm']) }}
                                            </td>
                                            <td rowspan="{{ ($vManifest['total_model'] + 1) }}"
                                                style="text-align: right; vertical-align: top; font-size: 10pt;border: 1pt solid black;">
                                                {{ thousand_reformat($vManifest['ritase2']) }}
                                            </td>
                                            <td rowspan="{{ ($vManifest['total_model'] + 1) }}"
                                                style="text-align: right; vertical-align: top; font-size: 10pt;border: 1pt solid black;">
                                                {{ thousand_reformat($vManifest['multidrop']) }}
                                            </td>
                                            <td rowspan="{{ ($vManifest['total_model'] + 1) }}"
                                                style="text-align: right; vertical-align: top; font-size: 10pt;border: 1pt solid black;">
                                                {{ thousand_reformat($vManifest['unloading']) }}
                                            </td>
                                            <td rowspan="{{ ($vManifest['total_model'] + 1) }}"
                                                style="text-align: right; vertical-align: top; font-size: 10pt;border: 1pt solid black;">
                                                {{ thousand_reformat($vManifest['overstay']) }}
                                            </td>
                                            @php
                                            $do = array_values($vManifest['do']);
                                            @endphp
                                            <td rowspan="{{ count($do[0]['models']) }}" style="text-align: left; font-size: 10pt;border: 1pt solid black;">
                                                {{ $do[0]['no_do_sap'] }}
                                            </td>
                                            <td rowspan="{{ count($do[0]['models']) }}" style="text-align: left; font-size: 10pt;border: 1pt solid black;">
                                                {{ date('d/m/Y', strtotime($do[0]['tgl_do_sap'])) }}
                                            </td>
                                            <td rowspan="{{ count($do[0]['models']) }}" style="text-align: left; font-size: 10pt;border: 1pt solid black;">
                                                {{ $do[0]['ship_to_code'] }}
                                            </td>
                                            <td rowspan="{{ count($do[0]['models']) }}" style="text-align: left; font-size: 10pt;border: 1pt solid black;">
                                                {{ $do[0]['ship_to'] }}
                                            </td>
                                            <td rowspan="{{ count($do[0]['models']) }}" style="text-align: left; font-size: 10pt;border: 1pt solid black;">
                                                {{ $do[0]['acc_code'] }}
                                            </td>
                                            <td style="text-align: left; font-size: 10pt;border: 1pt solid black;">
                                                {{ $do[0]['models'][0]['model'] }}
                                            </td>
                                            <td style="text-align: right; font-size: 10pt;border: 1pt solid black;">
                                                {{ $do[0]['models'][0]['quantity'] }}
                                            </td>
                                            <td style="text-align: right; font-size: 10pt;border: 1pt solid black;">
                                                {{ $do[0]['models'][0]['cbm_do'] }}
                                            </td>
                                            @php
                                            $subTotalQty += $do[0]['models'][0]['quantity'];
                                            $subTotalCbm += $do[0]['models'][0]['cbm_do'];
                                            @endphp
                                        </tr>
                                        @if(count($do[0]['models']) > 1)
                                        @foreach($do[0]['models'] AS $kModel => $vModel)
                                            @if($kModel != 0)
                                            @php
                                            $subTotalQty += $vModel['quantity'];
                                            $subTotalCbm += $vModel['cbm_do'];
                                            @endphp
                                            <tr>
                                                <td style="text-align: left; font-size: 10pt;border: 1pt solid black;">
                                                    {{$vModel['model']}}
                                                </td>
                                                <td style="text-align: right; font-size: 10pt;border: 1pt solid black;">
                                                    {{$vModel['quantity']}}
                                                </td>
                                                <td style="text-align: right; font-size: 10pt;border: 1pt solid black;">
                                                    {{$vModel['cbm_do']}}
                                                </td>
                                            </tr>
                                            @endif
                                        @endforeach
                                        @endif

                                        @if(count($do) > 1)
                                        @foreach($do AS $kdo => $vdo)
                                            @if($kdo != 0)
                                            <tr>
                                                <td rowspan="{{ count($do[$kdo]['models']) }}" style="text-align: left; font-size: 10pt;border: 1pt solid black;">
                                                {{ $do[$kdo]['no_do_sap'] }}
                                                </td>
                                                <td rowspan="{{ count($do[$kdo]['models']) }}" style="text-align: left; font-size: 10pt;border: 1pt solid black;">
                                                    {{ date('d/m/Y', strtotime($do[$kdo]['tgl_do_sap'])) }}
                                                </td>
                                                <td rowspan="{{ count($do[$kdo]['models']) }}" style="text-align: left; font-size: 10pt;border: 1pt solid black;">
                                                    {{ $do[$kdo]['ship_to_code'] }}
                                                </td>
                                                <td rowspan="{{ count($do[$kdo]['models']) }}" style="text-align: left; font-size: 10pt;border: 1pt solid black;">
                                                    {{ $do[$kdo]['ship_to'] }}
                                                </td>
                                                <td rowspan="{{ count($do[$kdo]['models']) }}" style="text-align: left; font-size: 10pt;border: 1pt solid black;">
                                                    {{ $do[$kdo]['acc_code'] }}
                                                </td>
                                                <td style="text-align: left; font-size: 10pt;border: 1pt solid black;">
                                                    {{ $do[$kdo]['models'][0]['model'] }}
                                                </td>
                                                <td style="text-align: right; font-size: 10pt;border: 1pt solid black;">
                                                    {{ $do[$kdo]['models'][0]['quantity'] }}
                                                </td>
                                                <td style="text-align: right; font-size: 10pt;border: 1pt solid black;">
                                                    {{ $do[$kdo]['models'][0]['cbm_do'] }}
                                                </td>
                                                @php
                                                $subTotalQty += $do[$kdo]['models'][0]['quantity'];
                                                $subTotalCbm += $do[$kdo]['models'][0]['cbm_do'];
                                                @endphp
                                            </tr>
                                            @if(count($do[$kdo]['models']) > 1)
                                            @foreach($do[$kdo]['models'] AS $kModel => $vModel)
                                                @if($kModel != 0)
                                                @php
                                                $subTotalQty += $vModel['quantity'];
                                                $subTotalCbm += $vModel['cbm_do'];
                                                @endphp
                                                <tr>
                                                    <td style="text-align: left; font-size: 10pt;border: 1pt solid black;">
                                                        {{$vModel['model']}}
                                                    </td>
                                                    <td style="text-align: right; font-size: 10pt;border: 1pt solid black;">
                                                        {{$vModel['quantity']}}
                                                    </td>
                                                    <td style="text-align: right; font-size: 10pt;border: 1pt solid black;">
                                                        {{$vModel['cbm_do']}}
                                                    </td>
                                                </tr>
                                                @endif
                                            @endforeach
                                            @endif
                                            @endif
                                        @endforeach
                                        @endif
                                        {{-- <tr>
                                            <td style="text-align: left; font-size: 10pt;border: 1pt solid black;">
                                                4915072395
                                            </td>
                                            <td style="text-align: left; font-size: 10pt;border: 1pt solid black;">
                                                13/12/2019

                                            </td>
                                            <td style="text-align: left; font-size: 10pt;border: 1pt solid black;">
                                                38000000
                                            </td>
                                            <td style="text-align: left; font-size: 10pt;border: 1pt solid black;">
                                                PT. SEID CAB. SERANG
                                            </td>
                                            <td style="text-align: left; font-size: 10pt;border: 1pt solid black;">
                                                Dec19-SRG-BR
                                            </td>
                                            <td style="text-align: left; font-size: 10pt;border: 1pt solid black;">
                                                2T-C50AD1I
                                            </td>
                                            <td style="text-align: right; font-size: 10pt;border: 1pt solid black;">
                                                20

                                            </td>
                                            <td style="text-align: right; font-size: 10pt;border: 1pt solid black;">
                                                3,45

                                            </td>
                                        </tr> --}}
                                        <tr>
                                            <td colspan="6"
                                                style="text-align: right; font-size: 10pt;border: 1pt solid black;">
                                                <strong>SUB TOTAL</strong></td>
                                            <td style="text-align: right; font-size: 10pt;border: 1pt solid black;">
                                                <strong>{{$subTotalQty}}</strong></td>
                                            <td style="text-align: right; font-size: 10pt;border: 1pt solid black;">
                                                <strong>{{$subTotalCbm}}</strong></td>
                                        </tr>

                                        @endforeach

                                        <tr>

                                            <td colspan="20" style="text-align: center; ">
                                                &nbsp;
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" style="text-align: center; ">
                                                &nbsp;
                                            </td>
                                            <td colspan="2" style="text-align: left;border: 1pt solid black;">Total
                                                Freight
                                            </td>
                                            <td style="text-align: right;border: 1pt solid black;">
                                                {{ thousand_reformat($printData['total_freight']) }}
                                            </td>
                                            <td style="text-align: right;border: 1pt solid black;">
                                                {{ thousand_reformat($printData['total_ritase']) }}
                                            </td>
                                            <td style="text-align: right;border: 1pt solid black;">
                                                {{ thousand_reformat($printData['total_cbm']) }}
                                            </td>
                                            <td style="text-align: right;border: 1pt solid black;">
                                                {{ thousand_reformat($printData['total_ritase2']) }}
                                            </td>
                                            <td style="text-align: right;border: 1pt solid black;">
                                                {{ thousand_reformat($printData['total_multidrop']) }}
                                            </td>
                                            <td style="text-align: right;border: 1pt solid black;">
                                                {{ thousand_reformat($printData['total_unloading']) }}
                                            </td>
                                            <td style="text-align: right;border: 1pt solid black;">
                                                {{ thousand_reformat($printData['total_overstay']) }}
                                            </td>
                                            <td colspan="8" style="text-align: center; ">
                                                &nbsp;
                                            </td>

                                        </tr>
                                        <tr>
                                            <td colspan="6" style="text-align: center; ">
                                                &nbsp;
                                            </td>
                                            <td colspan="2" style="text-align: left;border: 1pt solid black;">Tax
                                            </td>
                                            <td style="text-align: right;border: 1pt solid black;">
                                                {{ thousand_reformat($printData['tax']) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" style="text-align: center; ">
                                                &nbsp;
                                            </td>
                                            <td colspan="2" style="text-align: left;border: 1pt solid black;">Grand
                                                Total
                                            </td>
                                            <td style="text-align: right;border: 1pt solid black;">
                                                {{ thousand_reformat($printData['grand_total']) }}
                                            </td>
                                        </tr>
                                        <tr>

                                            <td colspan="23" style="text-align: center; ">
                                                &nbsp;
                                            </td>

                                        </tr>
                                        <tr>
                                            <td colspan="5" style="text-align: center; ">
                                                &nbsp;
                                            </td>
                                            <td colspan="6" style="text-align: center;border: 1pt solid black;">BR
                                            </td>
                                            <td colspan="4" style="text-align: center;border: 1pt solid black;">DS
                                            </td>
                                            <td colspan="4" style="text-align: center;border: 1pt solid black;">Total
                                            </td>
                                            <td colspan="4" style="text-align: center; ">
                                                &nbsp;
                                            </td>

                                        </tr>

                                        <tr>
                                            <td colspan="5" style="text-align: center; ">
                                                &nbsp;
                                            </td>
                                            <td colspan="3" style="text-align: center;border: 1pt solid black;">FREIGHT
                                                COST
                                            </td>
                                            <td style="text-align: center;border: 1pt solid black;">MULTIDROP
                                            </td>
                                            <td style="text-align: center;border: 1pt solid black;">UNLOADING
                                            </td>
                                            <td style="text-align: center;border: 1pt solid black;">OVERSTAY
                                            </td>

                                            <td style="text-align: center;border: 1pt solid black;">FREIGHT COST
                                            </td>
                                            <td style="text-align: center;border: 1pt solid black;">MULTIDROP
                                            </td>
                                            <td style="text-align: center;border: 1pt solid black;">UNLOADING
                                            </td>
                                            <td style="text-align: center;border: 1pt solid black;">OVERSTAY
                                            </td>
                                            <td style="text-align: center;border: 1pt solid black;">FREIGHT COST
                                            </td>
                                            <td style="text-align: center;border: 1pt solid black;">MULTIDROP
                                            </td>
                                            <td style="text-align: center;border: 1pt solid black;">UNLOADING
                                            </td>
                                            <td style="text-align: center;border: 1pt solid black;">OVERSTAY
                                            </td>
                                            <td colspan="4" style="text-align: center; ">
                                                &nbsp;
                                            </td>
                                        </tr>

                                        {{-- <tr>
                                            <td colspan="2" style="text-align: center; ">
                                                &nbsp;
                                            </td>
                                            <td colspan="3" style="text-align: left; border: 1pt solid black;">
                                                Dec19-SRG-BR
                                            </td>
                                            <td colspan="3" style="text-align: right;border: 1pt solid black;">5.888.888
                                            </td>
                                            <td style="text-align: right; border: 1pt solid black;">0
                                            </td>
                                            <td style="text-align: right; border: 1pt solid black;">0
                                            </td>
                                            <td style="text-align: right; border: 1pt solid black;">0
                                            </td>
                                            <td style="text-align: right; border: 1pt solid black;">5.888.888
                                            </td>
                                            <td style="text-align: right; border: 1pt solid black;">0
                                            </td>
                                            <td style="text-align: right; border: 1pt solid black;">0
                                            </td>
                                            <td style="text-align: right; border: 1pt solid black;">0
                                            </td>
                                            <td style="text-align: right; border: 1pt solid black;">5.888.888
                                            </td>
                                            <td style="text-align: right; border: 1pt solid black;">0
                                            </td>
                                            <td style="text-align: right; border: 1pt solid black;">0
                                            </td>
                                            <td style="text-align: right; border: 1pt solid black;">0
                                            </td>
                                            <td colspan="4" style="text-align: center; ">
                                                &nbsp;
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="text-align: center; ">
                                                &nbsp;
                                            </td>
                                            <td colspan="3" style="text-align: left;border: 1pt solid black;">
                                                Dec19-SRG-BR
                                            </td>
                                            <td colspan="3" style="text-align: right;border: 1pt solid black;">5.888.888
                                            </td>
                                            <td style="text-align: right; border: 1pt solid black;">0
                                            </td>
                                            <td style="text-align: right; border: 1pt solid black;">0
                                            </td>
                                            <td style="text-align: right; border: 1pt solid black;">0
                                            </td>
                                            <td style="text-align: right; border: 1pt solid black;">5.888.888
                                            </td>
                                            <td style="text-align: right; border: 1pt solid black;">0
                                            </td>
                                            <td style="text-align: right; border: 1pt solid black;">0
                                            </td>
                                            <td style="text-align: right; border: 1pt solid black;">0
                                            </td>
                                            <td style="text-align: right; border: 1pt solid black;">5.888.888
                                            </td>
                                            <td style="text-align: right; border: 1pt solid black;">0
                                            </td>
                                            <td style="text-align: right; border: 1pt solid black;">0
                                            </td>
                                            <td style="text-align: right; border: 1pt solid black;">0
                                            </td>
                                            <td colspan="4" style="text-align: center; ">
                                                &nbsp;
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="text-align: center; ">
                                                &nbsp;
                                            </td>
                                            <td colspan="3" style="text-align: left; border: 1pt solid black;">
                                                Dec19-SRG-BR
                                            </td>
                                            <td colspan="3" style="text-align: right;border: 1pt solid black;">5.888.888
                                            </td>
                                            <td style="text-align: right; border: 1pt solid black;">0
                                            </td>
                                            <td style="text-align: right; border: 1pt solid black;">0
                                            </td>
                                            <td style="text-align: right; border: 1pt solid black;">0
                                            </td>
                                            <td style="text-align: right; border: 1pt solid black;">5.888.888
                                            </td>
                                            <td style="text-align: right; border: 1pt solid black;">0
                                            </td>
                                            <td style="text-align: right; border: 1pt solid black;">0
                                            </td>
                                            <td style="text-align: right; border: 1pt solid black;">0
                                            </td>
                                            <td style="text-align: right; border: 1pt solid black;">5.888.888
                                            </td>
                                            <td style="text-align: right; border: 1pt solid black;">0
                                            </td>
                                            <td style="text-align: right; border: 1pt solid black;">0
                                            </td>
                                            <td style="text-align: right; border: 1pt solid black;">0
                                            </td>
                                            <td colspan="4" style="text-align: center; ">
                                                &nbsp;
                                            </td>
                                        </tr> --}}


                                        {{-- End Main Table --}}

                                    </table>
                                </td>
                            </tr>

                            {{-- <tr>

                                <td colspan="23">
                                    &nbsp;
                                </td>
                            </tr>
                            <tr>
                                <td colspan="7">
                                    &nbsp;
                                </td>
                                <td rowspan="3" style="text-align: center; border: 1pt solid #000000;">Total Freight
                                </td>
                                <td style="text-align: left; font-size: 10pt;">
                                    Total Freight
                                </td>

                            </tr> --}}






                        </table>
                    </td>
                </tr>
            </table>
        </td>

    </tr>

</table>
