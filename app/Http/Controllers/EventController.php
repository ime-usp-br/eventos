<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\Event;
use App\Models\Attachment;
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
            abort(403);
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
            abort(403);
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
            abort(403);
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


        return redirect("/events");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        //
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
            abort(403);
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
            abort(403);
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
            abort(403);
        }

        $event->delete();

        return redirect("/events");
    }
}
