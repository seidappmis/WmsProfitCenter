<?php 

function get_button_view($url = '#'){
  return '<a class="waves-effect btn-floating btn-small indigo darken-4 btn-edit" href="' . $url . '"><i class="material-icons">remove_red_eye</i></a>';
}

function get_button_print($url = '#'){
  return '<a class="waves-effect btn-floating btn-small green darken-4 btn-edit" href="' . $url . '"><i class="material-icons">local_printshop</i></a>';
}