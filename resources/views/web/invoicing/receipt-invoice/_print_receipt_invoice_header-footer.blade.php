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
			<td rowspan="10" colspan="13" style="text-align: left; font-size: 10pt; vertical-align: top;">
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
<sethtmlpageheader name="myHeader1" value="on" show-this-page="1" />

<htmlpagefooter name="myFooter1">
	<table width="100%" style="font-size: 9pt;">
		<tr>
			<td colspan="3">{{date('l, d-F-Y h:i:s A')}}</td>
			<td colspan="8" align="center"> Page {PAGENO} of {nbpg}</td>
			<td colspan="6" style="text-align: right; ">Print out from SEID WMS</td>
		</tr>
	</table>
</htmlpagefooter>
<sethtmlpagefooter name="myFooter1" value="on" />