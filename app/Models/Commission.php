<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Commission extends Model
{
    use LogsActivity;

    protected $fillable = [
        'user_id',
        'client_name',
        'client_email',
        'client_discord',
        'description',
        'character_type',
        'character_count',
        'reference_images',
        'budget',
        'status',
        'deadline',
        'admin_notes',
        'assigned_to',
    ];

    protected $casts = [
        'character_count' => 'integer',
        'budget' => 'decimal:2',
        'deadline' => 'date',
        'reference_images' => 'array',
    ];

    /**
     * Get the user who created this commission.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the admin user assigned to this commission.
     */
    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Get the status badge color.
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'yellow',
            'reviewing' => 'blue',
            'accepted' => 'green',
            'in_progress' => 'purple',
            'completed' => 'emerald',
            'cancelled' => 'gray',
            'rejected' => 'red',
            default => 'gray',
        };
    }
}
