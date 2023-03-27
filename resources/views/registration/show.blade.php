@extends('layouts.app')

@section('title', 'Ficha de Inscrição')

@section('content')
@parent
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-11 col-md-10 col-lg-9 col-xl-8">
            <h1 class='text-center'>Ficha de Inscrição</h1>
            <h2 class='text-center mb-5'>{{$inscrito->evento->titulo}}</h2>

            <div class="row justify-content-center">
                <div class="col-auto">

                    <div class="row custom-form-group d-flex align-items-center">
                        <div class="col-12 col-md-auto text-md-right">
                            <label>Nome Completo (Full Name):</label>
                        </div>
                        <div class="col-12 col-md">
                            {{ $inscrito->fullName }}
                        </div>        
                    </div>

                    <div class="row custom-form-group d-flex align-items-center">
                        <div class="col-12 col-md-auto text-md-right">
                            <label>Apelido (Nickname):</label>
                        </div>
                        <div class="col-12 col-md">
                            {{ $inscrito->nickname }}
                        </div>        
                    </div>

                    <div class="row custom-form-group d-flex align-items-center">
                        <div class="col-12 col-md-auto text-md-right">
                            <label>E-mail:</label>
                        </div>
                        <div class="col-12 col-md">
                            {{ $inscrito->email }}
                        </div>        
                    </div>

                    <div class="row custom-form-group d-flex align-items-center">
                        <div class="col-12 col-md-auto text-md-right">
                            <label>Passport:</label>
                        </div>
                        <div class="col-12 col-md">
                            {{ $inscrito->passport }}
                        </div>        
                    </div>

                    <div class="row custom-form-group d-flex align-items-center">
                        <div class="col-12 col-md-auto text-md-right">
                            <label>RG:</label>
                        </div>
                        <div class="col-12 col-md">
                            {{ $inscrito->rg }}
                        </div>        
                    </div>

                    <div class="row custom-form-group d-flex align-items-center">
                        <div class="col-12 col-md-auto text-md-right">
                            <label>Telefone (Phone number):</label>
                        </div>
                        <div class="col-12 col-md">
                            {{ $inscrito->phone }}
                        </div>        
                    </div>

                    <div class="row custom-form-group d-flex align-items-center">
                        <div class="col-12 col-md-auto text-md-right">
                            <label>Instituição (Affiliation):</label>
                        </div>
                        <div class="col-12 col-md">
                            {{ $inscrito->affiliation }}
                        </div>        
                    </div>

                    <div class="row custom-form-group d-flex align-items-center">
                        <div class="col-12 col-md-auto text-md-right">
                            <label>Vínculo (Position):</label>
                        </div>
                        <div class="col-12 col-md">
                            {{ $inscrito->position }}
                        </div>        
                    </div>

                    <div class="row custom-form-group d-flex align-items-center">
                        <div class="col-12 col-md-auto text-md-right">
                            <label>Departamento (Department):</label>
                        </div>
                        <div class="col-12 col-md">
                            {{ $inscrito->department }}
                        </div>        
                    </div>

                    <div class="row custom-form-group d-flex align-items-center">
                        <div class="col-12 col-md-auto text-md-right">
                            <label>CEP (Postal Code):</label>
                        </div>
                        <div class="col-12 col-md">
                            {{ $inscrito->cep }}
                        </div>        
                    </div>

                    <div class="row custom-form-group d-flex align-items-center">
                        <div class="col-12 col-md-auto text-md-right">
                            <label>Endereço (Address):</label>
                        </div>
                        <div class="col-12 col-md">
                            {{ $inscrito->address }}
                        </div>        
                    </div>

                    <div class="row custom-form-group d-flex align-items-center">
                        <div class="col-12 col-md-auto text-md-right">
                            <label>Cidade (City):</label>
                        </div>
                        <div class="col-12 col-md">
                            {{ $inscrito->city }}
                        </div>        
                    </div>

                    <div class="row custom-form-group d-flex align-items-center">
                        <div class="col-12 col-md-auto text-md-right">
                            <label>Estado (State):</label>
                        </div>
                        <div class="col-12 col-md">
                            {{ $inscrito->state }}
                        </div>        
                    </div>

                    <div class="row custom-form-group d-flex align-items-center">
                        <div class="col-12 col-md-auto text-md-right">
                            <label>País (Country):</label>
                        </div>
                        <div class="col-12 col-md">
                            {{ $inscrito->country }}
                        </div>        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection