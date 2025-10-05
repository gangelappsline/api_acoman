<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ManeuverExtensionResource extends JsonResource
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
            'type' => $this->type,
            'days' => $this->days,
            'total' => $this->total,
            'file' => Storage::disk("public")->url($this->file),
            'paid' => $this->paid,
            'notes' => $this->notes,
            'created_by' => $this->created_by == null ? null : $this->user,
            'created_at' => $this->created_at,
        ];
    }
}
