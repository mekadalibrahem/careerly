<?php

namespace App\Modules\N8n;

use App\Modules\N8n\Workflows\AnalyzeCvWorkflow;

class WorkflowManager
{
    private array $workflows;

    public function __construct(
        AnalyzeCvWorkflow $cv,

    ) {
        $this->workflows = [
            'analyze_cv' => $cv,
        ];
    }

    public function run(string $workflow, array $data): array
    {
        if (!isset($this->workflows[$workflow])) {
            return ['error' => 'Workflow not found'];
        }

        return $this->workflows[$workflow]->handle($data);
    }
}
