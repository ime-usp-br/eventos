@extends('layouts.app')

@section('title', 'Inscritos')

@section('content')
@parent
<div id="layout_conteudo">
    <div class="row justify-content-center">
        <div class="col-12">
            <h1 class='text-center'>Inscritos no evento</h1>
            <h2 class='text-center mb-5'>{{$evento->titulo}}</h2>

            @if(count($inscritos) > 0)
                <table class="table table-bordered table-striped table-hover" style="font-size:15px;">
                    <tr>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Telefone</th>
                        <th>Instituição</th>
                        <th>País</th>
                        <th></th>
                    </tr>
                    @foreach($inscritos as $inscrito)
                        <tr class="text-center">
                            <td>{{ $inscrito->fullName }}</td>
                            <td>{{ $inscrito->email }}</td>
                            <td>{{ $inscrito->phone }}</td>
                            <td>{{ $inscrito->affiliation }}</td>
                            <td>{{ $inscrito->country }}</td>
                            <td>
                                
                            </td>
                        </tr>
                    @endforeach
                </table>
            @else
                <p class="text-center">Não há inscritos neste evento</p>                
            @endif
        </div>
    </div>
</div>
@endsection