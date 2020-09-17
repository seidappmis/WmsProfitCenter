<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    //
  }

  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {
    // Using class based composers...
    View::composer(
      'layouts.materialize.sidenav', 'App\Http\View\Composers\AdminNavListComposer'
    );

    // Using Closure based composers...
    View::composer('dashboard', function ($view) {
      //
    });
  }
}
