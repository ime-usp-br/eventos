<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRegistrationRequest;
use App\Http\Requests\UpdateRegistrationRequest;
use App\Mail\NotifyAboutRegistration;
use App\Models\Registration;
use App\Models\Event;
use Illuminate\Support\Facades\Mail;
use Session;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($slug)
    {
        $evento = Event::where("slug", $slug)
                        ->where("inscricaoPeloSistema",1)
                        ->where("dataInicioInscricoes","<=",now())
                        ->where("dataFimInscricoes",">=", now())->first();
        
        if(!$evento){
            abort(403);
        }

        return view("registration.create", compact("evento"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRegistrationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRegistrationRequest $request, $slug)
    {
        $evento = Event::where("slug", $slug)
                        ->where("inscricaoPeloSistema",1)
                        ->where("dataInicioInscricoes","<=",now())
                        ->where("dataFimInscricoes",">=", now())->first();

        if(!$evento){
            abort(403);
        }

        $validated = $request->validated();
        $validated["eventoID"] = $evento->id;

        Registration::create($validated);

        Mail::to($validated["email"])->queue(new NotifyAboutRegistration($evento));

        Session::flash("alert-success", "Inscrição realizada com sucesso");
        
        return redirect("/");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Registration  $registration
     * @return \Illuminate\Http\Response
     */
    public function show(Registration $registration)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Registration  $registration
     * @return \Illuminate\Http\Response
     */
    public function edit(Registration $registration)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRegistrationRequest  $request
     * @param  \App\Models\Registration  $registration
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRegistrationRequest $request, Registration $registration)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Registration  $registration
     * @return \Illuminate\Http\Response
     */
    public function destroy(Registration $registration)
    {
        //
    }
}
