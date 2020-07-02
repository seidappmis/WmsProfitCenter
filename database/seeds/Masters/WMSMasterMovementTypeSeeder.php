<?php
namespace Database\Seeds\Masters;

use DB;
use Illuminate\Database\Seeder;

class WMSMasterMovementTypeSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('wms_master_movement_type')->insert([
      [
        'id'                 => 3,
        'group_id'           => '001',
        'transactions'       => 'RECEIVE FROM',
        'movement_code'      => '101',
        'action'             => 'INCREASE',
        'action_description' => 'Add Stock from OEM/IMPORT/OTHERS',
        'from_desc'          => 'INPUT',
        'to_desc'            => 'STORAGE LOCATION',
        'modul_name'         => 'Incoming Manual',
      ],
      [
        'id'                 => 4,
        'group_id'           => '001',
        'transactions'       => 'INCOMING CANCEL',
        'movement_code'      => '102',
        'action'             => 'DECREASE',
        'action_description' => 'Reverse [NO_TRANS]',
        'from_desc'          => 'STORAGE LOCATION',
        'to_desc'            => '-',
        'modul_name'         => 'Incoming Manual'
      ],
      [
        'id'                 => 5,
        'group_id'           => '002',
        'transactions'       => '(HQ) INCOMING FROM PRODUCTION',
        'movement_code'      => '101',
        'action'             => 'INCREASE',
        'action_description' => 'Add Stock from Production',
        'from_desc'          => 'APP BARCODE PRODUCTION',
        'to_desc'            => 'STORAGE LOCATION',
        'modul_name'         => 'Finish Good Production'
      ],
      [
        'id'                 => 6,
        'group_id'           => '002',
        'transactions'       => '(HQ) INCOMING CANCEL',
        'movement_code'      => '102',
        'action'             => 'DECREASE',
        'action_description' => 'Reverse [NO_TRANS]',
        'from_desc'          => 'STORAGE LOCATION',
        'to_desc'            => '-',
        'modul_name'         => 'Finish Good Production'
      ],
      [
        'id'                 => 7,
        'group_id'           => '003',
        'transactions'       => 'OUTGOING FROM HQ TO SLOC INTRANSIT',
        'movement_code'      => '101',
        'action'             => 'INCREASE',
        'action_description' => 'LMB Outgoing (Menambah SLOC Intransit)',
        'from_desc'          => 'STORAGE LOCATION',
        'to_desc'            => 'SLOC INTRANSIT',
        'modul_name'         => 'Picking List to LMB'
      ],
      [
        'id'                 => 8,
        'group_id'           => '003',
        'transactions'       => 'OUTGOING FROM HQ TO SLOC INTRANSIT',
        'movement_code'      => '647',
        'action'             => 'DECREASE',
        'action_description' => 'LMB Outgoing (Mengurangi SLOC)',
        'from_desc'          => 'STORAGE LOCATION',
        'to_desc'            => 'SLOC INTRANSIT',
        'modul_name'         => 'Picking List to LMB'
      ],
      [
        'id'                 => 9,
        'group_id'           => '004',
        'transactions'       => 'INCOMING BRANCH/HQ FROM HQ/BRANCH',
        'movement_code'      => '9X5',
        'action'             => 'INCREASE',
        'action_description' => 'DO  Confirm (Menambah SLOC)',
        'from_desc'          => 'SLOC INTRANSIT',
        'to_desc'            => 'STORAGE LOCATION',
        'modul_name'         => 'Confirm Manifest'
      ],
      [
        'id'                 => 10,
        'group_id'           => '004',
        'transactions'       => 'INCOMING BRANCH/HQ FROM HQ/BRANCH',
        'movement_code'      => '9X5',
        'action'             => 'DECREASE',
        'action_description' => 'DO  Confirm (Mengurangi SLOC Intransit)',
        'from_desc'          => 'SLOC INTRANSIT',
        'to_desc'            => 'STORAGE LOCATION',
        'modul_name'         => 'Confirm Manifest'
      ],
      [
        'id'                 => 11,
        'group_id'           => '005',
        'transactions'       => 'INCOMING BRANCH FROM HQ CANCEL',
        'movement_code'      => '9X6',
        'action'             => 'INCREASE',
        'action_description' => 'Cancel Confirm (Menambah SLOC Intransit)',
        'from_desc'          => 'STORAGE LOCATION',
        'to_desc'            => 'SLOC INTRANSIT',
        'modul_name'         => 'Cancel Movement'
      ],
      [
        'id'                 => 12,
        'group_id'           => '005',
        'transactions'       => 'INCOMING BRANCH FROM HQ CANCEL',
        'movement_code'      => '9X6',
        'action'             => 'DECREASE',
        'action_description' => 'Cancel Confirm (Mengurrangi SLOC)',
        'from_desc'          => 'STORAGE LOCATION',
        'to_desc'            => 'SLOC INTRANSIT',
        'modul_name'         => 'Cancel Movement'
      ],
      [
        'id'                 => 13,
        'group_id'           => '006',
        'transactions'       => 'OUTGOING FROM HQ TO SLOC INTRANSIT CANCEL',
        'movement_code'      => '102',
        'action'             => 'DECREASE',
        'action_description' => 'Cancel Outgoing',
        'from_desc'          => 'SLOC INTRANSIT',
        'to_desc'            => 'STORAGE LOCATION',
        'modul_name'         => 'Cancel Movement'
      ],
      [
        'id'                 => 14,
        'group_id'           => '006',
        'transactions'       => 'OUTGOING FROM HQ TO SLOC INTRANSIT CANCEL',
        'movement_code'      => '648',
        'action'             => 'INCREASE',
        'action_description' => 'Cancel Outgoing',
        'from_desc'          => 'SLOC INTRANSIT',
        'to_desc'            => 'STORAGE LOCATION',
        'modul_name'         => 'Cancel Movement'
      ],
      [
        'id'                 => 16,
        'group_id'           => '007',
        'transactions'       => 'OUTGOING HQ / BRANCH TO SLOC INTRANSIT DS',
        'movement_code'      => '9Z3',
        'action'             => 'INCREASE',
        'action_description' => 'LMB Outgoing',
        'from_desc'          => 'STORAGE LOCATION',
        'to_desc'            => 'SLOC INTRANSIT',
        'modul_name'         => 'Picking List To LMB'
      ],
      [
        'id'                 => 17,
        'group_id'           => '007',
        'transactions'       => 'OUTGOING HQ / BRANCH TO SLOC INTRANSIT',
        'movement_code'      => '9Z3',
        'action'             => 'DECREASE',
        'action_description' => 'LMB Outgoing',
        'from_desc'          => 'STORAGE LOCATION',
        'to_desc'            => 'SLOC INTRANSIT',
        'modul_name'         => 'Picking List To LMB'
      ],
      [
        'id'                 => 18,
        'group_id'           => '008',
        'transactions'       => 'OUTGOING HQ / BRANCH TO SLOC INTRANSIT DS CANCEL',
        'movement_code'      => '9Z4',
        'action'             => 'DECREASE',
        'action_description' => 'Cancel Outgoing',
        'from_desc'          => 'SLOC INTRANSIT',
        'to_desc'            => 'SLOC LOCATION',
        'modul_name'         => 'Cancel Movement'
      ],
      [
        'id'                 => 19,
        'group_id'           => '008',
        'transactions'       => 'OUTGOING HQ / BRANCH TO SLOC INTRANSIT DS CANCEL',
        'movement_code'      => '9Z4',
        'action'             => 'INCREASE',
        'action_description' => 'Cancel Outgoing',
        'from_desc'          => 'SLOC INTRANSIT',
        'to_desc'            => 'SLOC LOCATION',
        'modul_name'         => 'Cancel Movement'
      ],
      [
        'id'                 => 20,
        'group_id'           => '009',
        'transactions'       => 'INCOMING DS',
        'movement_code'      => '601',
        'action'             => 'DECREASE',
        'action_description' => 'DS Confirm',
        'from_desc'          => 'SLOC INTRANSIT',
        'to_desc'            => '-',
        'modul_name'         => 'Confirm Manifest'
      ],
      [
        'id'                 => 21,
        'group_id'           => '010',
        'transactions'       => 'INCOMING DS CANCEL',
        'movement_code'      => '602',
        'action'             => 'INCREASE',
        'action_description' => 'DS Confirm',
        'from_desc'          => '-',
        'to_desc'            => 'SLOC INTRANSIT',
        'modul_name'         => 'Cancel Manifest'
      ],
      [
        'id'                 => 22,
        'group_id'           => '011',
        'transactions'       => '"ADJUSTMENT "',
        'movement_code'      => '965',
        'action'             => 'INCREASE',
        'action_description' => 'ADJUSTMENT',
        'from_desc'          => 'STORAGE LOC',
        'to_desc'            => 'STORAGE LOC',
        'modul_name'         => 'Adjustment Finish Good'
      ],
      [
        'id'                 => 23,
        'group_id'           => '012',
        'transactions'       => 'ADJUSTMENT',
        'movement_code'      => '966',
        'action'             => 'DECREASE',
        'action_description' => 'ADJUSTMENT',
        'from_desc'          => 'STORAGE LOC',
        'to_desc'            => 'STORAGE LOC',
        'modul_name'         => 'Adjustment Finish Good'
      ],
      [
        'id'                 => 24,
        'group_id'           => '013',
        'transactions'       => 'ADJUSTMENT STOCK TAKING',
        'movement_code'      => '701',
        'action'             => 'INCREASE',
        'action_description' => 'ADJUSTMENT STOCK TAKING',
        'from_desc'          => 'STORAGE LOC',
        'to_desc'            => 'STORAGE LOC',
        'modul_name'         => 'ADJUSTMENT STOCK TAKING'
      ],
      [
        'id'                 => 25,
        'group_id'           => '014',
        'transactions'       => 'ADJUSTMENT STOCK TAKING',
        'movement_code'      => '702',
        'action'             => 'DECREASE',
        'action_description' => 'ADJUSTMENT STOCK TAKING',
        'from_desc'          => 'STORAGE LOC',
        'to_desc'            => 'STORAGE LOC',
        'modul_name'         => 'ADJUSTMENT STOCK TAKING'
      ],
      [
        'id'                 => 26,
        'group_id'           => '015',
        'transactions'       => 'TRANSFER',
        'movement_code'      => '311',
        'action'             => 'INCREASE',
        'action_description' => 'TRANSFER IN BRANCH',
        'from_desc'          => 'STORAGE LOC',
        'to_desc'            => 'STORAGE LOC',
        'modul_name'         => 'TRANSFER'
      ],
      [
        'id'                 => 27,
        'group_id'           => '015',
        'transactions'       => 'TRANSFER',
        'movement_code'      => '312',
        'action'             => 'DESCREASE',
        'action_description' => 'TRANSFER IN BRANCH',
        'from_desc'          => 'STORAGE LOC',
        'to_desc'            => 'STORAGE LOC',
        'modul_name'         => 'TRANSFER'
      ],
    ]);
  }
}
