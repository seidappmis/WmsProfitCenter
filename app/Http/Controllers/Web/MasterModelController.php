<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\MasterModel;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MasterModelController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		if ($request->ajax()) {
			$query = MasterModel::select(
				'wms_master_model.*',
				DB::raw('wms_model_material_group.description AS material_group_description')
			)
			->leftjoin('wms_model_material_group', 'wms_model_material_group.code', '=',
			'wms_master_model.material_group');

			$datatables = DataTables::of($query)
				->addIndexColumn() //DT_RowIndex (Penomoran)
				->editColumn('cbm', function($data){
					return setDecimal($data->cbm);
				})
				->addColumn('action', function ($data) {
					$action = '';
					//if (auth()->user()->allowTo('edit')) {
						$action .= ' ' . get_button_edit(url('master-model/' . $data->id . '/edit'));
					//}
					//if (auth()->user()->allowTo('delete')) {
						$action .= ' ' . get_button_delete();
					//}
					return $action;
				});

			return $datatables->make(true);
		}
		return view('web.master.master-model.index');
	}

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('web.master.master-model.create');
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
      'model_name'       => 'required|unique:wms_master_model|max:50',
      'model_from_apbar' => 'max:50',
      'ean_code'         => 'required|max:50',
      'cbm'              => 'required',
      'material_group'   => 'required',
      'category'         => 'required',
      'model_type'       => 'required',
      'description'      => 'max:250',
      // 'pcs_ctn'          => 'numeric',
      // 'ctn_plt'          => 'numeric',
      // 'max_pallet'       => 'numeric',
      // 'price1'           => 'numeric',
      // 'price2'           => 'numeric',
      // 'price3'           => 'numeric',
    ]);

    $masterModel                   = new MasterModel;
    $masterModel->model_name       = $request->input('model_name');
    $masterModel->model_from_apbar = $request->input('model_from_apbar');
    $masterModel->ean_code         = $request->input('ean_code');
    $masterModel->cbm              = $request->input('cbm');
    $masterModel->material_group   = $request->input('material_group');
    $masterModel->category         = $request->input('category');
    $masterModel->model_type       = $request->input('model_type');
    $masterModel->description      = $request->input('description');
    $masterModel->pcs_ctn          = $request->input('pcs_ctn');
    $masterModel->ctn_plt          = $request->input('ctn_plt');
    $masterModel->max_pallet       = $request->input('max_pallet');
    $masterModel->price1           = $request->input('price1');
    $masterModel->price2           = $request->input('price2');
    $masterModel->price3           = $request->input('price3');
    $masterModel->price_carton_box = $request->input('price_carton_box');

    return $masterModel->save();
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function proses_upload(Request $request)
  {
    $request->validate([
      'file-master-model' => 'required',
    ]);

    $file = fopen($request->file('file-master-model'), "r");

    $title         = true;
    $master_models = [];
    $rs_ean        = [];

    $date = date('Y-m-d H:i:s');

    while (!feof($file)) {
      $row = fgetcsv($file);
      if ($title) {
        $title = false;
        continue; // Skip baaris judul
      }

      if (!empty($row[0])) {
        $master_model = [
          'model_name'       => $row[0],
          'model_from_apbar' => $row[1],
          'ean_code'         => $row[2],
          'cbm'              => $row[3],
          'material_group'   => $row[4],
          'category'         => $row[5],
          'model_type'       => $row[6],
          'pcs_ctn'          => $row[7],
          'ctn_plt'          => $row[8],
          'max_pallet'       => $row[9],
          'description'      => $row[10],
          'price1'           => $row[11],
          'price2'           => $row[12],
          'price3'           => $row[13],
        ];

        $rs_ean[] = $master_model['ean_code'];

        $master_model['created_at'] = $date;
        $master_model['created_by'] = auth()->user()->id;
        $master_models[]            = $master_model;
      }

    }
    // Cek apakah data pernah diupload
    $cek_model = MasterModel::whereIn('ean_code', $rs_ean)->get();

    if ($cek_model->count() > 0) {
      // kalau ada data yang sudah diupload return
      return sendError('Data Already Upload', $cek_model);
    }
    // Akhir cek data

    fclose($file);

    MasterModel::insert($master_models);

    return true;
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $data['masterModel'] = MasterModel::findOrFail($id);

    return view('web.master.master-model.edit', $data);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $request->validate([
      'model_name'       => 'required|max:50',
      'model_from_apbar' => 'max:50',
      'ean_code'         => 'required|max:50',
      'cbm'              => 'required',
      'material_group'   => 'required',
      'category'         => 'required',
      'model_type'       => 'required',
      'description'      => 'max:250',
      'pcs_ctn'          => 'numeric',
      'ctn_plt'          => 'numeric',
      'max_pallet'       => 'numeric',
      'price1'           => 'numeric',
      'price2'           => 'numeric',
      'price3'           => 'numeric',
    ]);

    $masterModel = MasterModel::findOrFail($id);
    if (!$masterModel->isUsed()) {
      $masterModel->model_name = $request->input('model_name');
      $masterModel->ean_code   = $request->input('ean_code');
    }
    $masterModel->model_from_apbar = $request->input('model_from_apbar');
    $masterModel->cbm              = $request->input('cbm');
    $masterModel->material_group   = $request->input('material_group');
    $masterModel->category         = $request->input('category');
    $masterModel->model_type       = $request->input('model_type');
    $masterModel->description      = $request->input('description');
    $masterModel->pcs_ctn          = $request->input('pcs_ctn');
    $masterModel->ctn_plt          = $request->input('ctn_plt');
    $masterModel->max_pallet       = $request->input('max_pallet');
    $masterModel->price1           = $request->input('price1');
    $masterModel->price2           = $request->input('price2');
    $masterModel->price3           = $request->input('price3');
    $masterModel->price_carton_box = $request->input('price_carton_box');

    return $masterModel->save();
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    return MasterModel::destroy($id);
  }

  public function getSelect2Model2(Request $request)
  {
    $query = MasterModel::select(
      DB::raw('model_name AS id'),
      DB::raw('model_name AS text')
    )->toBase();

    return get_select2_data($request, $query);
  }

  public function getSelect2Model(Request $request)
  {
    $query = MasterModel::select(
      DB::raw('model_name AS id'),
      DB::raw('model_name AS text'),
      'wms_master_model.*'
    );

    return get_select2_data($request, $query);
  }

  public function getSelect2ModelSloc(Request $request)
  {
    $query = MasterModel::select(
      DB::raw('wms_master_model.id AS id'),
      DB::raw('wms_master_model.model_name AS text'),
      'wms_master_model.*',
      'wms_inventory_storage.quantity_total'
    )
      ->leftJoin('wms_inventory_storage', function ($join) use ($request) {
        $join->on('wms_inventory_storage.model_name', '=', 'wms_master_model.model_name')->where('wms_inventory_storage.storage_id', '=', $request->input('sloc'));
        // $join->on('wms_inventory_storage.storage_id', '>', 1);
      });

    return get_select2_data($request, $query);
  }

  /**
   * Show the application dataAjax.
   *
   * @return \Illuminate\Http\Response
   */
  public function getSelect2MaterialGroup(Request $request)
  {
    $query = \App\Models\ModelMaterialGroup::select(
      DB::raw('code AS id'),
      DB::raw('description AS text')
    );

    return get_select2_data($request, $query);
  }

  /**
   * Show the application dataAjax.
   *
   * @return \Illuminate\Http\Response
   */
  public function getSelect2Category(Request $request)
  {
    $query = \App\Models\ModelCategory::select(
      DB::raw('category_name AS id'),
      DB::raw('category_name AS text')
    );

    return get_select2_data($request, $query);
  }

  /**
   * Show the application dataAjax.
   *
   * @return \Illuminate\Http\Response
   */
  public function getSelect2ModelType(Request $request)
  {
    $query = \App\Models\ModelType::select(
      DB::raw('model_type AS id'),
      DB::raw('model_type_desc AS text')
    );

    return get_select2_data($request, $query);
  }
}
