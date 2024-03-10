<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HolidayPlanResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'date' => $this->date,
            'location' => $this->location,
            'participants' => $this->participants,
            'created_at' => $this->created_at,
            'created_at' => $this->created_at->copy()->diffForHumans(),
            'updated_at' => $this->updated_at->copy()->diffForHumans(),
            'user' => new UserResource($this->user),
        ];
    }
}
