<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Defense;
use Carbon\Carbon;

class ApiController extends Controller
{
    public function getAllEvents()
    {
        $eventos = Event::with(["local","idioma","modalidade","tipo","anexos"])->where("aprovado", true)->where(function($query){
            $query->whereNotNull("dataFinal")->where("dataFinal",">=", date("Y-m-d"))
                ->orWhere(function($query2){
                    $query2->whereNull("dataFinal")->where("dataInicial", ">=", date("Y-m-d"));
                });
        })->get();

        return response($eventos->toJson(JSON_PRETTY_PRINT), 200);
    }

    public function getAllDefenses()
    {
        $defesas = Defense::with(["aluno.orientadores", "trabalho", "banca.membros.instituicao", "local"])->whereHas("local")
            ->whereNotNull(["data","horario"])->where("data", ">=", date("Y-m-d"))->get();
        
        $defesas = $defesas->sort(function($a,$b){
            $dataDeA = Carbon::createFromFormat("d/m/Y", $a->data)->format("Y-m-d");
            $dataDeB = Carbon::createFromFormat("d/m/Y", $b->data)->format("Y-m-d");
            
            if($dataDeA > $dataDeB){
                return 1;
            }elseif($dataDeA < $dataDeB){
                return -1;
            }

            if($a->horario > $b->horario){
                return 1;
            }elseif($a->horario < $b->horario){
                return -1;
            }
        })->values();

        return response($defesas->toJson(JSON_PRETTY_PRINT),200);
    }
}
