<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    public $timestamp = true;
    protected $primaryKey = 'article_id';
    protected $fillable = [
        'title',
        'content',
        'is_publish',
        'is_accept',
        'published_at',
    ];
    public function bookmarks(){
        return $this->hasMany(Bookmark::class);
    }
    public function serie(){
        return $this->belongsTo(Serie::class, 'serie_id','serie_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id','user_id');
    }

    
    public function articleRequest(){
        return $this->hasOne(ArticleRequest::class);
    }
    public function tags(){
        return $this->belongsToMany(Tag::class,'article_tag', 'article_id','tag_id');
    }
    public function privacy(){
        return $this->belongsTo(Privacy::class,'privacy_id','privacy_id');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class,'commentable');
    }
}
