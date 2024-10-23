<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $table = 'tag';
    protected $fillable = ['nama', 'slug'];

    public function article()
    {
        // return $this->belongsToMany(Article::class, 'article_tag', 'id_article', 'id_tag');
        return $this->belongsToMany(Article::class, 'article_tag', 'id_tag', 'id_article');
    }
}
