<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dashboard extends Model
{
    use HasFactory;

    protected $table = 'model-stats-dashboards';

    protected $casts = [
        'body' => 'array',
    ];

    protected $attributes = [
        'body' => '{"widgets":[]}',
    ];
}
