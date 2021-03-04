<?php

namespace App\Http\Controllers;

use App\Models\LogManifestDetail;
use DB;
use Illuminate\Http\Request;

class DataSynchronizationController extends Controller
{
  public function index(Request $request)
  {
    $this->updateDOManifestDate();
    // $this->updateRitaseInvoice();
    // $this->updateBeritaAcaraNo();
    // $this->updateDatabaseBranchManifest();
    // $this->createLogInvoiceReceiptPrTable();
    // $this->updateDatabase18Jan2021();
    // $this->updateStockFromLMB();
    // $this->update13Jan2020MissingCBM();
    // $this->updateCreateByPickinglist();
    // $this->updateTable22Des2020();
    // $this->updateCBMLMB();
    // $this->updateCBMManifest();
    // $this->updateStockFromManifest();
    // $this->updateTable19Des2020();
    // $this->updateTable16Des2020();
    // $this->updateTable9Des2020();
    // $this->updateTable1Des2020();
    // $this->insertSummaryDGRMenu();
    // $this->updateTable30Nov2020();
    // $this->updateTable26Nov2020();
    // $this->updateHargaCartonBox();
    // $this->updateTable25Nov2020();
    // $this->updateTable23Nov2020();
    // $this->updateClaimInsuranceTable();
    // $this->updateBeritaAcaraTable();
    // $this->updateReceiptInvoiceDetail();
    // $this->updatePickinglist();
    // $this->updateConceptTruckFlow();
    // $this->updateClaimDatabase();
    // $this->updateDatabaseModules();
    // $this->updateDeliveryItemsLMB();
  }

  protected function updateDOManifestDate(){
    $rsManifest = DB::table('log_manifest_header')
    ->selectRaw('
    do_manifest_no, 
    do_manifest_date, 
    substr(do_manifest_no, 5, 6),
    DATE(substr(do_manifest_no, 5, 6)) AS new_do_manifest_date
    ')
    ->whereRaw('do_manifest_date != DATE(substr(do_manifest_no, 5, 6))')
    ->get()
    ;

    foreach ($rsManifest as $key => $value) {
      echo 'update do_manifest date to ' . $value->new_do_manifest_date . ' in manifest ' . $value->do_manifest_no . '<br>';
      DB::table('log_manifest_header')->where('do_manifest_no', $value->do_manifest_no)->update([
        'do_manifest_date' => $value->new_do_manifest_date
      ]);
    }
  }

  protected function updateRitaseInvoice(){
    $details = DB::table('log_invoice_receipt_detail')->where('ritase_amount', '>', 0)->get();

    $rsManifest = [];
    foreach($details AS $key => $value) {
      $rsManifest[$value->do_manifest_no][] = $value;
    }

    foreach($rsManifest AS $key => $dos){
      foreach($dos AS $kdo => $vdo){
        echo "update Manifest " . $vdo->do_manifest_no . " delivery no " . $vdo->delivery_no . '<br>';
        DB::table('log_invoice_receipt_detail')->where('id', $vdo->id)->update([
          'ritase_amount' => $vdo->ritase_amount / count($dos),
          'ritase2_amount' => $vdo->ritase2_amount / count($dos),
        ]);
      }
    }

  }

  protected function updateBeritaAcaraNo(){
    echo "update Berita Acara";
    DB::statement("UPDATE clm_berita_acara 
        set berita_acara_no = REPLACE(berita_acara_no, '2121', '2021') 
        where berita_acara_no like '%2121'");
    DB::statement("UPDATE clm_berita_acara_detail
        set berita_acara_no = REPLACE(berita_acara_no, '2121', '2021') 
        where berita_acara_no like '%2121'");
  }

  protected function updateDatabaseBranchManifest(){
    echo "update Branch Manifest";
    DB::statement("UPDATE `wms_branch_manifest_header` SET `manifest_type` = 'NORMAL' WHERE 1 =1 ");
  }

  protected function createLogInvoiceReceiptPrTable()
  {
    echo "Create Log_invoice_receipt_pr Table<br>";
    DB::statement('CREATE TABLE IF NOT EXISTS `log_invoice_receipt_pr` (
      `group_id_report` VARCHAR(20) NOT NULL,
      `expedition_name` VARCHAR(100) NOT NULL,
      `payment_requisition` VARCHAR(20) NULL DEFAULT NULL,
      PRIMARY KEY (`group_id_report`, `expedition_name`))');

    DB::statement('ALTER TABLE `log_invoice_receipt_pr` 
    COLLATE = utf8mb4_unicode_ci ,
    CHANGE COLUMN `group_id_report` `group_id_report` VARCHAR(20) NOT NULL ,
    CHANGE COLUMN `expedition_name` `expedition_name` VARCHAR(100) NOT NULL ,
    CHANGE COLUMN `payment_requisition` `payment_requisition` VARCHAR(20) NULL DEFAULT NULL ');
  }

  protected function updateDatabase18Jan2021()
  {
    echo 'Update Claim Insurance<br>';
    DB::statement('ALTER TABLE `clm_claim_insurance` 
    ADD COLUMN `summary_remark` VARCHAR(255) NULL DEFAULT NULL AFTER `remark`');

    echo 'Update Claim Notes<br>';
    DB::statement('ALTER TABLE `clm_claim_notes` 
    ADD COLUMN `kode_cabang` VARCHAR(3) NULL DEFAULT NULL AFTER `remarks`;');

    echo "update Marine Cargo Table<br>";
    DB::statement('ALTER TABLE `dur_marine_cargo` 
    ADD COLUMN `notice_of_claim_no` VARCHAR(30) NOT NULL AFTER `insurance_policy_no`');

    echo "Update During Berita Acara Detail<br>";
    DB::statement('ALTER TABLE `dur_berita_acara_detail` 
    ADD COLUMN `price` DECIMAL(18,3) NOT NULL AFTER `qty`
    ');
  }

  protected function updateStockFromLMB()
  {
    $missingLMB = DB::table('wms_lmb_detail')->selectRaw('
      COUNT(*)
    ')->leftjoin('tr_concept', function ($join) {
      $join->on('tr_concept.invoice_no', '=', 'wms_lmb_detail.invoice_no');
      $join->on('tr_concept.delivery_items', '=', 'wms_lmb_detail.delivery_items');
      $join->on('tr_concept.model', '=', 'wms_lmb_detail.model');
    })
      ->where('wms_lmb_detail.code_sales', '!=', 'tr_concept.code_sales')
      ->get();
    // print_r($missingLMB->toArray());
  }

  protected function update13Jan2020MissingCBM()
  {
    //cari lmb cbm 0;
    echo 'Start Sync LMB <br>';
    $missingLMB = \App\Models\LMBDetail::select(
      'wms_lmb_detail.*',
      DB::raw('(wms_pickinglist_detail.cbm / wms_pickinglist_detail.quantity) AS picking_list_cbm_unit'),
      'wms_pickinglist_detail.cbm',
      'wms_pickinglist_header.storage_id',
      'wms_pickinglist_header.picking_no',
      'wms_master_storage.sto_loc_code_long'
    )
      ->leftjoin('wms_pickinglist_detail', function ($join) {
        $join->on('wms_lmb_detail.picking_id', '=', 'wms_pickinglist_detail.header_id');
        $join->on('wms_lmb_detail.invoice_no', '=', 'wms_pickinglist_detail.invoice_no');
        $join->on('wms_lmb_detail.delivery_no', '=', 'wms_pickinglist_detail.delivery_no');
        $join->on('wms_lmb_detail.delivery_items', '=', 'wms_pickinglist_detail.delivery_items');
        $join->on('wms_lmb_detail.ean_code', '=', 'wms_pickinglist_detail.ean_code');
      })
      ->leftjoin('wms_pickinglist_header', 'wms_pickinglist_header.picking_no', '=', 'wms_lmb_detail.picking_id')
      ->leftjoin('wms_master_storage', 'wms_master_storage.id', '=', 'wms_pickinglist_header.storage_id')
      ->whereNull('cbm_unit')
      ->get();

    // echo "<pre>";
    // print_r($missingLMB);
    // exit;

    // Storage Intransit
    // 3 Intransit BR
    // $storageIntransit['BR'] = StorageMaster::where('sto_type_id', 3)
    //   ->where('kode_cabang', $lmbHeader->kode_cabang)
    //   ->first();
    $intransitBR = \App\Models\StorageMaster::where('sto_type_id', 3)
      ->get();

    foreach ($intransitBR as $key => $value) {
      $storageIntransit['BR'][$value->kode_cabang] = $value;
    }

    // 4 Intransit DS
    // $storageIntransit['DS'] = StorageMaster::where('sto_type_id', 4)
    //   ->where('kode_cabang', $lmbHeader->kode_cabang)
    //   ->first();
    $intranstDS = \App\Models\StorageMaster::where('sto_type_id', 4)
      ->get();

    foreach ($intranstDS as $key => $value) {
      $storageIntransit['DS'][$value->kode_cabang] = $value;
    }


    $date_now = date('Y-m-d H:i:s');

    foreach ($missingLMB as $key => $value) {
      $value->cbm_unit = $value->picking_list_cbm_unit;
      $value->save();

      \App\Models\InventoryStorage::updateOrCreate(
        // Condition
        [
          'storage_id' => $value->storage_id,
          'model_name' => $value->model,
        ],
        // Data Update
        [
          'cbm_total'      => DB::raw('IF(ISNULL(cbm_total), 0, cbm_total) - ' . $value->cbm),
          'last_updated'   => $date_now,
        ]
      );

      \App\Models\InventoryStorage::updateOrCreate(
        // Condition
        [
          'storage_id' => $storageIntransit[$value->code_sales][substr($value->kode_customer, 0, 2)]->id,
          'model_name' => $value->model,
        ],
        // Data Update
        [
          'cbm_total'      => DB::raw('IF(ISNULL(cbm_total), 0, cbm_total) + ' . $value->cbm),
          'last_updated'   => $date_now,
        ]
      );
    }

    echo 'Finish Sync LMB <br>';

    echo 'Start Sync Manifest <br>';

    $manifestDetail = \App\Models\LogManifestDetail::select(
      'log_manifest_detail.*',
      DB::raw('wms_pickinglist_detail.cbm AS picking_list_cbm'),
    )
      ->leftjoin('wms_pickinglist_detail', function ($join) {
        $join->on('wms_pickinglist_detail.invoice_no', 'log_manifest_detail.invoice_no');
        $join->on('wms_pickinglist_detail.delivery_no', 'log_manifest_detail.delivery_no');
        $join->on('wms_pickinglist_detail.delivery_items', 'log_manifest_detail.delivery_items');
        $join->on('wms_pickinglist_detail.model', 'log_manifest_detail.model');
      })
      ->whereNull('log_manifest_detail.cbm')
      // ->limit(100)
      ->get();

    foreach ($manifestDetail as $key => $value) {
      $value->cbm = $value->picking_list_cbm;
      $value->nilai_cbm = $value->base_price * $value->cbm;
      $value->save();
    }

    echo 'finish Sync Manifest <br>';

    // echo "<pre>";
    // print_r($manifestDetail->toArray());
  }

  protected function updateCreateByPickinglist()
  {
    $rs_pickingListHeader = \App\Models\PickinglistHeader::select(
      'wms_pickinglist_header.*',
      DB::raw('tr_concept_flow_header.created_by AS concept_created_by')
    )
      ->leftjoin('tr_concept_flow_header', 'tr_concept_flow_header.driver_register_id', '=', 'wms_pickinglist_header.driver_register_id')
      ->whereNotNull('tr_concept_flow_header.driver_register_id')
      ->whereNull('wms_pickinglist_header.created_by')->get();

    foreach ($rs_pickingListHeader as $key => $value) {
      echo $value->picking_no;
      echo '<br>';

      $value->created_by = $value->concept_created_by;
      $value->save();
    }
  }

  protected function updateTable22Des2020()
  {
    echo "update clm_berita_acara";
    DB::statement('ALTER TABLE `clm_berita_acara` 
    ADD COLUMN `expedition_name` VARCHAR(100) NULL DEFAULT NULL AFTER `kode_cabang`,
    CHANGE COLUMN `kode_cabang` `kode_cabang` VARCHAR(3) NULL DEFAULT NULL');

    echo "update During Marin Cargo";
    DB::statement('ALTER TABLE `dur_marine_cargo` 
    COLLATE = utf8mb4_unicode_ci ,
    CHANGE COLUMN `insurance_policy_no` `insurance_policy_no` VARCHAR(30) NOT NULL ,
    CHANGE COLUMN `sailed_on` `sailed_on` VARCHAR(255) NULL DEFAULT NULL ,
    CHANGE COLUMN `vessel_name` `vessel_name` VARCHAR(255) NULL DEFAULT NULL ,
    CHANGE COLUMN `cargo_description` `cargo_description` VARCHAR(255) NULL DEFAULT NULL');
  }

  protected function updateStockFromManifest()
  {
    $manifest_details = \App\Models\LogManifestDetail::where('do_manifest_no', 'KRW-201021-001')->get();
    $checkDetail = [];

    $rs_storage = [];
    foreach (\App\Models\StorageMaster::all() as $key => $value) {
      $rs_storage[$value->sto_loc_code_long] = $value;
    }

    DB::beginTransaction();
    foreach ($manifest_details as $key => $detail) {
      $id = $detail->delivery_no . $detail->model;

      if (empty($checkDetail[$id])) {
        $checkDetail[$id] = $detail;
        continue;
      }

      // Data Double
      LogManifestDetail::destroy($detail->id);
      $movement_transaction_log = \App\Models\MovementTransactionLog::where('do_manifest_no', $detail->do_manifest_no)
        ->where('model', $detail->model)
        ->where('quantity', $detail->quantity)
        ->first();

      echo 'Manifest No: ' . $movement_transaction_log->do_manifest_no;
      echo ' Model: ' . $movement_transaction_log->model;
      echo ' Quantity: ' . $movement_transaction_log->quantity;
      echo '<br>';

      // echo $rs_storage[$movement_transaction_log->storage_location_to]->id;
      // DB::rollback(); exit;
      \App\Models\InventoryStorage::updateOrCreate(
        // Condition
        [
          'storage_id' => $rs_storage[$movement_transaction_log->storage_location_from]->id,
          'model_name' => $movement_transaction_log->model,
        ],
        // Data Update
        [
          'quantity_total' => DB::raw('IF(ISNULL(quantity_total), 0, quantity_total) + ' . $movement_transaction_log->quantity),
          'cbm_total'      => DB::raw('IF(ISNULL(cbm_total), 0, cbm_total) + ' . $detail->cbm),
          'last_updated'   => date('Y-m-d H:i:s'),
        ]
      );
      // \App\Models\InventoryStorage::updateOrCreate(
      //   // Condition
      //   [
      //     'storage_id' => $rs_storage[$movement_transaction_log->storage_location_to]->id,
      //     'model_name' => $movement_transaction_log->model,
      //   ],
      //   // Data Update
      //   [
      //     'quantity_total' => DB::raw('IF(ISNULL(quantity_total), 0, quantity_total) - ' . $movement_transaction_log->quantity),
      //     'cbm_total'      => DB::raw('IF(ISNULL(cbm_total), 0, cbm_total) - ' . $detail->cbm),
      //     'last_updated'   => date('Y-m-d H:i:s'),
      //   ]
      // );

      $movement_transaction_log->delete();
    }
    DB::commit();
  }

  protected function updateCBMLMB()
  {
    $lmb_details = \App\Models\LMBDetail::selectRaw('
      wms_lmb_detail.*,
      ROUND(wms_pickinglist_detail.cbm / wms_pickinglist_detail.quantity, 3) AS cbm_unit_picking_list
      ')
      ->leftjoin('wms_pickinglist_detail', function ($join) {
        $join->on('wms_pickinglist_detail.header_id', '=', 'wms_lmb_detail.picking_id');
        $join->on('wms_pickinglist_detail.invoice_no', '=', 'wms_lmb_detail.invoice_no');
        $join->on('wms_pickinglist_detail.delivery_no', '=', 'wms_lmb_detail.delivery_no');
        $join->on('wms_pickinglist_detail.model', '=', 'wms_lmb_detail.model');
        $join->on('wms_pickinglist_detail.delivery_items', '=', 'wms_lmb_detail.delivery_items');
      })
      ->whereRaw('wms_lmb_detail.cbm_unit != ROUND(wms_pickinglist_detail.cbm / wms_pickinglist_detail.quantity, 3)')
      ->groupBy('wms_lmb_detail.serial_number')
      // ->where('wms_lmb_detail.picking_id', 1020201111001)
      ->get();

    foreach ($lmb_details as $key => $value) {
      // echo ' Model : ' . $value->model;
      // echo ' CBM UNIT : ' . $value->cbm_unit;
      // echo ' CBM UNIT PICKING : ' . $value->cbm_unit_picking_list;
      // echo "<br>";
      $value->cbm_unit = $value->cbm_unit_picking_list;
      $value->save();
    }
  }

  protected function updateCBMManifest()
  {
    $manifest_details = \App\Models\LogManifestDetail::selectRaw('
      log_manifest_detail.*,
      wms_pickinglist_detail.cbm AS cbm_picking
    ')->leftjoin('wms_pickinglist_detail', function ($join) {
      $join->on('log_manifest_detail.invoice_no', '=', 'wms_pickinglist_detail.invoice_no');
      $join->on('log_manifest_detail.delivery_no', '=', 'wms_pickinglist_detail.delivery_no');
      $join->on('log_manifest_detail.delivery_items', '=', 'wms_pickinglist_detail.delivery_items');
    })
      ->whereRaw('log_manifest_detail.cbm != wms_pickinglist_detail.cbm')
      ->get();

    foreach ($manifest_details as $key => $value) {
      echo " Manifest No : " . $value->do_manifest_no;
      echo " model : " . $value->model;
      echo " CBM : " . $value->cbm;
      echo " CBM Picking : " . $value->cbm_picking;
      echo "<br>";

      $value->cbm = $value->cbm_picking;
      $value->nilai_cbm = $value->base_price * $value->cbm;
      $value->save();
    }
  }

  protected function updateTable19Des2020()
  {
    echo "Update Clm_berita_acara_detail";
    DB::statement('ALTER TABLE `clm_berita_acara_detail` 
    ADD COLUMN `deleted_from_outstanding_insurance` TINYINT(4) NOT NULL DEFAULT "0" AFTER `keterangan`');
  }

  protected function updateTable16Des2020()
  {
    echo "Update Module";
    DB::table('tr_modules')->insert(
      [
        'id'         => 111,
        'modul_name' => 'Marine Cargo',
        'modul_link' => 'marine-cargo',
        'group_name' => 'During',
        'order_menu' => 6,
      ]
    );
    // DB::statement("INSERT INTO tr_modules (modul_name, modul_link, group_name, order_menu, created_at, updated_at) VALUES ('Marine Cargo', 'marine-cargo', 'during', 6, '2020-12-16 01:33:56', '2020-12-16 01:34:00')");

    echo "Create Marine Cargo table";
    DB::statement('CREATE TABLE IF NOT EXISTS `dur_marine_cargo` (
    `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `dur_dgr_id` INT(11) NULL DEFAULT NULL,
    `insurance_policy_no` VARCHAR(30) NOT NULL,
    `sailed_on` VARCHAR(255) NULL DEFAULT NULL,
    `vessel_name` VARCHAR(255) NULL DEFAULT NULL,
    `sailed_date` DATETIME NULL DEFAULT NULL,
    `arrived_date` DATETIME NULL DEFAULT NULL,
    `discharging_date` DATETIME NULL DEFAULT NULL,
    `delivery_date` DATETIME NULL DEFAULT NULL,
    `cargo_description` VARCHAR(255) NULL DEFAULT NULL,
    `qty` INT(11) NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    `created_by` INT(11) NULL DEFAULT NULL,
    `updated_by` INT(11) NULL DEFAULT NULL,
    PRIMARY KEY (`id`))');

    DB::statement('
      UPDATE log_region 
      SET region = "JAVA & BALI"
      WHERE region = "JAWA"
      ');
  }

  protected function updateTable9Des2020()
  {
    echo "update Table Claim Insurance <br>";
    DB::statement('ALTER TABLE `clm_claim_insurance`
    ADD COLUMN `submit_date` DATE NULL DEFAULT NULL AFTER `date_of_loss`,
    ADD COLUMN `submit_by` INT(11) NULL DEFAULT NULL AFTER `submit_date`,
    ADD COLUMN `payment_date` DATE NULL DEFAULT NULL AFTER `submit_by`,
    ADD COLUMN `remark` VARCHAR(255) NULL DEFAULT NULL AFTER `payment_date`;
    ');

    echo "Insert Summary Claim Insurance";
    DB::table('tr_modules')->insert(
      [
        'id'         => 110,
        'modul_name' => 'Summary Claim Insurance',
        'modul_link' => 'summary-claim-insurance',
        'group_name' => 'Claim',
        'order_menu' => 3,
      ]
    );

    echo "Update Berita Acara During Detail";
    DB::statement('ALTER TABLE `dur_berita_acara_detail`
      ADD COLUMN `category_damage` VARCHAR(255) NULL AFTER `serial_number`;
    ');

    echo "Update DGR";
    DB::statement('ALTER TABLE `dur_dgr`
      ADD COLUMN `vendor` VARCHAR(255) NULL AFTER `location`;
    ');
  }

  protected function updateTable1Des2020()
  {
    echo "Update Table Claim Notes<br>";
    DB::statement('ALTER TABLE `clm_claim_notes`
    DROP COLUMN `dn_issue_date`,
    ADD COLUMN `dn_issue` VARCHAR(255) NULL DEFAULT NULL AFTER `date_picking_expedition`');

    echo "Update Table log_return_surat_tugas<br>";
    DB::statement('ALTER TABLE `log_return_surat_tugas_actual`
    DROP COLUMN `modifiy_by`,
    DROP COLUMN `modifiy_date`,
    ADD COLUMN `modify_date` DATETIME NULL DEFAULT NULL AFTER `created_by`,
    ADD COLUMN `modify_by` INT(11) NULL DEFAULT NULL AFTER `modify_date`');
  }

  protected function insertSummaryDGRMenu()
  {
    echo "Insert Summary DGR Menu";
    DB::table('tr_modules')->insert(
      [
        'id'         => 109,
        'modul_name' => 'Summary DGR',
        'modul_link' => 'summary-damage-goods-report',
        'group_name' => 'During',
        'order_menu' => 3,
      ]
    );
  }

  protected function updateTable30Nov2020()
  {
    echo "Edit Table 30 Oktober";
    DB::statement('
      ALTER TABLE `dur_berita_acara`
      ADD COLUMN `category_damage` VARCHAR(255) NULL DEFAULT NULL AFTER `tanggal_kejadian`
      ');
    DB::statement('ALTER TABLE `dur_berita_acara_detail`
      ADD COLUMN `claim` VARCHAR(255) NULL DEFAULT NULL AFTER `damage`
      ');
    DB::statement('
      ALTER TABLE `dur_dgr`
      ADD COLUMN `submit_by` INT(11) NULL DEFAULT NULL AFTER `claim`,
      ADD COLUMN `submit_date` DATETIME NULL DEFAULT NULL AFTER `submit_by`');
  }

  protected function updateTable26Nov2020()
  {
    echo "Add reason to claimnote item <br>";
    DB::statement('ALTER TABLE `clm_claim_note_detail`
      ADD COLUMN `reason` VARCHAR(255) NULL AFTER `description`;
    ');
  }

  protected function updateHargaCartonBox()
  {
    $file = fopen('../database/seeds/source_files/harga_carton_box.csv', "r");

    $tr_vehicle_type_details = [];

    while (!feof($file)) {
      $row = fgetcsv($file);

      if (!empty($row[1])) {
        echo "Update Carton box Price " . $row[1] . '<br>';
        DB::table('wms_master_model')->where('model_name', $row[1])
          ->update(['price_carton_box' => $row[2]]);
      }
    }

    fclose($file);
  }

  protected function updateTable25Nov2020()
  {
    echo "Update Claim Insurance";
    DB::statement('ALTER TABLE `clm_claim_insurance`
    ADD COLUMN `branch` VARCHAR(255) NULL DEFAULT NULL AFTER `insurance_date`,
    ADD COLUMN `date_of_loss` DATE NULL DEFAULT NULL AFTER `branch`');

    echo "Update Clm Claim Notes";
    DB::statement('ALTER TABLE `clm_claim_notes`
    ADD COLUMN `send_to_management` DATETIME NULL DEFAULT NULL AFTER `submit_date`,
    ADD COLUMN `approval_start_date` DATETIME NULL DEFAULT NULL AFTER `send_to_management`,
    ADD COLUMN `approval_finish_date` DATETIME NULL DEFAULT NULL AFTER `approval_start_date`,
    ADD COLUMN `so_issue_date` DATETIME NULL DEFAULT NULL AFTER `approval_finish_date`,
    ADD COLUMN `date_picking_expedition` DATETIME NULL DEFAULT NULL AFTER `so_issue_date`,
    ADD COLUMN `dn_issue_date` DATETIME NULL DEFAULT NULL AFTER `date_picking_expedition`,
    ADD COLUMN `remarks` VARCHAR(255) NULL DEFAULT NULL AFTER `dn_issue_date`');

    echo "Insert Summary Claim Notes Menu";
    DB::table('tr_modules')->insert(
      [
        'id'         => 108,
        'modul_name' => 'Summary Claim Notes',
        'modul_link' => 'summary-claim-notes',
        'group_name' => 'Claim',
        'order_menu' => 4,
      ]
    );
  }

  protected function updateTable23Nov2020()
  {
    echo "Update clm_claim_notes <br>";
    DB::statement('ALTER TABLE `clm_claim_notes`
    ADD COLUMN `submit_by` INT(11) NULL DEFAULT NULL AFTER `claim`,
    ADD COLUMN `submit_date` DATETIME NULL DEFAULT NULL AFTER `submit_by`');

    echo "Update dur_berita_acara <br>";
    DB::statement('ALTER TABLE `dur_berita_acara`
    ADD COLUMN `tanggal_kejadian` DATE NULL DEFAULT NULL AFTER `tanggal_berita_acara`,
    ADD COLUMN `submit_by` INT(11) NULL DEFAULT NULL AFTER `photo_loading`,
    ADD COLUMN `submit_date` DATETIME NULL DEFAULT NULL AFTER `submit_by`');

    echo "Add Table dur_dgr <br>";
    DB::statement('CREATE TABLE IF NOT EXISTS `dur_dgr` (
      `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
      `dgr_no` VARCHAR(30) NOT NULL,
      `location` VARCHAR(50) NULL DEFAULT NULL,
      `claim` VARCHAR(15) NULL DEFAULT NULL,
      `created_at` TIMESTAMP NULL DEFAULT NULL,
      `updated_at` TIMESTAMP NULL DEFAULT NULL,
      `created_by` INT(11) NULL DEFAULT NULL,
      `updated_by` INT(11) NULL DEFAULT NULL,
      PRIMARY KEY (`id`))
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8mb4
    COLLATE = utf8mb4_unicode_ci');

    echo "Add Table dur_dgr_detail <br>";
    DB::statement('CREATE TABLE IF NOT EXISTS `dur_dgr_detail` (
      `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
      `dur_dgr_id` INT(11) NULL DEFAULT NULL,
      `berita_acara_during_detail_id` INT(11) NULL DEFAULT NULL,
      `description` VARCHAR(255) NULL DEFAULT NULL,
      `qty` INT(11) NULL DEFAULT NULL,
      `remark` VARCHAR(255) NULL DEFAULT NULL,
      `created_at` TIMESTAMP NULL DEFAULT NULL,
      `updated_at` TIMESTAMP NULL DEFAULT NULL,
      `created_by` INT(11) NULL DEFAULT NULL,
      `updated_by` INT(11) NULL DEFAULT NULL,
      PRIMARY KEY (`id`))
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8mb4
    COLLATE = utf8mb4_unicode_ci');
  }

  protected function updateClaimInsuranceTable()
  {
    echo "Update Table Insurance";
    DB::statement('ALTER TABLE `clm_claim_insurance`
    ADD COLUMN `claim_report` VARCHAR(255) NULL DEFAULT NULL AFTER `id`,
    ADD COLUMN `keterangan_kejadian` VARCHAR(255) NULL DEFAULT NULL AFTER `claim_report`
    ');
  }

  protected function updateBeritaAcaraTable()
  {
    DB::statement('ALTER TABLE `clm_berita_acara`
    ADD COLUMN `submit_by` INT(11) NULL DEFAULT NULL AFTER `kode_cabang`,
    ADD COLUMN `submit_date` DATETIME NULL DEFAULT NULL AFTER `submit_by`
    ');
  }

  protected function updateClaimDatabase()
  {
    try {
      DB::beginTransaction();
      DB::statement('ALTER TABLE `clm_berita_acara_detail`
    ADD COLUMN `claim_note_detail_id` INT(11) NULL DEFAULT NULL AFTER `berita_acara_id`,
    ADD COLUMN `claim_insurance_detail_id` INT(11) NULL DEFAULT NULL AFTER `claim_note_detail_id`');

      DB::statement('ALTER TABLE `clm_claim_insurance`
    ADD COLUMN `insurance_date` DATE NULL DEFAULT NULL AFTER `id`,
    ADD COLUMN `created_by` INT(11) NULL DEFAULT NULL AFTER `updated_at`,
    ADD COLUMN `updated_by` INT(11) NULL DEFAULT NULL AFTER `created_by`');

      DB::statement('CREATE TABLE IF NOT EXISTS `clm_claim_insurance_detail` (
    `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `claim_insurance_id` INT(11) NULL DEFAULT NULL,
    `berita_acara_detail_id` INT(11) NULL DEFAULT NULL,
    `date_of_receipt` DATE NULL DEFAULT NULL,
    `expedition_code` VARCHAR(3) NULL DEFAULT NULL,
    `driver_name` VARCHAR(50) NULL DEFAULT NULL,
    `vehicle_number` VARCHAR(11) NULL DEFAULT NULL,
    `do_no` VARCHAR(15) NULL DEFAULT NULL,
    `model_name` VARCHAR(50) NULL DEFAULT NULL,
    `serial_number` VARCHAR(50) NULL DEFAULT NULL,
    `description` VARCHAR(255) NULL DEFAULT NULL,
    `destination` VARCHAR(255) NULL DEFAULT NULL,
    `location` VARCHAR(255) NULL DEFAULT NULL,
    `qty` INT(11) NULL DEFAULT NULL,
    `price` INT(11) NULL DEFAULT NULL,
    `total_price` INT(11) NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    `created_by` INT(11) NULL DEFAULT NULL,
    `updated_by` INT(11) NULL DEFAULT NULL,
    PRIMARY KEY (`id`))
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8mb4
    COLLATE = utf8mb4_unicode_ci');

      DB::statement('CREATE TABLE IF NOT EXISTS `clm_claim_note_detail` (
    `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `claim_note_id` INT(11) NULL DEFAULT NULL,
    `berita_acara_detail_id` INT(11) NULL DEFAULT NULL,
    `date_of_receipt` DATE NULL DEFAULT NULL,
    `expedition_code` VARCHAR(3) NULL DEFAULT NULL,
    `driver_name` VARCHAR(50) NULL DEFAULT NULL,
    `vehicle_number` VARCHAR(11) NULL DEFAULT NULL,
    `do_no` VARCHAR(15) NULL DEFAULT NULL,
    `model_name` VARCHAR(50) NULL DEFAULT NULL,
    `serial_number` VARCHAR(50) NULL DEFAULT NULL,
    `description` VARCHAR(255) NULL DEFAULT NULL,
    `destination` VARCHAR(255) NULL DEFAULT NULL,
    `location` VARCHAR(255) NULL DEFAULT NULL,
    `qty` INT(11) NULL DEFAULT NULL,
    `price` INT(11) NULL DEFAULT NULL,
    `total_price` INT(11) NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    `created_by` INT(11) NULL DEFAULT NULL,
    `updated_by` INT(11) NULL DEFAULT NULL,
    PRIMARY KEY (`id`))
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8mb4
    COLLATE = utf8mb4_unicode_ci');

      DB::statement('ALTER TABLE `clm_claim_notes`
    DROP COLUMN `total_price`,
    DROP COLUMN `price`,
    DROP COLUMN `description`,
    DROP COLUMN `qty`,
    DROP COLUMN `serial_number`,
    DROP COLUMN `model_name`,
    DROP COLUMN `do_no`,
    DROP COLUMN `destination`,
    DROP COLUMN `vehicle_number`,
    DROP COLUMN `driver_name`,
    DROP COLUMN `expedition_code`,
    DROP COLUMN `date_of_receipt`,
    DROP COLUMN `berita_acara_no`');

      DB::statement('CREATE TABLE IF NOT EXISTS `dur_berita_acara` (
    `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `berita_acara_during_no` VARCHAR(30) NULL DEFAULT NULL,
    `tanggal_berita_acara` DATE NULL DEFAULT NULL,
    `ship_name` VARCHAR(255) NULL DEFAULT NULL,
    `invoice_no` VARCHAR(255) NULL DEFAULT NULL,
    `container_no` VARCHAR(255) NULL DEFAULT NULL,
    `bl_no` VARCHAR(255) NULL DEFAULT NULL,
    `seal_no` VARCHAR(255) NULL DEFAULT NULL,
    `damage_type` VARCHAR(255) NULL DEFAULT NULL,
    `expedition_code` VARCHAR(3) NULL DEFAULT NULL,
    `vehicle_number` VARCHAR(11) NULL DEFAULT NULL,
    `weather` VARCHAR(255) NULL DEFAULT NULL,
    `working_hour` VARCHAR(255) NULL DEFAULT NULL,
    `location` VARCHAR(255) NULL DEFAULT NULL,
    `photo_container_came` VARCHAR(255) NULL DEFAULT NULL,
    `photo_container_loading` VARCHAR(255) NULL DEFAULT NULL,
    `photo_seal_no` VARCHAR(255) NULL DEFAULT NULL,
    `photo_loading` VARCHAR(255) NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    `created_by` INT(11) NULL DEFAULT NULL,
    `updated_by` INT(11) NULL DEFAULT NULL,
    PRIMARY KEY (`id`))
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8mb4
    COLLATE = utf8mb4_unicode_ci');

      DB::statement('CREATE TABLE IF NOT EXISTS `dur_berita_acara_detail` (
    `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `berita_acara_during_id` INT(11) NULL DEFAULT NULL,
    `model_name` VARCHAR(50) NULL DEFAULT NULL,
    `qty` INT(11) NULL DEFAULT NULL,
    `pom` VARCHAR(255) NULL DEFAULT NULL,
    `serial_number` VARCHAR(255) NULL DEFAULT NULL,
    `damage` VARCHAR(255) NULL DEFAULT NULL,
    `photo_serial_number` VARCHAR(255) NULL DEFAULT NULL,
    `photo_damage` VARCHAR(255) NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    `created_by` INT(11) NULL DEFAULT NULL,
    `updated_by` INT(11) NULL DEFAULT NULL,
    PRIMARY KEY (`id`))
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8mb4
    COLLATE = utf8mb4_unicode_ci');

      DB::statement('ALTER TABLE `wms_pickinglist_header`
    CHANGE COLUMN `deleted_at` `deleted_at` DATETIME NULL DEFAULT NULL');
      DB::commit();
    } catch (Exception $e) {
      DB::rollback();
    }
  }

  protected function updateReceiptInvoiceDetail()
  {
    $details = \App\Models\InvoiceReceiptDetail::select(
      'log_invoice_receipt_detail.*',
      DB::raw('log_cabang.short_description AS short_description_cabang')
    )
      ->leftjoin('log_cabang', 'log_cabang.kode_cabang', '=', 'log_invoice_receipt_detail.kode_cabang')
      ->get();

    echo "Update Receive Invoice Detail";
    foreach ($details as $key => $value) {
      $value->acc_code = date('My', strtotime($value->do_manifest_date)) . '-' . $value->short_description_cabang . '-' . $value->code_sales;
      echo "Update ACC CODE  " . $value->acc_code . '<br>';
      $value->save();
    }
  }

  protected function updatePickinglist()
  {
    echo "Update deleted picking list";

    $pickinglistHeader = \App\Models\PickinglistHeader::whereNotNull('deleted_at')->get();

    foreach ($pickinglistHeader as $key => $value) {
      $value->driver_register_id = \Ramsey\Uuid\Uuid::uuid4();
      $value->save();
      echo "Update deleted picking list no " . $value->picking_no . '<br>';
    }
  }

  protected function updateConceptTruckFlow()
  {
    echo "Update Concept Truck Flow <br>";

    $conceptTruckFlow = \App\Models\ConceptTruckFlow::whereNull('created_start_date')->get();

    foreach ($conceptTruckFlow as $key => $value) {
      $lmbHeader = \App\Models\LMBHeader::find($value->concept_flow_header);
      if (!empty($lmbHeader)) {
        $detail_created_date = $lmbHeader->detail_created_date();
        // print_r($detail_created_date);
        // return;
        $value->created_start_date = $detail_created_date->created_start_date;
        $value->created_end_date   = $detail_created_date->created_end_date;

        $value->save();
        echo 'Updating Concept Truck Flow ' . $value->concept_flow_header . '<br>';
      }
    }
  }

  protected function updateDatabaseModules()
  {
    echo "Add Update Serial Number <br>";
    \App\Models\Module::updateOrCreate(
      ['id' => 106],
      ['modul_name' => 'Update Serial Number', 'modul_link' => 'update-serial-no', 'group_name' => 'Picking', 'order_menu' => 4]
    );
    echo "Add Send To LMB <br>";
    \App\Models\Module::updateOrCreate(
      ['id' => 107],
      ['modul_name' => 'Send To LMB', 'modul_link' => 'send-to-lmb', 'group_name' => 'Picking', 'order_menu' => 5]
    );
  }

  protected function updateDeliveryItemsLMB()
  {
    echo "Checking LMB Data ... <br>";
    $temp_lmb_details = \App\Models\LMBDetail::whereNull('delivery_items')
      ->orderBy('picking_id', 'asc')
      ->orderBy('invoice_no', 'asc')
      ->orderBy('delivery_no', 'asc')
      ->get();

    $rs_picking_lmb = [];

    foreach ($temp_lmb_details as $key => $value) {
      $rs_picking_lmb[$value->picking_id][] = $value;
    }

    foreach ($rs_picking_lmb as $key => $lmb_details) {
      $serial_numbers                 = [];
      $scan_summaries                 = [];
      $model_not_exist_in_pickinglist = [];

      $rs_models               = [];
      $rs_picking_list_details = [];
      $delivery_exceptions     = [];

      foreach ($lmb_details as $key => $lmb_detail) {

        if (empty($rs_picking_list_details[$lmb_detail->ean_code])) {
          $picking_detail = \App\Models\PickinglistDetail::select(
            'wms_pickinglist_detail.delivery_no',
            'wms_pickinglist_detail.invoice_no',
            'wms_pickinglist_detail.kode_customer',
            'wms_pickinglist_detail.code_sales',
            'wms_pickinglist_header.city_code',
            'wms_pickinglist_header.city_name',
            'wms_pickinglist_header.driver_register_id',
            // 'wms_pickinglist_detail.quantity',
            'wms_pickinglist_detail.cbm',
            DB::raw('GROUP_CONCAT(wms_pickinglist_detail.delivery_items SEPARATOR ",") as rs_delivery_items'),
            DB::raw('GROUP_CONCAT(wms_pickinglist_detail.quantity SEPARATOR ",") as rs_quantity'),
            DB::raw('(SUM(wms_pickinglist_detail.quantity)) AS quantity ')
          )
            ->leftjoin('wms_pickinglist_header', 'wms_pickinglist_header.id', '=', 'wms_pickinglist_detail.header_id')
            ->groupBy(
              'wms_pickinglist_detail.header_id',
              'wms_pickinglist_detail.invoice_no',
              'wms_pickinglist_detail.delivery_no',
              // 'wms_pickinglist_detail.delivery_items',
              'wms_pickinglist_detail.ean_code'
            )
            ->where('wms_pickinglist_detail.ean_code', $lmb_detail->ean_code)
            ->where('wms_pickinglist_detail.invoice_no', $lmb_detail->invoice_no)
            ->where('wms_pickinglist_detail.delivery_no', $lmb_detail->delivery_no)
            ->where('wms_pickinglist_header.picking_no', $lmb_detail->picking_id)
            ->orderBy('quantity', 'desc');

          // if (!empty($delivery_exceptions[$lmb_detail->ean_code])) {
          //   $picking_detail->whereNotIn('wms_pickinglist_detail.delivery_no', $delivery_exceptions[$lmb_detail->ean_code]);
          // }

          $picking_detail = $picking_detail->first();

          if (empty($picking_detail) || $picking_detail->quantity == 0) {
            echo 'EAN ' . $lmb_detail->ean_code . ' not found in picking_list !  Invoice No ' . $lmb_detail->invoice_no . ' Delivery No ' . $lmb_detail->delivery_no . ' set Delivery Items to ' . $lmb_detail->delivery_items . '<br>';
            // echo "<pre>";
            // print_r($scan_summaries[$lmb_detail->ean_code]);
            // exit;
          }

          // if ($lmb_detail->picking_id == '8120201021002') {
          //   echo "<pre>";
          //   print_r($picking_detail->toArray());
          //   print_r($lmb_details);
          //   exit;
          //   # code...
          // }

          if (!empty($delivery_exceptions[$lmb_detail->ean_code])) {
            $scan_summaries[$lmb_detail->ean_code]['quantity_picking'] += $picking_detail->quantity;
            $scan_summaries[$lmb_detail->ean_code]['quantity_existing'] += $picking_detail->quantity;
          }

          $picking_detail->rs_delivery_items = explode(',', $picking_detail->rs_delivery_items);
          $picking_detail->rs_quantity       = explode(',', $picking_detail->rs_quantity);

          $rs_picking_list_details[$lmb_detail->ean_code] = $picking_detail;
        }

        $lmb_detail->delivery_items = $rs_picking_list_details[$lmb_detail->ean_code]->rs_delivery_items[0];

        if (empty($scan_summaries[$lmb_detail->ean_code])) {
          $scan_summaries[$lmb_detail->ean_code] = [
            'model'             => $lmb_detail->model,
            'quantity_scan'     => 0,
            'quantity_picking'  => $rs_picking_list_details[$lmb_detail->ean_code]->quantity,
            'quantity_existing' => $rs_picking_list_details[$lmb_detail->ean_code]->quantity,
          ];
        }

        if ($scan_summaries[$lmb_detail->ean_code]['quantity_picking'] >= $scan_summaries[$lmb_detail->ean_code]['quantity_scan']) {
          $scan_summaries[$lmb_detail->ean_code]['quantity_scan'] += 1;
          $scan_summaries[$lmb_detail->ean_code]['quantity_existing'] -= 1;

          $quantity = $rs_picking_list_details[$lmb_detail->ean_code]->rs_quantity;
          $quantity[0] -= 1;
          $rs_picking_list_details[$lmb_detail->ean_code]->rs_quantity = $quantity;

          if ($rs_picking_list_details[$lmb_detail->ean_code]->rs_quantity[0] <= 0) {
            $rs_quantity = $rs_picking_list_details[$lmb_detail->ean_code]->rs_quantity;
            unset($rs_quantity[0]);
            $rs_picking_list_details[$lmb_detail->ean_code]->rs_quantity = array_values($rs_quantity);

            $rs_delivery_items = $rs_picking_list_details[$lmb_detail->ean_code]->rs_delivery_items;
            unset($rs_delivery_items[0]);
            $rs_picking_list_details[$lmb_detail->ean_code]->rs_delivery_items = array_values($rs_delivery_items);
          }

          if ($scan_summaries[$lmb_detail->ean_code]['quantity_existing'] <= 0) {
            $delivery_exceptions[$lmb_detail->ean_code][] = $rs_picking_list_details[$lmb_detail->ean_code]->delivery_no;
            unset($rs_picking_list_details[$lmb_detail->ean_code]);
          }
        } else {
          $model_not_exist_in_pickinglist[$lmb_detail->ean_code]['picking_no'] = $lmb_detail->picking_id;
          $model_not_exist_in_pickinglist[$lmb_detail->ean_code]['model']      = $lmb_detail->model;
          if (empty($model_not_exist_in_pickinglist[$lmb_detail->ean_code]['total_sn'])) {
            $model_not_exist_in_pickinglist[$lmb_detail->ean_code]['total_sn'] = 0;
          }
          $model_not_exist_in_pickinglist[$lmb_detail->ean_code]['total_sn'] += 1;
        }

        $lmb_detail->save();
        echo 'Fixing data Invoice No ' . $lmb_detail->invoice_no . ' Delivery No ' . $lmb_detail->delivery_no . ' EAN ' . $lmb_detail->ean_code . ' set Delivery Items to ' . $lmb_detail->delivery_items . '.<br>';
      }
    }

    echo "Delivery items lmb synchronized. <i>(" . date('Y-m-d H:i:s') . ")</i><br>";
  }
}
