<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\UpdateUserRequest;
use App\Models\GoogleCalendar;
use Auth;
use Session;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::check()){
            if(!Gate::allows('editar usuario')){
                abort(403);
            }
        }else{
            return redirect("login");
        }
        
        $users = User::all()->sortBy("name");
        $roles = Role::all()->sortBy("name");

        $gc = GoogleCalendar::latest("updated_at")->first();

        if(!$gc){
            Session::flash("alert-warning","Não foi encontrada nenhuma conta Google para divulgação dos eventos na agenda.");
        }

        return view('users.index', compact('users', 'roles'));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if(!Gate::allows('editar usuario')){
            abort(403);
        }

        $roles = Role::all()->sortBy("name");

        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        if(!Gate::allows('editar usuario')){
            abort(403);
        }

        $validated = $request->validated();

        $user->roles()->detach();
        $user->assignRole($validated['roles']);
        $user->update($validated);

        return redirect('/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    public function loginas()
    {
        if(!Gate::allows('editar usuario')){
            abort(403);
        }

        return view("users.loginas");
    }
}
