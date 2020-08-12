<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['name', 'supplier_id'];

    public function supplier() {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
    
    public function devices() {
        return $this->hasMany(Device::class, 'order_id');
    }

    public function events() {
        return $this->hasMany(Event::class, 'order_id');
    }

}
