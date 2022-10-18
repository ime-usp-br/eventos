@extends('layouts.app')

@section('title', 'Eventos')

@section('content')
@parent
<div id="layout_conteudo">
    <div class="justify-content-center">
        <div class="col-12">
            <h1 class='text-center mb-5'>Eventos</h1>


            <div class="d-flex justify-content-end">
                <div class="px-1 py-2">
                    <form action="{{ route('events.index') }}" method="GET" style="display: inline-block;">
                        <input type="hidden" name="filtro" value="passados">

                        <button class="btn btn-outline-primary" type="submit">Eventos Passados</button>
                    </form>
                </div>
                <div class="px-1 py-2">
                    <form action="{{ route('events.index') }}" method="GET" style="display: inline-block;">
                        <input type="hidden" name="filtro" value="nao_aprovados">

                        <button class="btn btn-outline-primary" type="submit">Não Aprovados</button>
                    </form>
                </div>
                <div class="px-1 py-2">
                    <form action="{{ route('events.index') }}" method="GET" style="display: inline-block;">
                        <input type="hidden" name="filtro" value="futuros">

                        <button class="btn btn-outline-primary" type="submit">Eventos Futuros</button>
                    </form>
                </div>
                <div class="px-1 py-2">
                    <a  id="btn-addEvent"
                        class="btn btn-outline-primary"
                        title="Cadastrar Novo Evento" 
                        href="{{ route('events.create') }}"
                    >
                        <i class="fas fa-plus-circle"></i>
                        Cadastrar
                    </a>
                </div>
            </div>
            @if (count($eventos) > 0)
                @foreach($eventos as $evento)
                    <div class="card mb-3">
                        <div class="card-header">
                            <div class="row justify-content-between">
                                <div class="row justify-content-start ml-0">
                                    <div class="col-sm-auto pl-2" style="margin-top:5px;">
                                    <b>Aprovado:</b> {{$evento->aprovado ? " Sim" : " Não"}}
                                    </div>
                                    @if(Auth::user()->hasRole(["Administrador", "Moderador"]))
                                        @include('events.modals.emailSendingConfirmation', ['eventoID'=>$evento->id])
                                        <div class="col-sm-auto pl-2">
                                            @if(!$evento->aprovado)
                                                <a class="btn btn-outline-success btn-sm"
                                                    data-toggle="modal"
                                                    data-target="{{ '#emailSendingConfirmationModal' . $evento->id  }}"
                                                >
                                                        Validar Evento
                                                </a>
                                            @else
                                                <form method="POST"  action="{{ route('events.invalidate',$evento) }}" style="display: inline;">
                                                    @csrf
                                                    @method('put')
                                                    <button class="btn btn-outline-danger btn-sm" type="submit">
                                                        Invalidar Evento
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                                @if(Auth::user()->hasRole(["Administrador", "Moderador"]) or $evento->cadastradorID == Auth::user()->id)
                                    <div class="text-rigth mr-3" style="white-space: nowrap;">
                                        <a class="text-dark text-decoration-none"
                                            data-toggle="tooltip" data-placement="top"
                                            title="Editar"
                                            href="{{ route('events.edit', $evento) }}"
                                        >
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="post"  action="{{ route('events.destroy',$evento) }}" style="display: inline;">
                                            @method('delete')
                                            @csrf
                                            <button class="btn p-0"
                                                onclick="return confirm('Você tem certeza que deseja excluir esse evento?')" >
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="custom-form-group">
                                    <label for="titulo">Título:</label> {{$evento->titulo}}
                            </div>

                            <div class="row custom-form-group">
                                <div class="col-lg lg-pb-3">
                                    <label for="dataInicial">Data Inicial:</label> {{$evento->dataInicial}}
                                </div>
                                <div class="col-lg lg-pb-3">
                                    <label for="dataFinal">Data Final:</label> {{$evento->dataFinal}}
                                </div>
                                <div class="col-lg lg-pb-3">
                                    <label for="horarioInicial">Horário Inicial:</label> {{$evento->horarioInicial}}
                                </div>
                                <div class="col-lg">
                                    <label for="horarioFinal">Horário Final:</label> {{$evento->horarioFinal}}
                                </div>
                            </div>

                            <div class="row custom-form-group">
                                <div class="col-lg lg-pb-3">
                                    <label for="local">Local:</label> {{$evento->local->nome}}
                                </div>
                                <div class="col-lg">
                                    <label for="nomeOrganizador">Nome do Organizador:</label> {{$evento->nomeOrganizador}}
                                </div>
                            </div>

                            <div class="row custom-form-group">
                                <div class="col-lg lg-pb-3">
                                    <label for="exigeInscricao">Exige Inscrição:</label> {{ $evento->exigeInscricao ? 'Sim' : 'Não' }}
                                </div>
                                <div class="col-lg lg-pb-3">
                                    <label for="gratuito">Gratuito:</label> {{ $evento->gratuito ? 'Sim' : 'Não' }}
                                </div>
                                <div class="col-lg">
                                    <label for="emiteCertificado">Emite Certificado:</label> {{ $evento->emiteCertificado ? 'Sim' : 'Não' }}
                                </div>
                            </div>

                            <div class="row custom-form-group">
                                <div class="col-lg lg-pb-3">
                                    <label for="idiomaID">Idioma:</label> {{$evento->idioma->nome}}
                                </div>
                                <div class="col-lg lg-pb-3">
                                    <label for="modalidadeID">Modalidade:</label> {{$evento->modalidade->nome}}
                                </div>
                                <div class="col-lg">
                                    <label for="tipoID">Tipo:</label> {{$evento->tipo->nome}}
                                </div>
                            </div>

                            <div class="custom-form-group">
                                <label for="descricao">Descrição:</label> {!! $evento->descricao !!}
                            </div>

                            <div class="custom-form-group">
                                <label for="descricao">Anexos:</label>
                                @foreach($evento->anexos as $anexo)
                                    <div class="col-lg">
                                        <a href="{{ route('attachments.download', $anexo) }}">{{ $anexo->nome }}</a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-center">Não há eventos cadastrados</p>
            @endif
        </div>
    </div>
</div>
@endsection