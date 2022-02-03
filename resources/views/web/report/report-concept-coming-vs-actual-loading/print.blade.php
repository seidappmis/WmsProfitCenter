<table style="font-family: Arial;" style="width: 210.0003mm;">
  <tr>
  <?php
$contentType = 'image/png';
$gdImgHandler = $graph->Stroke(_IMG_HANDLER);

ob_start();                        // start buffering
$graph->img->Stream();             // print data to buffer
$image_data = ob_get_contents();   // retrieve buffer contents
ob_end_clean();                    // stop buffer

//echo "data:$contentType;base64," . base64_encode($image_data);
?>

    <td><img src="data:image/png;base64,{{base64_encode($image_data)}}" style="width: 100%;" /></td>
  </tr>
  <tr>
    <td></td>
  </tr>
  <tr>
    <td style="text-align: right;">Print date : {{date('d M, Y')}}</td>
  </tr>
  <tr>
    <td style="text-align: right;">Print by : {{auth()->user()->username}}</td>
  </tr>
</table>