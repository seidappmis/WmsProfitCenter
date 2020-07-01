<?php
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
  return number_format($number, 0, ',', '.');
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
