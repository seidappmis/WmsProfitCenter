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
    $this->menuItems[] = ['name' => 'dashboard', 'label' => 'Dashboard', 'url' => 'dashboard', 'icon' => 'settings_input_svideo'];

    $this->menuItems[] = ['name' => 'incoming', 'label' => 'Incoming', 'url' => '#', 'icon' => 'play_for_work', 'childs' => [
      ['name' => 'incoming', 'label' => 'Incoming', 'url' => 'learning-classes', 'icon' => 'radio_button_unchecked'],
    ]];
    $this->menuItems[] = ['name' => 'picking', 'label' => 'Picking', 'url' => '#', 'icon' => 'rv_hookup', 'childs' => [
      ['name' => 'picking', 'label' => 'Upload DO for Picking', 'url' => 'upload-do-for-picking', 'icon' => 'radio_button_unchecked'],
      ['name' => 'picking', 'label' => 'Picking List', 'url' => 'picking-list', 'icon' => 'radio_button_unchecked'],
      ['name' => 'picking', 'label' => 'Picking to LMB', 'url' => 'picking-to-lmb', 'icon' => 'radio_button_unchecked'],
    ]];
    $this->menuItems[] = ['name' => 'outgoing', 'label' => 'Outgoing', 'url' => '#', 'icon' => 'present_to_all', 'childs' => [
      ['name' => 'outgoing', 'label' => 'Outgoing', 'url' => 'learning-classes', 'icon' => 'radio_button_unchecked'],
    ]];
    $this->menuItems[] = ['name' => 'invoicing', 'label' => 'Invoicing', 'url' => '#', 'icon' => 'pages', 'childs' => [
      ['name' => 'invoicing', 'label' => 'Invoicing', 'url' => 'learning-classes', 'icon' => 'radio_button_unchecked'],
    ]];
    $this->menuItems[] = ['name' => 'inventory', 'label' => 'Inventory', 'url' => '#', 'icon' => 'store', 'childs' => [
      ['name' => 'inventory', 'label' => 'Inventory', 'url' => 'learning-classes', 'icon' => 'radio_button_unchecked'],
    ]];
    $this->menuItems[] = ['name' => 'report', 'label' => 'Report', 'url' => '#', 'icon' => 'rate_review', 'childs' => [
      ['name' => 'report', 'label' => 'Report', 'url' => 'learning-classes', 'icon' => 'radio_button_unchecked'],
    ]];
    $this->menuItems[] = ['name' => 'master', 'label' => 'Master Data', 'url' => '#', 'icon' => 'storage', 'childs' => [
      ['name' => 'master', 'label' => 'Master Data', 'url' => 'learning-classes', 'icon' => 'radio_button_unchecked'],
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
