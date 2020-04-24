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

function get_button_edit($url = '#', $label = "Edit"){
  return '<a class="waves-effect  waves-light btn-small amber darken-4 btn-edit" href="' . $url . '">' . $label . '</a>';
}

function get_button_delete($label = "Delete"){
  return '<a class="waves-effect waves-light red darken-4 btn-small btn-delete" >' . $label . '</a>';
}

function get_button_save($label = "Save"){
  return '<a class="waves-effect waves-light indigo btn btn-save mt-2 mr-2">' . $label . '</a>';
}

function get_button_cancel($url = '#', $label = "Cancel"){
  return '<a class="waves-effect btn-flat mt-2" href="' . $url . '">' . $label . '</a>';
}