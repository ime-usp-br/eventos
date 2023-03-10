<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Defense;

class TVController extends Controller
{
    public function defesas()
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

        return view("tv.defesas", compact("defesas"));
    }
}