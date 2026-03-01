<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PostCategories extends Model
{
    use HasFactory, Sluggable;
    protected $guarded = ['id'];
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
                'onUpdate' => true,
            ],
        ];
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Posts::class, 'post_category_id');
    }
}
