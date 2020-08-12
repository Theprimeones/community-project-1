<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = ['name'];
    
    public function devices() {
        return $this->hasMany(Device::class, 'supplier_id');
    }
    
    public function orders() {
        return $this->hasMany(Order::class, 'supplier_id');
    }
}
