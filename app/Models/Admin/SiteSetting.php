<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $table = 'app_site_settings';
    protected $fillable = ['site_title_fa', 'site_title_en', 'logo_light', 'logo_dark', 'fav_icon'];
}
