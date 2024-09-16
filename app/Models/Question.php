<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $primaryKey = 'question_id';
    public function tags(){
        return $this->belongsToMany(Tag::class,'tag_question','question_id','tag_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id','user_id');
    }
    public function comments()
    {
        return $this->morphMany(Comment::class,'commentable');
    }
}
