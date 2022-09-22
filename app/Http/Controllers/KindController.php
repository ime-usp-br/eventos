<?php

namespace App\Http\Controllers;

use App\Models\Kind;
use Illuminate\Http\Request;
use App\Http\Requests\StoreKindRequest;
use Session;
use Auth;

class KindController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreKindRequest $request)
    {
        if(!Auth::check()){
            return redirect("/login");
        }

        $validated = $request->validated();

        $tipo = Kind::firstOrCreate($validated);
        
        Session::put("_old_input.tipoID", $tipo->id);
        
        return back();
    }
}
