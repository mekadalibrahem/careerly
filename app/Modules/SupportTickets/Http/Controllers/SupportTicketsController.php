<?php
namespace App\Modules\SupportTickets\Http\Controllers;

use App\Http\Controllers\Api\ApiController;
use App\Modules\SupportTickets\Entities\SupportTicket;
use App\Modules\SupportTickets\Http\Requests\IndexSupportTicketRequest;
use App\Modules\SupportTickets\Http\Requests\ShowSupportTicketRequest;
use App\Modules\SupportTickets\Http\Requests\StoreSupportTicketRequest;
use App\Modules\SupportTickets\Http\Resources\SupportTicketResource;
use Illuminate\Support\Facades\Auth;

class SupportTicketsController extends  ApiController
{

    public function store(StoreSupportTicketRequest $request )
    {
        try {
            $validated = $request->validated();
            $ticket = SupportTicket::create([
                "user_id" => Auth::id(),
                "message" => $validated["message"],
                "subject" => $validated['subject'],
                'priority' => $validated['priority']
            ]);
            if($ticket){
                return  $this->respondCreated($ticket);
            }
            return  $this->respondError("ERROR STORE SUPPORT");
        }catch (\Throwable $th){
            return $this->respondError("ERROR STORE SUPPORT With message: " . $th->getMessage());
        }
    }
    public function index(IndexSupportTicketRequest $request)
    {
        try {
            $request->validated();
            return SupportTicketResource::collection(SupportTicket::where("user_id" , Auth::id())
                ->orderBy('created_at' , "desc")
                ->paginate(10));
        }catch (\Throwable $th){
            return $this->respondError("ERROR GET SUPPORTS With message: " . $th->getMessage());
        }
    }
    public function show(ShowSupportTicketRequest $request , SupportTicket $supportTicket)
    {
        try {
            $request->validated();
            return new SupportTicketResource($supportTicket);
        }catch (\Throwable $th){
            return $this->respondError("ERROR GET SUPPORT With message: " . $th->getMessage());
        }
    }

}
