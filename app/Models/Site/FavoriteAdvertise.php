<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoriteAdvertise extends Model
{
    protected $table = 'app_favorite_advertises';
    protected $fillable = ['id', 'user_id', 'ads_id'];
    use HasFactory;
}
