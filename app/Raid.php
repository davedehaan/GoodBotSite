<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;
use App\Settings;
use App\RaidCategory;

class Raid extends BaseModel
{
    protected $table = 'raids';
    protected $fillable = ['name', 'title', 'raid', 'description', 'confirmation', 'softreserve', 'channelID', 'guildID', 'date', 'color', 'memberID', 'faction', 'time', 'archived'];

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    public function Signups() 
    {
        return $this->hasMany('App\Signup', 'raidID', 'id');
    }

    public function createRaid($saveData) {
        // Retrieve the parent category for the raid
        $guildID = $saveData['guildID'];
        $raid = $saveData['raid'];
        $faction = $saveData['faction'];
        $channelName = $saveData['channel'];
        $category = $this->getCategory($guildID, $raid, $faction);

        if (!$category) {
            return ['error' => 'No permissions.'];
        }
        // Save the guild ID
        $saveData['guildID'] = $guildID;

        // Create our channel
        $channel = $this->botRequest('/guilds/' . $guildID . '/channels', ['name' => $channelName, 'type' => 0, 'parent_id' => $category->id]);
        $saveData['channelID'] = $channel->id;
        
        // Create raid record
        $raid = Raid::create($saveData);

        // Create the embed
        $this->sendMessage(0, $raid->channelID, '+embed');
        return $raid;
    }

    public function updateRaid($id, $saveData) {
        // Retrieve and update channel, if necessary
        $raid = Raid::findOrFail($id);
        $channel = $this->botRequest('/channels/' . $raid->channelID);
        if ($channel->name != $saveData['channel']) {
            $result = $this->botRequest('/channels/' . $raid->channelID, ['name' => $saveData['channel']], true);
        }
        unset($saveData['channel']);
        
        // Update raid record
        Raid::where('id', $id)
            ->update($saveData);
            
        // Create the embed
        $this->sendMessage(0, $raid->channelID, '+embed refresh');
        return $saveData;        
    }

    public function getCategory($guildID, $raid, $faction) {
        // Our default
        $category = 'Raid Signups';

        // Find default raid category for this server
        $settings = Settings::where('guildID', $guildID)->first();
        if ($settings->raidcategory) {
            $category = $settings->raidcategory;
        }

        $params = ['guildID' => $guildID, 'raid' => $raid];
        if ($faction) {
            $params['faction'] = $faction;
        }

        $raidCategory = RaidCategory::where($params)->first();
        // Check if there's an overwrite
        if ($raidCategory) {
            $category = $raidCategory->category;
        }

        $channels = $this->botRequest('/guilds/' . $guildID . '/channels');
        $discordCategory = null;
        foreach ($channels AS $channel) {
            if ($channel->name == $category) {
                echo $channel->name;
                $discordCategory = $channel;
            }
        }

        // Check if the user has permissions here
        if ($this->hasPermission($guildID, $discordCategory)) {
            return $discordCategory;
        } else {
            return false;
        }
    }

    public function hasPermission($guildID, $category) {
        $user = session()->get('user');
        $roles = $this->getRoles($user, $guildID);
        // Retrieve our overwrites
        $overwrites = [];
        foreach ($category->permission_overwrites AS $overwrite) {
            if ($overwrite->type == 'role' && !empty($roles[$overwrite->id])) {
                $roles[$overwrite->id]->permissions = $roles[$overwrite->id]->permissions | $overwrite->allow;
            }
        }

        foreach ($roles AS $role) {
            if ($role->permissions & 0x10 || $role->permissions & 0x8) {
                return 1;
            }
        }
        return 0;
    }

    public function getRoles($user, $guildID) {
        $guildMember = $this->botRequest('/guilds/' . $guildID . '/members/' . $user->id);
        $roles = $this->botRequest('/guilds/' . $guildID . '/roles');
        $roleArray = [];
        foreach ($roles AS $role) {
            $roleArray[$role->id] = $role;
        }
        $userRoles = [];
        foreach ($guildMember->roles AS $role) {
            $userRoles[$role] = $roleArray[$role];
        }
        return $userRoles;
    }
}
