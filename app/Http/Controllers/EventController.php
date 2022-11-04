<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Http\Requests\IndexEventRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use \Illuminate\Support\Facades\URL;
use App\Mail\NotifyModeratorAboutEvent;
use App\Mail\NotifyUserAboutEvent;
use App\Models\Event;
use App\Models\Attachment;
use App\Models\User;
use App\Models\Location;
use App\Models\Kind;
use Carbon\Carbon;
use Auth;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexEventRequest $request)
    {
        if(!Auth::check()){
            return redirect("/login");
        }

        $validated = $request->validated();

        if(isset($validated["filtro"])){
            if($validated["filtro"] == "passados"){
                $eventos = Event::whereNotNull("dataFinal")->where("dataFinal","<", date("Y-m-d"))
                                    ->orWhere(function($query){
                                        $query->whereNull("dataFinal")->where("dataInicial", "<", date("Y-m-d"));
                                    })->get();
            }elseif($validated["filtro"] == "futuros"){
                $eventos = Event::whereNotNull("dataFinal")->where("dataFinal",">=", date("Y-m-d"))
                                    ->orWhere(function($query){
                                        $query->whereNull("dataFinal")->where("dataInicial", ">=", date("Y-m-d"));
                                    })->get();
            }elseif($validated["filtro"] == "nao_aprovados"){
                $eventos = Event::where("aprovado", false)->get();
            }
        }else{
            $eventos = Event::all();
        }

        if(!Auth::user()->hasRole(["Administrador", "Moderador"])){
            $eventos = $eventos->where("cadastradorID", Auth::user()->id);
        }

        $eventos = $eventos->sort(function($a,$b){
            $dataInitDeA = Carbon::createFromFormat("d/m/Y", $a->dataInicial)->format("Y-m-d");
            $dataInitDeB = Carbon::createFromFormat("d/m/Y", $b->dataInicial)->format("Y-m-d");
            $dataFimDeA = $a->dataFinal ? Carbon::createFromFormat("d/m/Y", $a->dataFinal)->format("Y-m-d") : null;
            $dataFimDeB = $b->dataFinal ? Carbon::createFromFormat("d/m/Y", $b->dataFinal)->format("Y-m-d") : null;
            
            if($a->dataFinal){
                $aVaiAcontecer = $dataFimDeA >= date("Y-m-d") ? 1 : 0;
            }else{
                $aVaiAcontecer = $dataInitDeA >= date("Y-m-d") ? 1 : 0;
            }

            if($b->dataFinal){
                $bVaiAcontecer = $dataFimDeB >= date("Y-m-d") ? 1 : 0;
            }else{
                $bVaiAcontecer = $dataInitDeB >= date("Y-m-d") ? 1 : 0;
            }

            if($aVaiAcontecer and !$bVaiAcontecer){
                return 1;
            }elseif(!$aVaiAcontecer and $bVaiAcontecer){
                return -1;
            }

            if(!$a->aprovado and $b->aprovado){
                return 1;
            }elseif($a->aprovado and !$b->aprovado){
                return -1;
            }

            if($aVaiAcontecer and $bVaiAcontecer and $dataInitDeA < $dataInitDeB){
                return 1;
            }elseif($aVaiAcontecer and $bVaiAcontecer and $dataInitDeA > $dataInitDeB){
                return -1;
            }

            if(!$aVaiAcontecer and !$bVaiAcontecer and $dataInitDeA > $dataInitDeB){
                return 1;
            }elseif(!$aVaiAcontecer and !$bVaiAcontecer and $dataInitDeA < $dataInitDeB){
                return -1;
            }
        })->reverse();
        
        return view("events.index", compact(["eventos"]));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Auth::check()){
            return redirect("/login");
        }

        $evento = new Event;

        return view("events.create", compact(["evento"]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEventRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEventRequest $request)
    {
        if(!Auth::check()){
            return redirect("/login");
        }

        $validated = $request->validated();

        $anexos = $validated["anexosNovos"] ?? [];
        unset($validated["anexosNovos"]);

        $validated["localID"] = Location::firstOrCreate(["nome"=>$validated["local"]])->id;
        unset($validated["local"]);

        $validated["tipoID"] = Kind::firstOrCreate(["nome"=>$validated["tipo"]])->id;
        unset($validated["tipo"]);

        $evento = Event::firstOrCreate($validated);

        foreach($anexos as $anexo){
            $attachment  = new Attachment;
            
            $attachment->nome = $anexo["arquivo"]->getClientOriginalName();
            $attachment->caminhoArquivo = $anexo["arquivo"]->store($evento->id);

            $evento->anexos()->save($attachment);

            $attachment->link = route("attachments.download",$attachment);
            $attachment->save();
        }

        $moderadores = User::whereHas("roles", function($query){$query->where("name","Moderador");})->get();

        if($moderadores){
            foreach($moderadores as $moderador){
                Mail::to($moderador->email)->send(new NotifyModeratorAboutEvent($moderador, $evento,
                    URL::signedRoute("events.show", ["event"=>$evento->id])));
            }
        }


        return redirect("/events");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Event $event)
    {
        if($request->has("signature")){
            if($request->hasValidSignature()){
                $hasValidSignature = true;
            }else{
                abort(403);
            }
        }elseif(Auth::check()){
            if(Auth::user()->hasRole(["Administrador", "Moderador"])){
                $hasValidSignature = false;
            }else{
                abort(403);
            }
        }else{
            return redirect("/login");
        }

        return view("events.show", ["evento"=>$event, "hasValidSignature"=>$hasValidSignature]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        if(Auth::check()){
            if(!Auth::user()->hasRole(["Administrador", "Moderador"]) and $event->criador->id != Auth::user()->id){
                abort(403);
            }
        }else{
            return redirect("/login");
        }

        return view("events.edit", ["evento"=>$event]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEventRequest  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        if(Auth::check()){
            if(!Auth::user()->hasRole(["Administrador", "Moderador"]) and $event->criador->id != Auth::user()->id){
                abort(403);
            }
        }else{
            return redirect("/login");
        }

        $validated = $request->validated();
        $validated['exigeInscricao'] = isset($validated['exigeInscricao']) ? 1 : 0;
        $validated['gratuito'] = isset($validated['gratuito']) ? 1 : 0;
        $validated['emiteCertificado'] = isset($validated['emiteCertificado']) ? 1 : 0;

        $validated["localID"] = Location::firstOrCreate(["nome"=>$validated["local"]])->id;
        unset($validated["local"]);

        $validated["tipoID"] = Kind::firstOrCreate(["nome"=>$validated["tipo"]])->id;
        unset($validated["tipo"]);

        foreach($event->anexos as $anexo){
            if(!in_array($anexo->id, $validated["anexosIDs"])){
                Storage::delete($anexo->caminhoArquivo);
                
                $anexo->delete();
            }
        }

        if(isset($validated["anexosNovos"])){
            foreach($validated["anexosNovos"] as $anexo){
                $attachment  = new Attachment;
                
                $attachment->nome = $anexo["arquivo"]->getClientOriginalName();
                $attachment->caminhoArquivo = $anexo["arquivo"]->store($event->id);

                $event->anexos()->save($attachment);

                $attachment->link = route("attachments.download",$attachment);
                $attachment->save();
            }
        }        


        $event->update($validated);

        return redirect("/events");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        if(Auth::check()){
            if(!Auth::user()->hasRole(["Administrador", "Moderador"]) and $event->criador->id != Auth::user()->id){
                abort(403);
            }
        }else{
            return redirect("/login");
        }

        foreach($event->anexos as $anexo){
            Storage::delete($anexo->caminhoArquivo);
            
            $anexo->delete();
        }

        $event->delete();

        return redirect("/events");
    }

    public function aprovar(Request $request, Event $event)
    {
        $event->aprovado = true;
        $event->dataAprovacao = date("d/m/Y");

        if(Auth::check()){
            $event->moderadorID = Auth::user()->id;
        }

        $event->save();

        $validated = $request->validate(["sendUserEmail"=>"required|bool"]);

        if($validated["sendUserEmail"]){
            Mail::to($event->criador->email)->send(new NotifyUserAboutEvent($event));
        }

        return back();
    }

    public function desaprovar(Request $request, Event $event)
    {
        $event->aprovado = false;
        $event->dataAprovacao = null;
        $event->moderadorID = null;

        $event->save();

        return back();
    }
}
