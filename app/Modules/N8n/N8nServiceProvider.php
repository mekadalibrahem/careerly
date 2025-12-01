<?php

namespace App\Modules\N8n;

use App\Modules\N8n\Workflows\AnalyzeCvWorkflow;
use App\Modules\N8n\Workflows\RateApplicantWorkflow;
use Illuminate\Support\ServiceProvider;

class N8nServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Bind N8nClient as singleton
        $this->app->singleton(N8nClient::class, function ($app) {
            return new N8nClient();
        });

        // Bind workflow handlers
        $this->app->singleton(AnalyzeCvWorkflow::class, function ($app) {
            return new AnalyzeCvWorkflow($app->make(N8nClient::class));
        });
        $this->app->singleton(RateApplicantWorkflow::class, function ($app) {
            return new RateApplicantWorkflow($app->make(N8nClient::class));
        });


        // Bind WorkflowManager as singleton
        $this->app->singleton(WorkflowManager::class, function ($app) {
            return new WorkflowManager(
                $app->make(AnalyzeCvWorkflow::class),
                $app->make(RateApplicantWorkflow::class),

            );
        });
    }

    public function boot()
    {
        //
    }
}
