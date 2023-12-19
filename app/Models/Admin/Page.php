<?php

namespace App\Models\Admin;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use Sluggable;

    protected $table = 'app_pages';
    protected $fillable = ['type', 'title_fa', 'title_en', 'slug', 'status', 'images', 'body_fa', 'body_en', 'seo_description_fa', 'seo_description_en', 'views_count'];
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
