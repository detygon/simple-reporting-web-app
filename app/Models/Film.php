<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    use HasFactory;

    protected $table = 'film';

    public function actors()
    {
        return $this->belongsToMany(Actor::class);
    }

    public function category()
    {
        return $this->belongsToMany(Category::class);
    }
}
