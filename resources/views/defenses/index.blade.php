@extends('layouts.app')

@section('title', 'Defesas')

@section('content')
@parent
<div id="layout_conteudo">
    <div class="justify-content-center">
        <div class="col-12">
            <h1 class='text-center mb-5'>Defesas</h1>

            <div class="d-flex justify-content-end">
                <div class="px-1 py-2">
                    <form action="{{ route('defenses.index') }}" method="GET">
                        <input type="hidden" name="filtro" value="passados">

                        <button class="btn btn-outline-primary" type="submit">Defesas Passadas</button>
                    </form>
                </div>
                <div class="px-1 py-2">
                    <form action="{{ route('defenses.index') }}" method="GET">
                        <input type="hidden" name="filtro" value="nao_agendadas">

                        <button class="btn btn-outline-primary" type="submit">Não Agendadas</button>
                    </form>
                </div>
                <div class="px-1 py-2">
                    <form action="{{ route('defenses.index') }}" method="GET">
                        <input type="hidden" name="filtro" value="futuros">

                        <button class="btn btn-outline-primary" type="submit">Defesas Futuras</button>
                    </form>
                </div>
            </div>

            @if (count($defesas) > 0)
                @foreach($defesas as $defesa)
                    <div class="card mb-3">
                        <div class="card-header">
                            <div class="row justify-content-between">
                                <div class="row justify-content-start ml-0">
                                    <div class="col-sm-auto pl-2" style="margin-top:5px;">
                                    <b>{{$defesa->aluno->nome}}</b>
                                    </div>
                                </div>
                                @if(Auth::user()->hasRole(["Administrador", "Moderador"]))
                                    <div class="text-rigth mr-3" style="white-space: nowrap;">
                                        <a class="text-dark text-decoration-none"
                                            data-toggle="tooltip" data-placement="top"
                                            title="Editar"
                                            href="{{ route('defenses.edit', $defesa) }}"
                                        >
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="post"  action="{{ route('defenses.destroy',$defesa) }}" style="display: inline;">
                                            @method('delete')
                                            @csrf
                                            <button class="btn p-0"
                                                onclick="return confirm('Você tem certeza que deseja excluir essa defesa?')" >
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">


                            <div class="row custom-form-group">
                                <div class="row col-lg lg-pb-3">
                                    <div class="col-lg-auto pr-0">
                                        <label>Programa:</label>
                                    </div>
                                    <div class="col-lg-auto">
                                    {{$defesa->programa}}
                                    </div>
                                </div>
                                <div class="row col-lg">
                                    <div class="col-lg-auto pr-0">
                                        <label>Nível:</label>
                                    </div>
                                    <div class="col-lg-auto">
                                    {!! $defesa->nivel !!}
                                    </div>
                                </div>
                            </div>

                            <div class="row custom-form-group">
                                <div class="row col-lg {{ $defesa->aluno->orientadores()->where('tipo', 'Coorientador')->exists() ? 'lg-pb-3' : '' }}">
                                    <div class="col-lg-auto pr-0">
                                        <label for="dataInicial">Orientador{!! count($defesa->aluno->orientadores()->where("tipo", "Orientador")->get()) > 1 ? "es" : "" !!}:</label>
                                    </div>
                                    <div class="col-lg-auto">
                                        @foreach($defesa->aluno->orientadores()->where("tipo", "Orientador")->get() as $orientador)
                                            {!! $orientador->nome !!}<br>
                                        @endforeach
                                    </div>
                                </div>
                                @if($defesa->aluno->orientadores()->where('tipo', 'Coorientador')->exists())
                                <div class="row col-lg">
                                    <div class="col-lg-auto pr-0">
                                        <label for="dataInicial">Coorientador{!! count($defesa->aluno->orientadores()->where("tipo", "Coorientador")->get()) > 1 ? "es" : "" !!}:</label>
                                    </div>
                                    <div class="col-lg-auto">
                                        @foreach($defesa->aluno->orientadores()->where("tipo", "Coorientador")->get() as $coorientador)
                                            {!! $coorientador->nome !!}<br>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                            </div>

                            <div class="row custom-form-group">
                                <div class="row col-lg lg-pb-3">
                                    <div class="col-lg-auto pr-0">
                                        <label for="dataInicial">Data:</label>
                                    </div>
                                    <div class="col-lg-auto">
                                        {{ $defesa->data ?? "Não informado"}}
                                    </div>
                                </div>
                                <div class="row col-lg lg-pb-3">
                                    <div class="col-lg-auto pr-0">
                                        <label for="dataFinal">Horário:</label>
                                    </div>
                                    <div class="col-lg-auto">
                                        {{ $defesa->horario ?? "Não informado"}}
                                    </div>
                                </div>
                                <div class="row col-lg">
                                    <div class="col-lg-auto pr-0">
                                        <label for="dataFinal">Local:</label>
                                    </div>
                                    <div class="col-lg-auto">
                                        {{ $defesa->local->nome ?? "Não informado"}}
                                    </div>
                                </div>
                            </div>

                            <div class="row custom-form-group">
                                <div class="row col-lg lg-pb-3">
                                    <div class="col-lg-auto">
                                        <label for="link">link:</label>
                                    </div>
                                    <div class="col-lg-auto">
                                        {{ $defesa->link ?? "Não informado"}}
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-3">
                                <div class="card-header">
                                    <b>Banca</b>
                                </div>

                                <div class="card-body">
                                    <div class="row custom-form-group">
                                        <div class="row col-lg lg-pb-3">
                                            <div class="col-lg-auto pr-0">
                                                <label>Presidente:</label>
                                            </div>
                                            <div class="col-lg-auto">
                                                @foreach($defesa->banca->membros()->where("vinculo", "Presidente")->get() as $presidente)
                                                    {!! $presidente->nome.( $presidente->staptp ? " (P)" : "" ) !!}<br>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="row col-lg lg-pb-3">
                                            <div class="col-lg-auto pr-0">
                                                <label>Titulares:</label>
                                            </div>
                                            <div class="col-lg-auto">
                                                @foreach($defesa->banca->membros()->where("vinculo", "Titular")->get() as $titular)
                                                    {!! $titular->nome.( $titular->staptp ? " (P)" : "" ) !!}<br>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="row col-lg {{ $defesa->banca->membros()->where('vinculo', 'Substituto')->exists() ? 'lg-pb-3' : '' }}">
                                            <div class="col-lg-auto pr-0">
                                                <label>Suplentes:</label>
                                            </div>
                                            <div class="col-lg-auto">
                                                @foreach($defesa->banca->membros()->where("vinculo", "Suplente")->get() as $suplente)
                                                    {!! $suplente->nome.( $suplente->staptp ? " (P)" : "" ) !!}<br>
                                                @endforeach
                                            </div>
                                        </div>
                                        @if($defesa->banca->membros()->where('vinculo', 'Substituto')->exists())
                                            <div class="row col-lg">
                                                <div class="col-lg-auto pr-0">
                                                    <label>Substitutos:</label>
                                                </div>
                                                <div class="col-lg-auto">
                                                    @foreach($defesa->banca->membros()->where("vinculo", "Substituto")->get() as $substituto)
                                                        {!! $substituto->nome.( $suplente->staptp ? " (P)" : "" ) !!}<br>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-3">
                                <div class="card-header">
                                    <b>{!! $defesa->nivel == "Mestrado" ? "Dissertação" : "Tese" !!}</b>
                                </div>

                                <div class="card-body">
                                    <div class="custom-form-group">
                                        <label for="titulo">Título:</label> {!! $defesa->trabalho ? $defesa->trabalho->titulo : ( $defesa->nivel == "Mestrado" ? "Dissertação " : "Tese " ) . "não encontrada." !!}
                                    </div>

                                    <div class="custom-form-group">
                                        <label for="titulo">Resumo:</label> {!! $defesa->trabalho ? $defesa->trabalho->resumo : ( $defesa->nivel == "Mestrado" ? "Dissertação " : "Tese " ) . "não encontrada." !!}
                                    </div>

                                    <div class="custom-form-group">
                                        <label for="titulo">Palavras-chave:</label> {!! $defesa->trabalho ? $defesa->trabalho->palavrasChave : ( $defesa->nivel == "Mestrado" ? "Dissertação " : "Tese " ) . "não encontrada." !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-center">Não há defesas cadastradas</p>
            @endif
        </div>
    </div>
</div>
@endsection