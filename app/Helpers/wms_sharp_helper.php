<?php

// view, detail, view detail
function get_button_view($url = '#', $label = "View", $class = "btn-view")
{
  return '<a class="waves-effect waves-light btn btn-small indigo darken-4 ' . $class . '" href="' . $url . '">' . $label . '</a>';
}

// print
function get_button_print($url = '#', $label = "Print", $class = "btn-print")
{
  return '<a class="waves-effect waves-light btn btn-small green darken-4 ' . $class . '" href="' . $url . '">' . $label . '</a>';
}

// send back
function get_button_return($url = '#', $label = "Send Back")
{
  return '<a class="waves-effect waves-light btn btn-small orange darken-4 btn-return" href="' . $url . '">' . $label . '</a>';
}

// edit
function get_button_edit($url = '#', $label = "Edit", $class = 'btn-edit')
{
  return '<a class="waves-effect waves-light btn btn-small amber darken-4 ' . $class . ' " href="' . $url . '">' . $label . '</a>';
}

// delete, clear
function get_button_delete($label = "Delete", $class = 'btn-delete')
{
  return '<a class="waves-effect waves-light red darken-4 btn-small ' . $class . ' " >' . $label . '</a>';
}

// save, update, submit, load
function get_button_save($label = "Save", $class = 'btn-save mt-2')
{
  return '<button type="submit" class="waves-effect waves-light indigo btn-small ' . $class . '">' . $label . '</button>';
}

// cancel, back
function get_button_cancel($url = '#', $label = "Cancel", $class = 'mt-2')
{
  return '<a class="waves-effect waves-light indigo btn-small btn-cancel ' . $class . '" href="' . $url . '">' . $label . '</a>';
}

function format_tanggal_wms($date)
{
  return date('d-M-Y', strtotime($date));
}

function getPHPSpreadsheetTitleStyle()
{
  $style = [
    'font'      => [
      'bold'  => true,
      'color' => [
        'argb' => 'FFFFFFFF',
      ],
    ],
    'alignment' => [
      'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    ],
    'borders'   => [
      'bottom' => [
        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
      ],
    ],
    'fill'      => [
      'fillType'   => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
      'rotation'   => 90,
      'startColor' => [
        'argb' => 'FF2F9DFF',
      ],
      'endColor'   => [
        'argb' => 'FF2F9DFF',
      ],
    ],
  ];
  return $style;
}

function getPHPSpreadsheetGroupTitleStyle()
{
  $style = [
    'font'      => [
      'bold'  => false,
      'color' => [
        'argb' => 'FFFFFFFF',
      ],
    ],
    'alignment' => [
      'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
    ],
    'fill'      => [
      'fillType'   => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
      'rotation'   => 90,
      'startColor' => [
        'argb' => 'FF929292',
      ],
      'endColor'   => [
        'argb' => 'FF929292',
      ],
    ],
  ];
  return $style;
}

// cancel modal
// function get_button_cancel_modal($label = "Cancel"){
//   return '<a class="modal-action modal-close waves-effect btn-flat mt-2 mb-1">' . $label . '</a>';
// }
