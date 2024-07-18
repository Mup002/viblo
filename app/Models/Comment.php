<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $primaryKey = 'comment_id';
    protected $hidden = ['is_publish', 'created_at', 'updated_at', 'reputation_condition'];
    protected $fillable = [
        'content',
        'cmtreply_id',
        'commentable_id',
        'commentable_type'
    ];
    public function user(){
        return $this->belongsTo(User::class,'user_id','user_id');
    }

    public function commentable()
    {
        return $this->morphTo();
    }
}
