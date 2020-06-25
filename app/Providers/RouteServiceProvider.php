<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Finder\Finder;

class RouteServiceProvider extends ServiceProvider
{
  /**
   * This namespace is applied to your controller routes.
   *
   * In addition, it is set as the URL generator's root namespace.
   *
   * @var string
   */
  protected $namespace = 'App\Http\Controllers';

  /**
   * The path to the "home" route for your application.
   *
   * @var string
   */
  // const HOME = '/dashboard';
  const HOME = '/home';
  /**
   * Define your route model bindings, pattern filters, etc.
   *
   * @return void
   */public function boot()
  {
    //

    parent::boot();
  }

  /**
   * Define the routes for the application.
   *
   * @return void
   */
  public function map(Router $route)
  {
    $this->mapApiRoutes();

    $this->mapWebRoutes($route);

    //
  }

  /**
   * Define the "web" routes for the application.
   *
   * These routes all receive session state, CSRF protection, etc.
   *
   * @return void
   */
  protected function mapWebRoutes($router)
  {
    Route::domain(env('APP_URL', 'wms-sharp.localhost'))
      ->middleware('web')
      ->namespace($this->namespace)
      ->group(function ($router) {
        $this->requireRoutes($router, 'Http/Routes/Web');
      });
  }

  /**
   * Define the "api" routes for the application.
   *
   * These routes are typically stateless.
   *
   * @return void
   */
  protected function mapApiRoutes()
  {
    Route::prefix('api')
      ->middleware('api')
      ->namespace($this->namespace)
      ->group(base_path('routes/api.php'));
  }

  /**
   * Requires all of the Files for Web Routes.
   *
   * @param  \Illuminate\Routing\Router  $router
   *
   * @return void
   */
  protected function requireRoutes($router, $app_path)
  {
    $files = Finder::create()
      ->in(app_path($app_path))
      ->name('*.php');

    // $files = new Finder();
    // $files->in(app_path('Http/Routes')

    $this->require_files($files);
  }

  /**
   * Requires the specified Files.
   *
   * @param  array  $files  The specified Files.
   *
   * @return void
   */
  public function require_files($files)
  {
    foreach ($files as $file) {
      require $file->getRealPath();
    }

  }
}
