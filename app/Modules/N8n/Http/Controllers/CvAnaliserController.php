<?php

namespace App\Modules\N8n\Http\Controllers;

use App\Http\Controllers\Api\ApiController;
use App\Jobs\SendCvAnalyzeRequest;
use App\Jobs\StoreCvAnalyze;
use App\Models\User;
use App\Modules\N8n\Enums\AiAnalyzeTypeEnum;
use App\Modules\N8n\Http\Requests\ShowUserCvAnalyzeRequest;
use App\Modules\N8n\Http\Requests\UserCvAnalyzeRequest;

use Illuminate\Http\Request;

class CvAnaliserController extends ApiController
{

    public function analyzeCV(UserCvAnalyzeRequest $request, User $user)
    {
        try {
            $request->validated();

            SendCvAnalyzeRequest::dispatch($user);
            return $this->respondOk("Your request sent");
        } catch (\Throwable $th) {
            return $this->respondError("ERROR TO SENT REQUEST: " . $th->getMessage());
        }
    }
    public function store(Request $request)
    {
        $output = $request['result']['output'];

        if (!$output) {
            return response()->json([
                'error' => 'Invalid payload format from n8n'
            ], 422);
        }
        StoreCvAnalyze::dispatch($output);
        return response()->json(['status' => 'received']);
    }
    public function show(ShowUserCvAnalyzeRequest $request, User $user)
    {
        try {
            $request->validated();
            $analyze = $user->analyze()->where('type', AiAnalyzeTypeEnum::CV())->orderBy('updated_at', 'desc')->first();
            if ($analyze) {
                return $this->respondWithSuccess($analyze->toArray());
            }

            return $this->respondNotFound("NOT FOUND");
        } catch (\Throwable $th) {
            return $this->respondError("ERROR TO SENT REQUEST: " . $th->getMessage());
        }
    }
}
