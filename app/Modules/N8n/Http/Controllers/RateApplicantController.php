<?php

namespace App\Modules\N8n\Http\Controllers;

use App\Http\Controllers\Api\ApiController;
use App\Jobs\RateProcess;
use App\Jobs\StoreRateProcess;
use App\Modules\N8n\Http\Requests\ApplicantRateRequest;
use App\Modules\Works\Entities\Models\Work;
use Illuminate\Http\Request;

class RateApplicantController extends ApiController
{

    public function rate(ApplicantRateRequest $request, Work $work)
    {

        try {
            $validated = $request->validated();
            RateProcess::dispatch($work->id,  $validated['applicants_ids']);
            return $this->respondOk("Your request sent");
        } catch (\Throwable $th) {
            return $this->respondError("ERROR TO SENT REQUEST: $th->getMesaage()");
        }
    }

    public function store(Request $request)
    {
        $output = $request['result']['output'];
        //$user_id = $output['user_id'];


        if (!$output) {
            return response()->json([
                'error' => 'Invalid payload format from n8n'
            ], 422);
        }

        StoreRateProcess::dispatch($output);



        return response()->json(['status' => 'received']);
    }
}
