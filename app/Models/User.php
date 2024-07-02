<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use  HasFactory;

    protected $fillable = [
        'username',
        'email',
        'password',
        'real_name',
        'display_name'
    ];
    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'password' => 'hashed',
    ];

    public $timestamp = true;
    public function role(){
        return $this-> belongsTo(Role::class);
    }

    public function followers(){
        return $this->hasMany(Follower::class);
    }
    public function articles(){
        return $this->hasMany(Article::class);
    }

    public function votes(){
        return $this->hasMany(Vote::class);
    }
    public function series(){
        return $this->hasMany(Serie::class);
    }

    public function bookmarks(){
        return $this->hasMany(Bookmark::class);
    }
    public function questions(){
        return $this->hasMany(Question::class);
    }
    public function articleRequest(){
        return $this->hasMany(ArticleRequest::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function reports(){
        return $this->hasMany(Report::class);
    }
}
