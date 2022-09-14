<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
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
use Auth;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::check()){
            if(Auth::user()->hasRole(["Administrador", "Moderador"])){
                $eventos = Event::all();
            }else{
                $eventos = Event::where("cadastradorID", Auth::user()->id)->get();
            }
        }else{
            return redirect("/login");
        }
        
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

        $evento = Event::firstOrCreate($validated);

        foreach($anexos as $anexo){
            $attachment  = new Attachment;
            
            $attachment->nome = $anexo["arquivo"]->getClientOriginalName();
            $attachment->caminhoArquivo = $anexo["arquivo"]->store($evento->id);

            $evento->anexos()->save($attachment);
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
            $hasValidSignature = false;
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

        $event->delete();

        return redirect("/events");
    }

    public function aprovar(Request $request, Event $event)
    {
        $event->aprovado = true;

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

        $event->save();

        return back();
    }
}
