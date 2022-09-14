<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class ApiController extends Controller
{
    public function getAllEvents()
    {
        $eventos = Event::with(["idioma","modalidade","tipo","anexos"])->where("aprovado", true)->get();
        $eventos = $eventos->filter(function($evento){
                if($evento->dataFinal){
                    if($evento->dataFinal > date("d/m/Y")){
                        return true;
                    }elseif($evento->dataFinal == date("d/m/Y")){
                        if($evento->horarioFinal){
                            if($evento->horarioFinal >= date("H:i")){
                                return true;
                            }
                        }elseif($evento->horarioInicial >= date("H:i")){
                            return true;
                        }
                    }
                }elseif($evento->dataInicial > date("d/m/Y")){
                    return true;
                }elseif($evento->dataInicial == date("d/m/Y")){
                    if($evento->horarioFinal){
                        if($evento->horarioFinal >= date("H:i")){
                            return true;
                        }
                    }elseif($evento->horarioInicial >= date("H:i")){
                        return true;
                    }
                }
                return false;
            })->toJson(JSON_PRETTY_PRINT);

        return response($eventos, 200);
    }
}
