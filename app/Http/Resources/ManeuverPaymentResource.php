<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ManeuverPaymentResource extends JsonResource
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
            'amount' => $this->amount,
            'reference' => $this->reference,
            'payment_method' => $this->payment_method,
            'notes' => $this->notes,
            'status' => $this->status,
            'payment_file' => Storage::disk("public")->url($this->payment_file),
            'created_at' => $this->created_at,
            ];
    }
}
