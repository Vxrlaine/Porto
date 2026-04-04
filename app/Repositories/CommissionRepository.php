<?php

namespace App\Repositories;

use App\Models\Commission;

class CommissionRepository extends BaseRepository
{
    /**
     * Set the model instance.
     */
    protected function setModel(): void
    {
        $this->model = new Commission();
    }

    /**
     * Get commissions with status filter.
     */
    public function getByStatus(string $status, int $perPage = 15)
    {
        return $this->model
            ->where('status', $status)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get commissions assigned to a user.
     */
    public function getByAssignedUser(int $userId, int $perPage = 15)
    {
        return $this->model
            ->where('assigned_to', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get commission statistics.
     */
    public function getStatistics(): array
    {
        return [
            'total' => $this->model->count(),
            'pending' => $this->model->where('status', 'pending')->count(),
            'reviewing' => $this->model->where('status', 'reviewing')->count(),
            'accepted' => $this->model->where('status', 'accepted')->count(),
            'in_progress' => $this->model->where('status', 'in_progress')->count(),
            'completed' => $this->model->where('status', 'completed')->count(),
            'cancelled' => $this->model->where('status', 'cancelled')->count(),
            'rejected' => $this->model->where('status', 'rejected')->count(),
        ];
    }

    /**
     * Get recent commissions.
     */
    public function getRecent(int $limit = 10)
    {
        return $this->model
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}
