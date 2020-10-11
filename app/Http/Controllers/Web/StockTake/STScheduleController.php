<?php

namespace App\Http\Controllers\Web\StockTake;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\MasterCabang;
use App\Models\StockTakeSchedule;
use App\Models\StockTakeScheduleDetail;
use DataTables;
use DB;
use Illuminate\Http\Request;

class STScheduleController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = StockTakeSchedule::select('*');
      if (!empty($request->input('area_name'))) {
        $query->where('area', $request->input('area_name'));
      }

      if (!empty($request->input('branch'))) {
        $query->where('log_stocktake_schedule.kode_cabang', $request->input('branch'));
      }
      if (empty($request->input('area_name')) && empty($request->input('branch'))) {
        $query->whereRaw('1 = 0');
      }

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->addColumn('action', function ($data) {
          $action = '';
          if ($data->status != "FINISH") {
            $action .= ' ' . get_button_edit(url('stock-take-schedule/' . $data->sto_id . '/edit'));
            $action .= ' ' . get_button_delete();
          }
          $action .= ' ' . get_button_view(url('stock-take-schedule/' . $data->sto_id), 'View Detail');
          if ($data->status != "FINISH") {
            $action .= ' ' . get_button_save('Finish', 'btn-finish');
          }
          return $action;
        });

      return $datatables->make(true);
    }

    return view('web.stock-take.stock-take-schedule.index');
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create(Request $request)
  {
    // sto_id = Kode Area/short description cabang-STO-Tanggal-Urutan
    // $kode = empty($request->input('area')) ? $request->input('kode_cabang') : $request->input('area');
    $prefix = '';
    $area   = null;
    $branch = null;

    if ($request->input('area') != 'null' && $request->input('area') != '') {
      $area = Area::where('code', $request->input('area'))->first();
      if (empty($area)) {
        return abort(404);
      }
      $prefix = $request->input('area');
    } else {
      $branch = MasterCabang::where('kode_cabang', $request->input('branch'))->first();
      if (empty($branch)) {
        return abort(404);
      }
      $prefix = $branch->short_description;
    }

    $sto_id = $prefix . '-STO-' . date('ymd') . '-';

    $prefix_length = strlen($sto_id);
    $max_no        = DB::select('SELECT MAX(SUBSTR(sto_id, ?)) AS max_no FROM log_stocktake_schedule WHERE SUBSTR(sto_id,1,?) = ? ', [$prefix_length + 2, $prefix_length, $sto_id])[0]->max_no;
    $max_no        = str_pad($max_no + 1, 3, 0, STR_PAD_LEFT);

    $data['stoScheduleID'] = $sto_id . $max_no;
    $data['area']          = $area;
    $data['branch']        = $branch;
    $data['max_no']        = $max_no;

    return view('web.stock-take.stock-take-schedule.create', $data);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $request->validate([
      'sto_id'              => 'unique:log_stocktake_schedule|max:18',
      'area'                => 'max:20',
      'branch'              => 'max:20',
      'description'         => 'max:100',
      'schedule_start_date' => 'nullable',
      'schedule_end_date'   => 'nullable',
      // 'file-stocktake-schedule'  => 'required',
    ]);

    $stockTakeSchedule = new StockTakeSchedule;

    // sto_id = Kode Area/short description cabang-STO-Tanggal-Urutan
    // $kode   = empty($request->input('area')) ? $request->input('kode_cabang') : $request->input('kode');
    // $sto_id = $kode . '-STO-' . date('ymd') . '-';

    // $prefix_length = strlen($sto_id);
    // $max_no        = DB::select('SELECT MAX(SUBSTR(sto_id, ?)) AS max_no FROM log_stocktake_schedule WHERE SUBSTR(sto_id,1,?) = ? ', [$prefix_length + 2, $prefix_length, $sto_id])[0]->max_no;
    // $max_no        = str_pad($max_no + 1, 3, 0, STR_PAD_LEFT);

    // $stockTakeSchedule->sto_id = $sto_id . $max_no;
    $stockTakeSchedule->sto_id = $request->input('sto_id');

    $stockTakeSchedule->area                = empty($request->input('area')) ? '' : $request->input('area');
    $stockTakeSchedule->kode_cabang         = !empty($request->input('kode_cabang')) ? $request->input('kode_cabang') : auth()->user()->cabang->kode_cabang;
    $stockTakeSchedule->description         = $request->input('description');
    $stockTakeSchedule->schedule_start_date = date('Y-m-d', strtotime($request->input('schedule_start_date')));
    $stockTakeSchedule->schedule_end_date   = date('Y-m-d', strtotime($request->input('schedule_end_date')));
    $stockTakeSchedule->urut                = $request->input('urut');
    $stockTakeSchedule->status                = 'aOpen';
    // $stockTakeSchedule->urut                = $max_no;

    if (date('Y-m-d', strtotime($request->input('schedule_start_date'))) < date("Y-m-d")) {
      return sendError('(Schedule Start Date can not be small than Today)');
    }

    if (empty($request->file('file-stocktake-schedule'))) {
      return sendError('Please select file!');
    }

    try {
      DB::beginTransaction();

      $stockTakeSchedule->save();

      // cek data file csv stock take schedule
      // bila tidak kosong ambil isinya
      if ($file_stocktake_schedule = $request->file('file-stocktake-schedule')) {
        // Baca file csv
        $file = fopen($file_stocktake_schedule, "r");

        $title             = true;
        $stocktake_details = [];

        $date = date('Y-m-d H:i:s');

        // Loop data sampai baris terakhir
        while (!feof($file)) {
          $row = fgetcsv($file);
          if ($title) {
            $title = false;
            continue; // Skip baris judul
          }

          if (!empty($row[0])) {
            $stockTakeDetail['sto_id']      = $request->input('sto_id');
            $stockTakeDetail['material_no'] = $row[0];
            $stockTakeDetail['qty']         = $row[1];
            $stockTakeDetail['created_at']  = $date;
            $stockTakeDetail['created_by']  = auth()->user()->id;
            $stocktake_details[]            = $stockTakeDetail;
          }
        }

        fclose($file);

        StockTakeScheduleDetail::insert($stocktake_details);
      }
      DB::commit();

      return $stockTakeSchedule;

    } catch (Exception $e) {
      DB::rollBack();
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show(Request $request, $sto_id)
  {
    $data['stockTakeSchedule'] = StockTakeSchedule::findOrFail($sto_id);

    if ($request->ajax()) {
      $query = $data['stockTakeSchedule']
        ->details()
        ->get();

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->addColumn('action', function ($data) {
          $action = '';
          $action .= ' ' . get_button_edit(url('stock-take-schedule/' . $data->sto_id . '/view-detail/' . $data->id . '/edit'));
          return $action;
        });

      return $datatables->make(true);
    }
    return view('web.stock-take.stock-take-schedule.detail', $data);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($sto_id)
  {
    $data['stockTakeSchedule'] = StockTakeSchedule::findOrFail($sto_id);
    $data['area']              = Area::where('area', $data['stockTakeSchedule']->area)->first();
    $data['branch']            = MasterCabang::where('kode_cabang', $data['stockTakeSchedule']->kode_cabang)->first();

    return view('web.stock-take.stock-take-schedule.edit', $data);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $sto_id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($sto_id)
  {
    try {
      DB::beginTransaction();

      $stockTakeSchedule = StockTakeSchedule::findOrFail($sto_id);
      $stockTakeSchedule->details()->delete();
      $stockTakeSchedule->delete();

      DB::commit();

      return true;

    } catch (Exception $e) {
      DB::rollBack();

      return false;
    }
  }

  public function finish($id)
  {
    $stockTakeSchedule         = StockTakeSchedule::findOrFail($id);
    $stockTakeSchedule->status = "FINISH";
    $stockTakeSchedule->save();

    return $stockTakeSchedule;
  }

  public function getSelect2Schedule(Request $request)
  {
    $query = StockTakeSchedule::select(
      DB::raw('sto_id AS id'),
      DB::raw("sto_id AS text"),
      'log_stocktake_schedule.schedule_start_date',
      'log_stocktake_schedule.schedule_end_date',
      'log_stocktake_schedule.description'
    )
      ->where('log_stocktake_schedule.status', '!=', 'FINISH')
      ->orderBy('created_at', 'desc')
    ;

    //$query->whereIn('kode_cabang', auth()->user()->getStringGrantCabang());

    if (auth()->user()->cabang->hq) {
      //$query->where('area', auth()->user()->area);
    } else {
      //$query->where('kode_cabang', auth()->user()->cabang->kode_cabang);
      $query->whereIn('kode_cabang', auth()->user()->getStringGrantCabang());
    }

    return get_select2_data($request, $query);
  }

}
