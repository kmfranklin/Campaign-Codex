<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use BladeUI\Icons\Factory;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   */
  public function register(): void
  {
    //
  }

  /**
   * Bootstrap any application services.
   */
  public function boot(): void
  {
    $this->app->booted(function () {
      $icons = app(Factory::class);

      $icons->add('custom', [
        'path' => resource_path('svg'),
        'prefix' => 'icon',
      ]);
    });
  }
}
