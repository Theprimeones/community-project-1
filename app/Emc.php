<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Modelle;

class Emc extends Model
{
    protected $fillable = ['name', 'modelle_id'];
    
    public function modelle() {
        return $this->belongsTo(Modelle::class, 'modelle_id');
    }

}
