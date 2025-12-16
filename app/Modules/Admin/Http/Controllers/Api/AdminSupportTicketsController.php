<?php

namespace  App\Modules\Admin\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Modules\Admin\Http\Requests\SupportTicket\IndexAdminSupportTicketsRequest;
use App\Modules\Admin\Http\Requests\SupportTicket\ShowAdminSupportTicketRequest;
use App\Modules\Admin\Http\Requests\SupportTicket\UpdateNoteAdminSupportTicketsRequest;
use App\Modules\Admin\Http\Requests\SupportTicket\UpdateStatusAdminSupportTicketsRequest;
use App\Modules\Admin\Services\SupportTicketsManagementService;
use App\Modules\SupportTickets\Entities\SupportTicket;
use App\Modules\SupportTickets\Http\Resources\SupportTicketResource;

class  AdminSupportTicketsController extends ApiController
{
    public function index(IndexAdminSupportTicketsRequest $request)
    {

        try {
            $validated = $request->validated();
            return  SupportTicketsManagementService::getAll($validated);
        }catch (\Throwable $th){
            return $this->respondError("ERROR GET SUPPORTS TO ADMIN With message: " . $th->getMessage());
        }
    }
    public function show(ShowAdminSupportTicketRequest $request , SupportTicket $supportTicket)
    {

        try {
            $validated = $request->validated();
            return  new  SupportTicketResource($supportTicket);
        }catch (\Throwable $th){
            return $this->respondError("ERROR GET SUPPORT TO ADMIN With message: " . $th->getMessage());
        }
    }
    public function updateStatus(UpdateStatusAdminSupportTicketsRequest $request,   SupportTicket $supportTicket )
    {
        try {
            $validated = $request->validated();
            $supportTicket->status = $validated['status'];

            if(array_key_exists('note' , $validated)){
                $supportTicket->note = $this->getNewNoteValue($supportTicket->note, $validated);
            }
            $saved = $supportTicket->save();
            if($saved){
                return new  SupportTicketResource($supportTicket);
            }
            return  $this->respondError("ERROR UPDATED STATUS OF SUPPORTED TICKET");
        }catch (\Throwable $th){
            return $this->respondError("ERROR UPDATE SUPPORT STATUS With message: " . $th->getMessage());
        }
    }
    public function updateNote(UpdateNoteAdminSupportTicketsRequest $request,   SupportTicket $supportTicket )
    {
        try {
            $validated = $request->validated();


            if(!array_key_exists('note', $validated)) {
            } else {
                $supportTicket->note = $this->getNewNoteValue($supportTicket->note, $validated);
            }
            $saved = $supportTicket->save();
            if($saved){
                return new  SupportTicketResource($supportTicket);
            }
            return  $this->respondError("ERROR UPDATED STATUS OF SUPPORTED TICKET");
        }catch (\Throwable $th){
            return $this->respondError("ERROR UPDATE SUPPORT NOTE With message: " . $th->getMessage());
        }
    }

    /**
     * @param SupportTicket $supportTicket
     * @param mixed $validated
     * @return string
     */
    protected function getNewNoteValue($oldNote, mixed $validated):string
    {
        $note = "\n----------------\n" . $oldNote;
        if (array_key_exists('append', $validated)) {
            if ($validated['append']) {
                $note = $validated['note'] . $note;
            } else {
                $note = $validated['note'];
            }

        } else {
            // default is append
            $note = $validated['note'] . $note;
        }
        return $note;
    }
}
