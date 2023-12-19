<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $table = 'app_forms';
    protected $fillable = ['type', 'language', 'status', 'body'];
    use HasFactory;
}
