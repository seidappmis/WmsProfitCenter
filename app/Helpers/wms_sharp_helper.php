<?php 

function get_button_view($url = '#', $tooltip = "View"){
  return '<a class="waves-effect btn-floating btn-small indigo darken-4 tooltipped" href="' . $url . '" data-position="top" data-tooltip="' . $tooltip . '"><i class="material-icons">remove_red_eye</i></a>';
}

function get_button_print($url = '#', $tooltip = "Print"){
  return '<a class="waves-effect btn-floating btn-small green darken-4 tooltipped" href="' . $url . '" data-position="top" data-tooltip="' . $tooltip . '"><i class="material-icons">local_printshop</i></a>';
}

function get_button_return($url = '#', $tooltip = "Send Back"){
  return '<a class="waves-effect btn-floating btn-small orange darken-4 tooltipped" href="' . $url . '" data-position="top" data-tooltip="' . $tooltip . '"><i class="material-icons">settings_backup_restore</i></a>';
}