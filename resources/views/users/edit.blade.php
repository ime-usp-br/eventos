@extends('layouts.app')

@section('title', 'Editar perfis')

@section('content')
@parent
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class='text-center mb-3'>
                Editar Usuário
            </h1>

            <p class="alert alert-info rounded-0">
                <b>Atenção:</b>
                Os campos assinalados com * são de preenchimento obrigatório.
            </p>

            <form method="POST"
                action="{{ route('users.update', $user) }}"
            >
                @method('patch')
                @csrf

                @include('users.partials.form', ['buttonText' => 'Editar'])
            </form>
        </div>
    </div>
</div>
@endsection