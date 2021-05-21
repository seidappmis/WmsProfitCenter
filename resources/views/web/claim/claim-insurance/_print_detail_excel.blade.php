<table style="font-size: 8pt; border-collapse: collapse;">
   <tr>
      <td>&nbsp;</td>
   </tr>
   <tr>
      <td colspan="11" style="font-size: 12pt; text-align: center;"><strong>LOSS/DAMAGE PRODUCT LIST</strong></td>
   </tr>
   <tr>
      <td colspan="11" style="font-size: 12pt; text-align: center;"><strong>(Daftar Kerugian/Kerusakan Barang)</strong></td>
   </tr>
   <tr>
      <td colspan="7"></td>
      <td style="width: 19px;">&nbsp;</td>
      <td colspan="3" style="text-align: right;"><strong>DATE OF REPORT {{date('d M Y', strtotime($claimInsurance->insurance_date))}}</strong></td>
   </tr>
   <tr>
      <td colspan="7"></td>
      <td style="width: 19px;">&nbsp;</td>
      <td colspan="3" style="text-align: right;"><strong>{{$claimInsurance->branch}} {{date('M Y', strtotime($claimInsurance->date_of_loss))}}</strong></td>
   </tr>
   <tr>
      <td style="width: 19px;">&nbsp;</td>
      <td colspan="4" style="border-left: 1pt solid red;"><strong>1st Report</strong></td>
      <td colspan="4" style="border-left: 1pt solid red;"><strong>2nd Report</strong></td>
      <td style="width: 19px;">&nbsp;</td>
      <td style="width: 19px;">&nbsp;</td>
      <td colspan="7">
         <!-- <strong> : Wh Medan Des 2019</strong> -->
      </td>
   </tr>
   <tr>
      <td colspan="18" style="color: red;">Shall be reported to HO &amp; Insurance <u> within 2 days</u> after the accident Shall be reported to HO and Insurance within </td>
   </tr>
   <tr>
      <td colspan="18" style="color: red;"><u>within a week</u> after the accident happened</td>
   </tr>
   <tr>
      <td style="border-top: 2pt solid #000000; border-left: 2pt solid #000000; border-right: 2pt solid #000000; width: 19px; text-align: center;"><strong>NO</strong></td>
      <td style="border-top: 2pt solid #000000; border-left: 2pt solid #000000; border-right: 2pt solid #000000; width: 75px; text-align: center;"><strong>SERIAL NUMBER</strong></td>
      <td style="border-top: 2pt solid #000000; border-left: 2pt solid #000000; border-right: 2pt solid #000000; width: 39px; text-align: center;"><strong>UNIT</strong></td>
      <td style="border-top: 2pt solid #000000; border-left: 2pt solid #000000; border-right: 2pt solid #000000; width: 75px; text-align: center;"><strong>PRODUCT</strong></td>
      <td style="border-top: 2pt solid #000000; border-left: 2pt solid #000000; border-right: 2pt solid #000000; width: 30px; text-align: center;"><strong>CURR</strong></td>
      <td style="border-top: 2pt solid #000000; border-left: 2pt solid #000000; border-right: 2pt solid #000000; width: 75px; text-align: center;"><strong>PRICE/UNIT</strong></td>
      <td style="border-top: 2pt solid #000000; border-left: 2pt solid #000000; border-right: 2pt solid #000000; width: 75px; text-align: center;"><strong>TOTAL</strong></td>
      <td style="border-top: 2pt solid #000000; border-left: 2pt solid #000000; border-right: 2pt solid #000000; width: 75px; text-align: center;"><strong>NATURE OF LOSS</strong></td>
      <td style="border-top: 2pt solid #000000; border-left: 2pt solid #000000; border-right: 2pt solid #000000; width: 75px; text-align: center;"><strong>LOCATION</strong></td>
      <td style="border-top: 2pt solid #000000; border-left: 2pt solid #000000; border-right: 2pt solid #000000; width: 75px; text-align: center;"><strong>PHOTO</strong></td>
      <td style="border-top: 2pt solid #000000; border-left: 2pt solid #000000; border-right: 2pt solid #000000; width: 75px; text-align: center;"><strong>REMARKS</strong></td>
      {{-- <td style="border-top: 2pt solid #000000; border-left: 2pt solid #000000; border-right: 2pt solid #000000; width: 75px; text-align: center;"><strong>CLAIM REPORT</strong></td> --}}
      {{-- <td style="border-top: 2pt solid #000000; border-left: 2pt solid #000000; border-right: 2pt solid #000000; width: 75px; text-align: center;"><strong>CLAIM FILE</strong></td> --}}
      {{-- <td style="border-top: 2pt solid #000000; border-left: 2pt solid #000000; border-right: 2pt solid #000000; width: 75px; text-align: center;"><strong>POLIS</strong></td> --}}
      {{-- <td style="border-top: 2pt solid #000000; border-left: 2pt solid #000000; border-right: 2pt solid #000000; width: 75px; text-align: center;"><strong>PAYMENT MSIG</strong></td> --}}
      {{-- <td style="border-top: 2pt solid #000000; border-left: 2pt solid #000000; border-right: 2pt solid #000000; width: 75px; text-align: center;"><strong>SALVEGE DATE</strong></td> --}}
      {{-- <td style="border-top: 2pt solid #000000; border-left: 2pt solid #000000; border-right: 2pt solid #000000; width: 75px; text-align: center;"><strong>DATE PICKING</strong></td> --}}
      {{-- <td style="border-top: 2pt solid #000000; border-left: 2pt solid #000000; border-right: 2pt solid #000000; width: 75px; text-align: center;"><strong>REMARKS</strong></td> --}}
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
      <td style="border: 1pt solid #000000; text-align: center;">{{!empty($value->photo_url)?'<img src="public/storage/'. $value->photo_url.'" width="200px" alt="">':'-'}}</td>
      <td style="border: 1pt solid #000000; text-align: left;">{{$v->keterangan}}</td>
      {{-- <td style="border: 1pt solid #000000; text-align: left;"></td> --}}
      {{-- <td style="border: 1pt solid #000000; text-align: left;"></td> --}}
      {{-- <td style="border: 1pt solid #000000; text-align: left;"></td> --}}
      {{-- <td style="border: 1pt solid #000000; text-align: left;"></td> --}}
      {{-- <td style="border: 1pt solid #000000; text-align: left;"></td> --}}
      {{-- <td style="border: 1pt solid #000000; text-align: left;">{{date('d M Y', strtotime($v->created_at))}}</td> --}}
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