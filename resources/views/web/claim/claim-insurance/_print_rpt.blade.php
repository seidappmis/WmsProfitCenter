<link rel="stylesheet" type="text/css" href="{{ url('materialize/css/custom/print.css') }}">


<table width="100%" style="font-size: 9pt; border-collapse: collapse;">
	<tr>
		<td>TO</td>
		<td colspan="3">: PT. ASURANSI MSIG INDONESIA</td>
		<td colspan="2" style=" text-align:right;">
			<span style="border-bottom:  1pt solid #000000; ">
				CLAIM REPORT NO : {{$claimInsurance->claim_report}}
			</span>
		</td>
	</tr>
	<tr>
		<td>FAX</td>
		<td colspan="5">: (021) 252-4084, 252-4083 (MARINE CLAIM SECTION)</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="6" style="text-align: center; border: 1px solid #000000"><strong>DATE OF REPORT : {{date('d F Y', strtotime($claimInsurance->created_at))}}</strong></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3" style="text-align: center; border: 2px solid #000000"><strong>1st REPORT (within 2 days)</strong></td>
		<td colspan="3">

		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="6" style="text-align: left; color: red;"><strong>IMPORTANT :</strong></td>
	</tr>
	<tr>
		<td colspan="6" style="text-align: left; color: red;">" Please fill in this 1st Report <u>within 2 days after the accident happened</u> and submit to HO and Insurance Company by e-mail"</td>
	</tr>
	<tr>
		<td colspan="2" style="border-left: 1pt solid #000000; border-top: 1pt solid #000000;"><strong>Branch</strong></td>
		<td colspan="4" style="border-right: 1pt solid #000000; border-top: 1pt solid #000000;"><strong>: {{$claimInsurance->branch}}</strong></td>
	<tr>
		<td colspan="2" style="border-left: 1pt solid #000000; border-top: 1pt solid #000000;"><strong>Date of Loss</strong></td>
		<td colspan="4" style="border-right: 1pt solid #000000; border-top: 1pt solid #000000;"></td>
	</tr>
	<tr>
		<td colspan="2" style="border-left: 1pt solid #000000;">(when the accident happened/found)</td>
		<td colspan="4" style="border-right: 1pt solid #000000;"><strong>: {{date('F Y', strtotime($claimInsurance->date_of_loss))}}</strong></td>
	</tr>
	<tr>
		<td colspan="2" style="border-left: 1pt solid #000000; border-top: 1pt solid #000000;"><strong>Damage Product</strong></td>
		<td colspan="4" style="border-right: 1pt solid #000000; border-top: 1pt solid #000000;">: Please fill up the attachment</td>
	</tr>
	<tr>
		<td colspan="2" style="border-left: 1pt solid #000000;">(product &amp; serial number)</td>
		<td colspan="4" style="border-right: 1pt solid #000000;">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2" style="border-left: 1pt solid #000000; border-top: 1pt solid #000000;"><strong>Place of Loss Found</strong></td>
		<td colspan="4" style="border-right: 1pt solid #000000; border-top: 1pt solid #000000;">: Please fill up the attachment</td>
	</tr>
	<tr>
		<td colspan="2" style="border-left: 1pt solid #000000;">(office/warehouse/dealer)/shop/transit)</td>
		<td colspan="4" style="border-right: 1pt solid #000000;">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2" style="border-left: 1pt solid #000000; border-top: 1pt solid #000000;"><strong>Route</strong></td>
		<td colspan="4" style="border-right: 1pt solid #000000; border-top: 1pt solid #000000;">&nbsp;</td>
	</tr>
	<tr>
		<td style="border-left: 1pt solid #000000; ">&nbsp;</td>
		<td colspan="5" style="border-right: 1pt solid #000000;"><strong>From</strong></td>
	</tr>
	<tr>
		<td style="border-left: 1pt solid #000000; ">&nbsp;</td>
		<td colspan="5" style="border-right: 1pt solid #000000;">(at the first time the product leave)</td>
	</tr>
	<tr>
		<td style="border-left: 1pt solid #000000; ">&nbsp;</td>
		<td colspan="5" style="border-right: 1pt solid #000000;"><strong>To</strong></td>
	</tr>
	<tr>
		<td style="border-left: 1pt solid #000000; ">&nbsp;</td>
		<td colspan="5" style="border-right: 1pt solid #000000;">(final destination)</td>
	</tr>
	<tr>
		<td colspan="3" style="border-top: 1pt solid #000000; border-left: 1pt solid #000000;"><strong>Nature of Loss</strong></td>
		<td colspan="3" style="border-top: 1pt solid #000000; border-right: 1pt solid #000000; color: blue;">: {{$nature_of_loss}}</td>
	</tr>
	<tr>
		<td colspan="6" style="border-bottom: 1pt solid #000000; border-left: 1pt solid #000000;border-right: 1pt solid #000000;">(choose the nature of loss or mention if the circumstance is other)</td>
	</tr>
	<tr>
		<td colspan="6" style="border-left: 1pt solid #000000; border-right: 1pt solid #000000;"><strong>Other Info (if any, such as : name of transportation coy &amp; driver)</strong></td>
	</tr>
	<tr>
		<td colspan="6" style="border-left: 1pt solid #000000;border-right: 1pt solid #000000; text-align: center; height: 50px;"><strong>{{$claimInsurance->keterangan_kejadian}}</strong></td>
	</tr>
	<tr>
		<td colspan="3" style="border-top: 1pt solid #000000; border-bottom: 1pt solid #000000; border-left: 1pt solid #000000;"><strong>Photograph</strong></td>
		<td colspan="3" style="border-top: 1pt solid #000000; border-bottom: 1pt solid #000000; border-right: 1pt solid #000000; color: blue;">please attach some picture to show the overall situation of the damage/loss</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td style="text-align:center;"><strong>Reported by</strong></td>
		<td colspan="2" style="text-align:right; padding-right:50px;"><strong>Acknowledged,</strong></td>
		<td style="text-align:center;"><strong>Acknowledged,</strong></td>
		<!--<td style="text-align:center;"><strong>Acknowledged</strong></td>-->
		<td style="text-align:center;"><strong>Acknowledged</strong></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td style="text-align:center;"><strong>(Hardian)</strong></td>
		<td style="text-align:center;"><strong>(Chairul Anwar) <br>Asst. Manager</strong></td>
		<td style="text-align:center;"><strong>(Firman) <br> SM. Logistik</strong></td>
		<td style="text-align:center;"><strong>(Denny A.R ) <br> GM. Prod. Planning</strong></td>
		<!--<td style="text-align:center;"><strong>( K. Tani ) <br> Acc GM</strong></td>-->
		<td style="text-align:center;"><strong>(Syaloom Labiro) <br> AGM. Acc &amp; Fin</strong></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3" style="text-align: center; border: 2px solid #000000"><strong>2nd REPORT (within a week)</strong></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="6" style="text-align: left; color: red;"><strong>IMPORTANT :</strong></td>
	</tr>
	<tr>
		<td colspan="6" style="text-align: left; color: red;font-size:8pt;">" These below supporting documents should be prepared and submitted to Insurance Company <u>within <strong>a week after the accident happened"</strong></u></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="6"><strong>SUPPORTING DOCUMENTS :</strong></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td style="text-align: center;"><input type="checkbox"> </td>
		<td scolspan="2" tyle="font-size: 9pt;"><strong>Delivery Order</strong> (Surat Jalan)</td>
		<td colspan="3" style="text-align: left; font-size: 9pt;"><strong>:</strong></td>
	</tr>
	<tr>
		<td style="text-align: center;"><input type="checkbox"> </td>
		<td scolspan="2" tyle="font-size: 9pt;"><strong>Return Form</strong> (Tanda Terima Barang Cacat)</td>
		<td colspan="3" style="text-align: left; font-size: 9pt;"><strong>:</strong></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="6" style="text-align: left;"><strong><i>In Head Office, please fill in the Declaration and Comment if any,</i></strong></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2" style="text-align: cemter;"><strong>Acknowledged,</strong></td>
		<td colspan="4" style="text-align: left;"><strong>Declaration for ( month/year) : ON {{date('M Y', strtotime($claimInsurance->date_of_loss))}}</strong></td>
	</tr>
	<tr>
		<td colspan="2" style="text-align: left;">&nbsp;</td>
		<td colspan="4" style="text-align: left;"><strong>Comment :</strong></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2" style="text-align: cemter;"><strong>(................................)</strong></td>
	</tr>
	<tr>
		<td colspan="2" style="text-align: cemter;"><strong>Authorized Person</strong></td>
	</tr>
</table>