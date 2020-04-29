<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Signup extends JsonResource
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
            'GuildID' => $this->guildID,
            'SignupID' => $this->id,
            'Signup' => $this->signup,
            'Confirmed' => $this->confirmed ? 1 : 0,
            'ConfirmationMode' => $this->raid->confirmation ? 1 : 0,
            'RaidID' => $this->raidID,
            'Raid' => $this->raid->raid,
            'RaidTitle' => $this->raid->title,
            'RaidDescription' => $this->raid->description,
            'RaidDate' => $this->raid->date,
            'SoftReserveMode' => $this->raid->softreserve ? 1 : 0,
            'Reserve' => $this->reserve ? $this->reserve->item->name : null,
            'ItemID' => $this->reserve ? $this->reserve->item->itemID : null
        ];    
    }
}
