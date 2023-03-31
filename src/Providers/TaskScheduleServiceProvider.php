<?php

namespace Encore\Admin\TaskScheduling\Providers;

use Illuminate\Support\ServiceProvider;
use Encore\Admin\TaskScheduling\TaskScheduling; 
use  Encore\Admin\TaskScheduling\Console\Commands\ListSchedule;

class TaskScheduleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // 
        $this->mergeConfigFrom(
            __DIR__.'/../../config/task-scheduling.php', 
            'task-scheduling'
        );

        $this->commands([
            ListSchedule::class,
        ]);

        $this->app->register(ConsoleServiceProvider::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $this->app->booted(function () {
            //路由
            TaskScheduling::routes(__DIR__.'/../routes/web.php');
        });

        $this->publishes([
            __DIR__.'/../../config' => config_path(),
        ], 'task-scheduling');
    }
}
