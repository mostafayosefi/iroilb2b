<?php

namespace App\Models\Admin;

use \Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Sluggable;
    protected $table = 'app_categories';
    protected $fillable = ['parent_id', 'slug', 'title_fa', 'title_en', 'description_fa', 'description_en'];
    use HasFactory;

    public function parent() {
        return $this->belongsTo(Category::class);
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['slug']
            ]
        ];
    }

}
