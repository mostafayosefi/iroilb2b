<?php

namespace App\Models\Site;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use Sluggable;
    use HasFactory;

    protected $table = 'app_tables';
    protected $fillable = ['title', 'language', 'key', 'header', 'data', 'detail'];

    public function sluggable(): array
    {
        return [
            'key' => [
                'source' => ['key']
            ]
        ];
    }
}
