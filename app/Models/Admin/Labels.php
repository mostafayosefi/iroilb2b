<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Cviebrock\EloquentSluggable\Sluggable;

class Labels extends Model
{
    use Sluggable;
    protected $table = 'app_labels';
    protected $fillable = ['lang','title','slug','description'];
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
