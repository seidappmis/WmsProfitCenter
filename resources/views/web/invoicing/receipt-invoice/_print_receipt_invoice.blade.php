<link rel="stylesheet" type="text/css" href="{{ url('materialize/css/custom/print1-a4.css') }}">
<body>
<htmlpageheader name="myHeader1">  
    <table width="100%" style="border-collapse: collapse;">
        <tr>
            {{-- <td rowspan="28">
                &nbsp;
            </td> --}}
            <td rowspan="4" colspan="1" style="width: 10px;">
                &nbsp;
            </td>
            <td colspan="2" style="text-align: left; font-size: 5pt;">
                <strong>ReceiptID</strong>
            </td>
            <td style="width: 5mm;">:</td>
            <td colspan="6" style="text-align: left; font-size: 5pt;">
                <strong>{{$invoiceReceiptHeader->invoice_receipt_id}}</strong>
            </td>
            <td rowspan="10" colspan="13"
                style="text-align: left; font-size: 10pt; vertical-align: top;">
                <strong>PT. SHARP ELECTRONICS INDONESIA - TRUCKING CHARGES OF TRANSPORTER</strong>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: left; font-size: 5pt;"><strong>No Tanda
                    Terima</strong>
            </td>
            <td style="width: 5mm;">:</td>
            <td colspan="5" style="text-align: left; font-size: 5pt;">
                <strong>{{$invoiceReceiptHeader->invoice_receipt_no}}</strong>
            </td>
            <td colspan="3" style="text-align: left; font-size: 5pt; width: 5mm;">
                <strong>{{date('Y-m-d')}}</strong>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: left; font-size: 5pt;">
                <strong>No Kwitansi</strong>
            </td>
            <td style="width: 5mm;">:</td>
            <td colspan="6" style="text-align: left; font-size: 5pt;">
                <strong>{{$invoiceReceiptHeader->kwitansi_no}}</strong>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: left; font-size: 5pt;">
                <strong>Ekspedisi</strong>
            </td>
            <td style="width: 5mm;">:</td>
            <td colspan="6" style="text-align: left; font-size: 5pt;">
                <strong>{{$invoiceReceiptHeader->expedition_name}}</strong>
            </td>
        </tr>
        {{-- <tr>
            <td colspan="23" style="text-align: left; font-size: 12pt;">&nbsp;
            </td>
        </tr> --}}
    </table>
</htmlpageheader>
<sethtmlpageheader name="myHeader1" value="on" show-this-page="1"/>

<htmlpagefooter name="myFooter1">
    <table width="100%" style="font-size: 9pt;">
      <tr>
            <td colspan="3">Thursday, {{date('d-F-Y h:i:s A')}}</td>
            <td colspan="8" align="center"> Page {PAGENO} of {nbpg}</td>
            <td colspan="6" style="text-align: right; ">Print out from SEID WMS</td>
        </tr>
    </table>
  </htmlpagefooter>
  <sethtmlpagefooter name="myFooter1" value="on" />

<table style="border-collapse: collapse; font-size: 5pt;">
    {{-- Table Head --}}
    <thead>
       {{--  <tr>
            <td colspan="23" style="text-align: left; font-size: 12pt;">&nbsp;
            </td>
        </tr> --}}
        <tr>
            <td style="text-align: center; vertical-align: top; font-size: 5pt; width: 0.5cm; border: 1pt solid black;">
                <strong>No.</strong>
            </td>
            <td colspan="2" 
                style="text-align: center; vertical-align: top; font-size: 5pt;width: 1.6cm;border: 1pt solid black;">
                <strong>NO MANIFEST</strong>
            </td>
            <td colspan="1"
                style="text-align: center; vertical-align: top; font-size: 5pt;width: 1.4cm;border: 1pt solid black;">
                <strong>TANGGAL</strong>
            </td>
            <td colspan="2"
                style="text-align: center; vertical-align: top; font-size: 5pt;width: 1.6cm;border: 1pt solid black;">
                <strong>TUJUAN</strong>
            </td>
            <td colspan="2"
                style="text-align: center; vertical-align: top; font-size: 5pt;width: 1.45cm;border: 1pt solid black;">
                <strong>KENDARAAN</strong>
            </td>
            <td
                style="text-align: center; vertical-align: top; font-size: 5pt;width: 1.4cm;border: 1pt solid black;">
                <strong>NO POLISI</strong>
            </td>
            <td
                style="text-align: center; vertical-align: top; font-size: 5pt;width: 1.3cm;border: 1pt solid black;">
                <strong>RITASE</strong>
            </td>
            <td
                style="text-align: center; vertical-align: top; font-size: 5pt;width: 1.3cm;border: 1pt solid black;">
                <strong>CBM</strong>

            </td>
            <td
                style="text-align: center; vertical-align: top; font-size: 5pt;width: 1.3cm;border: 1pt solid black;">
                <strong>RITASE2</strong>
            </td>
            <td
                style="text-align: center; vertical-align: top; font-size: 5pt;width: 1.3cm;border: 1pt solid black;">
                <strong>MULTIDROP</strong>
            </td>
            <td
                style="text-align: center; vertical-align: top; font-size: 5pt;width: 1.3cm;border: 1pt solid black;">
                <strong>UNLOADING</strong>

            </td>
            <td
                style="text-align: center; vertical-align: top; font-size: 5pt;width: 1.3cm;border: 1pt solid black;">
                <strong>OVERSTAY</strong>
            </td>
            <td
                style="text-align: center; vertical-align: top; font-size: 5pt; width: 2cm;border: 1pt solid black;">
                <strong>NO DO SAP</strong>
            </td>
            <td
                style="text-align: center; vertical-align: top; font-size: 5pt; width: 1.15m;border: 1pt solid black;">
                <strong>TGL DO SAP</strong>

            </td>
            <td
                style="text-align: center; vertical-align: top; font-size: 5pt; width: 1.2cm;border: 1pt solid black;">
                <strong>SHIP TO</strong>

            </td>
            <td
                style="text-align: center; vertical-align: top; font-size: 5pt; width: 3.5cm;border: 1pt solid black;">
                <strong>SHIP TO DETAIL</strong>

            </td>
            <td
                style="text-align: center; vertical-align: top; font-size: 5pt; width: 1.7cm;border: 1pt solid black;">
                <strong>ACC CODE</strong>

            </td>
            <td
                style="text-align: center; vertical-align: top; font-size: 5pt; width: 1.8cm;border: 1pt solid black;">
                <strong>MODEL</strong>

            </td>
            <td
                style="text-align: center; vertical-align: top; font-size: 5pt; width: 0.8cm;border: 1pt solid black;">
                <strong>QTY</strong>

            </td>
            <td
                style="text-align: center; vertical-align: top; font-size: 5pt;width: 1.2cm;border: 1pt solid black;">
                <strong>TOTAL CBM</strong>

            </td>
        </tr>
        {{-- Table Body --}}
    </thead>

    <tbody>
        
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
            <td rowspan="{{ ($vManifest['total_model'] + 1) }}"
                style="text-align: center; vertical-align: top; font-size: 5pt;border: 1pt solid black; widht: 1.5cm; padding: 2pt;">
                {{$noUrutManifest++}}.

            </td>
            <td rowspan="{{ ($vManifest['total_model'] + 1) }}" colspan="2"
                style="text-align: left; vertical-align: top; font-size: 5pt;border: 1pt solid black; widht: 1.5cm; padding: 2pt;">
                {{$vManifest['do_manifest_no']}}
            </td>
            <td rowspan="{{ ($vManifest['total_model'] + 1) }}"
                style="text-align: center; vertical-align: top; font-size: 5pt;border: 1pt solid black; widht: 1.5cm; padding: 2pt;">
                {{date('d/m/Y', strtotime($vManifest['do_manifest_date']))}}

            </td>
            <td rowspan="{{ ($vManifest['total_model'] + 1) }}" colspan="2"
                style="text-align: left; vertical-align: top; font-size: 5pt;border: 1pt solid black; widht: 1.5cm; padding: 2pt;">
                {{ $vManifest['city_name'] }}
            </td>
            <td rowspan="{{ ($vManifest['total_model'] + 1) }}" colspan="2"
                style="text-align: left; vertical-align: top; font-size: 5pt;border: 1pt solid black; widht: 1.5cm; padding: 2pt;">
                {{ $vManifest['vehicle_description'] }}
            </td>
            <td rowspan="{{ ($vManifest['total_model'] + 1) }}"
                style="text-align: left; vertical-align: top; font-size: 5pt;border: 1pt solid black; widht: 1.5cm; padding: 2pt;">
                {{ $vManifest['vehicle_number'] }}
            </td>
            <td rowspan="{{ ($vManifest['total_model'] + 1) }}"
                style="text-align: right; vertical-align: top; font-size: 5pt;border: 1pt solid black; widht: 1.5cm; padding: 2pt;">
                {{ thousand_reformat($vManifest['ritase']) }}
            </td>
            <td rowspan="{{ ($vManifest['total_model'] + 1) }}"
                style="text-align: right; vertical-align: top; font-size: 5pt;border: 1pt solid black; widht: 1.5cm; padding: 2pt;">
                {{ thousand_reformat($vManifest['cbm']) }}
            </td>
            <td rowspan="{{ ($vManifest['total_model'] + 1) }}"
                style="text-align: right; vertical-align: top; font-size: 5pt;border: 1pt solid black; widht: 1.5cm; padding: 2pt;">
                {{ thousand_reformat($vManifest['ritase2']) }}
            </td>
            <td rowspan="{{ ($vManifest['total_model'] + 1) }}"
                style="text-align: right; vertical-align: top; font-size: 5pt;border: 1pt solid black; widht: 1.5cm; padding: 2pt;">
                {{ thousand_reformat($vManifest['multidrop']) }}
            </td>
            <td rowspan="{{ ($vManifest['total_model'] + 1) }}"
                style="text-align: right; vertical-align: top; font-size: 5pt;border: 1pt solid black; widht: 1.5cm; padding: 2pt;">
                {{ thousand_reformat($vManifest['unloading']) }}
            </td>
            <td rowspan="{{ ($vManifest['total_model'] + 1) }}"
                style="text-align: right; vertical-align: top; font-size: 5pt;border: 1pt solid black; widht: 1.5cm; padding: 2pt;">
                {{ thousand_reformat($vManifest['overstay']) }}
            </td>
            @php
            $do = array_values($vManifest['do']);
            @endphp
            <td rowspan="{{ count($do[0]['models']) }}" style="text-align: left; font-size: 5pt;border: 1pt solid black; padding: 2pt;">
                {{ $do[0]['no_do_sap'] }}
            </td>
            <td rowspan="{{ count($do[0]['models']) }}" style="text-align: left; font-size: 5pt;border: 1pt solid black; padding: 2pt;">
                {{ date('d/m/Y', strtotime($do[0]['tgl_do_sap'])) }}
            </td>
            <td rowspan="{{ count($do[0]['models']) }}" style="text-align: left; font-size: 5pt;border: 1pt solid black; padding: 2pt;">
                {{ $do[0]['ship_to_code'] }}
            </td>
            <td rowspan="{{ count($do[0]['models']) }}" style="text-align: left; font-size: 5pt;border: 1pt solid black; padding: 2pt;">
                {{ $do[0]['ship_to'] }}
            </td>
            <td rowspan="{{ count($do[0]['models']) }}" style="text-align: left; font-size: 5pt;border: 1pt solid black; padding: 2pt;">
                {{ $do[0]['acc_code'] }}
            </td>
            <td style="text-align: left; font-size: 5pt;border: 1pt solid black; padding: 2pt; padding: 2pt;">
                {{ $do[0]['models'][0]['model'] }}
            </td>
            <td style="text-align: right; font-size: 5pt;border: 1pt solid black; padding: 2pt; padding: 2pt;">
                {{ $do[0]['models'][0]['quantity'] }}
            </td>
            <td style="text-align: right; font-size: 5pt;border: 1pt solid black;">
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
                <td style="text-align: left; font-size: 5pt;border: 1pt solid black;">
                    {{$vModel['model']}}
                </td>
                <td style="text-align: right; font-size: 5pt;border: 1pt solid black;">
                    {{$vModel['quantity']}}
                </td>
                <td style="text-align: right; font-size: 5pt;border: 1pt solid black;">
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
                <td rowspan="{{ count($do[$kdo]['models']) }}" style="text-align: left; font-size: 5pt;border: 1pt solid black; padding: 2pt;">
                {{ $do[$kdo]['no_do_sap'] }}
                </td>
                <<td rowspan="{{ count($do[$kdo]['models']) }}" style="text-align: left; font-size: 5pt;border: 1pt solid black; padding: 2pt;">
                    {{ date('d/m/Y', strtotime($do[$kdo]['tgl_do_sap'])) }}
                </td>
                <td rowspan="{{ count($do[$kdo]['models']) }}" style="text-align: left; font-size: 5pt;border: 1pt solid black; padding: 2pt;">
                    {{ $do[$kdo]['ship_to_code'] }}
                </td>
                <td rowspan="{{ count($do[$kdo]['models']) }}" style="text-align: left; font-size: 5pt;border: 1pt solid black; padding: 2pt;">
                    {{ $do[$kdo]['ship_to'] }}
                </td>
                <td rowspan="{{ count($do[$kdo]['models']) }}" style="text-align: left; font-size: 5pt;border: 1pt solid black; padding: 2pt;">
                    {{ $do[$kdo]['acc_code'] }}
                </td> -->
                <td style="text-align: left; font-size: 5pt;border: 1pt solid black; padding: 2pt;">
                    {{ $do[$kdo]['models'][0]['model'] }}
                </td>
                <td style="text-align: right; font-size: 5pt;border: 1pt solid black; padding: 2pt;">
                    {{ $do[$kdo]['models'][0]['quantity'] }}
                </td>
                <td style="text-align: right; font-size: 5pt;border: 1pt solid black; padding: 2pt;">
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
                    <td style="text-align: left; font-size: 5pt;border: 1pt solid black;">
                        {{$vModel['model']}}
                    </td>
                    <td style="text-align: right; font-size: 5pt;border: 1pt solid black;">
                        {{$vModel['quantity']}}
                    </td>
                    <td style="text-align: right; font-size: 5pt;border: 1pt solid black;">
                        {{$vModel['cbm_do']}}
                    </td>
                </tr>
                @endif
            @endforeach
            @endif
            @endif
        @endforeach
        @endif
        <tr>
            <td colspan="6"
                style="text-align: right; font-size: 5pt;border: 1pt solid black; padding: 2pt;">
                <strong>SUB TOTAL</strong></td>
            <td style="text-align: right; font-size: 5pt;border: 1pt solid black; padding: 2pt;">
                <strong>{{$subTotalQty}}</strong></td>
            <td style="text-align: right; font-size: 5pt;border: 1pt solid black; padding: 2pt;">
                <strong>{{$subTotalCbm}}</strong></td>
        </tr>

        @endforeach

	</tbody>
</table>
<table style="page-break-inside: avoid; border-collapse: collapse; font-size: 5pt;">
	<tr>
		<td style="text-align: center; width: 5.1cm;">
			&nbsp;
		</td>
		<td style="text-align: left;border: 1pt solid black; font-size: 5pt; width: 1.5cm; padding: 2pt;">Total Freight
		</td>
		<td style="text-align: right;border: 1pt solid black; font-size: 5pt; width: 1.5cm; padding: 2pt;">
			{{ thousand_reformat($printData['total_freight']) }}
		</td>
		<td style="text-align: right;border: 1pt solid black; font-size: 5pt; width: 1.5cm; padding: 2pt;">
			{{ thousand_reformat($printData['total_ritase']) }}
		</td>
		<td style="text-align: right;border: 1pt solid black; font-size: 5pt; width: 1.5cm; padding: 2pt;">
			{{ thousand_reformat($printData['total_cbm']) }}
		</td>
		<td style="text-align: right;border: 1pt solid black; font-size: 5pt; width: 1.5cm; padding: 2pt;">
			{{ thousand_reformat($printData['total_ritase2']) }}
		</td>
		<td style="text-align: right;border: 1pt solid black; font-size: 5pt; width: 1.5cm; padding: 2pt;">
			{{ thousand_reformat($printData['total_multidrop']) }}
		</td>
		<td style="text-align: right;border: 1pt solid black; font-size: 5pt; width: 1.5cm; padding: 2pt;">
			{{ thousand_reformat($printData['total_unloading']) }}
		</td>
		<td style="text-align: right;border: 1pt solid black; font-size: 5pt; width: 1.5cm; padding: 2pt;">
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
		<td colspan="2" style="text-align: left;border: 1pt solid black; font-size: 5pt; width: 1.5cm; padding: 2pt;">Tax
		</td>
		<td style="text-align: right;border: 1pt solid black; font-size: 5pt; width: 1.5cm; padding: 2pt;">
			{{ thousand_reformat($printData['tax']) }}
		</td>
	</tr>
	<tr>
		<td colspan="6" style="text-align: center; ">
			&nbsp;
		</td>
		<td colspan="2" style="text-align: left;border: 1pt solid black; font-size: 5pt; width: 1.5cm; padding: 2pt;">Grand
			Total
		</td>
		<td style="text-align: right;border: 1pt solid black; font-size: 5pt; width: 1.5cm; padding: 2pt;">
			{{ thousand_reformat($printData['grand_total']) }}
		</td>
	</tr>
</table>
<table style="page-break-inside: avoid; border-collapse: collapse; font-size: 5pt; margin-top: 10px;">
    <tbody>
        <tr>
            <td colspan="23" style="text-align: center; ">
                &nbsp;
            </td>
        </tr>
        <tr>
            <td colspan="6" style="text-align: center; ">
                &nbsp;
            </td>
            @if($printData['summary']['BR'])
            <td colspan="4" style="text-align: center;border: 1pt solid black; font-size: 5pt;">BR</td>
            @endif
            @if($printData['summary']['DS'])
            <td colspan="4" style="text-align: center;border: 1pt solid black; font-size: 5pt;">DS</td>
            @endif
            <td colspan="4" style="text-align: center;border: 1pt solid black; font-size: 5pt;">Total</td>
            <td colspan="4" style="text-align: center; ">
                &nbsp;
            </td>
        </tr>
        <tr>
            <td colspan="6" style="text-align: center; ">
                &nbsp;
            </td>
            @if($printData['summary']['BR'])
            <td style="text-align: center;border: 1pt solid black; font-size: 5pt; widht: 1.5cm; padding: 2pt;">FREIGHT COST
            </td>
            <td style="text-align: center;border: 1pt solid black; font-size: 5pt; widht: 1.5cm; padding: 2pt;">MULTIDROP
            </td>
            <td style="text-align: center;border: 1pt solid black; font-size: 5pt; widht: 1.5cm; padding: 2pt;">UNLOADING
            </td>
            <td style="text-align: center;border: 1pt solid black; font-size: 5pt; widht: 1.5cm; padding: 2pt;">OVERSTAY
            </td>
            @endif
            @if($printData['summary']['DS'])
            <td style="text-align: center;border: 1pt solid black; font-size: 5pt; widht: 1.5cm; padding: 2pt;">FREIGHT COST
            </td>
            <td style="text-align: center;border: 1pt solid black; font-size: 5pt; widht: 1.5cm; padding: 2pt;">MULTIDROP
            </td>
            <td style="text-align: center;border: 1pt solid black; font-size: 5pt;widht: 1.5cm; padding: 2pt;">UNLOADING
            </td>
            <td style="text-align: center;border: 1pt solid black; font-size: 5pt; widht: 1.5cm; padding: 2pt;">OVERSTAY
            </td>
            @endif
            <td style="text-align: center;border: 1pt solid black; font-size: 5pt; widht: 1.5cm; padding: 2pt;">FREIGHT COST
            </td>
            <td style="text-align: center;border: 1pt solid black; font-size: 5pt; widht: 1.5cm; padding: 2pt;">MULTIDROP
            </td>
            <td style="text-align: center;border: 1pt solid black; font-size: 5pt; widht: 1.5cm; padding: 2pt;">UNLOADING
            </td>
            <td style="text-align: center;border: 1pt solid black; font-size: 5pt; widht: 1.5cm; padding: 2pt;">OVERSTAY
            </td>
            <td colspan="4" style="text-align: center; ">
                &nbsp;
            </td>
        </tr>
        @foreach($printData['summary']['data'] AS $key => $value)
        <tr>
            <td colspan="3" style="font-size: 5pt;text-align: center; ">
                &nbsp;
            </td>
            <td colspan="3" style="font-size: 5pt;text-align: left; border: 1pt solid black; width: 20mm;">
                {{$key}}
            </td>
            @if($printData['summary']['BR'])
            <td colspan="1" style="font-size: 5pt;text-align: right;border: 1pt solid black; widht: 1.5cm; padding: 2pt;">
                {{!empty($value['BR']) ? thousand_reformat($value['BR']['freight_cost']) : 0}}
            </td>
            <td style="font-size: 5pt;text-align: right; border: 1pt solid black; widht: 1.5cm; padding: 2pt;">
                {{!empty($value['BR']) ? thousand_reformat($value['BR']['multidro_amount']) : 0}}
            </td>
            <td style="font-size: 5pt;text-align: right; border: 1pt solid black; widht: 1.5cm; padding: 2pt;">
                {{!empty($value['BR']) ? thousand_reformat($value['BR']['unloading_amount']) : 0}}
            </td>
            <td style="font-size: 5pt;text-align: right; border: 1pt solid black; widht: 1.5cm; padding: 2pt;">
                {{!empty($value['BR']) ? thousand_reformat($value['BR']['overstay_amount']) : 0}}
            </td>
            @endif
            @if($printData['summary']['DS'])
            <td style="font-size: 5pt;text-align: right;border: 1pt solid black; widht: 1.5cm; padding: 2pt;">
                {{!empty($value['DS']) ? thousand_reformat($value['DS']['freight_cost']) : 0}}
            </td>
            <td style="font-size: 5pt;text-align: right; border: 1pt solid black; widht: 1.5cm; padding: 2pt;">
                {{!empty($value['DS']) ? thousand_reformat($value['DS']['multidro_amount']) : 0}}
            </td>
            <td style="font-size: 5pt;text-align: right; border: 1pt solid black; widht: 1.5cm; padding: 2pt;">
                {{!empty($value['DS']) ? thousand_reformat($value['DS']['unloading_amount']) : 0}}
            </td>
            <td style="font-size: 5pt;text-align: right; border: 1pt solid black; widht: 1.5cm; padding: 2pt;">
                {{!empty($value['DS']) ? thousand_reformat($value['DS']['overstay_amount']) : 0}}
            </td>
            @endif
            <td style="font-size: 5pt;text-align: right; border: 1pt solid black; widht: 1.5cm; padding: 2pt;">
                {{ thousand_reformat((!empty($value['BR']) ? $value['BR']['freight_cost'] : 0) + (!empty($value['DS']) ? $value['DS']['freight_cost'] : 0)) }}
            </td>
            <td style="font-size: 5pt;text-align: right; border: 1pt solid black; widht: 1.5cm; padding: 2pt;">
                {{ thousand_reformat((!empty($value['BR']) ? $value['BR']['multidro_amount'] : 0) + (!empty($value['DS']) ? $value['DS']['multidro_amount'] : 0)) }}
            </td>
            <td style="font-size: 5pt;text-align: right; border: 1pt solid black; widht: 1.5cm; padding: 2pt;">
                {{ thousand_reformat((!empty($value['BR']) ? $value['BR']['unloading_amount'] : 0) + (!empty($value['DS']) ? $value['DS']['unloading_amount'] : 0)) }}
            </td>
            <td style="font-size: 5pt;text-align: right; border: 1pt solid black; widht: 1.5cm; padding: 2pt;">
                {{ thousand_reformat((!empty($value['BR']) ? $value['BR']['overstay_amount'] : 0) + (!empty($value['DS']) ? $value['DS']['overstay_amount'] : 0)) }}
            </td>
            <td colspan="4" style="font-size: 5pt;text-align: center; ">
                &nbsp;
            </td>
        </tr>
        @endforeach
        {{-- End Main Table --}}    
    </tbody>
</table>