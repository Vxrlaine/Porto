<?php

namespace App\Repositories;

use App\Models\Skill;

class SkillRepository extends BaseRepository
{
    /**
     * Set the model instance.
     */
    protected function setModel(): void
    {
        $this->model = new Skill();
    }

    /**
     * Get active skills ordered by display order.
     */
    public function getActiveSkills(?string $category = null)
    {
        $query = $this->model
            ->where('is_active', true)
            ->orderBy('order')
            ->orderBy('proficiency', 'desc');

        if ($category) {
            $query->where('category', $category);
        }

        return $query->get();
    }

    /**
     * Get skills grouped by category.
     */
    public function getGroupedByCategory()
    {
        return $this->model
            ->where('is_active', true)
            ->orderBy('category')
            ->orderBy('order')
            ->get()
            ->groupBy('category');
    }

    /**
     * Get skill count by category.
     */
    public function getCategoryCounts(): array
    {
        return $this->model
            ->where('is_active', true)
            ->selectRaw('category, count(*) as count')
            ->groupBy('category')
            ->pluck('count', 'category')
            ->toArray();
    }
}
