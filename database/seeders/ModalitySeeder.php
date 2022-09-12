<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Modality;

class ModalitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Modality::firstOrCreate(["nome"=>"Presencial"]);
        Modality::firstOrCreate(["nome"=>"Remoto"]);
        Modality::firstOrCreate(["nome"=>"Híbrido"]);
    }
}
