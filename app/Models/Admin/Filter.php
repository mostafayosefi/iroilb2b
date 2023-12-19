<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{
    protected $table = 'app_filters';
    protected $fillable = ['name_en','name_fa'];
    use HasFactory;
}
