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
            'SignupID' => $this->id,
            'Signup' => $this->signup,
            'Confirmed' => $this->confirmed,
            'ConfirmationMode' => $this->raid->confirmation ? 'yes' : 'no',
            'RaidID' => $this->raidID,
            'Raid' => $this->raid->raid,
            'RaidTitle' => $this->raid->title,
            'RaidDescription' => $this->raid->description,
            'RaidDate' => $this->raid->date,
            'Reserve' => $this->reserve ? $this->reserve->item->name : null,
            'ItemID' => $this->reserve ? $this->reserve->item->itemID : null
        ];    
    }
}
