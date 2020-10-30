<link rel="stylesheet" type="text/css" href="{{ url('materialize/css/custom/print.css') }}">
<table style="font-family: Arial;" style="width: 210.0003mm;">
  <tr>
    @php
    ob_start();
    imagepng($graph->Stroke(_IMG_HANDLER));
    $imageData = ob_get_contents();
    ob_end_clean();
    @endphp
    <td><img src="data:image/png;base64,{{base64_encode($imageData)}}" style="width: 100%;" /></td>
  </tr>
  <tr><td></td></tr>
  <tr><td style="text-align: right;">Print date : {{date('d M, Y')}}</td></tr>
  <tr><td style="text-align: right;">Print by : {{auth()->user()->username}}</td></tr>
</table>