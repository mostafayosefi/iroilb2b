<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminNotfication extends Model
{
    protected $table = 'app_admin_notfications';
    protected $fillable = ['status', 'text'];
    use HasFactory;
}
