<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MapStationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user' => new UserResource($this->user),
            'name' => $this->name,
            'working_time' => $this->working_time,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'images' => ChargingStationImagesResource::collection($this->images),
            'charging_station_type' => new ChargingStationTypeResource($this->chargingStationType),
            'likes' => $this->getLikes(),
            'dislikes' => $this->getDislikes(),
            'publish' => (bool) $this->publish,
            'created_at' => $this->created_at,
        ];
    }
}
