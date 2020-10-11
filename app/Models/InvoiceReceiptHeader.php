<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceReceiptHeader extends Model
{
  protected $table     = "log_invoice_receipt_header";
  public $incrementing = false;

  public function details()
  {
    return $this->hasMany('App\Models\InvoiceReceiptDetail', 'id_header');
  }

  public function getPrintReceiptData()
  {
    $data = [];
    foreach ($this->details as $key => $value) {
      $data[$value->do_manifest_no]['total_model'] = empty($data[$value->do_manifest_no]['total_model']) ? 1 : ($data[$value->do_manifest_no]['total_model'] + 1);

      $data[$value->do_manifest_no]['do_manifest_no']      = $value->do_manifest_no;
      $data[$value->do_manifest_no]['do_manifest_date']    = $value->do_manifest_date;
      $data[$value->do_manifest_no]['city_name']           = $value->city_name;
      $data[$value->do_manifest_no]['vehicle_description'] = $value->vehicle_description;
      $data[$value->do_manifest_no]['vehicle_number']      = $value->vehicle_number;

      $data[$value->do_manifest_no]['ritase']    = $value->ritase;
      $data[$value->do_manifest_no]['cbm']       = $value->cbm;
      $data[$value->do_manifest_no]['ritase2']   = $value->ritase2;
      $data[$value->do_manifest_no]['multidrop'] = $value->multidrop;
      $data[$value->do_manifest_no]['unloading'] = $value->unloading;
      $data[$value->do_manifest_no]['overstay']  = $value->overstay;

      $data[$value->do_manifest_no]['do'][$value->delivery_no]['no_do_sap']    = $value->delivery_no;
      $data[$value->do_manifest_no]['do'][$value->delivery_no]['tgl_do_sap']   = $value->do_date;
      $data[$value->do_manifest_no]['do'][$value->delivery_no]['ship_to_code'] = $value->ship_to_code;
      $data[$value->do_manifest_no]['do'][$value->delivery_no]['ship_to']      = $value->ship_to;
      $data[$value->do_manifest_no]['do'][$value->delivery_no]['acc_code']     = $value->acc_code;

      $model['model']    = $value->model;
      $model['quantity'] = $value->quantity;
      $model['cbm_do']   = $value->cbm_do;

      $data[$value->do_manifest_no]['do'][$value->delivery_no]['models'][] = $model;
    }
    return $data;
  }
}
