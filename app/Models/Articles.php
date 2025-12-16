<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Articles extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title_en',
        'title_kh',
        'slug_en',
        'slug_kh',
        'description_en',
        'description_kh',
        'info_en',
        'info_kh',
        'status',
        'url',
        'image',
        'category_id',
        'tag',
    ];

    public function category()
    {
        return $this->belongsTo(CategoryArticle::class, 'category_id');
    }
}
