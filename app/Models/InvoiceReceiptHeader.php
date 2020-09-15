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
}
