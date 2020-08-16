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
                $tabeldata .= '<tr><td>' . $value->userid . '</td><td>'. $value->first_name . '</td><td>'. ($value->status ? 'Active' : 'Not Active') . '</td><td>'. ($value->roles ? 'Admin' : 'User') . '</td></tr>';
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
    public function export(Request $request)
  {
    $query = UserScanner::select('wms_user_scanner.*','users.first_name','users.status')
      ->leftjoin ('users','users.username','=', 'wms_user_scanner.userid')
      ->leftjoin ('log_cabang','log_cabang.kode_customer','=', 'users.kode_customer')
      ->where ('kode_cabang', $request->input('cabang'))
      ->get();

    $reader      = new \PhpOffice\PhpSpreadsheet\Reader\Html();
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

    foreach ($query as $key => $value) {
      $reader->setSheetIndex($key);

      // echo $value->username . '<br>';
      $spreadsheet = $reader->loadFromString($this->getUserMobileTableData($value), $spreadsheet);

      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
    }

    $title = 'ReportUserMobile';

    if ($request->input('file_type') == 'pdf') {
      $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Mpdf');
      header('Content-Type: application/pdf');
      header('Content-Disposition: attachment;filename="' . $title . '.pdf"');
      header('Cache-Control: max-age=0');
    } else {
      $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment; filename="' . $title . '.xls"');
    }

    $writer->save("php://output");
  }
  protected function getUserMobileTableData($data)
  {
    
    $table = '';
    $table .= '<table  style="border-collapse: collapse; border: 1px solid black; width: 210mm;">';

    $table .= '<tr style="border: 1px solid black;">';
    $table .= '<th style="text-align: center; border: 1px solid black;">User Name</th>';
    $table .= '<th style="text-align: center; border: 1px solid black;">Name</th>';
    $table .= '<th style="text-align: center; border: 1px solid black;">Status</th>';
    $table .= '<th style="text-align: center; border: 1px solid black;">Privilage</th>';
    $table .= '</tr>';

    $table .= '<tr style="border: 1px solid black;">';
    $table .= '<td style="border: 1px solid black;">' . $data->userid . '</td>';
    $table .= '<td style="border: 1px solid black;">' . $data->first_name . '</td>';
    $table .= '<td style="border: 1px solid black;">' . ($data->status ? 'Active' : 'Not Active') . '</td>';
    $table .= '<td style="border: 1px solid black;">' . ($data->roles ? 'Admin' : 'User') . '</td>';
    $table .= '</tr>';

    $table .= '</table>';


    return $table;
  }
}


