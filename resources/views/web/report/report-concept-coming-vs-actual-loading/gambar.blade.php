<?php
$contentType = 'image/png';
$gdImgHandler = $graph->Stroke(_IMG_HANDLER);

ob_start();                        // start buffering
$graph->img->Stream();             // print data to buffer
$image_data = ob_get_contents();   // retrieve buffer contents
ob_end_clean();                    // stop buffer

//echo "data:$contentType;base64," . base64_encode($image_data);
?>    
@if (is_null($image_data))
    <img src="{{ base64_encode($image_data) }}" style="width:90px;height:85px;" alt=""/>
@else
    <img src="{{ asset('image/grap.png') }}" style="width:90px;height:85px;" alt=""/>
@endif
