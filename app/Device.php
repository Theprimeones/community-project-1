<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Supplier;
use App\Device;
use App\Event;
use App\Modelle;
use App\Emc;

class Device extends Model
{
    protected $fillable = ['asset', 'serial', 'creator_id', 'supplier_id', 'order_id', 'brand', 'model', 'modelle_id', 'emc_id', 'location', 'tracking'];

    public function creator() {
        return $this->belongsTo(User::class, 'creator_id');
    }
    
    public function supplier() {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function order() {
        return $this->belongsTo(Order::class, 'order_id');
    }
    
    public function modelle() {
        return $this->belongsTo(Modelle::class, 'modelle_id');
    }
    
    public function events() {
        return $this->hasMany(Event::class, 'device_id');
    }

    public function emc() {
        return $this->belongsTo(Emc::class, 'emc_id');
    }

    public function issetCreatorName() {
        $creator_name = null;
        if(isset($this->creator->name)) {
            $creator_name = $this->creator->name;
        }
        return $creator_name;
    }

    public function issetSupplierName() {
        $supplier_name = null;
        if(isset($this->supplier->name)) {
            $supplier_name = $this->supplier->name;
        }
        return $supplier_name;
    }

    public function getDeviceReturn() {
        return $this->events->filter(function($item) {
            return substr($item->body, 0, 7) == 'return:';
        })->first();
    }

    public function getDevicesTriage(Event $device_return) {
        $tri_events = collect();
        foreach($this->events as $event) {
            if (substr($event->body, 0, 7) == 'triage:' and $event->created_at > $device_return->created_at) {
                $tri_events->push($event);
            }
            else if ($event->body == 'issueless' and $event->created_at > $device_return->created_at) {
                $tri_events->push($event);
            }
        }
        return $tri_events;
    }

    

}
