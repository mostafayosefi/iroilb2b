<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Redirect extends Model
{
    protected $table = 'app_redirects';
    protected $fillable = ['link','redirect','status'];
    use HasFactory;
}
