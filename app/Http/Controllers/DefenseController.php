<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDefenseRequest;
use App\Http\Requests\UpdateDefenseRequest;
use App\Http\Requests\IndexDefenseRequest;
use App\Models\Defense;
use Uspdev\Replicado\DB;
use App\Models\Location;
use App\Models\Institution;
use Carbon\Carbon;
use Auth;

class DefenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexDefenseRequest $request)
    {
        if(!Auth::check()){
            return redirect("/login");
        }elseif(!Auth::user()->hasRole(["Administrador", "Moderador"])){
            abort(403);
        }

        $validated = $request->validated();

        if(isset($validated["filtro"])){
            if($validated["filtro"] == "passados"){
                $defesas = Defense::whereHas("trabalho")->whereNotNull("data")->where("data","<", date("Y-m-d"))->get();
            }elseif($validated["filtro"] == "futuros"){
                $defesas = Defense::whereHas("trabalho")->whereNotNull("data")->where("data",">=", date("Y-m-d"))->get();
            }elseif($validated["filtro"] == "nao_agendadas"){
                $defesas = Defense::whereHas("trabalho")->whereNull("data")->get();
            }
        }else{
            $defesas = Defense::whereHas("trabalho")->get();
        }

        $defesas = $defesas->sort(function($a, $b){
            $dataDeA = $a->data ? Carbon::createFromFormat('d/m/Y', $a->data)->format('Y-m-d') : null;
            $dataDeB = $b->data ? Carbon::createFromFormat('d/m/Y', $b->data)->format('Y-m-d') : null;

            if(($dataDeA and $dataDeA >= date("Y-m-d")) and (!$dataDeB or $dataDeB < date("Y-m-d"))){
                return 1;
            }elseif((!$dataDeA or $dataDeA < date("Y-m-d")) and ($dataDeB and $dataDeB >= date("Y-m-d"))){
                return -1;
            }

            if(!$dataDeA and ($dataDeB and $dataDeB < date("Y-m-d"))){
                return 1;
            }elseif(($dataDeA and $dataDeA < date("Y-m-d") and !$dataDeB)){
                return -1;
            }

            if(($dataDeA and $dataDeA < date("Y-m-d")) and ($dataDeB and $dataDeB < date("Y-m-d")) and $dataDeA > $dataDeB){
                return 1;
            }elseif(($dataDeA and $dataDeA < date("Y-m-d")) and ($dataDeB and $dataDeB < date("Y-m-d"))  and $dataDeA < $dataDeB){
                return -1;
            }

            if(($dataDeA and $dataDeA >= date("Y-m-d")) and ($dataDeB and $dataDeB >= date("Y-m-d")) and $dataDeA < $dataDeB){
                return 1;
            }elseif(($dataDeA and $dataDeA >= date("Y-m-d")) and ($dataDeB and $dataDeB >= date("Y-m-d"))  and $dataDeA > $dataDeB){
                return -1;
            }

            if($a->aluno->nome < $b->aluno->nome){
                return 1;
            }elseif($a->aluno->nome > $b->aluno->nome){
                return -1;
            }
        })->reverse();

        return view("defenses.index", compact(["defesas"]));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDefenseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDefenseRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Defense  $defense
     * @return \Illuminate\Http\Response
     */
    public function show(Defense $defense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Defense  $defense
     * @return \Illuminate\Http\Response
     */
    public function edit(Defense $defense)
    {
        if(Auth::check()){
            if(!Auth::user()->hasRole(["Moderador", "Administrador"])){
                abort(403);
            }
        }else{
            return redirect("login");
        }

        return view("defenses.edit", ["defesa"=>$defense]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDefenseRequest  $request
     * @param  \App\Models\Defense  $defense
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDefenseRequest $request, Defense $defense)
    {
        if(Auth::check()){
            if(!Auth::user()->hasRole(["Moderador", "Administrador"])){
                abort(403);
            }
        }else{
            return redirect("login");
        }

        $validated = $request->validated();

        foreach($defense->banca->membros as $membro){
            $membro->instituicao()->disassociate();
            $membro->save();
        }

        if(isset($validated["instituicoes"])){
            foreach($validated["instituicoes"] as $id=>$values){
                $membro = $defense->banca->membros()->where("id", $id)->first();
                if($membro){
                    $instituicao = Institution::firstOrCreate($values);
                    $membro->instituicao()->associate($instituicao);
                    $membro->save();
                }
            }
        }

        $validated["localID"] = Location::firstOrCreate(["nome"=>$validated["local"]])->id;
        unset($validated["local"]);

        $defense->update($validated);

        return redirect("defenses");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Defense  $defense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Defense $defense)
    {
        if(Auth::check()){
            if(!Auth::user()->hasRole(["Moderador", "Administrador"])){
                abort(403);
            }
        }else{
            return redirect("login");
        }

        if($defense->banca()->exists()){
            $defense->banca->delete();
        }

        if($defense->trabalho()->exists()){
            $defense->trabalho->delete();
        }

        $defense->delete();

        return redirect("defenses");
    }

}
