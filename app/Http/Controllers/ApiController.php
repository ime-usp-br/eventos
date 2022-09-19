<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Defense;

class ApiController extends Controller
{
    public function getAllEvents()
    {
        $eventos = Event::with(["idioma","modalidade","tipo","anexos"])->where("aprovado", true)->where(function($query){
            $query->whereNotNull("dataFinal")->where("dataFinal",">=", date("Y-m-d"))
                ->orWhere(function($query2){
                    $query2->whereNull("dataFinal")->where("dataInicial", ">=", date("Y-m-d"));
                });
        })->get();

        return response($eventos->toJson(JSON_PRETTY_PRINT), 200);
    }

    public function getAllDefenses()
    {
        $defesas = Defense::with(["aluno.orientadores", "trabalho", "banca.membros"])
            ->whereNotNull(["data","local","horario"])->where("data", ">=", date("Y-m-d"))->get();
            
        return response($defesas->toJson(JSON_PRETTY_PRINT),200);
    }
}
