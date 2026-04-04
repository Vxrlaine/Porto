<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommissionResource extends JsonResource
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
            'client_name' => $this->client_name,
            'client_email' => $this->when(
                $request->user()?->is_admin,
                $this->client_email
            ),
            'client_discord' => $this->when(
                $request->user()?->is_admin,
                $this->client_discord
            ),
            'description' => $this->description,
            'character_type' => $this->character_type,
            'character_count' => (int) $this->character_count,
            'reference_images' => $this->reference_images,
            'budget' => $this->budget ? number_format($this->budget, 2) : null,
            'status' => $this->status,
            'status_color' => $this->status_color,
            'deadline' => $this->deadline?->format('Y-m-d'),
            'admin_notes' => $this->when(
                $request->user()?->is_admin,
                $this->admin_notes
            ),
            'assigned_to' => $this->when(
                $request->user()?->is_admin,
                $this->assigned_to
            ),
            'assigned_user' => new UserResource($this->whenLoaded('assignedUser')),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
