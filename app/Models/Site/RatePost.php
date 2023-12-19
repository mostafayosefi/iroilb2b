<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RatePost extends Model
{
    protected $table = 'app_rate_posts';
    protected $fillable = ['post_id', 'rate'];
    use HasFactory;
}
