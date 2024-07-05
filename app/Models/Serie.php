<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    use HasFactory;
    public $timestamp = true;
    protected $primaryKey = 'serie_id';
    public function articles(){
        return $this->hasMany(Article::class);
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','user_id');
    }
    public function articleRequest(){
        return $this->hasOne(ArticleRequest::class);
    }
    public function tags(){
        return $this->belongsToMany(Tag::class,'serie_tag','serie_id','tag_id');
    }
}
