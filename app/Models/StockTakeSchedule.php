<?php

namespace App\Models;

use App\BaseModel;
use App\Models\StockTakeInput1;
use DB;

class StockTakeSchedule extends BaseModel
{
  //Set Table
  protected $table = "log_stocktake_schedule";

  // Set Table Primary Key
  // if not set default : id
  protected $primaryKey = 'sto_id';

  /**
   * The "type" of the auto-incrementing ID.
   *
   * @var string
   */
  protected $keyType = 'string';

  public function details()
  {
    return $this->hasMany('App\Models\StockTakeScheduleDetail', 'sto_id', 'sto_id');
  }

  public function Area()
  {
    return $this->belongsTo('App\Models\Area', 'area', 'area');
  }

  public function MasterCabang()
  {
    return $this->belongsTo('App\Models\MasterCabang', 'kode_cabang', 'kode_cabang');
  }

  public function input1()
  {
    return $this->hasMany('App\Models\StockTakeInput1', 'sto_id', 'sto_id');
  }

  public function input2()
  {
    return $this->hasMany('App\Models\StockTakeInput2', 'sto_id', 'sto_id');
  }

  public function total_all_location()
  {
    return $this->input1()->selectRaw('COUNT(DISTINCT(location)) AS total_all_location')->first()->total_all_location;
  }

  public static function get_summary_tag_compared_matched($sto_id)
  {
    return StockTakeInput1::select(
      DB::raw('COUNT(log_stocktake_input1.id) AS tag_compare_matched')
    )
      ->leftjoin('log_stocktake_input2', function ($join) {
        $join->on('log_stocktake_input1.sto_id', '=', 'log_stocktake_input2.sto_id');
        $join->on('log_stocktake_input1.no_tag', '=', 'log_stocktake_input2.no_tag');
      })
      ->where('log_stocktake_input1.sto_id', $sto_id)
      ->whereRaw('(log_stocktake_input1.input_date IS NOT NULL OR log_stocktake_input2.input_date IS NOT NULL)')
      ->whereRaw('IF(log_stocktake_input1.quantity IS NULL, 0, log_stocktake_input1.quantity) = IF(log_stocktake_input2.quantity IS NULL, 0, log_stocktake_input2.quantity)')
      ->first()->tag_compare_matched;
  }

  public static function getDifferentQuantity($sto_id)
  {
    return StockTakeInput1::select(
      // DB::raw('IF(SUM(log_stocktake_input1.quantity) IS NULL, 0, SUM(log_stocktake_input1.quantity)) - IF(SUM(log_stocktake_input2.quantity) IS NULL, 0, SUM(log_stocktake_input2.quantity)) AS different_quantity')
      DB::raw('IF(COUNT(log_stocktake_input1.quantity) IS NULL, 0, COUNT(log_stocktake_input1.quantity)) AS different_quantity')
    )
      ->leftjoin('log_stocktake_input2', function ($join) {
        $join->on('log_stocktake_input1.sto_id', '=', 'log_stocktake_input2.sto_id');
        $join->on('log_stocktake_input1.no_tag', '=', 'log_stocktake_input2.no_tag');
      })
      ->where('log_stocktake_input1.sto_id', $sto_id)
      ->whereRaw('(log_stocktake_input1.input_date IS NOT NULL OR log_stocktake_input2.input_date IS NOT NULL)')
      ->whereRaw('IF(log_stocktake_input1.quantity IS NULL, 0, log_stocktake_input1.quantity) != IF(log_stocktake_input2.quantity IS NULL, 0, log_stocktake_input2.quantity)')
      ->first()->different_quantity;
  }
}
