@extends('layouts.app')

@section('title', 'Usuários')

@section('content')
@parent
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1 class='text-center mb-5'>Usuários</h1>

            <div class="d-flex justify-content-end">
                <div class="px-1 py-2">
                    <a  class="btn btn-outline-primary"
                        title="Fazer Login com Conta do Google" 
                        href="{{ route('google.login') }}"
                    >
                        Login
                        <i class="fab fa-google pr-0"></i>oogle
                    </a>
                </div>
            </div>
            @if (count($users) > 0)
                <table class="table table-bordered table-striped table-hover">
                    <tr>
                        <th>Nome</th>
                        <th>Número USP</th>
                        <th>E-mail</th>
                        <th>Perfil</th>
                        <th></th>
                    </tr>

                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->codpes }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->getRoleNames()->implode(', ') }}</td>
                            <td class="text-center">
                                <a class="text-dark text-decoration-none"
                                    data-toggle="tooltip" data-placement="top"
                                    title="Editar"
                                    href="{{ route('users.edit', $user) }}"
                                >
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            @else
                <p class="text-center">Não há usuários cadastrados</p>
            @endif
        </div>
    </div>
</div>
@endsection