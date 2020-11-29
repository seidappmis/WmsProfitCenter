<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;

class AdminNavListComposer
{
  private $menuItems = [];

  /**
   * Create a new Admin Navigation List composer.
   *
   * @return void
   */
  public function __construct()
  {
    $this->menuItems[] = ['name' => '', 'label' => 'Home', 'url' => 'home', 'icon' => 'account_balance'];

    $this->menuItems[] = ['name' => 'dashboard', 'label' => 'Dashboard', 'url' => '#', 'icon' => 'dvr', 'childs' => [
      ['name' => 'dashboard', 'label' => 'Graphic Dashboard', 'url' => 'dashboard', 'icon' => 'radio_button_unchecked'],
      ['name' => 'dashboard', 'label' => 'Graphic Dashboard 2', 'url' => 'dashboard2', 'icon' => 'radio_button_unchecked'],
      ['name' => 'dashboard', 'label' => 'Trucking Monitor', 'url' => 'trucking-monitor', 'icon' => 'radio_button_unchecked'],
    ]];

    $this->menuItems[] = ['name' => 'incoming', 'label' => 'Incoming', 'url' => '#', 'icon' => 'play_for_work', 'childs' => [
      ['name' => 'incoming', 'label' => 'Finish Good Production', 'url' => 'finish-good-production', 'icon' => 'radio_button_unchecked'],
      ['name' => 'incoming', 'label' => 'Incoming Import/OEM', 'url' => 'incoming-import-oem', 'icon' => 'radio_button_unchecked'],
      ['name' => 'incoming', 'label' => 'Conform Manifest', 'url' => 'conform-manifest', 'icon' => 'radio_button_unchecked'],
      ['name' => 'incoming', 'label' => 'Billing Return', 'url' => 'billing-return', 'icon' => 'radio_button_unchecked'],
    ]];

    $this->menuItems[] = ['name' => 'other', 'label' => 'Others', 'url' => '#', 'icon' => 'assessment', 'childs' => [
      ['name' => 'other', 'label' => 'Clean Concept', 'url' => 'clean-concept', 'icon' => 'radio_button_unchecked'],
    ]];

    $this->menuItems[] = ['name' => 'picking', 'label' => 'Picking', 'url' => '#', 'icon' => 'rv_hookup', 'childs' => [
      ['name' => 'picking', 'label' => 'Upload DO for Picking', 'url' => 'upload-do-for-picking', 'icon' => 'radio_button_unchecked'],
      ['name' => 'outgoing', 'label' => 'IDCard Scan', 'url' => 'idcard-scan', 'icon' => 'radio_button_unchecked'],
      ['name' => 'picking', 'label' => 'Picking List', 'url' => 'picking-list', 'icon' => 'radio_button_unchecked'],
      ['name' => 'picking', 'label' => 'Picking to LMB', 'url' => 'picking-to-lmb', 'icon' => 'radio_button_unchecked'],
      ['name' => 'picking', 'label' => 'Update Serial No', 'url' => 'update-serial-no', 'icon' => 'radio_button_unchecked'],
    ]];
    $this->menuItems[] = ['name' => 'outgoing', 'label' => 'Outgoing', 'url' => '#', 'icon' => 'looks', 'childs' => [
      ['name' => 'outgoing', 'label' => 'Upload Concept', 'url' => 'upload-concept', 'icon' => 'radio_button_unchecked'],
      // ['name' => 'outgoing', 'label' => 'Assign Vehicles', 'url' => 'assign-vehicles', 'icon' => 'radio_button_unchecked'],
      ['name' => 'outgoing', 'label' => 'Gate Status', 'url' => 'select-gate', 'icon' => 'radio_button_unchecked'],
      // ['name' => 'outgoing', 'label' => 'Loading Process', 'url' => 'loading-process', 'icon' => 'radio_button_unchecked'],
      ['name' => 'outgoing', 'label' => 'Complete', 'url' => 'complete', 'icon' => 'radio_button_unchecked'],
      ['name' => 'outgoing', 'label' => 'Manifest Regular', 'url' => 'manifest-regular', 'icon' => 'radio_button_unchecked'],
      ['name' => 'outgoing', 'label' => 'Manifest AS', 'url' => 'manifest-as', 'icon' => 'radio_button_unchecked'],
      ['name' => 'outgoing', 'label' => 'Branch Manifest', 'url' => 'branch-manifest', 'icon' => 'radio_button_unchecked'],
      ['name' => 'outgoing', 'label' => 'Update Manifest', 'url' => 'update-manifest', 'icon' => 'radio_button_unchecked'],
      ['name' => 'outgoing', 'label' => 'Overload Concept or DO', 'url' => 'overload-concept-or-do', 'icon' => 'radio_button_unchecked'],
    ]];

    $this->menuItems[] = ['name' => 'invoicing', 'label' => 'Invoicing', 'url' => '#', 'icon' => 'pages', 'childs' => [
      ['name' => 'invoicing', 'label' => 'List of Unconfirm DO', 'url' => 'list-of-unconfirm-do', 'icon' => 'radio_button_unchecked'],
      ['name' => 'invoicing', 'label' => 'Receipt Invoice', 'url' => 'receipt-invoice', 'icon' => 'radio_button_unchecked'],
      ['name' => 'invoicing', 'label' => 'Receipt Invoice Accounting', 'url' => 'receipt-invoice-accounting', 'icon' => 'radio_button_unchecked'],
      ['name' => 'invoicing', 'label' => 'Summary Freight Cost Analysis', 'url' => 'summary-freight-cost-analysis', 'icon' => 'radio_button_unchecked'],
      ['name' => 'invoicing', 'label' => 'Branch Invoicing', 'url' => 'branch-invoicing', 'icon' => 'radio_button_unchecked'],
    ]];
    $this->menuItems[] = ['name' => 'inventory', 'label' => 'Inventory', 'url' => '#', 'icon' => 'store', 'childs' => [
      ['name' => 'inventory', 'label' => 'Storage Inventory Monitoring', 'url' => 'storage-inventory-monitoring', 'icon' => 'radio_button_unchecked'],
      ['name' => 'inventory', 'label' => 'Upload Inventory Storage', 'url' => 'upload-inventory-storage', 'icon' => 'radio_button_unchecked'],
      ['name' => 'inventory', 'label' => 'Adjust Inventory Movement', 'url' => 'adjust-inventory-movement', 'icon' => 'radio_button_unchecked'],
      ['name' => 'inventory', 'label' => 'Transfer SLoc', 'url' => 'transfer-sloc', 'icon' => 'radio_button_unchecked'],
      ['name' => 'inventory', 'label' => 'Cancel Movement', 'url' => 'cancel-movement', 'icon' => 'radio_button_unchecked'],
    ]];

    $this->menuItems[] = ['name' => 'report', 'label' => 'Return', 'url' => '#', 'icon' => 'low_priority', 'childs' => [
      ['name' => 'report', 'label' => 'Task Notice', 'url' => 'task-notice', 'icon' => 'radio_button_unchecked'],
    ]];

    $this->menuItems[] = ['name' => 'claim', 'label' => 'Claim', 'url' => '#', 'icon' => 'branding_watermark', 'childs' => [
      ['name' => 'claim', 'label' => 'Berita Acara', 'url' => 'berita-acara', 'icon' => 'radio_button_unchecked'],
      ['name' => 'claim', 'label' => 'Claim Notes', 'url' => 'claim-notes', 'icon' => 'radio_button_unchecked'],
      ['name' => 'claim', 'label' => 'Summary Claim Notes', 'url' => 'summary-claim-notes', 'icon' => 'radio_button_unchecked'],
      ['name' => 'claim', 'label' => 'Claim Insurance', 'url' => 'claim-insurance', 'icon' => 'radio_button_unchecked'],
    ]];

    $this->menuItems[] = ['name' => 'during', 'label' => 'During', 'url' => '#', 'icon' => 'ac_unit', 'childs' => [
      ['name' => 'during', 'label' => 'Berita Acara During', 'url' => 'berita-acara-during', 'icon' => 'radio_button_unchecked'],
      ['name' => 'during', 'label' => 'Damage Goods Report', 'url' => 'damage-goods-report', 'icon' => 'radio_button_unchecked'],
      ['name' => 'during', 'label' => 'Summary DGR', 'url' => 'summary-damage-goods-report', 'icon' => 'radio_button_unchecked'],
      // ['name' => 'during', 'label' => 'Claim Insurance', 'url' => 'claim-insurance', 'icon' => 'radio_button_unchecked'],
    ]];

    $this->menuItems[] = ['name' => 'report', 'label' => 'Stock Take', 'url' => '#', 'icon' => 'rate_review', 'childs' => [
      ['name' => 'report', 'label' => 'Stock Take Schedule', 'url' => 'stock-take-schedule', 'icon' => 'radio_button_unchecked'],
      ['name' => 'report', 'label' => 'Stock Take Create Tag', 'url' => 'stock-take-create-tag', 'icon' => 'radio_button_unchecked'],
      ['name' => 'report', 'label' => 'Stock Take Input 1', 'url' => 'stock-take-input-1', 'icon' => 'radio_button_unchecked'],
      ['name' => 'report', 'label' => 'Stock Take Input 2', 'url' => 'stock-take-input-2', 'icon' => 'radio_button_unchecked'],
      ['name' => 'report', 'label' => 'Stock Take Quick Count', 'url' => 'stock-take-quick-count', 'icon' => 'radio_button_unchecked'],
      ['name' => 'report', 'label' => 'Stock Take Compare SAP', 'url' => 'stock-take-compare-sap', 'icon' => 'radio_button_unchecked'],
    ]];

    $this->menuItems[] = ['name' => 'report', 'label' => 'Report', 'url' => '#', 'icon' => 'style', 'childs' => [
      ['name' => 'report', 'label' => 'Report Master', 'url' => 'report-master', 'icon' => 'radio_button_unchecked'],
      ['name' => 'report', 'label' => 'Report Master Users', 'url' => 'report-master-users', 'icon' => 'radio_button_unchecked'],
      ['name' => 'report', 'label' => 'Standby Driver List', 'url' => 'standby-driver-list', 'icon' => 'radio_button_unchecked'],
      ['name' => 'report', 'label' => 'Concept or DO Outstanding List', 'url' => 'concept-or-do-outstanding-list', 'icon' => 'radio_button_unchecked'],
      ['name' => 'report', 'label' => 'Loading Status List', 'url' => 'loading-status-list', 'icon' => 'radio_button_unchecked'],
      ['name' => 'report', 'label' => 'Report Concept Coming VS Actual Loading', 'url' => 'report-concept-coming-vs-actual-loading', 'icon' => 'radio_button_unchecked'],
      ['name' => 'report', 'label' => 'Concept Issue', 'url' => 'concept-issue', 'icon' => 'radio_button_unchecked'],
      ['name' => 'report', 'label' => 'Report Loading Lead Time', 'url' => 'report-loading-lead-time', 'icon' => 'radio_button_unchecked'],
      ['name' => 'report', 'label' => 'Report Loading Summary', 'url' => 'report-loading-summary', 'icon' => 'radio_button_unchecked'],
      ['name' => 'report', 'label' => 'Report KPi Expeditions', 'url' => 'report-kpi-expeditions', 'icon' => 'radio_button_unchecked'],
      ['name' => 'report', 'label' => 'Summary Incoming Report', 'url' => 'summary-incoming-report', 'icon' => 'radio_button_unchecked'],
      ['name' => 'report', 'label' => 'Summary Outgoing Report', 'url' => 'summary-outgoing-report', 'icon' => 'radio_button_unchecked'],
      ['name' => 'report', 'label' => 'Report Master Freight Cost', 'url' => 'report-master-freight-cost', 'icon' => 'radio_button_unchecked'],
      ['name' => 'report', 'label' => 'Summary Freight Cost Report Per Manifest', 'url' => 'summary-freight-cost-report-per-manifest', 'icon' => 'radio_button_unchecked'],
      ['name' => 'report', 'label' => 'Summary Freight Cost Report Per Region', 'url' => 'summary-freight-cost-report-per-region', 'icon' => 'radio_button_unchecked'],
      ['name' => 'report', 'label' => 'Report Overload Concept or DO', 'url' => 'report-overload-concept-or-do', 'icon' => 'radio_button_unchecked'],
      ['name' => 'report', 'label' => 'Summary Task Notice', 'url' => 'summary-task-notice', 'icon' => 'radio_button_unchecked'],
      ['name' => 'report', 'label' => 'Report User Mobile', 'url' => 'report-user-mobile', 'icon' => 'radio_button_unchecked'],
      ['name' => 'report', 'label' => 'Summary LMB Report', 'url' => 'summary-lmb-report', 'icon' => 'radio_button_unchecked'],
      ['name' => 'report', 'label' => 'Report Inventory Movement', 'url' => 'report-inventory-movement', 'icon' => 'radio_button_unchecked'],
      ['name' => 'report', 'label' => 'Report Stock Inventory', 'url' => 'report-stock-inventory', 'icon' => 'radio_button_unchecked'],
      ['name' => 'report', 'label' => 'Serial Number Trace', 'url' => 'serial-number-trace', 'icon' => 'radio_button_unchecked'],
      ['name' => 'report', 'label' => 'Report Occupancy', 'url' => 'report-occupancy', 'icon' => 'radio_button_unchecked'],
      ['name' => 'report', 'label' => 'Summary WH Transporter Report', 'url' => 'summary-wh-transporter-report', 'icon' => 'radio_button_unchecked'],
      ['name' => 'report', 'label' => 'Summary DO Confirmed', 'url' => 'summary-do-confirmed', 'icon' => 'radio_button_unchecked'],
    ]];
    $this->menuItems[] = ['name' => 'master', 'label' => 'Master Data', 'url' => '#', 'icon' => 'storage', 'childs' => [
      ['name' => 'master', 'label' => 'Master Gate', 'url' => 'master-gate', 'icon' => 'radio_button_unchecked'],
      ['name' => 'master', 'label' => 'Master Destination', 'url' => 'master-destination', 'icon' => 'radio_button_unchecked'],
      ['name' => 'master', 'label' => 'Master Vehicle', 'url' => 'master-vehicle', 'icon' => 'radio_button_unchecked'],
      ['name' => 'master', 'label' => 'Master Expedition', 'url' => 'master-expedition', 'icon' => 'radio_button_unchecked'],
      ['name' => 'master', 'label' => 'Master Vehicle Expedition', 'url' => 'master-vehicle-expedition', 'icon' => 'radio_button_unchecked'],
      ['name' => 'master', 'label' => 'Master Driver', 'url' => 'master-driver', 'icon' => 'radio_button_unchecked'],
      ['name' => 'master', 'label' => 'Destination City', 'url' => 'destination-city', 'icon' => 'radio_button_unchecked'],
      ['name' => 'master', 'label' => 'Master Freight Cost', 'url' => 'master-freight-cost', 'icon' => 'radio_button_unchecked'],
      ['name' => 'master', 'label' => 'Storage Master', 'url' => 'storage-master', 'icon' => 'radio_button_unchecked'],
      ['name' => 'master', 'label' => 'Master Model', 'url' => 'master-model', 'icon' => 'radio_button_unchecked'],
      ['name' => 'master', 'label' => 'Master Vendor', 'url' => 'master-vendor', 'icon' => 'radio_button_unchecked'],
      ['name' => 'master', 'label' => 'Master Model Exception', 'url' => 'master-model-exception', 'icon' => 'radio_button_unchecked'],
      ['name' => 'master', 'label' => 'Master Branch Expedition', 'url' => 'master-branch-expedition', 'icon' => 'radio_button_unchecked'],
      ['name' => 'master', 'label' => 'Branch Expedition Vehicle', 'url' => 'branch-expedition-vehicle', 'icon' => 'radio_button_unchecked'],
      ['name' => 'master', 'label' => 'Branch Master Driver', 'url' => 'branch-master-driver', 'icon' => 'radio_button_unchecked'],
      ['name' => 'master', 'label' => 'Destination City of Branch', 'url' => 'destination-city-of-branch', 'icon' => 'radio_button_unchecked'],
    ]];
    $this->menuItems[] = ['name' => 'setting', 'label' => 'Setting', 'url' => '#', 'icon' => 'build', 'childs' => [
      ['name' => 'setting', 'label' => 'User Manager', 'url' => 'user-manager', 'icon' => 'radio_button_unchecked'],
      ['name' => 'setting', 'label' => 'User Roles', 'url' => 'user-roles', 'icon' => 'radio_button_unchecked'],
      ['name' => 'setting', 'label' => 'Master Area', 'url' => 'master-area', 'icon' => 'radio_button_unchecked'],
      ['name' => 'setting', 'label' => 'Master Cabang', 'url' => 'master-cabang', 'icon' => 'radio_button_unchecked'],
      ['name' => 'setting', 'label' => 'Master User Mobile', 'url' => 'master-user-mobile', 'icon' => 'radio_button_unchecked'],
    ]];
  }

  /**
   * Bind data to the view.
   *
   * @param  View  $view
   * @return void
   */
  public function compose(View $view)
  {
    $view->with('navList', $this->getMenu());
  }

  public function getMenu()
  {
    $menuItems = [];
    $modules   = auth()->user()->modules();
    foreach ($this->menuItems as $key => $menu) {
      if (empty($menu['name'])) {
        $menuItems[] = $menu;
      }

      if (!empty($menu['childs'])) {
        $menuData           = $menu;
        $menuData['childs'] = [];

        foreach ($menu['childs'] as $key => $child_menu) {
          if (!empty($modules[$child_menu['url']]) && $modules[$child_menu['url']]['view'] == 1) {
            $menuData['childs'][] = $child_menu;
          }
        }

        if (!empty($menuData['childs'])) {
          $menuItems[] = $menuData;
        }
      }
    }
    return $menuItems;
  }
}
