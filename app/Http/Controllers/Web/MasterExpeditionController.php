<?php

namespace App\Http\Controllers\Web;

use App\Models\MasterExpedition;
use DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterExpeditionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        if ($request->ajax()) {
            $query = MasterExpedition::all();
      
            $datatables = DataTables::of($query)
              ->addIndexColumn() //DT_RowIndex (Penomoran)
              ->addColumn('action', function ($data) {
                $action = '';
                $action .= ' ' . get_button_edit(url('master-expedition/' . $data->code . '/edit'));
                $action .= ' ' . get_button_delete();
                return $action;
              });
      
            return $datatables->make(true);
          }
        return view ('web.master.master-expedition.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('web.master.master-expedition.create');
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
            'code'=>'required|unique:master_expedition|max:3',
            'expedition_name'=>'required|max:40',
            'sap_code'=>'required|max:6',
           
        ]);

        $masterExpedition                           = new MasterExpedition;
        $masterExpedition->code                     =$request->input('code');
        $masterExpedition->expedition_name          =$request->input('expedition_name');
        $masterExpedition->sap_code                 =$request->input('sap_code');
        $masterExpedition->address                  =$request->input('address');
        $masterExpedition->npwp                     =$request->input('npwp');
        $masterExpedition->contact_person           =$request->input('contact_person');
        $masterExpedition->phone1                   =$request->input('phone1');
        $masterExpedition->phone2                   =$request->input('phone2');
        $masterExpedition->fax                      =$request->input('fax');
        $masterExpedition->bank                     =$request->input('bank');
        $masterExpedition->currency                 =$request->input('currency');
        $masterExpedition->active                   =$request->has('active');

        return $masterExpedition->save();

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
        $data['masterExpedition'] = MasterExpedition::findorfail($id);
        return view('web.master.master-expedition.edit',$data);

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
            'code'=>'required|unique:master_expedition|max:3',
            'expedition_name'=>'required|max:40',
            'sap_code'=>'required|max:6',
            'address'=>'required|max:100',
            'npwp'=>'required|max:20',
            'contact_person'=>'required|max:25',
            'phone1'=>'required|max:12',
            'phone2'=>'required|max:12',
            'fax'=>'required|max:12',
            'bank'=>'required',
            'currency'=>'required',
            'active'=>'required'
        ]);

        $masterExpedition                           =MasterExpedition::findorfai($id);
        $masterExpedition->code                     =$request->input('code');
        $masterExpedition->expedition_name          =$request->input('expedition_name');
        $masterExpedition->sap_code                 =$request->input('sap_code');
        $masterExpedition->address                  =$request->input('address');
        $masterExpedition->npwp                     =$request->input('npwp');
        $masterExpedition->contact_person           =$request->input('contact_person');
        $masterExpedition->phone1                   =$request->input('phone1');
        $masterExpedition->phone2                   =$request->input('phone2');
        $masterExpedition->fax                      =$request->input('fax');
        $masterExpedition->bank                     =$request->input('bank');
        $masterExpedition->currency                 =$request->input('currency');
        $masterExpedition->active                   =$request->has('active');
        
        return $masterExpedition->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return MasterExpedition::destroy($id);
    }
}
