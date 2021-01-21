<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class InvoiceReceiptConfirm extends Model
{
   protected $table     = "log_invoice_receipt_confirm";
   public $incrementing = false;
   protected $primaryKey = 'invoice_receipt_id';
   public $timestamps = false;
}
