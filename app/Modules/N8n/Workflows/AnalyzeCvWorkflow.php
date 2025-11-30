<?php

namespace App\Modules\N8n\Workflows;

use App\Models\User;
use App\Modules\N8n\Contracts\WorkflowHandlerInterface;
use App\Modules\N8n\N8nClient;

class AnalyzeCvWorkflow implements WorkflowHandlerInterface
{
    public function __construct(private N8nClient $client) {}

    public function handle(array $payload): array
    {
        return $this->client->call('cvAnalize', $payload);
    }
}
