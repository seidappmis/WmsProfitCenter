<link rel="stylesheet" type="text/css" href="{{ url('materialize/css/custom/print.css') }}">

<table style="width: 210.0003mm; border-collapse: collapse;">
  <tr style="border: 1px solid black;">
    <td style="border: 1px solid black; font-weight: 700; background-color: PaleTurquoise;">Branch</td>
    <td style="border: 1px solid black; font-weight: 700; background-color: PaleTurquoise;">DO Date</td>
    <td style="border: 1px solid black; font-weight: 700; background-color: PaleTurquoise;">DO No</td>
    <td style="border: 1px solid black; font-weight: 700; background-color: PaleTurquoise;">Internal DO</td>
    <td style="border: 1px solid black; font-weight: 700; background-color: PaleTurquoise;">Confirm Date</td>
    <td style="border: 1px solid black; font-weight: 700; background-color: PaleTurquoise;">Confirm Status</td>
    <td style="border: 1px solid black; font-weight: 700; background-color: PaleTurquoise;">Manifest No</td>
  </tr>
  @foreach($details AS $key => $value)
  <tr style="border: 1px solid black;">
    <td style="border: 1px solid black;">{{$value->kode_customer}}</td>
    <td style="border: 1px solid black;">{{$value->do_date}}</td>
    <td style="border: 1px solid black;">{{$value->delivery_no}}</td>
    <td style="border: 1px solid black;">{{$value->do_internal}}</td>
    <td style="border: 1px solid black;">{{$value->confirm_date}}</td>
    <td style="border: 1px solid black;">{{$value->status_confirm ? 'Confirm' : 'Unconfirm'}}</td>
    <td style="border: 1px solid black;">{{$value->do_manifest_no}}</td>
  </tr>
  @endforeach
</table>