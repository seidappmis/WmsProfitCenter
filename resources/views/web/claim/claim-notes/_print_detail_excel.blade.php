<table>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="1" style="text-align: left;"><strong>{{ isset($claimNote) ? $claimNote->claim_note_no : '-' }}</strong></td>
		<td style="text-align: right;"><strong>{{money_reformat($subTotal,'IDR')}}</strong></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2">
			{{-- Main Table --}}
			<table>
				{{-- Table Head --}}
				<tr>
					<td style="border: 1pt solid #000000; ">Date</td>
					<td style="border: 1pt solid #000000; ">Ekspedisi</td>
					<td style="border: 1pt solid #000000; ">Driver</td>
					<td style="border: 1pt solid #000000; ">Plate Number</td>
					<td style="border: 1pt solid #000000; ">Destination</td>
					<td style="border: 1pt solid #000000; ">Delivery Order</td>
					<td style="border: 1pt solid #000000; ">Model</td>
					<td style="border: 1pt solid #000000; ">Serial Number</td>
					<td style="border: 1pt solid #000000; ">Qty</td>
					<td style="border: 1pt solid #000000;">Warehouse</td>
					<td style="border: 1pt solid #000000; ">Description</td>
					<td style="border: 1pt solid #000000;">Claim</td>
					<td style="border: 1pt solid #000000;">Price</td>
					<td style="border: 1pt solid #000000;">Total Price</td>
				</tr>
				{{-- Body Table --}}
				@if (!empty($claimNoteDetail))
				@foreach ($claimNoteDetail as $k=> $v)
				<tr>
					<td style="border: 1pt solid #000000;">{{!empty($v->date_of_receipt)?date('d-M-Y',strtotime($v->date_of_receipt)):'-'}}</td>
					<td style="border: 1pt solid #000000;"><strong>{{!empty($v->expedition_name)?$v->expedition_name:'-'}}</strong></td>
					<td style="border: 1pt solid #000000;">{{!empty($v->driver_name)?$v->driver_name:'-'}}</td>
					<td style="border: 1pt solid #000000;">{{!empty($v->vehicle_number)?$v->vehicle_number:'-'}}</td>
					<td style="border: 1pt solid #000000;">{{!empty($v->destination)?$v->destination:'-'}}</td>
					<td style="border: 1pt solid #000000;">{{!empty($v->do_no)?$v->do_no:'-'}}</td>
					<td style="border: 1pt solid #000000;">{{!empty($v->model_name)?$v->model_name:'-'}}</td>
					<td style="border: 1pt solid #000000;">{{!empty($v->serial_number)?$v->serial_number:'-'}}</td>
					<td style="border: 1pt solid #000000;text-align:center">{{!empty($v->qty)?$v->qty:0}}</td>
					<td style="border: 1pt solid #000000;">{{!empty($v->location)?$v->location:'-'}}</td>
					<td style="border: 1pt solid #000000;">{{!empty($v->description)?$v->description:'-'}}</td>
					<td style="border: 1pt solid #000000;">{{!empty($claimNote->claim)?$claimNote->claim:'-'}}</td>
					@php
					$price = $v->price;
					if ($claimNote->claim == 'unit') {
					$price = $price * 111 / 100;
					}
					@endphp
					<td style="border: 1pt solid #000000; text-align:right;">{{!empty($v->price)?money_reformat($price,'IDR'):0}}</td>
					<td style="border: 1pt solid #000000; text-align:right;">{{money_reformat($v->qty*$price,'IDR')}}</td>
				</tr>
				@endforeach
				@else
				<td colspan="14" style="border: 1pt solid #000000;">empty</td>
				@endif
			</table>
		</td>
	</tr>
</table>