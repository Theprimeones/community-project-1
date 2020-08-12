<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Device;

class Box extends Model
{
    protected $fillable = ['name', 'location', 'creator_id'];
    
    public function creator() {
        return $this->belongsTo(User::class, 'creator_id');
    }
    
    public function devices() {
        return $this->hasMany(Device::class, 'box_id');
    }
}
