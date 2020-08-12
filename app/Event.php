<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Device;

class Event extends Model
{
    protected $fillable = ['body', 'creator_id', 'device_id'];

    public function creator() {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function device() {
        return $this->belongsTo(Device::class, 'device_id');
    }
}
