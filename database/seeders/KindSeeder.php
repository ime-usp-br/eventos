<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kind;

class KindSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Kind::firstOrCreate(["nome"=>"Colóquio"]);
        Kind::firstOrCreate(["nome"=>"Seminário"]);
        Kind::firstOrCreate(["nome"=>"Palestra"]);
        Kind::firstOrCreate(["nome"=>"Workshop"]);
        Kind::firstOrCreate(["nome"=>"Congresso"]);
    }
}
