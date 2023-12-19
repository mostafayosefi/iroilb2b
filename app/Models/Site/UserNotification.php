<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    protected $table = 'app_user_notifications';
    protected $fillable = ['user_id_receiver', 'user_id_sender', 'status', 'message'];
    use HasFactory;
}
