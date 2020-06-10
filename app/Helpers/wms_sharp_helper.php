<?php 

// view, detail, view detail
function get_button_view($url = '#', $label = "View"){
  return '<a class="waves-effect waves-light btn btn-small indigo darken-4 btn-view mt-1" href="' . $url . '">' . $label . '</a>';
}

// print
function get_button_print($url = '#', $label = "Print"){
  return '<a class="waves-effect waves-light btn btn-small green darken-4 btn-print mt-2" href="' . $url . '">' . $label . '</a>';
}

// send back
function get_button_return($url = '#', $label = "Send Back"){
  return '<a class="waves-effect waves-light btn btn-small orange darken-4 btn-return" href="' . $url . '">' . $label . '</a>';
}

// edit
function get_button_edit($url = '#', $label = "Edit", $class = 'btn-edit'){
  return '<a class="waves-effect waves-light btn btn-small amber darken-4 ' . $class . ' mt-2" href="' . $url . '">' . $label . '</a>';
}

// delete, clear
function get_button_delete($label = "Delete", $class = 'btn-delete'){
  return '<a class="waves-effect waves-light red darken-4 btn-small ' . $class . ' mt-2" >' . $label . '</a>';
}

// save, update, submit, load
function get_button_save($label = "Save", $class = 'btn-save'){
  return '<button type="submit" class="waves-effect waves-light indigo btn-small ' . $class . '">' . $label . '</button>';
}

// cancel, back
function get_button_cancel($url = '#', $label = "Cancel", $class = ''){
  return '<a class="waves-effect btn-flat ' . $class . '" href="' . $url . '">' . $label . '</a>';
}

// cancel modal
// function get_button_cancel_modal($label = "Cancel"){
//   return '<a class="modal-action modal-close waves-effect btn-flat mt-2 mb-1">' . $label . '</a>';
// }