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
}
