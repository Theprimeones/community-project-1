<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\User;

class Reply extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'creator_id' => $this->creator_id,
            'creator_username' => User::find($this->creator_id)->username,
            'body' => explode(' ', $this->body),
            'like_count' => $this->like_count,
            'dislike_count' => $this->dislike_count,
            'created_at' => $this->created_at->diffForHumans()
        ];
    }
}
