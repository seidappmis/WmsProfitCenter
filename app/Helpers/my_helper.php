<?php
function serial_no_explode($serial)
{
  $s = explode(' ', $serial);
  return isset($s[0]) ? $s[0] : $serial;
}
function date_reformat($date)
{
  if (empty($date)) {
    return $date;
  }
  return date('Y-m-d h:i:s', strtotime($date));
}

function date_display($date)
{
  if (empty($date)) {
    return $date;
  }
  return date('d M Y', strtotime($date));
}

function date_display_input($date)
{
  if (!empty($date)) {
    //return date format
    return date('d F Y', strtotime($date));
  } else {
    //return empty
    return $date;
  }
}

function percentage_reformat($percentage)
{
  return str_replace([' ', '%'], '', $percentage);
}

function thousand_reformat($number)
{
  return number_format($number, 0, '.', ',');
}

function getSecondFromTime($time)
{
  $seconds = strtotime("1970-01-01 $time UTC");
  return $seconds;
}

function getTimeFromSeconds($seconds)
{
  return gmdate("H:i:s", $seconds);
}

function setDecimal($number)
{
  return number_format($number, 3);
}

function money_reformat($number, $currency = null)
{
  switch ($currency) {
    case 'IDR':
      $prefix = 'Rp ';
      break;
    case 'EUR':
      $prefix = '€ ';
      break;
    case 'USD':
      $prefix = '$ ';
      break;

    default:
      $prefix = '';
      break;
  }

  return $prefix . number_format($number, 2, ',', '.');
}

function unformat_currency($currency)
{
  return str_replace(['Rp', '€', '$', ' ', ','], '', $currency);
}

function get_select2_data($request, $query)
{
  $query->having('text', 'like', "%" . $request->input('q') . "%");
  $data['total_record'] = count($query->get());

  $start  = ($request->input('page') - 1) * $request->input('page_limit');
  $length = $request->input('page_limit');
  // $sql .= " LIMIT {$start}, {$length}";

  $query->offset($start)
    ->limit($length);

  $params = '';
  // $query->having('text', 'like', "%" . $request->input('q') . "%");
  // $query = $this->db->query($sql, $params);

  $data['more'] = $data['total_record'] > $request->input('page') * $request->input('page_limit');

  $data['items'] = $query->get()->toArray();
  return $data;
}

function is_file_exist_public($filepathInPublic)
{
  // if (file_exists(public_path() .'/storage/tender_req_document/'.$file_name_orginal)) {
  if (file_exists(public_path() . $filepathInPublic)) {
    return true;
  } else {
    return false;
  }
}

function limit_kalimat_wrap($kalimat, $panjang_max = 100, $wrap_length = 40)
{
  if (strlen($kalimat) > $panjang_max) {
    $kalimat = substr($kalimat, 0, $panjang_max) . '...';
    return wordwrap($kalimat, $wrap_length, "<br>\n");
  }
  return wordwrap($kalimat, $wrap_length, "<br>\n");
}

function sendError($message, $data = null)
{
  return [
    'status'  => false,
    'message' => $message,
    'data'    => $data,
  ];
}

function sendSuccess($message, $data)
{
  return [
    'status'  => true,
    'message' => $message,
    'data'    => $data,
  ];
}

function getRomawi($bln)
{
  switch ($bln) {
    case 1:
      return "I";
      break;
    case 2:
      return "II";
      break;
    case 3:
      return "III";
      break;
    case 4:
      return "IV";
      break;
    case 5:
      return "V";
      break;
    case 6:
      return "VI";
      break;
    case 7:
      return "VII";
      break;
    case 8:
      return "VIII";
      break;
    case 9:
      return "IX";
      break;
    case 10:
      return "X";
      break;
    case 11:
      return "XI";
      break;
    case 12:
      return "XII";
      break;
  }
}
