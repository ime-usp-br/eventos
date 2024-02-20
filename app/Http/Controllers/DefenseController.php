<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDefenseRequest;
use App\Http\Requests\UpdateDefenseRequest;
use App\Http\Requests\IndexDefenseRequest;
use Illuminate\Console\Scheduling\Event;
use App\Models\Defense;
use Uspdev\Replicado\DB;
use App\Models\Location;
use App\Models\Institution;
use App\Models\Student;
use App\Models\Thesis;
use App\Models\Committee;
use App\Models\CommitteeMember;
use App\Models\Advisor;
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
        }elseif(!Auth::user()->hasRole(["Administrador", "Secretario da Pós-Graduação"])){
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
            if(!Auth::user()->hasRole(["Administrador", "Secretario da Pós-Graduação"])){
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
            if(!Auth::user()->hasRole(["Administrador", "Secretario da Pós-Graduação"])){
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
            if(!Auth::user()->hasRole(["Administrador", "Secretario da Pós-Graduação"])){
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

    public function importFromReplicado($task = null)
    {        
        if ($task !== 'ImportDefesesFromReplicadoTask') {
            if(Auth::check()){
                if(!Auth::user()->hasRole(["Administrador", "Secretario da Pós-Graduação"])){
                    abort(403);
                }
            }else{
                return redirect("login");
            }
        }

        $query = " SELECT VP.codpes, VP.nompes, AGP.nivpgm, NC.nomcur, P.sexpes as sexo";
        $query .= " FROM CURSO as C, NOMECURSO as NC, AREA as A, AGPROGRAMA as AGP, VINCULOPESSOAUSP as VP, PESSOA as P";
        $query .= " WHERE C.sglclg = 'CPG'";
        $query .= " AND C.codclg IN (45,95)";
        $query .= " AND NC.codcur = C.codcur";
        $query .= " AND A.codcur = C.codcur";
        $query .= " AND AGP.codare = A.codare";
        $query .= " AND AGP.dtadfapgm IS NULL ";
        $query .= " AND AGP.dtaaprbantrb IS NOT NULL";
        $query .= " AND VP.codpes = AGP.codpes";
        $query .= " AND VP.sitatl = 'A'";
        $query .= " AND P.codpes = VP.codpes";

        $res = array_unique(DB::fetchAll($query),SORT_REGULAR);

        $niveis = ["ME"=>"Mestrado","DO"=>"Doutorado", "DD"=>"Doutorado Direto"];
        $tipos = ["ORI"=>"Orientador", "COO"=>"Coorientador"];
        $vinculos = ["PRE"=>"Presidente","TIT"=>"Titular","SUP"=>"Suplente","SUB"=>"Substituto"];
        $siglas = [
            "Matemática Aplicada" => "MAP",
            "Estatística" => "MAE",
            "Probabilidade e Estatística" => "MAE",
            "Ciência da Computação" => "MAC",
            "Mestrado Profissional em Ensino de Matemática" => "MPEM",
            "Ensino de Matemática" => "MPEM",
            "Bioinformática" => "BIOINFO",
            "Matemática" => "MAT",
        ];

        foreach($res as $r){
            $aluno = Student::firstOrCreate(["nome"=>$r["nompes"],"codpes"=>$r["codpes"],"sexo"=>$r["sexo"]]);
            $defesa = Defense::updateOrCreate(["nivel"=>$niveis[$r["nivpgm"]],"programa"=>$r["nomcur"],"alunoID"=>$aluno->id],["sigla"=>$siglas[$r["nomcur"]]]);


            $query = " SELECT DET.tittrb as titulo, DET.rsutrb as resumo, DET.palcha as palavrasChave, DET.tittrbigl as title, DET.rsutrbigl as abstract, DET.palchaigl as keyWords";
            $query .= " FROM AGPROGRAMA as AGP, DDTDEPOSITOTRABALHO as DDT, DDTENTREGATRABALHO as DET";
            $query .= " WHERE AGP.codpes = :codpes";
            $query .= " AND AGP.dtadfapgm IS NULL ";
            $query .= " AND AGP.dtaaprbantrb IS NOT NULL";
            $query .= " AND DDT.codare = AGP.codare";
            $query .= " AND DDT.codpes = AGP.codpes";
            $query .= " AND DDT.numseqpgm = AGP.numseqpgm";
            $query .= " AND DET.coddpodgttrb = DDT.coddpodgttrb";
            $param = [
                'codpes' => $aluno->codpes,
            ];
    
            $res2 = array_unique(DB::fetchAll($query, $param),SORT_REGULAR);

            if($res2){
                $res2[0]["alunoID"] = $aluno->id;
                $res2[0]["defesaID"] = $defesa->id;
                Thesis::firstOrCreate($res2[0]);
            }
            
            $banca = Committee::firstOrCreate(["defesaID"=>$defesa->id]);

            $query = " SELECT P.nompes as nome, P.codpes, R.vinptpbantrb as vinculo, P.sexpes as sexo, R.staptp";
            $query .= " FROM AGPROGRAMA as AGP, PESSOA as P, R48PGMTRBDOC as R";
            $query .= " WHERE AGP.codpes = :codpes";
            $query .= " AND AGP.dtadfapgm IS NULL ";
            $query .= " AND AGP.dtaaprbantrb IS NOT NULL";
            $query .= " AND R.codare = AGP.codare";
            $query .= " AND R.codpes = :codpes";
            $query .= " AND R.numseqpgm = AGP.numseqpgm";
            $query .= " AND P.codpes = R.codpesdct";
            $param = [
                'codpes' => $aluno->codpes,
            ];
    
            $res2 = array_unique(DB::fetchAll($query, $param),SORT_REGULAR);

            foreach($res2 as $r2){
                CommitteeMember::updateOrCreate([
                    "codpes"=>$r2["codpes"],
                    "bancaID"=>$banca->id,
                    "nome"=>$r2["nome"],
                    "sexo"=>$r2["sexo"],
                ],[
                    "vinculo"=>$vinculos[$r2["vinculo"]],
                    "staptp"=>$r2["staptp"] == "S" ? 1 : 0,
                ]);
            }

            $query = " SELECT VP.nompes as nome, VP.codpes, R.tiport as tipo, P.sexpes as sexo";
            $query .= " FROM AGPROGRAMA as AGP, VINCULOPESSOAUSP as VP, PESSOA as P, R39PGMORIDOC as R";
            $query .= " WHERE AGP.codpes = :codpespgm";
            $query .= " AND AGP.dtadfapgm IS NULL ";
            $query .= " AND AGP.dtaaprbantrb IS NOT NULL";
            $query .= " AND R.codare = AGP.codare";
            $query .= " AND R.codpespgm = :codpespgm";
            $query .= " AND R.numseqpgm = AGP.numseqpgm";
            $query .= " AND R.staort = :staort";
            $query .= " AND R.dtafimort IS NULL";
            $query .= " AND VP.codpes = R.codpes";
            $query .= " AND P.codpes = VP.codpes";
            $param = [
                'codpespgm' => $aluno->codpes,
                'staort' => 'AT'
            ];
    
            $res2 = array_unique(DB::fetchAll($query, $param),SORT_REGULAR);

            foreach($res2 as $r2){
                $orientador = Advisor::firstOrCreate(["tipo"=>$tipos[$r2["tipo"]],"nome"=>$r2["nome"],"codpes"=>$r2["codpes"],"sexo"=>$r2["sexo"]]);
                if(!$orientador->orientandos->contains($aluno)){
                    $orientador->orientandos()->save($aluno);
                }
            }
        }

        return back();
    }

}
