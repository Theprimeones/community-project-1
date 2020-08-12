<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Collec;
use App\Moji;
use App\Reply;
use App\User;
use App\Modelle;
use App\Emc;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */

    public function createModelle($modelle, $brand, $charger) {
        $modelles = Modelle::all();
        if ($modelles->where('name', $modelle)->count() == 0) {
            Modelle::create([
                'name' => $modelle,
                'brand' => $brand,
                'charger_name' => $charger,
                'charger_amount' => 0,
            ]);
        }
    }

    public function createEmcs($modelle) {
        if ($modelle->emcs->where('modelle_id', $modelle->id)->count() == 0) {
            Emc::create([
                'name' => 'None',
                'modelle_id' => $modelle->id
            ]);
        }
        if ($modelle->brand === 'Apple') {
            $this->createAppleEmcs($modelle);
        }
    }
    
    public function createAppleEmc($modelle, $emc_name) {
        if ($modelle->emcs->where('name', $emc_name)->count() == 0) {
            Emc::create([
                'name' => $emc_name,
                'modelle_id' => $modelle->id
            ]);
        }
    }

    public function run() {
    }
}
