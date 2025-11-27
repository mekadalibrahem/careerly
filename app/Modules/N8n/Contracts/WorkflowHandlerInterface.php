<?php

namespace App\Modules\N8n\Contracts;

interface WorkflowHandlerInterface
{
    public function handle(array $payload): array;
}
