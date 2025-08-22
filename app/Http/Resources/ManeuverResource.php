<?php

namespace App\Http\Resources;

use App\Models\Maneuver;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ManeuverResource extends JsonResource
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
            'status' => $this->status,
            'pediment' => $this->pediment,
            'patent' => $this->patent,
            'container' => $this->container,
            'product' => $this->product,
            'type' => $this->type,
            'country' => $this->country,
            'bulks' => $this->bulks,
            'check_in' => $this->check_in,
            'check_out' => $this->check_out,
            'check_in_user' => $this->checkInUser ? $this->checkInUser->name : null,
            'check_out_user' => $this->checkOutUser ? $this->checkOutUser->name : null,
            'presentation' => $this->presentation,
            'company' => $this->company,
            'importer' => $this->importer,
            'folio_200' => $this->folio_200,
            'folio_500' => $this->folio_500,
            'created_at' => $this->created_at,
            'client' => $this->client,
            'files' => ManeuverFileResource::collection($this->files),
        ];
    }
}
