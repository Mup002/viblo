<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    protected $primaryKey = 'tag_id';

    public function articles(){
        return $this->belongsToMany(Article::class,'article_tag','tag_id','article_id');
    }
    public function series(){
        return $this->belongsToMany(Serie::class,'serie_tag','tag_id','serie_id');
    }
    public function questions(){
        return $this->belongsToMany(Question::class,'tag_question','tag_id','question_id');
    }
}
