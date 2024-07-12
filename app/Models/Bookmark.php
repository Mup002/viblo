<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    use HasFactory;

    protected $primaryKey = 'bookmark_id';
    protected $fillable = [
        "user_id",
        "article_id",
        "created_at",
        "updated_at"
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function article(){
        return $this->belongsTo(Article::class);
    }
}
