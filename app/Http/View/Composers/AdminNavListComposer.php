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
    $this->menuItems[] = ['name' => 'home', 'label' => 'Home', 'url' => 'home', 'icon' => 'account_balance'];

    $this->menuItems[] = ['name' => 'dashboard', 'label' => 'Dashboard', 'url' => '#', 'icon' => 'dvr', 'childs' => [
      ['name' => 'dashboard', 'label' => 'Graphic Dashboard', 'url' => 'dashboard', 'icon' => 'radio_button_unchecked'],
      ['name' => 'dashboard', 'label' => 'Graphic Dashboard 2', 'url' => 'dashboard2', 'icon' => 'radio_button_unchecked'],
      ['name' => 'dashboard', 'label' => 'Trucking Monitor', 'url' => 'trucking-monitor', 'icon' => 'radio_button_unchecked'],
    ]];

    $this->menuItems[] = ['name' => 'incoming', 'label' => 'Incoming', 'url' => '#', 'icon' => 'play_for_work', 'childs' => [
      ['name' => 'incoming', 'label' => 'Finish Good Production', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'incoming', 'label' => 'Incoming Import/OEM', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'incoming', 'label' => 'Confirm Manifest', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'incoming', 'label' => 'Billing Return', 'url' => '#', 'icon' => 'radio_button_unchecked'],
    ]];

    $this->menuItems[] = ['name' => 'other', 'label' => 'Others', 'url' => '#', 'icon' => 'assessment', 'childs' => [
      ['name' => 'other', 'label' => 'Clean Concept', 'url' => '#', 'icon' => 'radio_button_unchecked'],
    ]];

    // $this->menuItems[] = ['name' => 'picking', 'label' => 'Picking', 'url' => '#', 'icon' => 'rv_hookup', 'childs' => [
    //   ['name' => 'picking', 'label' => 'Upload DO for Picking', 'url' => 'upload-do-for-picking', 'icon' => 'radio_button_unchecked'],
    //   ['name' => 'picking', 'label' => 'Picking List', 'url' => 'picking-list', 'icon' => 'radio_button_unchecked'],
    //   ['name' => 'picking', 'label' => 'Picking to LMB', 'url' => 'picking-to-lmb', 'icon' => 'radio_button_unchecked'],
    // ]];
    $this->menuItems[] = ['name' => 'outgoing', 'label' => 'Outgoing', 'url' => '#', 'icon' => 'looks', 'childs' => [
      ['name' => 'outgoing', 'label' => 'Upload Concept', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'outgoing', 'label' => 'IDCard Scan', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'outgoing', 'label' => 'Assign Vehicles', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'outgoing', 'label' => 'Select Gate', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'outgoing', 'label' => 'Loading Process', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'outgoing', 'label' => 'Complete', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'outgoing', 'label' => 'Manifest Regular', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'outgoing', 'label' => 'Manifest AS', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'outgoing', 'label' => 'Update Manifest', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'outgoing', 'label' => 'Overload Concept or DO', 'url' => '#', 'icon' => 'radio_button_unchecked'],
    ]];

    $this->menuItems[] = ['name' => 'invoicing', 'label' => 'Invoicing', 'url' => '#', 'icon' => 'pages', 'childs' => [
      ['name' => 'invoicing', 'label' => 'List of Unconfirm DO', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'invoicing', 'label' => 'Receipt Invoice', 'url' => 'receipt-invoice', 'icon' => 'radio_button_unchecked'],
      ['name' => 'invoicing', 'label' => 'Receipt Invoice Accounting', 'url' => 'receipt-invoice-accounting', 'icon' => 'radio_button_unchecked'],
      ['name' => 'invoicing', 'label' => 'Summary Freight Cost Analysis', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'invoicing', 'label' => 'Branch Invoicing', 'url' => 'branch-invoicing', 'icon' => 'radio_button_unchecked'],
    ]];
    $this->menuItems[] = ['name' => 'inventory', 'label' => 'Inventory', 'url' => '#', 'icon' => 'store', 'childs' => [
      ['name' => 'inventory', 'label' => 'Storage Inventory Monitoring', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'inventory', 'label' => 'Upload Inventory Storage', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'inventory', 'label' => 'Adjust Inventory Movement', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'inventory', 'label' => 'Transfer SLoc', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'inventory', 'label' => 'Cancel Movement', 'url' => '#', 'icon' => 'radio_button_unchecked'],
    ]];

    $this->menuItems[] = ['name' => 'report', 'label' => 'Return', 'url' => '#', 'icon' => 'low_priority', 'childs' => [
      ['name' => 'report', 'label' => 'Task Notice', 'url' => '#', 'icon' => 'radio_button_unchecked'],
    ]];

    $this->menuItems[] = ['name' => 'report', 'label' => 'Stock Take', 'url' => '#', 'icon' => 'rate_review', 'childs' => [
      ['name' => 'report', 'label' => 'Stock Take Schedule', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'report', 'label' => 'Stock Take Create Tag', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'report', 'label' => 'Stock Take Input 1', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'report', 'label' => 'Stock Take Input 2', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'report', 'label' => 'Stock Take Quick Count', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'report', 'label' => 'Stock Take Compare SAP', 'url' => '#', 'icon' => 'radio_button_unchecked'],
    ]];

    $this->menuItems[] = ['name' => 'report', 'label' => 'Report', 'url' => '#', 'icon' => 'style', 'childs' => [
      ['name' => 'report', 'label' => 'Report Master', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'report', 'label' => 'Report Master User', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'report', 'label' => 'Standby Driver List', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'report', 'label' => 'Concept or DO Outstanding List', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'report', 'label' => 'Loading Status List', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'report', 'label' => 'Report Concept Coming VS Actual Loading', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'report', 'label' => 'Concept Issue', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'report', 'label' => 'Report Loading Lead Time', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'report', 'label' => 'Report Loading Summary', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'report', 'label' => 'Report KPi Expeditions', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'report', 'label' => 'Summary Incoming Report', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'report', 'label' => 'Summary Outgoing Report', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'report', 'label' => 'Report Master Freight Cost', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'report', 'label' => 'Summary Freight Cost Report Per Manifest', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'report', 'label' => 'Summary Freight Cost Report Per Region', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'report', 'label' => 'Report Overload Concept or DO', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'report', 'label' => 'Summary Task Notice', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'report', 'label' => 'Report User Mobile', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'report', 'label' => 'Summary LMB Report', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'report', 'label' => 'Report Inventory Movement', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'report', 'label' => 'Report Stock Inventory', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'report', 'label' => 'Serial Number Trace', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'report', 'label' => 'Report Occupancy', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'report', 'label' => 'Summary WH Transporter Report', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'report', 'label' => 'Summary DO Confirmed', 'url' => '#', 'icon' => 'radio_button_unchecked'],
    ]];
    $this->menuItems[] = ['name' => 'master', 'label' => 'Master Data', 'url' => '#', 'icon' => 'storage', 'childs' => [
      ['name' => 'master', 'label' => 'Master Gate', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'master', 'label' => 'Master Destioantion', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'master', 'label' => 'Master Vehicle', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'master', 'label' => 'Master Expedition', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'master', 'label' => 'Master Vehicle Expedition', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'master', 'label' => 'Master Driver', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'master', 'label' => 'Destionation City', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'master', 'label' => 'Master Freight Cost', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'master', 'label' => 'Storage Master', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'master', 'label' => 'Master Model', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'master', 'label' => 'Master Vendor', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'master', 'label' => 'Master Model Exception', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'master', 'label' => 'Master Branch Expedition', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'master', 'label' => 'Branch Expedition Vehicle', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'master', 'label' => 'Branch Master Driver', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'master', 'label' => 'Destination City of Branch', 'url' => '#', 'icon' => 'radio_button_unchecked'],
    ]];
    $this->menuItems[] = ['name' => 'setting', 'label' => 'Setting', 'url' => '#', 'icon' => 'build', 'childs' => [
      ['name' => 'setting', 'label' => 'User Manager', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'setting', 'label' => 'User Roles', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'setting', 'label' => 'Master Area', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'setting', 'label' => 'Master Cabang', 'url' => '#', 'icon' => 'radio_button_unchecked'],
      ['name' => 'setting', 'label' => 'Master User Mobile', 'url' => '#', 'icon' => 'radio_button_unchecked'],
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
    $view->with('navList', $this->menuItems);
  }
}
