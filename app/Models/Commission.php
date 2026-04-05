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

    /**
     * Define allowed status transitions.
     * 
     * Rules:
     * - pending -> reviewing, cancelled
     * - reviewing -> accepted, rejected, cancelled
     * - accepted -> in_progress, cancelled
     * - in_progress -> completed, cancelled
     * - completed, rejected, cancelled -> final states (no transitions allowed)
     */
    public static function getAllowedTransitions(): array
    {
        return [
            'pending' => ['reviewing', 'cancelled'],
            'reviewing' => ['accepted', 'rejected', 'cancelled'],
            'accepted' => ['in_progress', 'cancelled'],
            'in_progress' => ['completed', 'cancelled'],
            'completed' => [],
            'rejected' => [],
            'cancelled' => [],
        ];
    }

    /**
     * Check if the commission can transition to a new status.
     */
    public function canTransitionTo(string $newStatus): bool
    {
        $allowedTransitions = self::getAllowedTransitions();
        $currentStatus = $this->status;

        // If current status is not in the transitions map, deny
        if (!isset($allowedTransitions[$currentStatus])) {
            return false;
        }

        // Check if new status is allowed from current status
        return in_array($newStatus, $allowedTransitions[$currentStatus]);
    }

    /**
     * Get all allowed transitions for the current status.
     */
    public function getAllowedTransitionsForCurrentStatus(): array
    {
        $allowedTransitions = self::getAllowedTransitions();
        return $allowedTransitions[$this->status] ?? [];
    }

    /**
     * Check if the commission is in a final state.
     */
    public function isFinalState(): bool
    {
        return in_array($this->status, ['completed', 'rejected', 'cancelled']);
    }

    /**
     * Validate status transition and throw exception if invalid.
     */
    public function validateStatusTransition(string $newStatus): void
    {
        if ($this->isFinalState()) {
            throw new \InvalidArgumentException(
                "Cannot change status from '{$this->status}'. This is a final state."
            );
        }

        if (!$this->canTransitionTo($newStatus)) {
            $allowed = $this->getAllowedTransitionsForCurrentStatus();
            throw new \InvalidArgumentException(
                "Invalid status transition. From '{$this->status}', you can only transition to: " . 
                implode(', ', $allowed)
            );
        }
    }
}
