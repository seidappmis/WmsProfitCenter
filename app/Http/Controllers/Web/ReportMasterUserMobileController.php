<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\UserScanner;
use DB;
use App\User;
use App\Models\MasterCabang;
use DataTables;
use Illuminate\Http\Request;


class ReportMasterUserMobileController extends Controller
{
    public function index(Request $request){
        if ($request->ajax()) {
            $query = UserScanner::select('wms_user_scanner.*','users.first_name','users.status')
            ->leftjoin ('users','users.username','=', 'wms_user_scanner.userid')
            ->leftjoin ('log_cabang','log_cabang.kode_customer','=', 'users.kode_customer')
            ->where ('kode_cabang', $request->input('cabang'))
            ->where ('roles_id',$request->input('role'))
            ->where ('status',$request->input('userStatus'))
            ;

            if(!empty($request->input('role')))
                $query->where ('roles_id',$request->input('role'));
            if(!empty($request->input('userStatus')))
                $query->where('status',$request->input('userStatus'));

            $tabeldata ='';
            $tabeldata .= '<h4 style="text-align: center;">Report User Mobile</h4>';
            $tabeldata .= '<table>';
            $tabeldata .= '<tr><th>Username</th><th>name</th><th>Status</th><th>Privilage</th></tr>';

            foreach($query->get() AS $key => $value){
                $tabeldata .= '<tr><td>' . $value->userid . '</td><td>'. $value->first_name . '</td><td>'. $value->status . '</td><td>'. $value->roles . '</td></tr>';
            }

            $tabeldata .= '</table>';

      
            $result=[
                // 'data' => [
                //     [
                //         'tabeldata' => '<table>
                //             <tr><th>Bobby</th><th>Sevri</th></tr>
                            
                //             <tr><td>asdf</td><td>asdfewer</td></tr>
                //             <tr><td>asdf</td><td>asdfewer</td></tr>
                //             </table>'
                //     ]
                // ],
                'data' => [ 
                    ['tabeldata' => $tabeldata] 
                ],
                'draw' => 0,
                'recordsFiltered' => 0,
                'recordsTotal' => 0
            ];
      
            return $result;
          }
          return view('web.report.report-user-mobile.index');
    }
}

