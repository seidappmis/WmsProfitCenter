<?php

namespace App\Models;

use App\BaseModel;
use App\Models\Concept;
use App\Models\ManualConcept;

class PickinglistDetail extends BaseModel
{
  protected $table     = 'wms_pickinglist_detail';
  public $incrementing = false;

  public function header()
  {
    return $this->belongsTo('App\Models\PickinglistHeader', 'header_id', 'id');
  }

	public function lmb_details()
	{
		return $this->hasMany('App\Models\LMBDetail', 'picking_detail_id', 'id');
	}

	public function getQuantityInLmb(){
		return $this->lmb_details()->count();
	}

  public function customer()
  {
    $customer = '';
    if ($this->header->cabang->hq) {
      $customer = Concept::where('invoice_no', $this->invoice_no)
        ->where('delivery_no', $this->delivery_no)
        ->where('delivery_items', $this->delivery_items)
        ->where('line_no', $this->line_no)
        ->first()->sold_to;
    } else {
      $customer = ManualConcept::where('invoice_no', $this->invoice_no)
        ->where('delivery_no', $this->delivery_no)
        ->where('delivery_items', $this->delivery_items)
        ->first()->long_description_customer;
    }
    return $customer;
  }
}
