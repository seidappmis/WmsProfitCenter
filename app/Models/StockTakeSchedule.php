<?php

namespace App\Models;

use App\BaseModel;

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
}
