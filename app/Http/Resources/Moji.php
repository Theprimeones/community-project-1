<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\User;

class Moji extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'creator_id' => $this->creator_id,
            'creator_username' => User::find($this->creator_id)->username,
            'name' => $this->name,
            'path' => $this->path,
            'like_count' => $this->like_count,
            'dislike_count' => $this->dislike_count,
            'collec_count' => $this->collecs->count(),
            'created_at' => $this->created_at->diffForHumans()
        ];
    }
}
