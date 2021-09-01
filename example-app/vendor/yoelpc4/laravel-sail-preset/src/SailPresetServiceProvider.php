<?php

namespace Yoelpc4\LaravelSailPreset;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\ServiceProvider;

class SailPresetServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            Artisan::command('sail:publish-preset', function () {
                if ($this->confirm('Do you want to replace the current runtimes & docker-compose.yml with preset?', false)) {
                    copy(__DIR__.'/../stubs/docker-compose.yml', base_path('docker-compose.yml'));
                    copy(__DIR__.'/../runtimes/7.4/Dockerfile', base_path('docker/7.4/Dockerfile'));
                    copy(__DIR__.'/../runtimes/7.4/php.ini', base_path('docker/7.4/php.ini'));
                    copy(__DIR__.'/../runtimes/8.0/Dockerfile', base_path('docker/8.0/Dockerfile'));
                    copy(__DIR__.'/../runtimes/8.0/php.ini', base_path('docker/8.0/php.ini'));

                    $this->info('Successfully publishing laravel sail preset, please run "sail build --no-cache" to re-building docker image.');
                }
            })->purpose('Publish the Laravel Sail Docker preset files.');
        }
    }

    /**
     * @inheritDoc
     */
    public function provides()
    {
        return [
            'sail.publish-preset-command',
        ];
    }
}
