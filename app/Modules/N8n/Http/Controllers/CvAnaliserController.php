<?php

namespace App\Modules\N8n\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\N8n\WorkflowManager;
use App\Modules\N8n\Workflows\AnalyzeCvWorkflow;
use Illuminate\Http\Request;

class CvAnaliserController extends Controller
{
    public function analyzeCV(Request $request, WorkflowManager $manager)
    {
        $user_id = 3;
        // return AnalyzeCvWorkflow::preperPayload($user_id);
        return $manager->run('analyze_cv', AnalyzeCvWorkflow::preperPayload($user_id));
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
