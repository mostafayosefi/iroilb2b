<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = 'app_tickets';
    protected $fillable = ['user_id', 'status', 'subject', 'text', 'file'];
    use HasFactory;
}
