<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\MasterArea;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterAreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
          $query = MasterArea::all();

          $datatables = DataTables::of($query)
            ->addIndexColumn() //DT_RowIndex (Penomoran)
            ->addColumn('action', function ($data) {
              $action = '';
              $action .= ' ' . get_button_edit(url('master-area/' . $data->code . '/edit'));
              $action .= ' ' . get_button_delete();
              return $action;
            });

          return $datatables->make(true);
        }
        return view('web.settings.master-area.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('web.settings.master-area.create');
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
          'code'       => 'unique:master_areas|max:10',
          'area'       => 'max:100',
        ]);

        $masterArea            = new MasterArea;
        $masterArea->code      = $request->input('code');
        $masterArea->area      = $request->input('area');

        return $masterArea->save();
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
        $data['masterArea'] = MasterArea::findOrFail($id);

        return view('web.settings.master-area.edit', $data);
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
          'code'       => 'max:10',
          'area'       => 'max:100',
        ]);

        $masterArea            = MasterArea::findOrFail($id);
        $masterArea->code      = $request->input('code');
        $masterArea->area      = $request->input('area');

        return $masterArea->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return MasterArea::destroy($id);
    }

    /**
   * Show the application dataAjax.
   *
   * @return \Illuminate\Http\Response
   */
    public function getSelect2Area(Request $request)
    {
        $query = MasterArea::select(
          DB::raw('code AS id'),
          DB::raw('area AS text')
        );

        return get_select2_data($request, $query);
    }
}
