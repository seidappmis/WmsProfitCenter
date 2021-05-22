<body>	
	<table width="100%">
		<tr>
			{{-- <td rowspan="28">
			&nbsp;
		</td> --}}
			<td rowspan="4" colspan="1" style="width: 10px;">
				&nbsp;
			</td>
			<td colspan="2" style="text-align: left; font-size: 8pt;">
				<strong>ReceiptID</strong>
			</td>
			<td style="width: 19px;">:</td>
			<td colspan="6" style="text-align: left; font-size: 8pt;">
				<strong>{{$invoiceReceiptHeader->invoice_receipt_id}}</strong>
			</td>
			<td rowspan="10" colspan="13" style="text-align: left; font-size: 16pt; vertical-align: top;">
				<strong>PT. SHARP ELECTRONICS INDONESIA - TRUCKING CHARGES OF TRANSPORTER</strong>
			</td>
		</tr>
		<tr>
			<td colspan="2" style="text-align: left; font-size: 8pt;"><strong>No Tanda
					Terima</strong>
			</td>
			<td style="width: 19px;">:</td>
			<td colspan="5" style="text-align: left; font-size: 8pt;">
				<strong>{{$invoiceReceiptHeader->invoice_receipt_no}}</strong>
			</td>
			<td colspan="3" style="text-align: left; font-size: 8pt; width: 19px;">
				<strong>{{date('Y-m-d')}}</strong>
			</td>
		</tr>
		<tr>
			<td colspan="2" style="text-align: left; font-size: 8pt;">
				<strong>No Kwitansi</strong>
			</td>
			<td style="width: 19px;">:</td>
			<td colspan="6" style="text-align: left; font-size: 8pt;">
				<strong>{{$invoiceReceiptHeader->kwitansi_no}}</strong>
			</td>
		</tr>
		<tr>
			<td colspan="2" style="text-align: left; font-size: 8pt;">
				<strong>Ekspedisi</strong>
			</td>
			<td style="width: 19px;">:</td>
			<td colspan="6" style="text-align: left; font-size: 8pt;">
				<strong>{{$invoiceReceiptHeader->expedition_name}}</strong>
			</td>
		</tr>
		{{-- <tr>
		<td colspan="23" style="text-align: left; font-size: 12pt;">&nbsp;
		</td>
	</tr> --}}
	</table>

	<table>
		{{-- Table Head --}}
		<thead>
			{{--<tr><td colspan="23" style="text-align: left; font-size: 12pt;">&nbsp;</td></tr> --}}
			<tr>
				<td style="text-align: center; vertical-align: top; font-size: 8pt; width: 19px; border: 1pt solid black;">
					<strong>No.</strong>
				</td>
				<td colspan="2" style="text-align: center; vertical-align: top; font-size: 8pt;width: 60px;border: 1pt solid black;">
					<strong>NO MANIFEST</strong>
				</td>
				<td colspan="1" style="text-align: center; vertical-align: top; font-size: 8pt;width: 53px;border: 1pt solid black;">
					<strong>TANGGAL</strong>
				</td>
				<td colspan="2" style="text-align: center; vertical-align: top; font-size: 8pt;width: 60px;border: 1pt solid black;">
					<strong>TUJUAN</strong>
				</td>
				<td colspan="2" style="text-align: center; vertical-align: top; font-size: 8pt;width: 55px;border: 1pt solid black;">
					<strong>KENDARAAN</strong>
				</td>
				<td style="text-align: center; vertical-align: top; font-size: 8pt;width: 53px;border: 1pt solid black;">
					<strong>NO POLISI</strong>
				</td>
				<td style="text-align: center; vertical-align: top; font-size: 8pt;width: 49px;border: 1pt solid black;">
					<strong>RITASE</strong>
				</td>
				<td style="text-align: center; vertical-align: top; font-size: 8pt;width: 49px;border: 1pt solid black;">
					<strong>CBM</strong>

				</td>
				<td style="text-align: center; vertical-align: top; font-size: 8pt;width: 49px;border: 1pt solid black;">
					<strong>RITASE2</strong>
				</td>
				<td style="text-align: center; vertical-align: top; font-size: 8pt;width: 49px;border: 1pt solid black;">
					<strong>MULTIDROP</strong>
				</td>
				<td style="text-align: center; vertical-align: top; font-size: 8pt;width: 49px;border: 1pt solid black;">
					<strong>UNLOADING</strong>

				</td>
				<td style="text-align: center; vertical-align: top; font-size: 8pt;width: 49px;border: 1pt solid black;">
					<strong>OVERSTAY</strong>
				</td>
				<td style="text-align: center; vertical-align: top; font-size: 8pt; width: 76px;border: 1pt solid black;">
					<strong>NO DO SAP</strong>
				</td>
				<td style="text-align: center; vertical-align: top; font-size: 8pt; width: 34px;border: 1pt solid black;">
					<strong>TGL DO SAP</strong>

				</td>
				<td style="text-align: center; vertical-align: top; font-size: 8pt; width: 45px;border: 1pt solid black;">
					<strong>SHIP TO</strong>

				</td>
				<td style="text-align: center; vertical-align: top; font-size: 8pt; width: 132px;border: 1pt solid black;">
					<strong>SHIP TO DETAIL</strong>

				</td>
				<td style="text-align: center; vertical-align: top; font-size: 8pt; width: 64px;border: 1pt solid black;">
					<strong>ACC CODE</strong>

				</td>
				<td style="text-align: center; vertical-align: top; font-size: 8pt; width: 68px;border: 1pt solid black;">
					<strong>MODEL</strong>

				</td>
				<td style="text-align: center; vertical-align: top; font-size: 8pt; width: 30px;border: 1pt solid black;">
					<strong>QTY</strong>

				</td>
				<td style="text-align: center; vertical-align: top; font-size: 8pt;width: 45px;border: 1pt solid black;">
					<strong>TOTAL CBM</strong>

				</td>
			</tr>
		</thead>

		{{-- Table Body --}}
		<tbody>
			@php
				$noUrutManifest = 1;
				$printData = $invoiceReceiptHeader->getPrintReceiptData();
			@endphp
			@foreach( $printData['list'] AS $kManifest => $vManifest)
				@php
					$subTotalQty = 0;
					$subTotalCbm = 0;
					$do = array_values($vManifest['do']);
					$subTotalQty += $do[0]['models'][0]['quantity'];
					$subTotalCbm += $do[0]['models'][0]['cbm_do'];
				@endphp
				<tr>
					<td style="text-align: center; font-size: 8pt; border: 1pt solid black; border-bottom:none; width: 57px;">
						{{$noUrutManifest++}}.
					</td>
					<td colspan="2" style="text-align: left; font-size: 8pt; border: 1pt solid black; border-bottom:none; width: 57px; padding: 2pt;">
						{{$vManifest['do_manifest_no']}}
					</td>
					<td style="text-align: center; font-size: 8pt; border: 1pt solid black; border-bottom:none; width: 57px; padding: 2pt;">
						{{date('d/m/Y', strtotime($vManifest['do_manifest_date']))}}
					</td>
					<td colspan="2" style="text-align: left; font-size: 8pt; border: 1pt solid black; border-bottom:none; width: 57px; padding: 2pt;">
						{{ $vManifest['city_name'] }}
					</td>
					<td colspan="2" style="text-align: left; font-size: 8pt; border: 1pt solid black; border-bottom:none; width: 57px; padding: 2pt;">
						{{ $vManifest['vehicle_description'] }}
					</td>
					<td style="text-align: left; font-size: 8pt; border: 1pt solid black; border-bottom:none; width: 57px; padding: 2pt;">
						{{ $vManifest['vehicle_number'] }}
					</td>
					<td style="text-align: right; font-size: 8pt; border: 1pt solid black; border-bottom:none; width: 57px; padding: 2pt;">
						{{ thousand_reformat($vManifest['ritase']) }}
					</td>
					<td style="text-align: right; font-size: 8pt; border: 1pt solid black; border-bottom:none; width: 57px; padding: 2pt;">
						{{ thousand_reformat($vManifest['cbm']) }}
					</td>
					<td style="text-align: right; font-size: 8pt; border: 1pt solid black; border-bottom:none; width: 57px; padding: 2pt;">
						{{ thousand_reformat($vManifest['ritase2']) }}
					</td>
					<td style="text-align: right; font-size: 8pt; border: 1pt solid black; border-bottom:none; width: 57px; padding: 2pt;">
						{{ thousand_reformat($vManifest['multidrop']) }}
					</td>
					<td style="text-align: right; font-size: 8pt; border: 1pt solid black; border-bottom:none; width: 57px; padding: 2pt;">
						{{ thousand_reformat($vManifest['unloading']) }}
					</td>
					<td style="text-align: right; font-size: 8pt;border: 1pt solid black; border-bottom:none; width: 57px; padding: 2pt;">
						{{ thousand_reformat($vManifest['overstay']) }}
					</td>
					<td rowspan="{{ count($do[0]['models']) }}" style="text-align: left; font-size: 8pt;border: 1pt solid black; padding: 2pt;">
						{{ $do[0]['no_do_sap'] }}
					</td>
					<td rowspan="{{ count($do[0]['models']) }}" style="text-align: left; font-size: 8pt;border: 1pt solid black; padding: 2pt;">
						{{ date('d/m/Y', strtotime($do[0]['tgl_do_sap'])) }}
					</td>
					<td rowspan="{{ count($do[0]['models']) }}" style="text-align: left; font-size: 8pt;border: 1pt solid black; padding: 2pt;">
						{{ $do[0]['ship_to_code'] }}
					</td>
					<td rowspan="{{ count($do[0]['models']) }}" style="text-align: left; font-size: 8pt;border: 1pt solid black; padding: 2pt;">
						{{ $do[0]['ship_to'] }}
					</td>
					<td rowspan="{{ count($do[0]['models']) }}" style="text-align: left; font-size: 8pt;border: 1pt solid black; padding: 2pt;">
						{{ $do[0]['acc_code'] }}
					</td>
					<td style="text-align: left; font-size: 8pt;border: 1pt solid black; padding: 2pt; padding: 2pt;">
						{{ $do[0]['models'][0]['model'] }}
					</td>
					<td style="text-align: right; font-size: 8pt;border: 1pt solid black; padding: 2pt; padding: 2pt;">
						{{ $do[0]['models'][0]['quantity'] }}
					</td>
					<td style="text-align: right; font-size: 8pt;border: 1pt solid black;">
						{{ $do[0]['models'][0]['cbm_do'] }}
					</td>
				</tr>

				@if(count($do[0]['models']) > 1)
					@foreach($do[0]['models'] AS $kModel => $vModel)
						@if($kModel != 0)
							@php
								$subTotalQty += $vModel['quantity'];
								$subTotalCbm += $vModel['cbm_do'];
							@endphp
							<tr>
								<td style="text-align: left; font-size: 8pt;border: 1pt solid black;">
									{{$vModel['model']}}
								</td>
								<td style="text-align: right; font-size: 8pt;border: 1pt solid black;">
									{{$vModel['quantity']}}
								</td>
								<td style="text-align: right; font-size: 8pt;border: 1pt solid black;">
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
								<td style="text-align: center; vertical-align: top; font-size: 8pt;border-left: 1pt solid black; border-right: 1pt solid black; width: 57px; padding: 2pt;">&nbsp;</td>
								<td colspan="2" style="border-left: 1pt solid black; border-right: 1pt solid black; width: 57px;">&nbsp;</td>
								<td style="border-left: 1pt solid black; border-right: 1pt solid black; width: 57px;">&nbsp;</td>
								<td colspan="2" style="border-left: 1pt solid black; border-right: 1pt solid black; width: 57px;">&nbsp;</td>
								<td colspan="2" style="border-left: 1pt solid black; border-right: 1pt solid black; width: 57px;">&nbsp;</td>
								<td style="border-left: 1pt solid black; border-right: 1pt solid black; width: 57px;">&nbsp;</td>
								<td style="border-left: 1pt solid black; border-right: 1pt solid black; width: 57px;">&nbsp;</td>
								<td style="border-left: 1pt solid black; border-right: 1pt solid black; width: 57px;">&nbsp;</td>
								<td style="border-left: 1pt solid black; border-right: 1pt solid black; width: 57px;">&nbsp;</td>
								<td style="border-left: 1pt solid black; border-right: 1pt solid black; width: 57px;">&nbsp;</td>
								<td style="border-left: 1pt solid black; border-right: 1pt solid black; width: 57px;">&nbsp;</td>
								<td style="border-left: 1pt solid black; border-right: 1pt solid black; width: 57px;">&nbsp;</td>

								<td rowspan="{{ count($do[$kdo]['models']) }}" style="text-align: left; font-size: 8pt; border: 1pt solid black; padding: 2pt;">
									{{ $do[$kdo]['no_do_sap'] }}
								</td>
								<td rowspan="{{ count($do[$kdo]['models']) }}" style="text-align: left; font-size: 8pt;border: 1pt solid black; padding: 2pt;">
									{{ date('d/m/Y', strtotime($do[$kdo]['tgl_do_sap'])) }}
								</td>
								<td rowspan="{{ count($do[$kdo]['models']) }}" style="text-align: left; font-size: 8pt;border: 1pt solid black; padding: 2pt;">
									{{ $do[$kdo]['ship_to_code'] }}
								</td>
								<td rowspan="{{ count($do[$kdo]['models']) }}" style="text-align: left; font-size: 8pt;border: 1pt solid black; padding: 2pt;">
									{{ $do[$kdo]['ship_to'] }}
								</td>
								<td rowspan="{{ count($do[$kdo]['models']) }}" style="text-align: left; font-size: 8pt;border: 1pt solid black; padding: 2pt;">
									{{ $do[$kdo]['acc_code'] }}
								</td>
								<td style="text-align: left; font-size: 8pt;border: 1pt solid black; padding: 2pt;">
									{{ $do[$kdo]['models'][0]['model'] }}
								</td>
								<td style="text-align: right; font-size: 8pt;border: 1pt solid black; padding: 2pt;">
									{{ $do[$kdo]['models'][0]['quantity'] }}
								</td>
								<td style="text-align: right; font-size: 8pt;border: 1pt solid black; padding: 2pt;">
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
											<td style="text-align: left; font-size: 8pt;border: 1pt solid black;">
												{{$vModel['model']}}
											</td>
											<td style="text-align: right; font-size: 8pt;border: 1pt solid black;">
												{{$vModel['quantity']}}
											</td>
											<td style="text-align: right; font-size: 8pt;border: 1pt solid black;">
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
					<td style="text-align: center; font-size: 8pt; border: 1pt solid black; border-top:none; width: 57px; padding: 2pt;"></td>
					<td colspan="2" style="border: 1pt solid black; border-top:none; width: 57px"></td>
					<td style="border: 1pt solid black; border-top:none; width: 57px"></td>
					<td colspan="2" style="border: 1pt solid black; border-top:none; width: 57px"></td>
					<td colspan="2" style="border: 1pt solid black; border-top:none; width: 57px"></td>
					<td style="border: 1pt solid black; border-top:none; width: 57px"></td>
					<td style="border: 1pt solid black; border-top:none; width: 57px"></td>
					<td style="border: 1pt solid black; border-top:none; width: 57px"></td>
					<td style="border: 1pt solid black; border-top:none; width: 57px"></td>
					<td style="border: 1pt solid black; border-top:none; width: 57px"></td>
					<td style="border: 1pt solid black; border-top:none; width: 57px"></td>
					<td style="border: 1pt solid black; border-top:none; width: 57px"></td>

					<td colspan="6" style="text-align: right; font-size: 8pt;border: 1pt solid black; padding: 2pt;">
						<strong>SUB TOTAL</strong>
					</td>
					<td style="text-align: right; font-size: 8pt;border: 1pt solid black; padding: 2pt;">
						<strong>{{$subTotalQty}}</strong>
					</td>
					<td style="text-align: right; font-size: 8pt;border: 1pt solid black; padding: 2pt;">
						<strong>{{$subTotalCbm}}</strong>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>

	<table>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td colspan="6" style="text-align: center; width: 192px;">
				&nbsp;
			</td>
			<td colspan="2" style="text-align: left;border: 1pt solid black; font-size: 8pt; width: 55px; padding: 2pt;">
				Total Freight
			</td>
			<td style="text-align: right;border: 1pt solid black; font-size: 8pt; width: 53px; padding: 2pt;">
				{{ thousand_reformat($printData['total_freight']) }}
			</td>
			<td style="text-align: right;border: 1pt solid black; font-size: 8pt; width: 49px; padding: 2pt;">
				{{ thousand_reformat($printData['total_ritase']) }}
			</td>
			<td style="text-align: right;border: 1pt solid black; font-size: 8pt; width: 49px; padding: 2pt;">
				{{ thousand_reformat($printData['total_cbm']) }}
			</td>
			<td style="text-align: right;border: 1pt solid black; font-size: 8pt; width: 49px; padding: 2pt;">
				{{ thousand_reformat($printData['total_ritase2']) }}
			</td>
			<td style="text-align: right;border: 1pt solid black; font-size: 8pt; width: 49px; padding: 2pt;">
				{{ thousand_reformat($printData['total_multidrop']) }}
			</td>
			<td style="text-align: right;border: 1pt solid black; font-size: 8pt; width: 49px; padding: 2pt;">
				{{ thousand_reformat($printData['total_unloading']) }}
			</td>
			<td style="text-align: right;border: 1pt solid black; font-size: 8pt; width: 49px; padding: 2pt;">
				{{ thousand_reformat($printData['total_overstay']) }}
			</td>
			<td colspan="8" style="text-align: center; ">
				&nbsp;
			</td>
		</tr>
		<tr>
			<td colspan="6">
				&nbsp;
			</td>
			<td colspan="2" style="text-align: left;border: 1pt solid black; font-size: 8pt; padding: 2pt;">Tax
			</td>
			<td style="text-align: right;border: 1pt solid black; font-size: 8pt; padding: 2pt;">
				{{ thousand_reformat($printData['tax']) }}
			</td>
		</tr>
		<tr>
			<td colspan="6">
				&nbsp;
			</td>
			<td colspan="2" style="text-align: left;border: 1pt solid black; font-size: 8pt; padding: 2pt;">Grand
				Total
			</td>
			<td style="text-align: right;border: 1pt solid black; font-size: 8pt; padding: 2pt;">
				{{ thousand_reformat($printData['grand_total']) }}
			</td>
		</tr>
	</table>

	<table>
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
				<td colspan="4" style="text-align: center;border: 1pt solid black; font-size: 8pt;">BR</td>
				@endif
				@if($printData['summary']['DS'])
				<td colspan="4" style="text-align: center;border: 1pt solid black; font-size: 8pt;">DS</td>
				@endif
				<td colspan="4" style="text-align: center;border: 1pt solid black; font-size: 8pt;">Total</td>
				<td colspan="4" style="text-align: center; ">
					&nbsp;
				</td>
			</tr>
			<tr>
				<td colspan="6" style="text-align: center; ">
					&nbsp;
				</td>
				@if($printData['summary']['BR'])
				<td style="text-align: center;border: 1pt solid black; font-size: 8pt; width: 57px; padding: 2pt;">FREIGHT COST
				</td>
				<td style="text-align: center;border: 1pt solid black; font-size: 8pt; width: 57px; padding: 2pt;">MULTIDROP
				</td>
				<td style="text-align: center;border: 1pt solid black; font-size: 8pt; width: 57px; padding: 2pt;">UNLOADING
				</td>
				<td style="text-align: center;border: 1pt solid black; font-size: 8pt; width: 57px; padding: 2pt;">OVERSTAY
				</td>
				@endif
				@if($printData['summary']['DS'])
				<td style="text-align: center;border: 1pt solid black; font-size: 8pt; width: 57px; padding: 2pt;">FREIGHT COST
				</td>
				<td style="text-align: center;border: 1pt solid black; font-size: 8pt; width: 57px; padding: 2pt;">MULTIDROP
				</td>
				<td style="text-align: center;border: 1pt solid black; font-size: 8pt;width: 57px; padding: 2pt;">UNLOADING
				</td>
				<td style="text-align: center;border: 1pt solid black; font-size: 8pt; width: 57px; padding: 2pt;">OVERSTAY
				</td>
				@endif
				<td style="text-align: center;border: 1pt solid black; font-size: 8pt; width: 57px; padding: 2pt;">FREIGHT COST
				</td>
				<td style="text-align: center;border: 1pt solid black; font-size: 8pt; width: 57px; padding: 2pt;">MULTIDROP
				</td>
				<td style="text-align: center;border: 1pt solid black; font-size: 8pt; width: 57px; padding: 2pt;">UNLOADING
				</td>
				<td style="text-align: center;border: 1pt solid black; font-size: 8pt; width: 57px; padding: 2pt;">OVERSTAY
				</td>
				<td colspan="4" style="text-align: center; ">
					&nbsp;
				</td>
			</tr>
			@foreach($printData['summary']['data'] AS $key => $value)
			<tr>
				<td colspan="3" style="font-size: 8pt;text-align: center; ">
					&nbsp;
				</td>
				<td colspan="3" style="font-size: 8pt;text-align: left; border: 1pt solid black; width: 76px;">
					{{$key}}
				</td>
				@if($printData['summary']['BR'])
				<td colspan="1" style="font-size: 8pt;text-align: right;border: 1pt solid black; width: 57px; padding: 2pt;">
					{{!empty($value['BR']) ? thousand_reformat($value['BR']['freight_cost']) : 0}}
				</td>
				<td style="font-size: 8pt;text-align: right; border: 1pt solid black; width: 57px; padding: 2pt;">
					{{!empty($value['BR']) ? thousand_reformat($value['BR']['multidro_amount']) : 0}}
				</td>
				<td style="font-size: 8pt;text-align: right; border: 1pt solid black; width: 57px; padding: 2pt;">
					{{!empty($value['BR']) ? thousand_reformat($value['BR']['unloading_amount']) : 0}}
				</td>
				<td style="font-size: 8pt;text-align: right; border: 1pt solid black; width: 57px; padding: 2pt;">
					{{!empty($value['BR']) ? thousand_reformat($value['BR']['overstay_amount']) : 0}}
				</td>
				@endif
				@if($printData['summary']['DS'])
				<td style="font-size: 8pt;text-align: right;border: 1pt solid black; width: 57px; padding: 2pt;">
					{{!empty($value['DS']) ? thousand_reformat($value['DS']['freight_cost']) : 0}}
				</td>
				<td style="font-size: 8pt;text-align: right; border: 1pt solid black; width: 57px; padding: 2pt;">
					{{!empty($value['DS']) ? thousand_reformat($value['DS']['multidro_amount']) : 0}}
				</td>
				<td style="font-size: 8pt;text-align: right; border: 1pt solid black; width: 57px; padding: 2pt;">
					{{!empty($value['DS']) ? thousand_reformat($value['DS']['unloading_amount']) : 0}}
				</td>
				<td style="font-size: 8pt;text-align: right; border: 1pt solid black; width: 57px; padding: 2pt;">
					{{!empty($value['DS']) ? thousand_reformat($value['DS']['overstay_amount']) : 0}}
				</td>
				@endif
				<td style="font-size: 8pt;text-align: right; border: 1pt solid black; width: 57px; padding: 2pt;">
					{{ thousand_reformat((!empty($value['BR']) ? $value['BR']['freight_cost'] : 0) + (!empty($value['DS']) ? $value['DS']['freight_cost'] : 0)) }}
				</td>
				<td style="font-size: 8pt;text-align: right; border: 1pt solid black; width: 57px; padding: 2pt;">
					{{ thousand_reformat((!empty($value['BR']) ? $value['BR']['multidro_amount'] : 0) + (!empty($value['DS']) ? $value['DS']['multidro_amount'] : 0)) }}
				</td>
				<td style="font-size: 8pt;text-align: right; border: 1pt solid black; width: 57px; padding: 2pt;">
					{{ thousand_reformat((!empty($value['BR']) ? $value['BR']['unloading_amount'] : 0) + (!empty($value['DS']) ? $value['DS']['unloading_amount'] : 0)) }}
				</td>
				<td style="font-size: 8pt;text-align: right; border: 1pt solid black; width: 57px; padding: 2pt;">
					{{ thousand_reformat((!empty($value['BR']) ? $value['BR']['overstay_amount'] : 0) + (!empty($value['DS']) ? $value['DS']['overstay_amount'] : 0)) }}
				</td>
				<td colspan="4" style="font-size: 8pt;text-align: center; ">
					&nbsp;
				</td>
			</tr>
			@endforeach
			{{-- End Main Table --}}
		</tbody>
	</table>

</body>