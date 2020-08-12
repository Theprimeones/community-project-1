<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Notif extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'body' => $this->body,
            'read' => $this->read,
            'created_at' => $this->created_at->diffForHumans(),
            'type' => $this->type,
            'spec_name' => $this->spec_name,
            'spec_id' => $this->spec_id,
        ];
    }
}
