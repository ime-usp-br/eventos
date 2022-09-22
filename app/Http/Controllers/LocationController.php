<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLocationRequest;
use App\Http\Requests\UpdateLocationRequest;
use App\Models\Location;
use Session;
use Auth;

class LocationController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreLocationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLocationRequest $request)
    {
        if(!Auth::check()){
            return redirect("/login");
        }

        $validated = $request->validated();

        $local = Location::firstOrCreate($validated);
        
        Session::put("_old_input.localID", $local->id);

        return back();
    }
}
