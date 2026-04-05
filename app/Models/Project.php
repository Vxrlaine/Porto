<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    // use LogsActivity;

    protected $fillable = [
        'title',
        'description',
        'image_path',
        'client_name',
        'completion_date',
        'project_url',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'completion_date' => 'date',
    ];
}
