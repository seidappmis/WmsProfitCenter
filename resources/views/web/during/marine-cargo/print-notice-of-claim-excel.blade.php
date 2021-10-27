<html>
<head>
  <link rel="stylesheet" type="text/css" href="{{ url('materialize/css/custom/print1-hq.css') }}">
</head>
<body style="font-family: courier New; font-size: 9pt;">
  <table style="font-family: Arial;border-collapse: collapse;">
   <tr><td colspan="5">&nbsp;</td></tr>
   <tr><td colspan="5">&nbsp;</td></tr>
   <tr><td colspan="5">&nbsp;</td></tr>
   <tr><td colspan="5">&nbsp;</td></tr>
   <tr><td colspan="5">&nbsp;</td></tr>
   <tr><td colspan="5">&nbsp;</td></tr>
   <tr><td colspan="5">&nbsp;</td></tr>
   <tr><td colspan="5">&nbsp;</td></tr>
   <tr><td colspan="5">&nbsp;</td></tr>
   <tr><td colspan="5">&nbsp;</td></tr>
   <tr><td colspan="5">&nbsp;</td></tr>
   <tr><td colspan="5">&nbsp;</td></tr>
   <tr>
      <td colspan="3">Ref. {{ $marineCargo->notice_of_claim_no }}</td>
      <td colspan="2" style="text-align: right;">Karawang, {{ date('F d, Y', strtotime($marineCargo->dgr->created_at)) }}</td>
   </tr>
   <tr><td colspan="5">&nbsp;</td></tr>
   <tr>
      <td><strong>To.</strong></td>
      <td colspan="4"><strong><u>Evergreen Line</u> <br> PT.NITTSU LEMO</strong></td>
   </tr>
   <tr><td colspan="5">&nbsp;</td></tr>
   <tr><td colspan="5" style="text-align: center;"><strong>NOTICE OF CLAIM</strong></td></tr>
   <tr><td colspan="5">&nbsp;</td></tr>
   <tr><td colspan="5">&nbsp;</td></tr>
   <tr><td colspan="5">Please be advise that in receiving of our cargo, Sharp Brand Product has been found damage the carton box, for which we reserve the right to file a claim with you when this details are ascertained.</td></tr>
   <tr><td colspan="5">&nbsp;</td></tr>
   <tr><td colspan="5">The carton box was torn and dented, when the goods still in the container with the details as below:</td></tr>
   <tr><td colspan="5">&nbsp;</td></tr>
   <tr><td colspan="2">Name of Vessel</td><td style="width: 15px;">:</td><td>{{ $marineCargo->vessel_name }}</td><td></td></tr>
   <tr><td colspan="5">&nbsp;</td></tr>
   <tr><td colspan="2">Sailed On, {{ date('M d, Y', strtotime($marineCargo->sailed_date)) }}</td><td style="width: 15px;">:</td><td>{{ $marineCargo->sailed_on }}</td><td></td></tr>
   <tr><td colspan="5">&nbsp;</td></tr>
   <tr><td colspan="2">Eta, Tanjung Priuk, Jakarta</td><td style="width: 15px;">:</td><td>{{ date('F d, Y', strtotime($marineCargo->arrived_date)) }}</td><td></td></tr>
   <tr><td colspan="5">&nbsp;</td></tr>
   <tr><td colspan="2">Receiving goods at our Warehouse</td><td style="width: 15px;">:</td><td>{{ date('F d, Y', strtotime($marineCargo->discharging_date)) }}</td><td></td></tr>
   <tr><td colspan="5">&nbsp;</td></tr>
   <tr><td colspan="2">B/L No</td><td style="width: 15px;">:</td><td>{{ $marineCargo->getBLNo() }}</td><td></td></tr>
   <tr><td colspan="5">&nbsp;</td></tr>
   <tr><td colspan="2">Invoice No</td><td style="width: 15px;">:</td><td>{{ $marineCargo->getInvoiceNo() }}</td><td></td></tr>
   <tr><td colspan="5">&nbsp;</td></tr>
   <tr><td colspan="2">Nature of Claim</td><td style="width: 15px;">:</td><td>{{ $marineCargo->getNatureOfClaim() }}</td><td></td></tr>
   <tr><td colspan="5">&nbsp;</td></tr>
   <tr><td colspan="5">You are kindly to inform us in writing your opinion of this matter on your investigation at an early date.</td></tr>
   <tr><td colspan="5">&nbsp;</td></tr>
   <tr><td colspan="5">Your faithfully,</td></tr>
   <tr><td colspan="5">&nbsp;</td></tr>
   <tr><td colspan="5">&nbsp;</td></tr>
   <tr><td colspan="5">&nbsp;</td></tr>
   <tr><td colspan="5">&nbsp;</td></tr>
   <tr><td colspan="5">&nbsp;</td></tr>
   <tr><td colspan="5"><strong><u>Mr. E. Gunandi</u></strong></td></tr>
   <tr><td colspan="5"><strong>Staff Accounting</strong></td></tr>
   <tr><td colspan="5"><strong>C.C.PT.Asuransi MSIG Indonesia</strong></td></tr>
  </table>
</body>