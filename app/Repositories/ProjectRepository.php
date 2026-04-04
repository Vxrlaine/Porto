<?php

namespace App\Repositories;

use App\Models\Project;

class ProjectRepository extends BaseRepository
{
    /**
     * Set the model instance.
     */
    protected function setModel(): void
    {
        $this->model = new Project();
    }

    /**
     * Get active projects ordered by display order.
     */
    public function getActiveProjects()
    {
        return $this->model
            ->where('is_active', true)
            ->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get paginated projects with filtering.
     */
    public function getFilteredProjects(?string $search = null, ?bool $activeOnly = false, int $perPage = 15)
    {
        $query = $this->model->query();

        if ($activeOnly) {
            $query->where('is_active', true);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('client_name', 'like', "%{$search}%");
            });
        }

        return $query->orderBy('order')->orderBy('created_at', 'desc')->paginate($perPage);
    }

    /**
     * Get project count statistics.
     */
    public function getStatistics(): array
    {
        return [
            'total' => $this->model->count(),
            'active' => $this->model->where('is_active', true)->count(),
            'inactive' => $this->model->where('is_active', false)->count(),
        ];
    }
}
