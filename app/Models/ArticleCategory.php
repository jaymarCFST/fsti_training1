<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleCategory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'updated_user_id'
    ];

    /**
     * Category - Article Relationship
     *
     */
    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    /**
     * Article Category - User Relationship
     *
     */
    public function created_by()
    {
        return $this->belongsTo(User::class, 'updated_user_id', 'id');
    }


}
