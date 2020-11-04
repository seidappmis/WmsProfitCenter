<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;

class SummaryLMBReportController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {

      $tabeldata = $this->getTableData($request);

      // return $query;

      $result = [
        'data'            => [
          ['tabeldata' => $tabeldata],
        ],
        'draw'            => 0,
        'recordsFiltered' => 0,
        'recordsTotal'    => 0,
      ];

      return $result;
    }

    return view('web.report.summary-lmb-report.index');
  }

  public function export(Request $request)
  {

    $table = $this->getTableData($request);
    // Request FILE EXCEL
    $title = 'REPORT SUMMARY LMB';

    if ($request->input('file_type') == 'pdf') {
      $mpdf = new \Mpdf\Mpdf(['tempDir' => '/tmp',
        'margin_left'                     => 7,
        'margin_right'                    => 12,
        'margin_top'                      => 5,
        'margin_bottom'                   => 5,
        'format'                          => 'A4',
      ]);
      $mpdf->shrink_tables_to_fit = 1;
      $mpdf->WriteHTML($table);

      $mpdf->Output($title . '.pdf', "D");
    } else {
      $reader      = new \PhpOffice\PhpSpreadsheet\Reader\Html();
      $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

      $spreadsheet = $reader->loadFromString($table, $spreadsheet);

      $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment; filename="' . $title . '.xls"');
    }

    $writer->save("php://output");
  }

  protected function getTableData($request)
  {
    $sql = "
    SELECT
        lc.kode_customer
        , lc.short_description as nama_cabang
        , CONCAT(wph.vehicle_number,' / ', wph.expedition_code) AS vehicle_number_expedition
        , wlh.lmb_date
        , wph.picking_no
        , wph.picking_date
        , wld.model
        , GROUP_CONCAT(wld.serial_number ORDER BY wld.serial_number) as rs_serial_number
      FROM wms_lmb_detail wld
      LEFT JOIN wms_lmb_header wlh ON wlh.driver_register_id = wld.driver_register_id
      LEFT JOIN wms_pickinglist_header wph ON wph.id = wld.picking_id
      LEFT JOIN log_cabang lc ON lc.kode_cabang = wph.kode_cabang
      WHERE wlh.lmb_date IS NOT NULL
      AND wph.kode_cabang = ?
      AND wph.picking_date >= ?
      AND wph.picking_date <= ?
    ";

    $params = [
      $request->input('kode_cabang'),
      $request->input('picking_date_start'),
      $request->input('picking_date_end'),
    ];

    if (!empty($request->input('picking_no'))) {
      $sql .= ' AND wph.picking_no = ?';

      $params[] = $request->input('picking_no');
    }

    if (!empty($request->input('lmb_date_start'))) {
      $sql .= ' AND wlh.lmb_date >= ?';

      $params[] = $request->input('lmb_date_start');
    }

    if (!empty($request->input('lmb_date_end'))) {
      $sql .= ' AND wlh.lmb_date <= ?';

      $params[] = $request->input('lmb_date_end');
    }



    if (!empty($request->input('model'))) {
      $sql .= ' AND wld.model = ?';

      $params[] = $request->input('model');
    }

    $sql .= ' GROUP BY wld.picking_id, wld.model ORDER BY wld.picking_id, wld.model, wld.serial_number ';

    $query = DB::select(DB::raw($sql), $params);

    // return $query;

    $rs_summary_temp = [];
    $group           = 1;

    foreach ($query as $key => $value) {
      $rs_serial_number = explode(',', $value->rs_serial_number);
      // return $rs_serial_number;
      $summary = [];
      foreach ($rs_serial_number as $ks => $vs) {
        $previousSequence = false;

        if (!empty($summary['fromsn'])) {
          $previousSN = !empty($summary['tosn']) ? $summary['tosn'] : $summary['fromsn'];
          $previousSN++;

          if ($previousSN == $vs) {
            $previousSequence = true;
            $tosn             = $vs;
          } else {
            $previousSequence = false;
          }

          // return $summary['fromsn'];
        }

        if ($previousSequence) {
          $summary['tosn'] = $tosn;
          $summary['totalsn'] += 1;
          // return $summary;
        } else {

          $summary = [];

          $summary['fromsn']  = $vs;
          $summary['tosn']    = '';
          $summary['totalsn'] = 1;
        }

        $summary['kode_customer']             = $value->kode_customer;
        $summary['nama_cabang']               = $value->nama_cabang;
        $summary['vehicle_number_expedition'] = $value->vehicle_number_expedition;
        $summary['lmb_date']                  = $value->lmb_date;
        $summary['picking_no']                = $value->picking_no;
        $summary['picking_date']              = $value->picking_date;
        $summary['model']                     = $value->model;

        $rs_summary_temp[$summary['picking_no']][$summary['model']][$summary['fromsn']] = $summary;
        // if (!$previousSequence) {
        // }

      }
      // return $rs_serial_number;
      // $rs_summary_temp[$value->picking_no][$value->model][] = $value;
    }

    $tabeldata = '';
    // $tabeldata .= '<h4 style="text-align: center;">Report Summary LMB</h4>';
    $tabeldata .= '<html>';
    $tabeldata .= '<head>';
    if ($request->input('file_type') == 'pdf') {
      $tabeldata .= '<link rel="stylesheet" type="text/css" href="' . url('materialize/css/custom/print1-a4.css') . '">';
    }
    $tabeldata .= '</head>';
    $tabeldata .= '<body>';

    $tabeldata .= '<table>';
    $tabeldata .= '<tr style="border: none;"><td colspan="10" style="border: none; font-size: 16pt;">PT. SHARP ELECTRONICS INDONESIA</td></tr>';
    $tabeldata .= '<tr style="border: none;"><td colspan="10" style="text-align: center; border: none; font-size: 16pt;">REPORT SUMMARY LMB</td></tr>';
    $tabeldata .= '<tr style="text-align: center;"><th style="text-align: center;" rowspan="2">Branch Code</th><th style="text-align: center;" rowspan="2">Branch</th><th style="text-align: center;" rowspan="2">Vehicle No <br>Expedition Code</th><th style="text-align: center;" rowspan="2">Date of LMB</th><th style="text-align: center;" rowspan="2">Picking List No.</th><th style="text-align: center;" rowspan="2">Date of PL</th><th style="text-align: center;" rowspan="2">Model</th><th style="text-align: center;" colspan="2">SN</th><th style="text-align: center;" rowspan="2">QTY</th></tr>';
    $tabeldata .= '<tr><th style="text-align: center;">FROM</th><th style="text-align: center;">TO</th><tr>';

    foreach ($rs_summary_temp as $kpicking => $vpicking) {
      foreach ($vpicking as $kmodel => $vmodel) {
        $totalsn = 0;
        foreach ($vmodel as $key => $value) {
          $totalsn += $value['totalsn'];
          $tabeldata .= '<tr>';
          $tabeldata .= '<td>' . $value['kode_customer'] . '</td>';
          $tabeldata .= '<td>' . $value['nama_cabang'] . '</td>';
          $tabeldata .= '<td>' . $value['vehicle_number_expedition'] . '</td>';
          $tabeldata .= '<td>' . $value['lmb_date'] . '</td>';
          $tabeldata .= '<td>' . $value['picking_no'] . '</td>';
          $tabeldata .= '<td>' . $value['picking_date'] . '</td>';
          $tabeldata .= '<td>' . $value['model'] . '</td>';
          $tabeldata .= '<td>' . $value['fromsn'] . '</td>';
          $tabeldata .= '<td>' . $value['tosn'] . '</td>';
          $tabeldata .= '<td style="text-align: right;">' . $value['totalsn'] . '</td>';
          $tabeldata .= '</tr>';
        }
        $tabeldata .= '<tr>';
        $tabeldata .= '<td colspan="9" style="text-align: right;"><strong>' . $kmodel . '</strong></td>';
        $tabeldata .= '<td style="text-align: right;"><strong>' . $totalsn . '</strong></td>';
        $tabeldata .= '</tr>';
      }
    }

    $tabeldata .= '</table>';
    $tabeldata .= '</body>';
    $tabeldata .= '</html>';

    return $tabeldata;
  }
}
