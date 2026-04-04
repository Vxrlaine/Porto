<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use LogsActivity;

    protected $fillable = [
        'name',
        'category',
        'proficiency',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'proficiency' => 'integer',
    ];
}
