<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'follower_id',
        'created_at',
        'updated_at',
    ];
    public function user(){
        $this->belongsTo(User::class);
    }
}
