<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'article_category_id',
        'slug',
        'content',
        'image_path',
        'updated_user_id'
    ];

    /**
     * Article - Category Relationship
     *
     */
    public function category()
    {
        return $this->belongsTo(ArticleCategory::class, 'article_category_id', 'id');
    }

    /**
     * Article - User Relationship
     *
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'updated_user_id', 'id');
    }

}
