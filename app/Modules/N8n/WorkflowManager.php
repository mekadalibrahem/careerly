<?php

namespace App\Modules\N8n;

use App\Modules\N8n\Enums\AiAnalyzeTypeEnum;
use App\Modules\N8n\Workflows\AnalyzeCvWorkflow;
use App\Modules\N8n\Workflows\RateApplicantWorkflow;

class WorkflowManager
{
    private array $workflows;

    public function __construct(
        AnalyzeCvWorkflow $cv,
        RateApplicantWorkflow $rateApplicant,

    ) {
        $this->workflows = [
            AiAnalyzeTypeEnum::CV() => $cv,
            AiAnalyzeTypeEnum::APPLICANT() => $rateApplicant,
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
