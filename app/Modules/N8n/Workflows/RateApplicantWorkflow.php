<?php

namespace App\Modules\N8n\Workflows;

use App\Modules\N8n\Contracts\WorkflowHandlerInterface;
use App\Modules\N8n\N8nClient;

class RateApplicantWorkflow implements WorkflowHandlerInterface
{
    public function __construct(private N8nClient $client) {}
    public function handle(array $payload): array
    {
        return $this->client->call('rateApplicants', $payload);
    }
}
