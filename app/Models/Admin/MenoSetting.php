<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenoSetting extends Model
{
    protected $table = 'app_meno_settings';
    protected $fillable = ['meno'];
    use HasFactory;
}
