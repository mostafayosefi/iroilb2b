<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Cviebrock\EloquentSluggable\Sluggable;

class Post extends Model
{
    use Sluggable;
    protected $table = 'app_posts';
    protected $fillable = ['title', 'slug', 'language', 'status', 'images', 'user_id', 'categories', 'labels', 'body', 'seo_description', 'seo_kaywords', 'views_count', 'comments_count'];
    use HasFactory;
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['slug']
            ]
        ];
    }
}
