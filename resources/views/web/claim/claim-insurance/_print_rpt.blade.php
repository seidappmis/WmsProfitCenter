<link rel="stylesheet" type="text/css" href="{{ url('materialize/css/custom/print.css') }}">

<table style="font-family: Arial Narrow; border-style: double;">
	<tr>
		<td>
			<table style="width: 210.0003mm;">
				<tr>
					<td>
						<table width="100%" style="font-size: 9pt;">
							<tr><td>&nbsp;</td></tr>
							<tr>
								<td>&nbsp;</td>
								<td>TO</td>
								<td>:</td>
								<td>PT. ASURANSI MSIG INDONESIA</td>
								<td>CLAIM REPORT NO : {{$claimInsurance->claim_report}}</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>FAX</td>
								<td>:</td>
								<td>(021) 252-4084, 252-4083 (MARINE CLAIM SECTION)</td>
								<td>&nbsp;</td>
							</tr>
							<tr><td>&nbsp;</td></tr>
							<tr><td>&nbsp;</td></tr>
							<tr><td>&nbsp;</td></tr>
							<tr><td>&nbsp;</td></tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table width="100%" style="font-size: 12pt; border-collapse: collapse;">
							<tr>
								<td>&nbsp;</td>
								<td colspan="12" style="text-align: center; border: 1px solid #000000"><strong>DATE OF REPORT : {{date('d F Y', strtotime($claimInsurance->created_at))}}</strong></td>
								<td>&nbsp;</td>
							</tr>
							<tr><td>&nbsp;</td></tr>
							<tr>
								<td>&nbsp;</td>
								<td colspan="7" style="text-align: center; border: 2px solid #000000"><strong>1st REPORT (within 2 days)</strong></td>
								<td style="width: 20mm;">&nbsp;</td>
								<td style="width: 20mm;">&nbsp;</td>
								<td style="width: 20mm;">&nbsp;</td>
								<td style="width: 20mm;">&nbsp;</td>
								<td style="width: 20mm;">&nbsp;</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td colspan="2" style="text-align: left; color: red;"><strong>IMPORTANT :</strong></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td rowspan="2" colspan="8" style="text-align: left; color: red;">" Please fill in this 1st Report <u>within 2 days after the accident happened</u> and submit to HO and Insurance Company by e-mail"</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						{{-- Table --}}
						<table width="100%" style="font-size: 9pt; border-collapse: collapse;">
							<tr>
								<td>&nbsp;</td>
								<td style="border-top: 1pt solid #000000; border-bottom: 1pt solid #000000; border-left: 1pt solid #000000; width: 40mm;"><strong>Branch</strong></td>
								<td style="border-top: 1pt solid #000000; border-bottom: 1pt solid #000000; width: 40mm;">&nbsp;</td>
								<td style="border-top: 1pt solid #000000; border-bottom: 1pt solid #000000; width: 10mm;">&nbsp;</td>
								<td style="border-top: 1pt solid #000000; border-bottom: 1pt solid #000000;">&nbsp;</td>
								<td style="border-top: 1pt solid #000000; border-bottom: 1pt solid #000000; border-right: 1pt solid #000000;"><strong>: Wh Medan Des 2019</strong></td>
							<tr>
								<td>&nbsp;</td>
								<td style="border-top: 1pt solid #000000; border-left: 1pt solid #000000; width: 40mm;"><strong>Date of Loss</strong></td>
								<td style="border-top: 1pt solid #000000; width: 40mm;">&nbsp;</td>
								<td style="border-top: 1pt solid #000000; width: 10mm;">&nbsp;</td>
								<td style="border-top: 1pt solid #000000;">&nbsp;</td>
								<td style="border-top: 1pt solid #000000; border-right: 1pt solid #000000;"></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td style="border-bottom: 1pt solid #000000; border-left: 1pt solid #000000; width: 40mm;">(when the accident happened/found)</td>
								<td style="border-bottom: 1pt solid #000000; width: 40mm;">&nbsp;</td>
								<td style="border-bottom: 1pt solid #000000; width: 10mm;">&nbsp;</td>
								<td style="border-bottom: 1pt solid #000000;">&nbsp;</td>
								<td style="border-bottom: 1pt solid #000000; border-right: 1pt solid #000000; color: blue;"><strong>: {{date('F Y', strtotime($claimInsurance->created_at))}}</strong></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td style="border-top: 1pt solid #000000; border-left: 1pt solid #000000; width: 40mm;"><strong>Damage Product</strong></td>
								<td style="border-top: 1pt solid #000000; width: 40mm;">&nbsp;</td>
								<td style="border-top: 1pt solid #000000; width: 10mm;">&nbsp;</td>
								<td style="border-top: 1pt solid #000000;">&nbsp;</td>
								<td style="border-top: 1pt solid #000000; border-right: 1pt solid #000000; color: blue;">: Please fill up the attachment</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td style="border-bottom: 1pt solid #000000; border-left: 1pt solid #000000; width: 40mm;">(product & serial number)</td>
								<td style="border-bottom: 1pt solid #000000; width: 40mm;">&nbsp;</td>
								<td style="border-bottom: 1pt solid #000000; width: 10mm;">&nbsp;</td>
								<td style="border-bottom: 1pt solid #000000;">&nbsp;</td>
								<td style="border-bottom: 1pt solid #000000; border-right: 1pt solid #000000;">&nbsp;</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td style="border-top: 1pt solid #000000; border-left: 1pt solid #000000; width: 40mm;"><strong>Place of Loss Found</strong></td>
								<td style="border-top: 1pt solid #000000; width: 40mm;">&nbsp;</td>
								<td style="border-top: 1pt solid #000000; width: 10mm;">&nbsp;</td>
								<td style="border-top: 1pt solid #000000;">&nbsp;</td>
								<td style="border-top: 1pt solid #000000; border-right: 1pt solid #000000; color: blue;">: Please fill up the attachment</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td style="border-bottom: 1pt solid #000000; border-left: 1pt solid #000000; width: 40mm;">(office/warehouse/dealer)/shop/transit)</td>
								<td style="border-bottom: 1pt solid #000000; width: 40mm;">&nbsp;</td>
								<td style="border-bottom: 1pt solid #000000; width: 10mm;">&nbsp;</td>
								<td style="border-bottom: 1pt solid #000000;">&nbsp;</td>
								<td style="border-bottom: 1pt solid #000000; border-right: 1pt solid #000000;">&nbsp;</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td style="border-top: 1pt solid #000000; border-left: 1pt solid #000000; width: 40mm;"><strong>Route</strong></td>
								<td style="border-top: 1pt solid #000000; width: 40mm;">&nbsp;</td>
								<td style="border-top: 1pt solid #000000; width: 10mm;">&nbsp;</td>
								<td style="border-top: 1pt solid #000000;">&nbsp;</td>
								<td style="border-top: 1pt solid #000000; border-right: 1pt solid #000000;">&nbsp;</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td style="border-left: 1pt solid #000000; width: 40mm;">&nbsp;</td>
								<td style="width: 40mm;"><strong>From</strong></td>
								<td style="width: 10mm;">&nbsp;</td>
								<td style="">&nbsp;</td>
								<td style="border-right: 1pt solid #000000;">&nbsp;</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td style="border-left: 1pt solid #000000; width: 40mm;">&nbsp;</td>
								<td style="width: 40mm;">(at the first time the product leave)</td>
								<td style="width: 10mm;">&nbsp;</td>
								<td style="">&nbsp;</td>
								<td style="border-right: 1pt solid #000000;">&nbsp;</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td style="border-left: 1pt solid #000000; width: 40mm;">&nbsp;</td>
								<td style="width: 40mm;"><strong>To</strong></td>
								<td style="width: 10mm;">&nbsp;</td>
								<td style="">&nbsp;</td>
								<td style="border-right: 1pt solid #000000;">&nbsp;</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td style="border-bottom: 1pt solid #000000; border-left: 1pt solid #000000; width: 40mm;">&nbsp;</td>
								<td style="border-bottom: 1pt solid #000000; width: 40mm;">(final destination)</td>
								<td style="border-bottom: 1pt solid #000000; width: 10mm;">&nbsp;</td>
								<td style="border-bottom: 1pt solid #000000;">&nbsp;</td>
								<td style="border-bottom: 1pt solid #000000; border-right: 1pt solid #000000;">&nbsp;</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td style="border-top: 1pt solid #000000; border-left: 1pt solid #000000; width: 40mm;"><strong>Nature of Loss</strong></td>
								<td style="border-top: 1pt solid #000000; width: 40mm;">&nbsp;</td>
								<td style="border-top: 1pt solid #000000; width: 10mm;">&nbsp;</td>
								<td style="border-top: 1pt solid #000000;">&nbsp;</td>
								<td style="border-top: 1pt solid #000000; border-right: 1pt solid #000000; color: blue;">: Broken/bend/dent/scratch/stolen/w et/carton box etc/ other / accident <strong>(Pilih)</strong></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td colspan="2" style="border-bottom: 1pt solid #000000; border-left: 1pt solid #000000; width: 40mm;">(choose the nature of loss or mention if the circumstance is other)</td>
								<td style="border-bottom: 1pt solid #000000; width: 10mm;">&nbsp;</td>
								<td style="border-bottom: 1pt solid #000000;">&nbsp;</td>
								<td style="border-bottom: 1pt solid #000000; border-right: 1pt solid #000000;">&nbsp;</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td colspan="2" style="border-top: 1pt solid #000000; border-left: 1pt solid #000000; width: 40mm;"><strong>Other Info (if any, such as : name of transportation coy & driver)</strong></td>
								<td style="border-top: 1pt solid #000000; width: 10mm;">&nbsp;</td>
								<td style="border-top: 1pt solid #000000;">&nbsp;</td>
								<td style="border-top: 1pt solid #000000; border-right: 1pt solid #000000;">&nbsp;</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td style="border-left: 1pt solid #000000; width: 40mm;">&nbsp;</td>
								<td style="width: 40mm;">&nbsp;</td>
								<td style="width: 10mm;">&nbsp;</td>
								<td style="">&nbsp;</td>
								<td style="border-right: 1pt solid #000000;">&nbsp;</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td style="border-left: 1pt solid #000000; width: 40mm;">&nbsp;</td>
								<td colspan="4" style="border-right: 1pt solid #000000; width: 40mm;"><strong>Unit Lost (Bajing Loncat) ( Input di "Keterangan kejadian" )</strong></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td style="border-bottom: 1pt solid #000000; border-left: 1pt solid #000000; width: 40mm;">&nbsp;</td>
								<td style="border-bottom: 1pt solid #000000; width: 40mm;">&nbsp;</td>
								<td style="border-bottom: 1pt solid #000000; width: 10mm;">&nbsp;</td>
								<td style="border-bottom: 1pt solid #000000;">&nbsp;</td>
								<td style="border-bottom: 1pt solid #000000; border-right: 1pt solid #000000;">&nbsp;</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td style="border-top: 1pt solid #000000; border-bottom: 1pt solid #000000; border-left: 1pt solid #000000; width: 40mm;"><strong>Photograph</strong></td>
								<td style="border-top: 1pt solid #000000; border-bottom: 1pt solid #000000; width: 40mm;">&nbsp;</td>
								<td style="border-top: 1pt solid #000000; border-bottom: 1pt solid #000000; width: 10mm;">&nbsp;</td>
								<td style="border-top: 1pt solid #000000; border-bottom: 1pt solid #000000;">&nbsp;</td>
								<td style="border-top: 1pt solid #000000; border-bottom: 1pt solid #000000; border-right: 1pt solid #000000; color: blue;">please attach some picture to show the overall situation of the damage/loss</td>
								<td>&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table width="100%" style="font-size: 8pt;">
							<tr><td>&nbsp;</td></tr>
							<tr>
								<td>&nbsp;</td>
								<td colspan="2" style="text-align: left; width: 50mm;"><strong>Reported by</strong></td>
				                <td colspan="2" style="text-align: center; width: 70mm;"><strong>Acknowledged,</strong></td>
				                <td colspan="3" style="text-align: center; width: 70mm;"><strong>Acknowledged,</strong></td>
				                <td colspan="3" style="text-align: center; width: 70mm;"><strong>Acknowledged</strong></td>
				                <td colspan="3" style="text-align: right; width: 70mm;"><strong>Acknowledged</strong></td>
				                <td>&nbsp;</td>
							</tr>
							<tr><td>&nbsp;</td></tr>
				            <tr><td>&nbsp;</td></tr>
				            <tr><td>&nbsp;</td></tr>
				            <tr>
								<td>&nbsp;</td>
								<td colspan="2" style="text-align: left; width: 50mm;"><strong>(Hardian)</strong></td>
								<td style="text-align: left; width: 20mm;"><strong>(Tomi S) <br> Manager</strong></td>
				                <td style="text-align: left; width: 35mm;"><strong>(Firman) <br> Manager</strong></td>
				                <td colspan="3" style="text-align: center; width: 70mm;"><strong>(Denny A.R ) <br> Logistic GM</strong></td>
				                <td colspan="3" style="text-align: center; width: 70mm;"><strong>( K. Tani ) <br> Acc GM</strong></td>
				                <td colspan="3" style="text-align: right; width: 70mm;"><strong>(Sayloom Labiro) <br> Sr.Mgr.Acc Tax & Fin</strong></td>
				                <td>&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table width="100%" style="font-size: 12pt; border-collapse: collapse;">
							<tr><td>&nbsp;</td></tr>
							<tr>
								<td>&nbsp;</td>
								<td colspan="7" style="text-align: center; border: 2px solid #000000"><strong>2nd REPORT (within a week)</strong></td>
								<td style="width: 20mm;">&nbsp;</td>
								<td style="width: 20mm;">&nbsp;</td>
								<td style="width: 20mm;">&nbsp;</td>
								<td style="width: 20mm;">&nbsp;</td>
								<td style="width: 20mm;">&nbsp;</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td colspan="2" style="text-align: left; color: red;"><strong>IMPORTANT :</strong></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td rowspan="2" colspan="8" style="text-align: left; color: red;">" These below supporting documents should be prepared and submitted to Insurance Company <u>within <strong>a week after the accident happened"</strong></u></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table width="100%">
							<tr><td>&nbsp;</td></tr>
							<tr>
								<td colspan="6"><strong>SUPPORTING DOCUMENTS :</strong></td>
							</tr>
							<tr><td>&nbsp;</td></tr>
							<tr>
								<td colspan="2" style="border: 1pt solid #000000; width: 20mm; font-size: 11pt;"></td>
								<td style="width: 10mm;">&nbsp;</td>
								<td style="font-size: 9pt;"><strong>Delivery Order</strong> (Surat Jalan)</td>
								<td style="width: 30mm;">&nbsp;</td>
								<td style="width: 5mm; font-size: 9pt;"><strong>:</strong></td>
								<td style="width: 80mm;">&nbsp;</td>
							</tr>
							<tr><td>&nbsp;</td></tr>
							<tr>
								<td colspan="2" style="border: 1pt solid #000000; width: 20mm; font-size: 11pt;"></td>
								<td style="width: 10mm;">&nbsp;</td>
								<td style="font-size: 9pt; width: 60mm;"><strong>Return Form</strong> (Tanda Terima Barang Cacat)</td>
								<td style="width: 30mm;">&nbsp;</td>
								<td style="width: 5mm; font-size: 9pt;"><strong>:</strong></td>
								<td style="width: 80mm;">&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table  width="100%" style="font-size: 9pt;">
							<tr><td>&nbsp;</td></tr>
							<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td colspan="5" style="text-align: left; width: 50mm;"><strong><i>In Head Office, please fill in the Declaration and Comment if any,</i></strong></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
				                <td colspan="2" style="text-align: left; width: 50mm;"><strong>Acknowledged,</strong></td>
				                <td colspan="2" style="text-align: center; width: 40mm;">&nbsp;</td>
				                <td colspan="5" style="text-align: center; width: 100mm;"><strong>Declaration for ( month/year) : ON Des 2019</strong></td>
				                <td colspan="3" style="text-align: center; width: 70mm;">&nbsp;</td>
				                <td colspan="3" style="text-align: right; width: 70mm;">&nbsp;</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
				                <td colspan="3" style="text-align: left; width: 50mm;">&nbsp;</td>
				                <td colspan="5" style="text-align: center; width: 100mm;"><strong>Comment :</strong></td>
				                <td colspan="3" style="text-align: center; width: 70mm;">&nbsp;</td>
				                <td colspan="3" style="text-align: right; width: 70mm;">&nbsp;</td>
							</tr>
							<tr><td>&nbsp;</td></tr>
            				<tr><td>&nbsp;</td></tr>
            				<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
				                <td colspan="2" style="text-align: left; width: 50mm;"><strong>(................................)</strong></td>
				                <td colspan="2" style="text-align: center; width: 40mm;">&nbsp;</td>
				                <td colspan="5" style="text-align: center; width: 100mm;">&nbsp;</td>
				                <td colspan="3" style="text-align: center; width: 70mm;">&nbsp;</td>
				                <td colspan="3" style="text-align: right; width: 70mm;">&nbsp;</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
				                <td colspan="2" style="text-align: left; width: 50mm;"><strong>Authorized Person</strong></td>
				                <td colspan="2" style="text-align: center; width: 40mm;">&nbsp;</td>
				                <td colspan="5" style="text-align: center; width: 100mm;">&nbsp;</td>
				                <td colspan="3" style="text-align: center; width: 70mm;">&nbsp;</td>
				                <td colspan="3" style="text-align: right; width: 70mm;">&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>