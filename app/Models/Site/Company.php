<?php

namespace App\Models\Site;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use Sluggable;
    protected $table = 'app_companies';
    protected $fillable = ['users_management', 'slug', 'status', 'verified', 'body_fa', 'body_en', 'data', 'logo', 'document_one', 'document_tow', 'document_three'];
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
