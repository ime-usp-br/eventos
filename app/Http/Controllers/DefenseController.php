<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDefenseRequest;
use App\Http\Requests\UpdateDefenseRequest;
use App\Models\Defense;
use Uspdev\Replicado\DB;

class DefenseController extends Controller
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Defense  $defense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Defense $defense)
    {
        //
    }

    public function importFromReplicado()
    {
        
    }
}
