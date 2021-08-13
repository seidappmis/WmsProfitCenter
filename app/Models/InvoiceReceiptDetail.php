<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceReceiptDetail extends Model
{
  protected $table = "log_invoice_receipt_detail";

  public function header(){
	  return $this->belongsTo(InvoiceReceiptHeader::class, 'id_header');
  }
}