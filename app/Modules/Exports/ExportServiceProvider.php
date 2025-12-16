<?php

namespace  App\Modules\Exports;

use App\Modules\Exports\Contracts\ExportStrategy;
use App\Modules\Exports\ExportStrategies\BrowserShotStrategy;
use Illuminate\Support\ServiceProvider;

class  ExportServiceProvider extends  ServiceProvider
{

    public function  register()
    {
        $this->app->singleton(ExportStrategy::class , function ($app){
            return new BrowserShotStrategy();
        });
        $this->app->singleton(ExportManager::class,function ($app){
            return new ExportManager(
                    new BrowserShotStrategy()
            );
        });
    }
    public function boot(){

    }

}

