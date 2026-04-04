<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SkillResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'category' => $this->category,
            'proficiency' => (int) $this->proficiency,
            'proficiency_label' => $this->getProficiencyLabel(),
            'order' => $this->order,
            'is_active' => (bool) $this->is_active,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * Get human-readable proficiency label.
     */
    private function getProficiencyLabel(): string
    {
        $proficiency = (int) $this->proficiency;
        
        return match(true) {
            $proficiency >= 90 => 'Expert',
            $proficiency >= 70 => 'Advanced',
            $proficiency >= 50 => 'Intermediate',
            $proficiency >= 30 => 'Beginner',
            default => 'Novice',
        };
    }
}
