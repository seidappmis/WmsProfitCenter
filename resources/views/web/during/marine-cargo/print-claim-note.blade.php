<html>

<head>
  <link rel="stylesheet" type="text/css" href="{{ url('materialize/css/custom/print1-hq.css') }}">
</head>

<body style="font-family: courier New; font-size: 10pt;">
  <table style="font-family: Arial;border-collapse: collapse; border-bottom: 2px solid; margin-bottom: 20px;"
    width="100%">
    <tr>
      <td width="10%"><img src="{{ URL::to('/images/msig-logo.png') }}" style="width: 70px" /></td>
      <td>
        <div style="text-align: center;"><strong>PT. Asuransi MSIG Indonesia</strong></div>
        <div style="text-align: center;">Summitmas II Building, 15<sup>th</sup> Floor, Jl. Jend. Sudirman Kav. 61-62,
          Jakarta 12190</div>
        <div style="text-align: center;">Telephone: (62) (021) 2523110, 5201268 (Hunting)</div>
        <div style="text-align: center;">Fax: (62) (021) 2524307 (General), 2524084 (Claim), 2524309 (Production)</div>
      </td>
      <td width="10%"></td>
    </tr>
  </table>
  <table style="font-family: Arial;border-collapse: collapse;" width="100%">
    <tr>
      <td colspan="13" style="text-align: center;"><strong><u>CLAIM NOTE</u></strong></td>
    </tr>
    <tr>
      <td colspan="13" style="text-align: center;"><strong>Marine Cargo</strong></td>
    </tr>
    <tr>
      <td colspan="13">Dear Sirs</td>
    </tr>
    <tr>
      <td colspan="13" style="text-align: center;">I/We send you here with my/our claim note for the undermentioned with
        the request that you</td>
    </tr>
    <tr>
      <td colspan="13" style="text-align: center;">will be kind enough to settlement of the claim at the earliest date.
      </td>
    </tr>
    <tr>
      <td colspan="4" style="border-top: 1px solid black; border-left: 1px solid black;">Insurance Policy No.</td>
      <td width="20px;" style="border-top: 1px solid black;">:</td>
      <td colspan="7" style="border-top: 1px solid black;">{{ $marineCargo->insurance_policy_no }}</td>
      <td rowspan="13" width="200px" style="border: 1px solid black;">
        Enclosures (Mark O)
        <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Policy Original
        <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Invoice
        <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Packing List
        <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Cargo Boat Note
        <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Survey Report
        <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Import Declaration
        <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Notice of Claim
        <br> toCarrier
        <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Reply from Carriers
        <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Weight Certificate
        <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Loading Report
        <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Landing Report
        <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Others
      </td>
    </tr>
    <tr>
      <td colspan="4" style="border-left: 1px solid black;">Vessel Name</td>
      <td width="20px;">:</td>
      <td colspan="7">{{ $marineCargo->vessel_name }}</td>
    </tr>
    <tr>
      <td colspan="2" style="border-left: 1px solid black;">Sailed On</td>
      <td colspan="2">{{ date('M d, Y', strtotime($marineCargo->sailed_date)) }}</td>
      <td width="20px;">:</td>
      <td colspan="7">{{ $marineCargo->sailed_on }}</td>
    </tr>
    <tr>
      <td colspan="2" style="border-left: 1px solid black;">Arrived</td>
      <td colspan="2">{{ date('M d, Y', strtotime($marineCargo->arrived_date)) }}</td>
      <td width="20px;">:</td>
      <td colspan="7">at Tanjung Priuk, Jakarta</td>
    </tr>
    <tr>
      <td colspan="4" style="border-left: 1px solid black;">Discharging Date</td>
      <td width="20px;">:</td>
      <td colspan="7">{{ date('F d, Y', strtotime($marineCargo->discharging_date)) }}</td>
    </tr>
    <tr>
      <td colspan="4" style="border-left: 1px solid black;">Delivery to the site</td>
      <td width="20px;">:</td>
      <td colspan="7">{{ date('F d, Y', strtotime($marineCargo->delivery_date)) }}</td>
    </tr>
    <tr>
      <td colspan="4" style="border-left: 1px solid black;">Cargo Description</td>
      <td width="20px;">:</td>
      <td colspan="7">{{ $marineCargo->cargo_description }}</td>
    </tr>
    <tr>
      <td colspan="4" style="border-left: 1px solid black;">Quantity</td>
      <td width="20px;">:</td>
      <td colspan="7">Set &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ $marineCargo->qty }}</td>
    </tr>
    <tr>
      <td colspan="4" style="border-left: 1px solid black;">Conditions</td>
      <td width="20px;">:</td>
      <td colspan="7">As per Insurance Policy</td>
    </tr>
    <tr>
      <td colspan="4" style="border-left: 1px solid black;">On Cargo</td>
      <td width="20px;">:</td>
      <td colspan="7">USD -</td>
    </tr>
    <tr>
      <td colspan="4" style="border-left: 1px solid black;">Insurance Amount on Duty</td>
      <td width="20px;">:</td>
      <td colspan="7">USD -</td>
    </tr>
    <tr>
      <td colspan="4" style="border-left: 1px solid black;">Increased Value</td>
      <td width="20px;">:</td>
      <td colspan="7">Price unit * 110 % * Qty unit</td>
    </tr>
    <tr>
      <td colspan="4" style="border-left: 1px solid black; border-bottom: 1px solid black;">Kind of Damage/Kind of Loss
      </td>
      <td width="20px;" style="border-bottom: 1px solid black;">:</td>
      <td colspan="7" style="border-bottom: 1px solid black;">Wet and Dented</td>
    </tr>

    <tr>
      <td colspan="13" style="text-align: center; border-left: 1px solid black; border-right: 1px solid black;">
        <strong><u>CALCULATION</u></strong>
      </td>
    </tr>
    <tr>
      <td colspan="13" style="text-align: center; border-left: 1px solid black; border-right: 1px solid black;">
        <strong>No.{{ $marineCargo->dgr->dgr_no }}</strong>
      </td>
    </tr>
    <tr>
      <td colspan="2" style="border-left: 1px solid black;"><strong>Invoice No</strong></td>
      <td width="20px">:</td>
      <td colspan="10" style="border-right: 1px solid black;"><strong>{{ $marineCargo->getInvoiceNo() }}</strong>
      </td>
    </tr>
    <tr>
      <td colspan="2" style="border-left: 1px solid black;"><strong>Claim</strong></td>
      <td width="20px">:</td>
      <td colspan="10" style="border-right: 1px solid black;">{{ $marineCargo->getNatureOfClaim() }}</td>
    </tr>
    <tr>
      <td colspan="2" style="border-left: 1px solid black;"><strong>B/L No</strong></td>
      <td width="20px">:</td>
      <td colspan="10" style="border-right: 1px solid black;">{{ $marineCargo->getBLNo() }}</td>
    </tr>
    <tr>
      <td colspan="13" style="border-left: 1px solid black; border-right: 1px solid black;">&nbsp;</td>
    </tr>

    @php
      $totalPriceIDR = 0;
      $totalPriceUSD = 0;
      $totalQty = 0;
    @endphp

    {{-- Carton box Claim --}}
    @foreach ($cartonBoxs as $value)
      @php
        $totalPriceIDR = empty($totalPriceIDR) ? $value['qty'] * $value['price_carton_box'] : $totalPriceIDR + $value['qty'] * $value['price_carton_box'];
      @endphp
      <tr>
        <td colspan="3" style="border-left: 1px solid black;"></td>
        <td>{{ $value['model_name'] }}</td>
        <td width="5px">=</td>
        <td style="text-align: right;" width="120px">IDR {{ thousand_reformat($value['price_carton_box']) }}</td>
        <td style="text-align: center;" width="50px">X</td>
        <td style="text-align: center;" width="50px">{{ $value['qty'] }}</td>
        <?php $totalQty += $value['qty'] ?? 1; ?>
        <td>&nbsp;</td>
        <td style="text-align: left;">=</td>
        <td colspan="2" width="120px" style="text-align: right;">IDR
          {{ thousand_reformat($value['price_carton_box'] * $value['qty']) }}</td>
        <td style="border-right: 1px solid black;"></td>
      </tr>
    @endforeach
    @if (!empty($cartonBoxs))
      <tr>
        <td colspan="7" style="border-left: 1px solid black;"></td>
        <td style="text-align: center; border-top: 1px solid black;"><strong>{{ $totalQty }}</strong></td>
        <td></td>
        <td></td>
        <td colspan="2" style="text-align: right; border-top: 1px solid black;"><strong>IDR
            {{ thousand_reformat($totalPriceIDR) }}</strong></td>
        <td style="border-right: 1px solid black;"></td>
      </tr>
    @endif

    <tr>
      <td colspan="13" style="border-left: 1px solid black; border-right: 1px solid black;">&nbsp;</td>
    </tr>
    <?php $totalQty = 0; ?>
    @foreach ($units as $value)
      @php
        $totalPriceUSD = empty($totalPriceUSD) ? $value['qty'] * $value['price'] : $totalPriceUSD + ($value['qty'] * $value['price'] * 110) / 100;
      @endphp
      <tr>
        <td colspan="3" style="border-left: 1px solid black;"></td>
        <td>{{ $value['model_name'] }}</td>
        <td width="5px">=</td>
        <td style="text-align: right;">{{ $marineCargo->currency }} {{ thousand_reformat($value['price']) }}</td>
        <td style="text-align: center;" width="50px">X</td>
        <td>110%</td>
        <td style="text-align: center;" width="50px">X</td>
        <td style="text-align: center;">{{ $value['qty'] }}</td>
        <?php $totalQty += $value['qty'] ?? 1; ?>
        <td>=</td>
        <td style="text-align: right;">
          {{ thousand_reformat(($value['qty'] * $value['price'] * 110) / 100) }}
        </td>
        <td style="border-right: 1px solid black;"></td>
      </tr>
    @endforeach
    @if (!empty($units))
      <tr>
        <td colspan="9" style="border-left: 1px solid black;"></td>
        <td style="text-align: center; border-top: 1px solid black;"><strong>{{ $totalQty }}</strong></td>
        <td></td>
        <td style="text-align: right; border-top: 1px solid black;"><strong>{{ $marineCargo->currency }}
            {{ thousand_reformat($totalPriceUSD) }}</strong></td>
        <td style="border-right: 1px solid black;"></td>
      </tr>
    @endif
    <tr>
      <td colspan="13" style="border-left: 1px solid black; border-right: 1px solid black;">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="12" style="border-left: 1px solid black;"></td>
      <td style="border-right: 1px solid black;"><strong>Curr: {{ $marineCargo->currency }}</strong></td>
    </tr>
    <tr>
      <td colspan="8" style="text-align: right; border-left: 1px solid black; border-bottom: 1px solid black;">
        <strong>Total Claim Amount : </strong>
      </td>
      <td colspan="4" style="border-bottom: 1px solid black;"><strong>IDR
          {{ thousand_reformat($totalPriceIDR) }}</strong></td>
      <td style="border-right: 1px solid black; border-bottom: 1px solid black;"><strong>USD
          {{ thousand_reformat($totalPriceUSD) }}</strong></td>
    </tr>

    <tr>
      <td colspan="13" style="border-left: 1px solid black; border-right: 1px solid black;"></td>
    </tr>
    <tr>
      <td width="5px" style="border-left: 1px solid black;"></td>
      <td colspan="7" style="border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black;">
        <strong><u>Please Remit the Payment To:</u></strong>
      </td>
      <td colspan="5" style="text-align: center; border-right: 1px solid black;">Karawang,
        {{ date('F d, Y', strtotime($marineCargo->dgr->created_at)) }}
      <td>
    </tr>
    <tr>
      <td width="5px" style="border-left: 1px solid black;"></td>
      <td style="border-left: 1px solid black;">Bank</td>
      <td>:</td>
      <td colspan="5" style="border-right: 1px solid black;">MUFG Bank Ltd</td>
      <td colspan="5" style="text-align: center; border-right: 1px solid black;">Yours faithfully
      <td>
    </tr>
    <tr>
      <td width="5px" style="border-left: 1px solid black;"></td>
      <td style="border-left: 1px solid black;">Acc No.</td>
      <td>:</td>
      <td colspan="5" style="border-right: 1px solid black;">5100-103677 (IDR)</td>
      <td colspan="5" style="text-align: center; border-right: 1px solid black;">&nbsp;
      <td>
    </tr>
    <tr>
      <td width="5px" style="border-left: 1px solid black;"></td>
      <td style="border-left: 1px solid black;"></td>
      <td></td>
      <td colspan="5" style="border-right: 1px solid black;">5300-366494 (USD)</td>
      <td colspan="5" style="text-align: center; border-right: 1px solid black;">&nbsp;
      <td>
    </tr>
    <tr>
      <td width="5px" style="border-left: 1px solid black;"></td>
      <td style="border-left: 1px solid black;">Address</td>
      <td>:</td>
      <td colspan="5" style="border-right: 1px solid black;">JL. JEND SUDIRMAN KAV. 10-11 JAKARTA</td>
      <td colspan="5" style="text-align: center; border-right: 1px solid black;"><u>Mr. E. Gunandi</u>
      <td>
    </tr>
    <tr>
      <td width="5px" style="border-left: 1px solid black;"></td>
      <td style="border-left: 1px solid black; border-bottom: 1px solid black;">Beneficary</td>
      <td style="border-bottom: 1px solid black;">:</td>
      <td colspan="5" style="border-right: 1px solid black; border-bottom: 1px solid black;">PT. SHARP ELECTRONIC
        INDONESIA</td>
      <td colspan="5" style="text-align: center; border-right: 1px solid black;">Authorized Signature
      <td>
    </tr>
    <tr>
      <td colspan="13"
        style="border-left: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;"></td>
    </tr>

  </table>
</body>
