<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Location::firstOrCreate(["nome"=>"Sala 01 Bloco B"]);
        Location::firstOrCreate(["nome"=>"Sala 02 Bloco B"]);
        Location::firstOrCreate(["nome"=>"Sala 03 Bloco B"]);
        Location::firstOrCreate(["nome"=>"Sala 04 Bloco B"]);
        Location::firstOrCreate(["nome"=>"Sala 05 Bloco B"]);
        Location::firstOrCreate(["nome"=>"Sala 06 Bloco B"]);
        Location::firstOrCreate(["nome"=>"Sala 07 Bloco B"]);
        Location::firstOrCreate(["nome"=>"Sala 09 Bloco B"]);
        Location::firstOrCreate(["nome"=>"Sala 10 Bloco B"]);
        Location::firstOrCreate(["nome"=>"Sala 16 Bloco B"]);
        Location::firstOrCreate(["nome"=>"Sala 101 Bloco B"]);
        Location::firstOrCreate(["nome"=>"Sala 138 Bloco B"]);
        Location::firstOrCreate(["nome"=>"Sala 139 Bloco B"]);
        Location::firstOrCreate(["nome"=>"Sala 142 Bloco B"]);
        Location::firstOrCreate(["nome"=>"Sala 143 Bloco B"]);
        Location::firstOrCreate(["nome"=>"Sala 144 Bloco B"]);
        Location::firstOrCreate(["nome"=>"Sala 132 Bloco A"]);
        Location::firstOrCreate(["nome"=>"Sala 241 Bloco A"]);
        Location::firstOrCreate(["nome"=>"Sala 242 Bloco A"]);
        Location::firstOrCreate(["nome"=>"Sala 243 Bloco A"]);
        Location::firstOrCreate(["nome"=>"Sala 249 Bloco A"]);
        Location::firstOrCreate(["nome"=>"Sala 252 Bloco A"]);
        Location::firstOrCreate(["nome"=>"Sala 259 Bloco A"]);
        Location::firstOrCreate(["nome"=>"Sala 266 Bloco A"]);
        Location::firstOrCreate(["nome"=>"Sala 267 Bloco A"]);
        Location::firstOrCreate(["nome"=>"Sala 268 Bloco A"]);
        Location::firstOrCreate(["nome"=>"Sala Elza Gomide"]);
        Location::firstOrCreate(["nome"=>"Auditório Antonio Gilioli"]);
        Location::firstOrCreate(["nome"=>"Auditório Jacy Monteiro"]);
    }
}
