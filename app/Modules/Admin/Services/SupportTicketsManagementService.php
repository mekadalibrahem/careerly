<?php
namespace  App\Modules\Admin\Services;

use App\Modules\SupportTickets\Entities\SupportTicket;
use App\Modules\SupportTickets\Http\Resources\SupportTicketResource;

class  SupportTicketsManagementService
{
    public  static function  getAll($params)
    {
        $query = SupportTicket::query();
        if(array_key_exists('priorities', $params)){

            $query->priority($params['priorities']);
        }
        if(array_key_exists('status', $params)){

            $query->whereIn("support_tickets.status" , $params['status']);
        }
        if(array_key_exists('searchString', $params)){
            $query->whereAny(['support_tickets.subject' , 'support_tickets.message'] , 'like' ,"%".$params['searchString']."%");

        }
        $query->orderByDesc('created_at');
        return  SupportTicketResource::collection($query->paginate(10));
    }
}
