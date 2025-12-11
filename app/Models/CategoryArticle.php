<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryArticle extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title_en',
        'title_kh',
        'description_en',
        'description_kh',
        'url',
        'type',
        'status'
    ];
}
