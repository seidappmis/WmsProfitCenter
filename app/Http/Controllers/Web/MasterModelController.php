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
            ->addColumn('action', function ($data) {
              $action = '';
              $action .= ' ' . get_button_edit(url('master-model/' . $data->id . '/edit'));
              $action .= ' ' . get_button_delete();
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
          'model_name'        => 'required|max:50',
          'model_from_apbar'  => 'max:50',
          'ean_code'          => 'required|max:50',
          'cbm'               => 'required',
          'material_group'    => 'required',
          'category'          => 'required',
          'model_type'        => 'required',
          'description'       => 'max:250',
          'pcs_ctn'           => 'numeric',
          'ctn_plt'           => 'numeric',
          'max_pallet'        => 'numeric',
          'price1'            => 'numeric',
          'price2'            => 'numeric',
          'price3'            => 'numeric',
        ]);

        $masterModel                   = new MasterModel;
        $masterModel->model_name       = $request->input('model_name' );
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
        'file-master-model' => 'required'
      ]);

      $file = fopen($request->file('file-master-model'), "r");

      $title          = true;
      $master_models   = [];
      // $rs_destination = [];
      // $rs_expedition  = [];

      while (!feof($file)) {
        $row = fgetcsv($file);
        if ($title) {
          $title = false;
          continue;
        }
        $master_models = [
          'id'              => $masterModel->id,
          'model_name'      => $row[1],
          'ean_code'        => $row[2],
          'cbm'             => $row[3],
          'material_group'  => $row[4],
          'category'        => $row[5],
          'model_type'      => $row[6],
          'pcs_ctn'         => $row[7],
          'ctn_plt'         => $row[8],
          'max_pallet'      => $row[9],
          'description'     => $row[10],
          'price1'          => $row[11],
          'price2'          => $row[12],
          'price3'          => $row[13],
        ];

        if (!empty($master_models['ean_code'])) {
          // kalau data ada isinya

          // find destination bila belum ada di rs_destination
          // cari di database, bila sudah ada tidak perlu cari di database
          if (empty($rs_destination[$concept['destination_name']])) {
            $destination = MasterDestination::where('description', $concept['destination_name'])->first();
            if (empty($destination)) {
              $result['status']  = false;
              $result['message'] = 'Destination not found in master destination !';
              return $result;
            }

            $rs_destination[$concept['destination_name']] = $destination->destination_number;
          }

          // cari expedition
          if (empty($rs_expedition[$concept['expedition_code']])) {
            $expedition = MasterExpedition::where('sap_vendor_code', $concept['expedition_code'])->first();
            if (empty($expedition)) {
              $result['status']  = false;
              $result['message'] = 'EXPEDITION CODE ' . $concept['expedition_code'] . ' not found in SAP Vendor Code : master expedition !';
              return $result;
            }

            $rs_expedition[$concept['expedition_code']] = $expedition->id;
          }

          $concept['destination_number'] = $rs_destination[$concept['destination_name']];
          $concept['expedition_id']      = $rs_expedition[$concept['expedition_code']];

          $concepts[] = $concept;
        }
      }

      return $concepts;
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
          'model_name'        => 'required|max:50',
          'model_from_apbar'  => 'max:50',
          'ean_code'          => 'required|max:50',
          'cbm'               => 'required',
          'material_group'    => 'required',
          'category'          => 'required',
          'model_type'        => 'required',
          'description'       => 'max:250',
          'pcs_ctn'           => 'numeric',
          'ctn_plt'           => 'numeric',
          'max_pallet'        => 'numeric',
          'price1'            => 'numeric',
          'price2'            => 'numeric',
          'price3'            => 'numeric',
        ]);

        $masterModel                   = MasterModel::findOrFail($id);
        $masterModel->model_name       = $request->input('model_name' );
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

    public function getSelect2Model(Request $request)
    {
        $query = MasterModel::select(
          DB::raw('model_name AS id'),
          DB::raw('model_name AS text'),
          'wms_master_model.*'
        );

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
