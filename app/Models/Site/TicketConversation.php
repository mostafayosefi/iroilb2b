<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketConversation extends Model
{
    protected $table = 'app_ticket_conversations';
    protected $fillable = ['answer_id', 'ticket_id', 'text', 'file'];
    use HasFactory;
}
