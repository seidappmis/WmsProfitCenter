<?php
namespace Database\Seeds\Masters;

use DB;
use Illuminate\Database\Seeder;

class TRWorkflowTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $file = fopen('database/seeds/source_files/tr_workflow.csv', "r");

    $workflows = [];

    while (!feof($file)) {
      $row = fgetcsv($file);

      $workflow['id']                         = $row[0];
      $workflow['step_number']                = $row[1];
      $workflow['step_description']           = $row[2];
      $workflow['step_condition_explanation'] = $row[3];
      $workflow['finished']                   = $row[4];
      $workflow['formname']                   = $row[5];

      if (!empty($workflow['id'])) {
        $workflows[] = $workflow;
      }
    }

    fclose($file);

    DB::table('tr_workflow')->insert($workflows);
  }
}
