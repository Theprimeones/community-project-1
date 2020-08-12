<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth; 

class User extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'followingsCount' => $this->followings->count(),
            'followersCount' => $this->followers->count(),
            'notifsCount' => $this->unreadNotifs->count(),
            'pubMojisCount' => $this->pubMojis->count(),
            'priMojisCount' => $this->priMojis->count()
        ];
    }
}
