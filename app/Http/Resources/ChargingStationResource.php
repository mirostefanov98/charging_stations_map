<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChargingStationResource extends JsonResource
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
            'user_id' => $this->user_id,
            'name' => $this->name,
            'working_time' => $this->working_time,
            'description' => $this->description,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'images' => ChargingStationImagesResource::collection($this->images),
            'charging_station_type' => new ChargingStationTypeResource($this->chargingStationType()->first()),
            'plug_types' => PlugTypeResource::collection($this->plugTypes()->get()),
            'payment_types' =>  PaymentTypeResource::collection($this->paymentTypes()->get()),
            'likes' => $this->likes(),
            'dislike' => $this->dislikes(),
            'publish' => (bool) $this->publish,
            'created_at' => $this->created_at,
        ];
    }
}
