<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Uspdev\Replicado\DB;
use App\Models\Student;
use App\Models\Thesis;
use App\Models\Committee;
use App\Models\Defense;
use App\Models\CommitteeMember;
use App\Models\Advisor;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function() {
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

            foreach($res as $r){
                $aluno = Student::firstOrCreate(["nome"=>$r["nompes"],"codpes"=>$r["codpes"],"sexo"=>$r["sexo"]]);
                $defesa = Defense::firstOrCreate(["nivel"=>$niveis[$r["nivpgm"]],"programa"=>$r["nomcur"],"alunoID"=>$aluno->id]);


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

                $query = " SELECT VP.nompes as nome, VP.codpes, R.vinptpbantrb as vinculo, P.sexpes as sexo";
                $query .= " FROM AGPROGRAMA as AGP, VINCULOPESSOAUSP as VP, PESSOA as P, R48PGMTRBDOC as R";
                $query .= " WHERE AGP.codpes = :codpes";
                $query .= " AND AGP.dtadfapgm IS NULL ";
                $query .= " AND AGP.dtaaprbantrb IS NOT NULL";
                $query .= " AND R.codare = AGP.codare";
                $query .= " AND R.codpes = :codpes";
                $query .= " AND R.numseqpgm = AGP.numseqpgm";
                $query .= " AND VP.codpes = R.codpesdct";
                $query .= " AND P.codpes = VP.codpes";
                $param = [
                    'codpes' => $aluno->codpes,
                ];
        
                $res2 = array_unique(DB::fetchAll($query, $param),SORT_REGULAR);

                foreach($res2 as $r2){
                    $membroBanca = CommitteeMember::firstOrCreate([
                        "vinculo"=>$vinculos[$r2["vinculo"]],
                        "nome"=>$r2["nome"],
                        "codpes"=>$r2["codpes"],
                        "bancaID"=>$banca->id,
                        "sexo"=>$r2["sexo"]]);
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
        })->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
