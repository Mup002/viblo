<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPending extends Model
{
    use HasFactory;
    protected $fillable = [
        'username',
        'display_name',
        'real_name',
        'password',
        'email',
        'verify_token',
        'expires_at'
    ];
    protected $primaryKey = 'up_id';
}
