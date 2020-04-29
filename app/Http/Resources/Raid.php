<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Raid extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->raid,
            'guild' => $this->guildID,
            'softReserve' => $this->softreserve,
            'locked' => $this->locked,
            'title' => $this->title,
            'description' => $this->description,
            'time' => $this->time,
            'createdAt' => $this->createdAt,
        ];
    }
}
