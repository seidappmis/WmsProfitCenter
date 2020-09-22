<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class ReportKPIExpeditionsController extends Controller
{
  public function index(Request $request)
  {

    if ($request->ajax()) {
      $year  = '';
      $month = '';

      if (!empty($request->input('periode'))) {
        $periode = Carbon::createFromFormat('d/m/Y', '01/' . $request->input('periode'));

        $year  = $periode->format('Y');
        $month = $periode->format('m');
      }

      $query = DB::select("
        SELECT
        c.expedition_name,
        COUNT(delivery_no) AS sum_of_concept,
        IF(ISNULL(achieve), 0, achieve) AS achieve,
        (COUNT(delivery_no) - IF(ISNULL(achieve), 0, achieve)) AS non_achive
        FROM tr_concept c
        LEFT JOIN(
          SELECT
          tc.expedition_name,
          COUNT(tc.delivery_no) AS achieve,
           tc.`created_at`, t.`complete_date`
          FROM tr_concept tc
          LEFT JOIN (
            SELECT
            fd.`invoice_no`, fd.`delivery_no`, fd.`delivery_items`, tf.complete_date
            FROM tr_concept_flow_detail fd
            LEFT JOIN tr_concept_truck_flow tf ON fd.`id_header` = tf.`concept_flow_header`
            WHERE YEAR(tf.complete_date) = ? AND MONTH(tf.complete_date) = ? AND tf.`area` = ?
          ) t ON t.invoice_no = tc.`invoice_no` AND t.delivery_no = tc.`delivery_no` AND tc.`delivery_items` = t.delivery_items AND (TIMESTAMPDIFF(DAY, tc.`created_at`, t.`complete_date`) > 2)
          WHERE tc.expedition_id IS NOT NULL AND YEAR(tc.created_at) = ? AND MONTH(tc.created_at) = ? AND tc.`area` = ? AND t.invoice_no IS NOT NULL
          GROUP BY tc.`expedition_name`
        ) ct ON ct.expedition_name = c.`expedition_name`
        WHERE YEAR(c.created_at) = ? AND MONTH(c.created_at) = ? AND c.`area` = ?
        GROUP BY c.`expedition_name`
        ", [
        $year,
        $month,
        $request->input('area'),
        $year,
        $month,
        $request->input('area'),
        $year,
        $month,
        $request->input('area'),
      ])

      ;

      $tabeldata = '';
      $tabeldata .= '<div style="text-align: center; font-size: 14pt;"><strong>Fleet Capablility - Area : ' . $request->input('area') . ' (' . date('Y-m-d H:i:s') . ')</strong></div>';
      $tabeldata .= '<table>';
      $tabeldata .= '<tr>';
      $tabeldata .= '<th style="text-align: center;">EXPEDITION NAME</th>';
      $tabeldata .= '<th style="text-align: center;">Non Achieve</th>';
      $tabeldata .= '<th style="text-align: center;">Acheive</th>';
      $tabeldata .= '<th style="text-align: center;">Sum Of Concept</th>';
      $tabeldata .= '<th style="text-align: center;" colspan="2">(%)</th>';
      $tabeldata .= '<th style="text-align: center;">Total</th>';
      $tabeldata .= '</tr>';

      foreach ($query as $key => $value) {
        $tabeldata .= '<tr>';
        $tabeldata .= '<td>' . $value->expedition_name . '</td>';
        $tabeldata .= '<td>' . $value->non_achive . '</td>';
        $tabeldata .= '<td>' . $value->achieve . '</td>';
        $tabeldata .= '<td>' . $value->sum_of_concept . '</td>';
        $tabeldata .= '<td>' . ($value->achieve / $value->sum_of_concept * 100) . ' %</td>';
        $tabeldata .= '<td>' . ($value->non_achive / $value->sum_of_concept * 100) . ' %</td>';
        $tabeldata .= '<td>' . ($value->sum_of_concept / $value->sum_of_concept * 100) . ' %</td>';
        $tabeldata .= '</tr>';
      }

      $tabeldata .= '</table>';

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
    return view('web.report.report-kpi-expeditions.index');
  }
}
