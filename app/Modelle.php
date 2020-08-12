<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Emc;

class Modelle extends Model
{
    protected $fillable = ['name', 'brand', 'charger_name', 'charger_amount'];

    public function emcs() {
        return $this->hasMany(Emc::class, 'modelle_id');
    }
    
}
