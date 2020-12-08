<html>

<head>
	<link rel="stylesheet" type="text/css" href="{{ url('materialize/css/custom/print1-a4.css') }}">
	{{-- @include('layouts.materialize.components.print-style') --}}
</head>

<body style="font-family: courier New; font-size: 10pt;">
	<table style="font-family: Arial Narrow;" width="100%">
		<tr>
			<td>
				<table width="100%">
					<tr>
						<td>
							<table width="100%" style="font-size: 9pt;">
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td colspan="12" style="font-size: 12pt; text-align: center;"><strong>LOSS/DAMAGE PRODUCT LIST</strong></td>
								</tr>
								<tr>
									<td colspan="12" style="font-size: 12pt; text-align: center;"><strong>(Daftar Kerugian/Kerusakan Barang)</strong></td>
								</tr>
								<tr>
									<td colspan="9"></td>
									<td style="width: 5mm;">&nbsp;</td>
									<td colspan="3" style="text-align: left; width:30%;"><strong>DATE OF REPORT {{date('d M Y', strtotime($claimInsurance->insurance_date))}}</strong></td>
								</tr>
								<tr>
									<td colspan="9"></td>
									<td style="width: 5mm;">&nbsp;</td>
									<td colspan="3" style="text-align: left; width:30%;"><strong>{{$claimInsurance->branch}} {{date('M Y', strtotime($claimInsurance->date_of_loss))}}</strong></td>
								</tr>
								<tr>
									<td style="width: 5mm;">&nbsp;</td>
									<td colspan="4" style="border-left: 1pt solid red;"><strong>1st Report</strong></td>
									<td colspan="4" style="border-left: 1pt solid red;"><strong>2nd Report</strong></td>
									<td style="width: 5mm;">&nbsp;</td>
									<td style="width: 5mm;">&nbsp;</td>
									<td colspan="2">
										<!-- <strong> : Wh Medan Des 2019</strong> -->
									</td>
								</tr>
								<tr>
									<td style="width: 5mm;">&nbsp;</td>
									<td colspan="10" style="color: red;">Shall be reported to HO & Insurance <u> within 2 days</u> after the accident Shall be reported to HO and Insurance within </td>
								</tr>
								<tr>
									<td style="width: 5mm;">&nbsp;</td>
									<td colspan="10" style="color: red;"><u>within a week</u> after the accident happened</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td>
							{{-- Table --}}
							<table width="100%" style="font-size: 8pt; border-collapse: collapse;">
								<tr>
									<td style="border-top: 2pt solid #000000; border-left: 2pt solid #000000; border-right: 2pt solid #000000; width: 5mm; text-align: center;"><strong>NO</strong></td>
									<td style="border-top: 2pt solid #000000; border-left: 2pt solid #000000; border-right: 2pt solid #000000; width: 20mm; text-align: center;"><strong>SERIAL NUMBER</strong></td>
									<td style="border-top: 2pt solid #000000; border-left: 2pt solid #000000; border-right: 2pt solid #000000; width: 10mm; text-align: center;"><strong>UNIT</strong></td>
									<td style="border-top: 2pt solid #000000; border-left: 2pt solid #000000; border-right: 2pt solid #000000; width: 20mm; text-align: center;"><strong>PRODUCT</strong></td>
									<td style="border-top: 2pt solid #000000; border-left: 2pt solid #000000; border-right: 2pt solid #000000; width: 8mm; text-align: center;"><strong>CURR</strong></td>
									<td style="border-top: 2pt solid #000000; border-left: 2pt solid #000000; border-right: 2pt solid #000000; width: 20mm; text-align: center;"><strong>PRICE/UNIT</strong></td>
									<td style="border-top: 2pt solid #000000; border-left: 2pt solid #000000; border-right: 2pt solid #000000; width: 20mm; text-align: center;"><strong>TOTAL</strong></td>
									<td style="border-top: 2pt solid #000000; border-left: 2pt solid #000000; border-right: 2pt solid #000000; width: 20mm; text-align: center;"><strong>NATURE OF LOSS</strong></td>
									<td style="border-top: 2pt solid #000000; border-left: 2pt solid #000000; border-right: 2pt solid #000000; width: 20mm; text-align: center;"><strong>LOCATION</strong></td>
									<td style="border-top: 2pt solid #000000; border-left: 2pt solid #000000; border-right: 2pt solid #000000; width: 20mm; text-align: center;"><strong>PHOTO</strong></td>
									<td style="border-top: 2pt solid #000000; border-left: 2pt solid #000000; border-right: 2pt solid #000000; width: 20mm; text-align: center;"><strong>REMARKS</strong></td>
									{{-- <td style="border-top: 2pt solid #000000; border-left: 2pt solid #000000; border-right: 2pt solid #000000; width: 20mm; text-align: center;"><strong>CLAIM REPORT</strong></td> --}}
									{{-- <td style="border-top: 2pt solid #000000; border-left: 2pt solid #000000; border-right: 2pt solid #000000; width: 20mm; text-align: center;"><strong>CLAIM FILE</strong></td> --}}
									{{-- <td style="border-top: 2pt solid #000000; border-left: 2pt solid #000000; border-right: 2pt solid #000000; width: 20mm; text-align: center;"><strong>POLIS</strong></td> --}}
									{{-- <td style="border-top: 2pt solid #000000; border-left: 2pt solid #000000; border-right: 2pt solid #000000; width: 20mm; text-align: center;"><strong>PAYMENT MSIG</strong></td> --}}
									{{-- <td style="border-top: 2pt solid #000000; border-left: 2pt solid #000000; border-right: 2pt solid #000000; width: 20mm; text-align: center;"><strong>SALVEGE DATE</strong></td> --}}
									{{-- <td style="border-top: 2pt solid #000000; border-left: 2pt solid #000000; border-right: 2pt solid #000000; width: 20mm; text-align: center;"><strong>DATE PICKING</strong></td> --}}
									{{-- <td style="border-top: 2pt solid #000000; border-left: 2pt solid #000000; border-right: 2pt solid #000000; width: 20mm; text-align: center;"><strong>REMARKS</strong></td> --}}
								</tr>

								<?php
								$totalUnit = 0;
								$totalPrice = 0;
								$no = 1;
								?>
								@if(!empty($claimInsuranceDetail))
								@foreach ($claimInsuranceDetail as $k => $v)
								<tr>
									<td style="border: 1pt solid #000000; text-align: center;">{{$no}}</td>
									<td style="border: 1pt solid #000000; text-align: center;">{{$v->serial_number}}</td>
									<td style="border: 1pt solid #000000; text-align: center;">{{$v->qty}}</td>
									<td style="border: 1pt solid #000000; text-align: center;">{{$v->model_name}}</td>
									<td style="border: 1pt solid #000000; text-align: center;">IDR</td>
									<td style="border: 1pt solid #000000; text-align: right;">{{money_currency($v->price)}}</td>
									<td style="border: 1pt solid #000000; text-align: right;">{{money_currency($v->qty*$v->price)}}</td>
									<td style="border: 1pt solid #000000; text-align: left;">{{$v->description}}</td>
									<td style="border: 1pt solid #000000; text-align: left;">{{$v->location}}</td>
									<td style="border: 1pt solid #000000; text-align: center;">{!!!empty($v->photo_url)?'<img class="materialboxed center-align" width="200" height="200" src="'.asset('storage/').'/'.$v->photo_url.'">':'-'!!}</td>
									<td style="border: 1pt solid #000000; text-align: left;">{{$v->keterangan}}</td>
									{{-- <td style="border: 1pt solid #000000; text-align: left;"></td> --}}
									{{-- <td style="border: 1pt solid #000000; text-align: left;"></td> --}}
									{{-- <td style="border: 1pt solid #000000; text-align: left;"></td> --}}
									{{-- <td style="border: 1pt solid #000000; text-align: left;"></td> --}}
									{{-- <td style="border: 1pt solid #000000; text-align: left;"></td> --}}
									{{-- <td style="border: 1pt solid #000000; text-align: left;">{{date('d M Y', strtotime($v->created_at))}}
						</td> --}}
						{{-- <td style="border: 1pt solid #000000; text-align: left;"></td> --}}
					</tr>
					<?php
					$totalUnit += $v->qty;
					$totalPrice += ($v->qty * $v->price);
					$no++;
					?>
					@endforeach
					@endif

					<tr>
						<td colspan="2" style="border: 1pt solid #000000; text-align: center;"><strong>Total</strong></td>
						<td style="border: 1pt solid #000000; text-align: center;"><strong>{{$totalUnit}}</strong></td>
						<td colspan="1" style="border: 1pt solid #000000; text-align: center;">&nbsp;</td>
						<td colspan="1" style="border: 1pt solid #000000; text-align: center;">&nbsp;</td>
						<td colspan="1" style="border: 1pt solid #000000; text-align: center;">&nbsp;</td>
						<td style="border: 1pt solid #000000; text-align: right;"><strong>{{money_currency($totalPrice)}}</strong></td>
						<td colspan="4" style="border: 1pt solid #000000; text-align: center;">&nbsp;</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	</td>
	</tr>
	</table>

	<footer>
	</footer>

</body>

</html>