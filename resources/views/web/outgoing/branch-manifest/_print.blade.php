<link rel="stylesheet" type="text/css" href="{{ url('materialize/css/custom/print.css') }}">

<table style="font-family: Arial Narrow;">
  <tr>
    <td>
      <table style="width: 210.0003mm;">
        <tr>
          <td>
            <table width="100%" style="font-size: 9pt;">
              <tr><td>&nbsp;</td></tr>
              <tr><td>&nbsp;</td></tr>
              <tr>
                <td colspan="17" style="font-size: 10pt;"><strong>PT. SHARP ELECTRONICS INDONESIA</strong></td>
              </tr>
              <tr><td>&nbsp;</td></tr>
              <tr>
                <td colspan="17" style="font-size: 12pt; text-align: center;"><strong>BRANCH MANIFEST</strong></td>
              </tr>
              <tr><td>&nbsp;</td></tr>
              <tr>
                <td>Manifest No.</td>
                <td>:</td>
                <td colspan="8" style="text-align: left; width: 90mm;"><strong>{{!empty($branchManifestHeader) ? $branchManifestHeader->do_manifest_no : ''}}</strong></td>
                <td colspan="2">Vehicle</td>
                <td>:</td>
                <td colspan="4" style="text-align: left;"><strong>{{!empty($branchManifestHeader) ? $branchManifestHeader->vehicle_number : ''}} {{!empty($branchManifestHeader) ? $branchManifestHeader->vehicle_description : ''}}</strong></td>
              </tr>
              <tr>
                <td>Date</td>
                <td>:</td>
                <td colspan="8" style="text-align: left; width: 90mm;"><strong>{{!empty($branchManifestHeader) ? $branchManifestHeader->do_manifest_date : ''}}</strong></td>
                <td colspan="2">Expedition Name</td>
                <td>:</td>
                <td colspan="4" style="text-align: left;"><strong>{{!empty($branchManifestHeader) ? $branchManifestHeader->expedition_name : ''}}</strong></td>
              </tr>
              <tr>
                <td>Destination</td>
                <td>:</td>
                <td colspan="8" style="text-align: left; width: 90mm;"><strong>{{!empty($branchManifestHeader) ? $branchManifestHeader->city_name : ''}}</strong></td>
                <td colspan="2">Container No.</td>
                <td>:</td>
                <td colspan="4" style="text-align: left;"><strong>{{!empty($branchManifestHeader) ? $branchManifestHeader->container_no : ''}}</strong></td>
              </tr>
              <tr>
                <td>Picking No</td>
                <td>:</td>
                <td colspan="8" style="text-align: left; width: 90mm;"><strong>{{!empty($branchManifestHeader) ? $branchManifestHeader->picking->picking_no : ''}}</strong></td>
                <td colspan="2">PDO. No</td>
                <td>:</td>
                <td colspan="4" style="text-align: left;"><strong>{{!empty($branchManifestHeader) ? $branchManifestHeader->pdo_no : ''}}</strong></td>
              </tr>
              <tr><td>&nbsp;</td></tr>
            </table>
          </td>
        </tr>
        <tr>
          <td>
            {{-- Main Table --}}
            <table  width="100%" style="font-size: 8pt; border-collapse: collapse;">
              {{-- Table Head --}}
              <tr>
                <td style="border-top: 1pt solid #000000; border-bottom: 1pt solid #000000;"><strong>Ship To</strong></td>
                <td style="border-top: 1pt solid #000000; border-bottom: 1pt solid #000000; width: 5mm;"></td>
                <td style="border-top: 1pt solid #000000; border-bottom: 1pt solid #000000;"><strong>Ship To - Detail</strong></td>
                <td style="border-top: 1pt solid #000000; border-bottom: 1pt solid #000000; width: 5mm;"></td>
                <td style="border-top: 1pt solid #000000; border-bottom: 1pt solid #000000; text-align: right;"><strong>#</strong></td>
                <td style="border-top: 1pt solid #000000; border-bottom: 1pt solid #000000; width: 5mm;"></td>
                <td style="border-top: 1pt solid #000000; border-bottom: 1pt solid #000000;"><strong>DO No.</strong></td>
                <td style="border-top: 1pt solid #000000; border-bottom: 1pt solid #000000; width: 5mm;"></td>
                <td style="border-top: 1pt solid #000000; border-bottom: 1pt solid #000000; text-align: right;"><strong>#</strong></td>
                <td style="border-top: 1pt solid #000000; border-bottom: 1pt solid #000000; width: 5mm;"></td>
                <td style="border-top: 1pt solid #000000; border-bottom: 1pt solid #000000;"><strong>Model</strong></td>
                <td style="border-top: 1pt solid #000000; border-bottom: 1pt solid #000000; width: 5mm;"></td>
                <td style="border-top: 1pt solid #000000; border-bottom: 1pt solid #000000; text-align: right;"><strong>Qty</strong></td>
                <td style="border-top: 1pt solid #000000; border-bottom: 1pt solid #000000; width: 5mm;"></td>
                <td style="border-top: 1pt solid #000000; border-bottom: 1pt solid #000000; text-align: right;"><strong>CBM</strong></td>
                <td style="border-top: 1pt solid #000000; border-bottom: 1pt solid #000000; width: 5mm;"></td>
                <td style="border-top: 1pt solid #000000; border-bottom: 1pt solid #000000; text-align: right;"><strong>Total CBM</strong></td>
              </tr>
              {{-- Table Body --}}
              @php
              $start_no = 1;
              $total_qty = 0;
              $total_cbm = 0;
              @endphp
              @foreach($rs_details as $key => $detail)
                @php
                $sub_total_qty = 0;
                $sub_total_cbm = 0;
                @endphp

                @foreach($detail['models'] AS $km => $vm)
                @php
                $sub_total_qty += $vm->quantity;
                $sub_total_cbm += $vm->cbm;
                @endphp
                <tr>
                  @if($km == 0)
                  <td rowspan="{{ count($detail['models']) }}" style="vertical-align: top;">{{$detail['data']->ship_to_code}}</td>
                  <td rowspan="{{ count($detail['models']) }}" style="width: 5mm;"></td>
                  <td rowspan="{{ count($detail['models']) }}" style="vertical-align: top;">{{$detail['data']->ship_to}}</td>
                  <td rowspan="{{ count($detail['models']) }}" style="width: 5mm;"></td>
                  <td rowspan="{{ count($detail['models']) }}" style="vertical-align: top; text-align: right;">{{ $start_no++ }}.</td>
                  <td rowspan="{{ count($detail['models']) }}" style="width: 5mm;"></td>
                  <td rowspan="{{ count($detail['models']) }}" style="vertical-align: top;">{{!empty($detail['data']->do_internal) ? $detail['data']->do_internal : $detail['data']->delivery_no}}</td>
                  <td rowspan="{{ count($detail['models']) }}" style="width: 5mm;"></td>
                  @endif

                  {{-- MODEL START --}}
                  <td style="text-align: right;">{{$km+1}}.</td>
                  <td style="width: 5mm;"></td>
                  <td style="{{ count($detail['models']) == ($km + 1) ? 'border-bottom: 1pt solid #000000;' : ''  }}">{{$vm->model}}</td>
                  <td style="{{ count($detail['models']) == ($km + 1) ? 'border-bottom: 1pt solid #000000;' : ''  }} width: 5mm;"></td>
                  <td style="{{ count($detail['models']) == ($km + 1) ? 'border-bottom: 1pt solid #000000;' : ''  }} text-align: right;">{{$vm->quantity}}</td>
                  <td style="{{ count($detail['models']) == ($km + 1) ? 'border-bottom: 1pt solid #000000;' : ''  }} width: 5mm;"></td>
                  <td style="{{ count($detail['models']) == ($km + 1) ? 'border-bottom: 1pt solid #000000;' : ''  }} text-align: right;">{{$vm->cbm / $vm->quantity}}</td>
                  <td style="{{ count($detail['models']) == ($km + 1) ? 'border-bottom: 1pt solid #000000;' : ''  }} width: 5mm;"></td>
                  <td style="{{ count($detail['models']) == ($km + 1) ? 'border-bottom: 1pt solid #000000;' : ''  }} text-align: right;">{{$vm->cbm}}</td>
                </tr>
                @endforeach
                <tr>
                  <td colspan="10"></td>`
                  <td style="text-align: right;"><strong>Sub Total</strong></td>
                  <td style="width: 5mm;"></td>
                  <td style="text-align: right;">{{$sub_total_qty}}</td>
                  <td style="width: 5mm;"></td>
                  <td style="width: 5mm;"></td>
                  <td colspan="2" style="text-align: right;">{{$sub_total_cbm}}</td>
                </tr>
                @php
                $total_qty += $sub_total_qty;
                $total_cbm += $sub_total_cbm;
                @endphp
              @endforeach
              <tr>
                <td colspan="7" style="text-align: right; border-top: 1pt solid #000000; border-bottom: 1pt solid #000000;"><strong>Total</strong></td>
                <td style="border-top: 1pt solid #000000; border-bottom: 1pt solid #000000; text-align: center;"></td>
                <td style="border-top: 1pt solid #000000; border-bottom: 1pt solid #000000; text-align: right;"></td>
                <td style="border-top: 1pt solid #000000; border-bottom: 1pt solid #000000; width: 5mm;"></td>
                <td style="border-top: 1pt solid #000000; border-bottom: 1pt solid #000000; width: 5mm;"></td>
                <td colspan="2" style="text-align: right; border-top: 1pt solid #000000; border-bottom: 1pt solid #000000;">{{$total_qty}}</td>
                <td style="border-top: 1pt solid #000000; border-bottom: 1pt solid #000000; width: 5mm;"></td>
                <td style="border-top: 1pt solid #000000; border-bottom: 1pt solid #000000; width: 5mm;"></td>
                <td colspan="2" style="text-align: right; border-top: 1pt solid #000000; border-bottom: 1pt solid #000000;">{{$total_cbm}}</td>
              </tr>
              <tr><td>&nbsp;</td></tr>
            </table>
            {{-- End Main Table --}}
          </td>
        </tr>
        <tr>
          <td>
            <footer>
            <table width="100%" style="font-size: 8pt;">
              <tr>
                <td colspan="3" style="text-align: center; width: 70mm;"><strong>EXPEDITION</strong></td>
                <td colspan="8" style="text-align: center; width: 70mm;"><strong>OUTSOURCE <br> LOGISTIC</strong></td>
                <td colspan="6" style="text-align: center; width: 70mm;"><strong>RECEIVER</strong></td>
              </tr>
              <tr><td>&nbsp;</td></tr>
              <tr><td>&nbsp;</td></tr>
              <tr><td>&nbsp;</td></tr>
              <tr>
                <td colspan="3" style="text-align: center; width: 70mm;">(................................)</td>
                <td colspan="8" style="text-align: center; width: 70mm;">(................................)</td>
                <td colspan="6" style="text-align: center; width: 70mm;">(................................)</td>
              </tr>
              <tr><td>&nbsp;</td></tr>
              <tr><td>&nbsp;</td></tr>
              <tr>
                <td colspan="3" style="text-align: left; width: 70mm;">Thursday, 13-August-2020 04:16:31 PM</td>
                <td colspan="8" style="text-align: center; width: 70mm;">Page 1 of 1</td>
                <td colspan="6" style="text-align: right; width: 70mm;">print out from SEID WMS</td>
              </tr>
            </table>
            </footer>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>