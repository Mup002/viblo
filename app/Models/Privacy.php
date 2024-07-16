<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Privacy extends Model
{
    use HasFactory;
    protected $primaryKey = 'privacy_id';
    protected $fillable = [
        'name',
        'description'
    ];
    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
