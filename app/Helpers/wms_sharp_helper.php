<?php 

function get_button_view($url = '#', $label = "View"){
  return '<a class="waves-effect waves-light btn btn-small indigo darken-4 btn-view" href="' . $url . '">' . $label . '</a>';
}

function get_button_print($url = '#', $label = "Print"){
  return '<a class="waves-effect waves-light btn btn-small green darken-4 btn-print" href="' . $url . '">' . $label . '</a>';
}

function get_button_return($url = '#', $label = "Send Back"){
  return '<a class="waves-effect waves-light btn btn-small orange darken-4 btn-return" href="' . $url . '">' . $label . '</a>';
}