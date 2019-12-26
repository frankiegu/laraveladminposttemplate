<?php

namespace yangze\LaravelAdminPostTemplate;

use Illuminate\Support\ServiceProvider;
use yangze\LaravelAdminPostTemplate\Console\LaravelAdminPostTemplateCommand;

class LaravelAdminPostTemplateServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'yangze');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'yangze');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laraveladminposttemplate.php', 'laraveladminposttemplate');

        // Register the service the package provides.
        $this->app->singleton('laraveladminposttemplate', function ($app) {
            return new LaravelAdminPostTemplate;
        });

        // 添加生成命令
        $this->app->singleton('command.create.admin.template', function ($app) {
            return $app[LaravelAdminPostTemplateCommand::class];
        });
        $this->commands('command.create.admin.template');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['laraveladminposttemplate'];
    }
    
    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/laraveladminposttemplate.php' => config_path('laraveladminposttemplate.php'),
        ], 'laraveladminposttemplate.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/yangze'),
        ], 'laraveladminposttemplate.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/yangze'),
        ], 'laraveladminposttemplate.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/yangze'),
        ], 'laraveladminposttemplate.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
