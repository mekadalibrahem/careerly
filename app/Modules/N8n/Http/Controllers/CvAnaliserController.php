<?php

namespace App\Modules\N8n\Http\Controllers;

use App\Http\Controllers\Api\ApiController;
use App\Models\User;
use App\Modules\N8n\WorkflowManager;
use App\Modules\N8n\Workflows\AnalyzeCvWorkflow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CvAnaliserController extends ApiController
{

    public function analyzeCV(Request $request, WorkflowManager $manager)
    {
        try {

            $user_id = Auth::user()->id;
           
            $manager->run('analyze_cv', AnalyzeCvWorkflow::preperPayload($user_id));
            return $this->respondOk("Your request sent");
        } catch (\Throwable $th) {
            return $this->respondError("ERROR TO SENT REQUEST: $th->getMesaage()");
        }
    }
    public function store(Request $request)
    {
        $output = $request['result']['output'];
        $user_id = $output['user_id'];


        if (!$output) {
            return response()->json([
                'error' => 'Invalid payload format from n8n'
            ], 422);
        }



        // Save full result JSON
        User::where('id', $user_id)->update([
            'ai' => json_encode($output)
        ]);

        // Fire your event for notifications
        // event(new CvAnalysisCompleted($userId));

        return response()->json(['status' => 'received']);
    }
}
