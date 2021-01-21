<link rel="stylesheet" type="text/css" href="{{ url('materialize/css/custom/print-lanscape.css') }}">
<table width="100%" style="border-collapse: collapse; width: 350mm;">
    <tr><td colspan="14">&nbsp;</td></tr>
    <tr>
        <td colspan="2" style="text-align: left; font-size: 12pt;"><strong>Tanggal</strong>
        </td>
        <td colspan="2" style="text-align: left; font-size: 12pt;"><strong>{{ format_tanggal_wms(date('Y-m-d')) }}</strong>
        </td>
        <td colspan="10" style="text-align: left; font-size: 12pt; width:200mm;"><strong>&nbsp;</strong>
        </td>

    </tr>
    <tr>
        <td colspan="14" style="text-align: left; font-size: 12pt">
        <strong>Diterima Dari Logistics PT. SHARP ELECTRONICS INDONESIA</strong>
        </td>
    </tr>
    <tr>
        <td colspan="14" style="text-align: left; font-size: 12pt;">&nbsp;
        </td>
    </tr>
    <tr>
        <td style="text-align: center; font-size: 10pt; border: 1pt solid black;">
            <strong>No.</strong>
        </td>
        <td colspan="2"
            style="text-align: center; font-size: 10pt; border: 1pt solid black;">
            <strong>Receipt ID</strong>
        </td>
        <td colspan="2"
            style="text-align: center; font-size: 10pt; border: 1pt solid black;">
            <strong>Receipt Number</strong>
        </td>
        <td style="text-align: center; font-size: 10pt; border: 1pt solid black;">
            <strong>Invoice Number</strong>
        </td>
        <td style="text-align: center; font-size: 10pt; border: 1pt solid black;">
            <strong>Receipt Date</strong>
        </td>
        <td colspan="2"
            style="text-align: center; font-size: 10pt; border: 1pt solid black;">
            <strong>Transporter</strong>
        </td>
        <td style="text-align: center; font-size: 10pt; border: 1pt solid black;">
            <strong>Amount</strong>
        </td>
        <td style="text-align: center; font-size: 10pt; border: 1pt solid black;">
            <strong>PPN(10%)</strong>
        </td>
        <td style="text-align: center; font-size: 10pt; border: 1pt solid black;">
            <strong>PPH</strong>
        </td>
        <td style="text-align: center; font-size: 10pt; border: 1pt solid black;">
            <strong>Total Amount</strong>
        </td>
        <td style="text-align: center; font-size: 10pt; border: 1pt solid black;">
            <strong>PR</strong>
        </td>
    </tr>
    @php
        $total_amount_before_tax = 0;
        $total_amount_ppn = 0;
        $total_amount_pph = 0;
        $total_amount_after_tax = 0;
    @endphp
    @foreach($receipts AS $key =>$value)
    @php
        $total_amount_before_tax += $value->amount_before_tax;
        $total_amount_ppn += $value->amount_ppn;
        $total_amount_pph += $value->amount_pph;
        $total_amount_after_tax += $value->amount_after_tax;
    @endphp
    <tr>
        <td style="text-align: center; font-size: 10pt; border: 1pt solid black;">{{ $key + 1 }}.</td>
        <td colspan="2" style="text-align: center; font-size: 10pt; border: 1pt solid black;">{{ $value->invoice_receipt_id }}</td>
        <td colspan="2" style="text-align: center; font-size: 10pt; border: 1pt solid black;">{{ $value->invoice_receipt_no }}</td>
        <td style="text-align: center; font-size: 10pt; border: 1pt solid black;">{{ $value->kwitansi_no }}</td>
        <td style="text-align: center; font-size: 10pt; border: 1pt solid black;">{{ format_tanggal_wms($value->invoice_date) }}</td>
        <td colspan="2" style="text-align: center; font-size: 10pt; border: 1pt solid black;">{{ $value->expedition_name }}</td>
        <td style="text-align: right; font-size: 10pt; border: 1pt solid black;">{{ thousand_reformat($value->amount_after_tax) }}</td>
        <td style="text-align: right; font-size: 10pt; border: 1pt solid black;">{{ thousand_reformat($value->amount_ppn) }}</td>
        <td style="text-align: right; font-size: 10pt; border: 1pt solid black;">{{ thousand_reformat($value->amount_pph) }}</td>
        <td style="text-align: right; font-size: 10pt; border: 1pt solid black;">{{ thousand_reformat($value->amount_after_tax) }}</td>
        <td style="text-align: center; font-size: 10pt; border: 1pt solid black;">{{ $value->payment_requisition }}</td>
    </tr>
    @endforeach
    <tr>
        <td colspan="9"
            style="text-align: right; font-size: 10pt; border: 1pt solid black;">
            Total
        </td>
        <td style="text-align: right; font-size: 10pt; border: 1pt solid black;">
            {{ thousand_reformat($total_amount_before_tax) }}
        </td>
        <td style="text-align: right; font-size: 10pt; border: 1pt solid black;">
            {{ thousand_reformat($total_amount_ppn) }}
        </td>
        <td style="text-align: right; font-size: 10pt; border: 1pt solid black;">
            {{ thousand_reformat($total_amount_pph) }}
        </td>
        <td style="text-align: right; font-size: 10pt; border: 1pt solid black;">
            {{ thousand_reformat($total_amount_after_tax) }}
        </td>
        <td style="text-align: center; font-size: 10pt; border: 1pt solid black;">
            &nbsp;
        </td>
    </tr>

    <tr><td colspan="14">&nbsp;</td></tr>
    <tr><td colspan="14">&nbsp;</td></tr>
    @if(!empty($value))
    <tr>
        <td></td>
        <td colspan="2" style="border: 1pt solid black;">Made by:</td>
        <td width="20px"></td>
        <td colspan="2" style="border: 1pt solid black;">Checked by:</td>
        <td></td>
        <td colspan="2" style="border: 1pt solid black;">Aknowledge by:</td>
        <td></td>
        <td colspan="3" style="border: 1pt solid black;">Receive by:</td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td colspan="2" style="border: 1pt solid black;">
            &nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br><br>&nbsp;<br>
        </td>
        <td width="20px"></td>
        <td colspan="2" style="border: 1pt solid black;">
            &nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br><br>&nbsp;<br>
        </td>
        <td></td>
        <td colspan="2" style="border: 1pt solid black;">
            &nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br><br>&nbsp;<br>
        </td>
        <td></td>
        <td colspan="3" style="border: 1pt solid black;">
            &nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br><br>&nbsp;<br>
        </td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td colspan="2" style="border: 1pt solid black; text-align:center;">{{ $value->logistic_staff }}</td>
        <td width="20px"></td>
        <td colspan="2" style="border: 1pt solid black; text-align:center;">{{ $value->logistic_ass_manager }}</td>
        <td></td>
        <td colspan="2" style="border: 1pt solid black; text-align:center;">{{ $value->logistic_manager }}</td>
        <td></td>
        <td colspan="3" style="border: 1pt solid black; text-align:center;">{{ $value->accounting_division }}</td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td colspan="2" style="border: 1pt solid black; text-align:center;">Logistic Staff</td>
        <td width="20px"></td>
        <td colspan="2" style="border: 1pt solid black; text-align:center;">Logistic Ass. Supervisor</td>
        <td></td>
        <td colspan="2" style="border: 1pt solid black; text-align:center;">Logistic Ass. Manager</td>
        <td></td>
        <td colspan="3" style="border: 1pt solid black; text-align:center;">Accounting</td>
        <td></td>
    </tr>
    @endif

</table>