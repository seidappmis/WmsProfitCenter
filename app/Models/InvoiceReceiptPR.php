<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class InvoiceReceiptPR extends Model
{
   protected $table     = "log_invoice_receipt_pr";
   public $incrementing = false;
   public $timestamps = false;
}
