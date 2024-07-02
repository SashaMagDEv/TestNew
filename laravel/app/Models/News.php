<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'thumbnail',
        'title',
        'date',
        'short_description',
        'likes',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
