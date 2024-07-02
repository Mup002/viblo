<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    
    public $timestamp = true;
    public function bookmarks(){
        return $this->hasMany(Bookmark::class);
    }
    public function serie(){
        return $this->belongsTo(Serie::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function articleRequest(){
        return $this->hasOne(ArticleRequest::class);
    }
    public function tags(){
        return $this->belongsToMany(Tag::class);
    }
}
