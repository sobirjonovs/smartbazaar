<?php

namespace App\Http\Resources\Merchant;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $status
 * @property mixed $id
 * @property mixed $address
 * @property mixed $schedule
 * @property mixed $latitude
 * @property mixed $longitude
 * @property mixed $merchant_id
 */
class ShopListsResource extends JsonResource
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
            'address' => $this->address,
            'schedule' => $this->schedule,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'merchant_id' => $this->merchant_id,
            'status' => $this->status
        ];
    }
}
