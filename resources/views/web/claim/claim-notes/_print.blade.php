<html>

<head>
    <link rel="stylesheet" type="text/css" href="{{ url('materialize/css/custom/print1-hq.css') }}">
</head>

<body style="font-family: courier New; font-size: 8pt;">
    <table width="100%" style="font-family: Arial Narrow;border-collapse: collapse; font-size: 8pt;">
        {{-- Logo --}}
        <tr>
            <td colspan="35" style="border-left: 2pt solid #000000; border-top: 2pt solid #000000; border-right: 2pt solid #000000;">
                &nbsp; <img src="{{ $request->input('filetype') != 'xls' ?  url('images/sharp-logo-small.png') : 'images/sharp-logo-small.png' }}" alt="sharp-logo" style="width: 100px;">
            </td>
        </tr>
        {{-- Title --}}
        <tr>
            <td colspan="35" style="border-left: 2pt solid #000000; border-right: 2pt solid #000000; text-align: center; font-size: 18pt;"><strong>CLAIM LETTER</strong></td>
        </tr>
        <tr>
            <td colspan="35" style="border-left: 2pt solid #000000; border-right: 2pt solid #000000; text-align: center; font-size: 10pt;">(Transporter/ Outsourcing Logistics)</td>
        </tr>
        <tr>
            <td colspan="35" style="border-left: 2pt solid #000000; border-right: 2pt solid #000000;">&nbsp;</td>
        </tr>
        {{-- No --}}
        <tr>
            <td style="border-left: 2pt solid #000000; text-align: left; width: 5mm;"><strong>No :</strong></td>
            <td style="border-bottom: 1px solid #000000;"></td>
            <td colspan="11" style="text-align: center; border-bottom: 1px solid #000000;">{{$claimNote->claim_note_no}}</td>
            <td colspan="22" style="border-right: 2pt solid #000000">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="3" style="border-left: 2pt solid #000000; text-align: left; width: 20mm;"><strong>Issued by :</strong></td>
            <td colspan="10" style="text-align: center; border-bottom: 1px solid #000000; width: 50mm;"><strong>LOGISTICS</strong></td>
            <td style="width: 7mm;">&nbsp;</td>
            <td colspan="3" style="text-align: left; width: 20mm;"><strong>Division :</strong></td>
            <td colspan="6" style="text-align: left; border-bottom: 1px solid #000000;"><strong>LOGISTICS</strong></td>
            <td colspan="5">&nbsp;</td>
            <td colspan="2" style="text-align: left;"><strong>Date:</strong></td>
            <td colspan="4" style="text-align: center; border-bottom: 1px solid #000000; width: 18mm;"><strong>{{date('d-M-Y',strtotime($claimNote->created_at))}}</strong></td>
            <td style="border-right: 2pt solid #000000; width: 5mm;">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="35" style="height: 10px; border-left: 2pt solid #000000; border-right: 2pt solid #000000;"></td>
        </tr>
        {{-- Table --}}
        <tr>
            <td colspan="14" style="border-top: 2pt solid #000000; border-bottom: 2pt solid #000000; border-left: 2pt solid #000000;"><strong>Plan No :</strong></td>
            <td colspan="7" style="border-top: 2pt solid #000000; border-bottom: 2pt solid #000000; border-left: 1pt solid #000000;"><strong>Part Code :</strong></td>
            <td colspan="7" style="border-top: 2pt solid #000000; border-bottom: 2pt solid #000000; border-left: 1pt solid #000000;"><strong>Part Name :</strong></td>
            <td colspan="7" style="border-top: 2pt solid #000000; border-bottom: 2pt solid #000000; border-left: 1pt solid #000000; border-right: 2pt solid #000000;"><strong>Mould Name :</strong></td>
        </tr>
        {{-- Body --}}
        <tr>
            <td style="border-left: 2px solid #000000; border-right: 1px solid #000000;" colspan="14">&nbsp;</td>
            <td style="border-right: 2px solid #000000;" colspan="21"></td>
        </tr>
        <tr>
            <td style="border-left: 2px solid #000000; border-right: 1px solid #000000;" colspan="14">Reason :</td>
            <td style="border-right: 2px solid #000000;" colspan="21">Claim Amount :</td>
        </tr>
       {{number_format($claimNote->sub_total, 2, ',', '.')}} <tr>
            <td style="border-left: 2px solid #000000;"></td>
            <td colspan="13" style="width: 7mm; border-right: 1px solid #000000;"><strong>Claim Carton Box : {{$claimNote->claim=='carton-box'?$claimNote->sum_qty.' Unit':''}}</strong></td>
            <td colspan="21" style="width: 7mm; border-right: 2px solid #000000;"></td>
        </tr>
        <tr>
            <td style="border-left: 2px solid #000000;"></td>
            <td style="width: 5mm;"><input type="checkbox" /></td>
            <td colspan="12" style="border-right: 1px solid #000000;">Wet Carton Box</td>

            <!-- RIGHT SIDE -->
            <td>&#9312;</td>
            <td colspan="12">Material Cost Amount</td>
            <td>=</td>
            <td colspan="6" style="text-align: right;">{{number_format($claimNote->sub_total, 2, ',', '.')}}</td>
            <td style="border-right: 2px solid #000000;"></td>
            <!-- END RIGHT SIDE -->
        </tr>
        <tr>
            <td style="border-left: 2px solid #000000; border-right: 1px solid #000000;" colspan="14">&nbsp;</td>
            <td style="border-right: 2px solid #000000;" colspan="21"></td>
        </tr>
        <tr>
            <td style="border-left: 2px solid #000000;"></td>
            <td style="width: 5mm;"><input type="checkbox" /></td>
            <td colspan="12" style="border-right: 1px solid #000000;">Damage Carton Box</td>

             <!-- RIGHT SIDE -->
            <td>&#9313;</td>
            <td colspan="12">F/G Sales Price Amount</td>
            <td>=</td>
            <td colspan="6" style="text-align: right;"></td>
            <td style="border-right: 2px solid #000000;"></td>
            <!-- END RIGHT SIDE -->
        </tr>
        <tr>
            <td style="border-left: 2px solid #000000; border-right: 1px solid #000000;" colspan="14">&nbsp;</td>
            <td style="border-right: 2px solid #000000;" colspan="21"></td>
        </tr>
        <tr>
            <td style="border-left: 2px solid #000000;"></td>
            <td colspan="12" style=""><strong>Claim Unit : {{$claimNote->claim=='unit'?$claimNote->sum_qty.' Unit':''}}</strong></td>
            <td colspan="" style="width: 7mm; border-right: 1px solid #000000;"></td>

             <!-- RIGHT SIDE -->
            <td>&#9314;</td>
            <td colspan="12">Man Power Cost</td>
            <td>=</td>
            <td colspan="6" style="text-align: right;"></td>
            <td style="border-right: 2px solid #000000;"></td>
            <!-- END RIGHT SIDE -->
        </tr>
        <tr>
            <td style="border-left: 2px solid #000000;"></td>
            <td style="width: 5mm;"><input type="checkbox" /></td>
            <td colspan="12" style="border-right: 1px solid #000000;">Unit of F/G Damaged</td>

            <!-- RIGHT SIDE -->
            <td style="border-right: 2px solid #000000;" colspan="21"></td>
            <!-- END RIGHT SIDE -->
        </tr>
        <tr>
            <td style="border-left: 2px solid #000000; border-right: 1px solid #000000;" colspan="14">&nbsp;</td>

            <!-- RIGHT SIDE -->
            <td>&#9315;</td>
            <td colspan="12">Other Cost</td>
            <td>=</td>
            <td colspan="6" style="text-align: right; border-bottom: 1px solid #000000;"></td>
            <td style="border-right: 2px solid #000000;">+</td>
            <!-- END RIGHT SIDE -->
        </tr>
        <tr>
            <td style="border-left: 2px solid #000000;"></td>
            <td style="width: 5mm;"><input type="checkbox" /></td>
            <td colspan="12" style="border-right: 1px solid #000000;">Unit of F/G Scratched</td>

            <!-- RIGHT SIDE -->
            <td style="border-right: 2px solid #000000;" colspan="21"></td>
            <!-- END RIGHT SIDE -->
        </tr>
        <tr>
            <td style="border-left: 2px solid #000000; border-right: 1px solid #000000;" colspan="14">&nbsp;</td>

            <!-- RIGHT SIDE -->
            <td>&#9316;</td>
            <td colspan="12">Claim Cost (&#9312; + &#9313; + &#9314; + &#9315;)</td>
            <td>=</td>
            <td colspan="6" style="text-align: right;"></td>
            <td style="border-right: 2px solid #000000;"></td>
            <!-- END RIGHT SIDE -->
        </tr>
        <tr>
            <td style="border-left: 2px solid #000000;"></td>
            <td style="width: 5mm;"><input type="checkbox" /></td>
            <td colspan="12" style="border-right: 1px solid #000000;">Unit of F/G Dented</td>

            <!-- RIGHT SIDE -->
            <td style="border-right: 2px solid #000000;" colspan="21"></td>
            <!-- END RIGHT SIDE -->
        </tr>
        <tr>
            <td style="border-left: 2px solid #000000; border-right: 1px solid #000000;" colspan="14">&nbsp;</td>
            <td style="border-right: 2px solid #000000;" colspan="21"></td>
        </tr>
        <tr>
            <td style="border-left: 2px solid #000000;"></td>
            <td style="width: 5mm;"><input type="checkbox" /></td>
            <td colspan="12" style="border-right: 1px solid #000000;">Unit of F/G Broken</td>

            <!-- RIGHT SIDE -->
            <td style="border-right: 2px solid #000000;" colspan="21"></td>
            <!-- END RIGHT SIDE -->
        </tr>
        <tr>
            <td style="border-left: 2px solid #000000; border-right: 1px solid #000000;" colspan="14">&nbsp;</td>
            <td style="border-right: 2px solid #000000;" colspan="21"></td>
        </tr>
        <tr>
            <td style="border-left: 2px solid #000000;"></td>
            <td style="border-right: 1px solid #000000;" colspan="13">Remarks :</td>
            <td style="border-right: 2px solid #000000;" colspan="21"></td>
        </tr>
        <tr>
            <td style="border-left: 2px solid #000000; border-right: 1px solid #000000;" colspan="14">&nbsp;</td>
            <td style="border-right: 2px solid #000000;" colspan="21"></td>
        </tr>
        <tr>
            <td style="border-left: 2px solid #000000; border-right: 1px solid #000000;" colspan="14">&nbsp;</td>
            <td style="border-right: 2px solid #000000;" colspan="21"></td>
        </tr>
        <tr>
            <td style="border-left: 2px solid #000000; border-right: 1px solid #000000;" colspan="14">&nbsp;</td>
            <td style="border-right: 2px solid #000000;" colspan="21"></td>
        </tr>
        <tr>
            <td style="border-left: 2px solid #000000; border-right: 1px solid #000000;" colspan="14">&nbsp;</td>
            <td style="border-right: 2px solid #000000;" colspan="21"></td>
        </tr>
        <tr>
            <td style="border-left: 2px solid #000000; border-right: 1px solid #000000; border-bottom: 2px solid #000000;" colspan="14">&nbsp;</td>
            <td style="border-right: 2px solid #000000; border-bottom: 2px solid #000000;" colspan="21">Note: Prices are subject to change without prior notice.</td>
        </tr>
        <!-- END BODY -->
        <tr>
            <td colspan="5" style="border-left: 2pt solid #000000; border-bottom: 2pt solid #000000;">
            	<strong>Total Claim Amount</strong>
            </td>
            <td style="border-bottom: 2pt solid #0000{{number_format($claimNote->sub_total, 2, ',', '.')}}00;">
            	<input type="checkbox" name="">
            </td>
            <td style="border-bottom: 2pt solid #000000;">
            	IDR
            </td>
            <td style="border-bottom: 2pt solid #000000;">
            	<input type="checkbox" name="">
            </td>
            <td style="border-bottom: 2pt solid #000000;">
            	USD
            </td>
            <td style="border-bottom: 2pt solid #000000;">
            	<input type="checkbox" name="">
            </td>
            <td style="border-bottom: 2pt solid #000000;">
            	JPY
            </td>
            <td style="border-bottom: 2pt solid #000000;"></td>
            <td style="border-bottom: 2pt solid #000000; border-right: 2px solid #000000;" colspan="23"><strong>Others :</strong></td>
        </tr>

        <tr>
            <td colspan="35" style="border-left: 2pt solid #000000; border-right: 2pt solid #000000;"><strong>Logistic Dept. Opinion :</strong></td>
        </tr>
        <tr>
            <td colspan="35" style="border-left: 2pt solid #000000; border-right: 2pt solid #000000;">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="20" style="border-left: 2pt solid #000000;">&nbsp;</td>
            <td rowspan="2" colspan="3" style="border: 1pt solid #000000; text-align: center;">Div. Head <br>(Japanese)</td>
            <td rowspan="2" colspan="3" style="border: 1pt solid #000000; text-align: center;">Div. Head <br>(Local)</td>
            <td rowspan="2" colspan="3" style="border: 1pt solid #000000; text-align: center;">Dept Head</td>
            <td rowspan="2" colspan="6" style="border: 1pt solid #000000; border-right: 2px solid #000000; text-align: center;">PIC</td>
        </tr>
        <tr>
            <td colspan="20" style="border-left: 2pt solid #000000;">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="20" style="border-left: 2pt solid #000000;">&nbsp;</td>
            <td colspan="3" style="border-left: 1pt solid #000000; text-align: center;">&nbsp;</td>
            <td colspan="3" style="border-left: 1pt solid #000000; text-align: center;">&nbsp;</td>
            <td colspan="3" style="border-left: 1pt solid #000000; text-align: center;">&nbsp;</td>
            <td colspan="3" style="border-left: 1pt solid #000000; text-align: center;">&nbsp;</td>
            <td colspan="3" style="border-left: 1pt solid #000000; border-right: 2px solid #000000; text-align: center;">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="20" style="border-left: 2pt solid #000000;">&nbsp;</td>
            <td colspan="3" style="border-left: 1pt solid #000000; text-align: center;">&nbsp;</td>
            <td colspan="3" style="border-left: 1pt solid #000000; text-align: center;">&nbsp;</td>
            <td colspan="3" style="border-left: 1pt solid #000000; text-align: center;">&nbsp;</td>
            <td colspan="3" style="border-left: 1pt solid #000000; text-align: center;">&nbsp;</td>
            <td colspan="3" style="border-left: 1pt solid #000000; border-right: 2px solid #000000; text-align: center;">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="20" style="border-left: 2pt solid #000000;">&nbsp;</td>
            <td colspan="3" style="border-left: 1pt solid #000000; text-align: center;">&nbsp;</td>
            <td colspan="3" style="border-left: 1pt solid #000000; text-align: center;">&nbsp;</td>
            <td colspan="3" style="border-left: 1pt solid #000000; text-align: center;">&nbsp;</td>
            <td colspan="3" style="border-left: 1pt solid #000000; text-align: center;">&nbsp;</td>
            <td colspan="3" style="border-left: 1pt solid #000000; border-right: 2px solid #000000; text-align: center;">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="20" style="border-left: 2pt solid #000000;">&nbsp;</td>
            <td colspan="3" style="border-left: 1pt solid #000000; border-bottom: 1px solid #000000; text-align: center; width: 18mm;">&nbsp;</td>
            <td colspan="3" style="border-left: 1pt solid #000000; border-bottom: 1px solid #000000; text-align: center; width: 18mm;">Denny A</td>
            <td colspan="3" style="border-left: 1pt solid #000000; border-bottom: 1px solid #000000; text-align: center; width: 18mm;">Firman</td>
            <td colspan="3" style="border-left: 1pt solid #000000; border-bottom: 1px solid #000000; text-align: center; width: 18mm;">Tomi S</td>
            <td colspan="3" style="border-left: 1pt solid #000000; border-bottom: 1px solid #000000; border-right: 2px solid #000000; text-align: center; width: 18mm;">Hardian</td>
        </tr>
        <tr>
            <td colspan="35" style="border-left: 2pt solid #000000; border-right: 2pt solid #000000; border-bottom: 2pt solid #000000; height: 5px;"></td>
        </tr>
        <!-- END SEPARATOR -->
        <tr>
            <td colspan="35" style="border-left: 2pt solid #000000; border-right: 2pt solid #000000; border-bottom: 2pt solid #000000; height: 5px;"></td>
        </tr>
        <!-- END SEPARATOR -->

        <tr>
            <td colspan="5" style="border-left: 2pt solid #000000;"><strong>Company Name : </strong></td>
            <td colspan="14" style=""><strong>{{$claimNote->expedition_name}}</strong></td>
            <td colspan="16" style="border-right: 2pt solid #000000;"><strong>Supplier Code : {{$claimNote->expedition_code}}</strong></td>
        </tr>
        <tr>
            <td colspan="35" style="border-left: 2pt solid #000000; border-right: 2pt solid #000000;"><strong>Opinion : </strong></td>
        </tr>
        <tr>
            <td colspan="31" style="border-left: 2pt solid #000000;">&nbsp;</td>
            <td colspan="4" rowspan="2" style="border: 1pt solid #000000; border-right: 2px solid #000000; text-align: center;"><strong>PIC</strong></td>
        </tr>
        <tr>
            <td colspan="31" style="border-left: 2pt solid #000000;">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="31" style="border-left: 2pt solid #000000;">&nbsp;</td>
            <td colspan="4" style="border-left: 1pt solid #000000; border-right: 2px solid #000000; text-align: center;"><strong></strong></td>
        </tr>
        <tr>
            <td colspan="31" style="border-left: 2pt solid #000000;">&nbsp;</td>
            <td colspan="4" style="border-left: 1pt solid #000000; border-right: 2px solid #000000; text-align: center;"><strong></strong></td>
        </tr>
        <tr>
            <td colspan="31" style="border-left: 2pt solid #000000;">&nbsp;</td>
            <td colspan="4" style="border-left: 1pt solid #000000; border-right: 2px solid #000000; text-align: center;"><strong></strong></td>
        </tr>
        <tr>
            <td colspan="5" style="border-left: 2pt solid #000000;">Payment Method ( √ ) :</td>
            <td></td>
            <td colspan="6">Transfer</td>
            <td></td>
            <td colspan="5">Deduct Payment</td>
            <td colspan="6">Claim Amount (IDR, JPY, USD) : </td>
            <td colspan="1" style="border-bottom: 1px solid #000000;"></td>
            <td colspan="5" style="border-bottom: 1px solid #000000;">{{number_format($claimNote->sub_total, 2, ',', '.')}}</td>
            <td style="width: 5mm;"></td>
            <td colspan="4" style="border-left: 1pt solid #000000; border-bottom: 1px solid #000000; border-right: 2px solid #000000; text-align: center;"><strong></strong></td>
        </tr>
        <tr>
            <td colspan="35" style="border-left: 2pt solid #000000; border-right: 2pt solid #000000; border-bottom: 2pt solid #000000; height: 5px;"></td>
        </tr>

        <!-- SEPARATOR -->
        <tr>
            <td colspan="35" style="border-left: 2pt solid #000000; border-right: 2pt solid #000000; border-bottom: 2pt solid #000000; height: 5px;"></td>
        </tr>
        <!-- END SEPARATOR -->

        <tr>
            <td colspan="35" style="border-left: 2pt solid #000000; border-right: 2pt solid #000000;"><strong>Accounting Dept. Opinion :</strong></td>
        </tr>
        <tr>
            <td colspan="26" style="border-left: 2pt solid #000000;">&nbsp;</td>
            <td colspan="3" rowspan="2" style="border-left: 1pt solid #000000; border-top: 1px solid #000000; border-bottom: 1px solid #000000; text-align: center;">Div. Head <br>(Japanese)</td>
            <td colspan="3" rowspan="2" style="border-left: 1pt solid #000000; border-top: 1px solid #000000; border-bottom: 1px solid #000000; text-align: center;">Dept. Head</td>
            <td colspan="3" rowspan="2" style="border-left: 1pt solid #000000; border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 2pt solid #000000; text-align: center;">PIC</td>
        </tr>
        <tr>
            <td colspan="26" style="border-left: 2pt solid #000000;">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="26" style="border-left: 2pt solid #000000;">&nbsp;</td>
            <td colspan="3" style="border-left: 1pt solid #000000;"></td>
            <td colspan="3" style="border-left: 1pt solid #000000;"></td>
            <td colspan="3" style="border-left: 1pt solid #000000; border-right: 2pt solid #000000;"></td>
        </tr>
        <tr>
            <td colspan="26" style="border-left: 2pt solid #000000;">&nbsp;</td>
            <td colspan="3" style="border-left: 1pt solid #000000;"></td>
            <td colspan="3" style="border-left: 1pt solid #000000;"></td>
            <td colspan="3" style="border-left: 1pt solid #000000; border-right: 2pt solid #000000;"></td>
        </tr>
        <tr>
            <td colspan="26" style="border-left: 2pt solid #000000;">&nbsp;</td>
            <td colspan="3" style="border-left: 1pt solid #000000;"></td>
            <td colspan="3" style="border-left: 1pt solid #000000;"></td>
            <td colspan="3" style="border-left: 1pt solid #000000; border-right: 2pt solid #000000;"></td>
        </tr>
        <tr>
            <td colspan="26" style="border-left: 2pt solid #000000;">&nbsp;</td>
            <td colspan="3" style="border-left: 1pt solid #000000; border-bottom: 1px solid #000000; text-align: center;">K. Tani</td>
            <td colspan="3" style="border-left: 1pt solid #000000; border-bottom: 1px solid #000000; text-align: center;">Syaalom</td>
            <td colspan="3" style="border-left: 1pt solid #000000; border-bottom: 1px solid #000000; border-right: 2pt solid #000000; text-align: center;"></td>
        </tr>
        <tr>
            <td colspan="35" style="border-left: 2pt solid #000000; border-right: 2pt solid #000000; border-bottom: 2pt solid #000000; height: 5px;"></td>
        </tr>

        <tr>
            <td colspan="35" style="border-left: 2pt solid #000000; border-right: 2pt solid #000000;"><strong>Management Opinion:</strong></td>
        </tr>
        <tr>
            <td colspan="26" style="border-left: 2pt solid #000000;">&nbsp;</td>
            <td colspan="3" rowspan="2" style="border-left: 1pt solid #000000; border-top: 1px solid #000000; border-bottom: 1px solid #000000; text-align: center;">President<br>Director</td>
            <td colspan="3" rowspan="2" style="border-left: 1pt solid #000000; border-top: 1px solid #000000; border-bottom: 1px solid #000000; text-align: center;">Vice <br>President</td>
            <td colspan="3" rowspan="2" style="border-left: 1pt solid #000000; border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 2pt solid #000000; text-align: center;">Finance Director</td>
        </tr>
        <tr>
            <td colspan="26" style="border-left: 2pt solid #000000;">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="26" style="border-left: 2pt solid #000000;">&nbsp;</td>
            <td colspan="3" style="border-left: 1pt solid #000000;"></td>
            <td colspan="3" style="border-left: 1pt solid #000000;"></td>
            <td colspan="3" style="border-left: 1pt solid #000000; border-right: 2pt solid #000000;"></td>
        </tr>
        <tr>
            <td colspan="26" style="border-left: 2pt solid #000000;">&nbsp;</td>
            <td colspan="3" style="border-left: 1pt solid #000000;"></td>
            <td colspan="3" style="border-left: 1pt solid #000000;"></td>
            <td colspan="3" style="border-left: 1pt solid #000000; border-right: 2pt solid #000000;"></td>
        </tr>
        <tr>
            <td colspan="26" style="border-left: 2pt solid #000000;">&nbsp;</td>
            <td colspan="3" style="border-left: 1pt solid #000000;"></td>
            <td colspan="3" style="border-left: 1pt solid #000000;"></td>
            <td colspan="3" style="border-left: 1pt solid #000000; border-right: 2pt solid #000000;"></td>
        </tr>
        <tr>
            <td colspan="26" style="border-left: 2pt solid #000000;">&nbsp;</td>
            <td colspan="3" style="border-left: 1pt solid #000000; border-bottom: 1px solid #000000; text-align: center;">Mr Teraoka</td>
            <td colspan="3" style="border-left: 1pt solid #000000; border-bottom: 1px solid #000000; text-align: center;"></td>
            <td colspan="3" style="border-left: 1pt solid #000000; border-bottom: 1px solid #000000; border-right: 2pt solid #000000; text-align: center;">Yagura</td>
        </tr>
        <tr>
            <td colspan="35" style="border-left: 2pt solid #000000; border-right: 2pt solid #000000; border-bottom: 2pt solid #000000; height: 5px;"></td>
        </tr>

        <tr>
            <td colspan="35" style="border-left: 2pt solid #000000; border-right: 2pt solid #000000; border-bottom: 2pt solid #000000;"><strong>Debit Note No :</strong></td>
        </tr>

        <tr>
        	<td colspan="29">Note : Harga diatas dapat berubah sewaktu-waktu tanpa pemberitahuan sebelumnya</td>
        	<td colspan="6" rowspan="2" style="border: 2px solid #000000; text-align: center;">QUALITY-FORM-003</td>
        </tr>
        <tr>
        	<td colspan="29">&nbsp;</td>
        </tr>

    </table>
</body>

</html>
