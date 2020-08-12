<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\User;

class Message extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'creator_id' => $this->creator_id,
            'creator_name' => User::find($this->creator_id)->name,
            'body' => explode(' ', $this->body),
            'like_count' => $this->like_count,
            'created_at' => $this->created_at->diffForHumans()
        ];
    }
}
