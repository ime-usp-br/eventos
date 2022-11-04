@extends('layouts.app')

@section('content')
  @parent
  <div id="layout_conteudo">
    <div class="justify-content-center">
      <div class="col-12">
        @php
          $eventos = App\Models\Event::where("aprovado", true)->where(function($query){
              $query->whereNotNull("dataFinal")->where("dataFinal",">=", date("Y-m-d"))
                ->orWhere(function($query2){
                  $query2->whereNull("dataFinal")->where("dataInicial", ">=", date("Y-m-d"));
              });
            })->orderBy("dataInicial")->get();
          $defesas = App\Models\Defense::whereHas("local")->whereNotNull(["data","horario"])->where("data", ">=", date("Y-m-d"))->orderBy("data")->get();
        @endphp

        @if($eventos->isNotEmpty() or $defesas->isNotEmpty())
          <h1 class='text-center mb-5'>Próximas defesas e eventos</h1>

          <table class="table table-bordered table-hover" style="font-size:12px;">
            <tr style="background-color: rgba(0,0,0,.075);vertical-align: middle;text-align: center;">
              <th style="width:800px;"><b>Titulo</b></th>
              <th>Autor/Organizador</th>
              <th>Tipo</th>
              <th>Data</th>
              <th>Horário</th>
              <th>Local</th>
            </tr>

            @foreach($eventos as $evento)
              <tr data-toggle="collapse"  class="accordion-toggle" data-target="{{ '#collapse-evento'.$evento->id }}">
                <td>{!! $evento->titulo !!}</td>
                <td>{{ $evento->nomeOrganizador }}</td>
                <td>{{ $evento->tipo->nome }}</td>
                <td style="vertical-align: middle;text-align: center;">{{ $evento->dataInicial . ( $evento->dataFinal ? " à " . $evento->dataFinal : "") }}</td>
                <td style="vertical-align: middle;text-align: center;">{{ $evento->horarioInicial . ( $evento->horarioFinal ? " às " . $evento->horarioFinal : "" ) }}</td>
                <td>{{ $evento->local->nome }}</td>
              </tr>

              <tr>
                <td colspan="6" style="padding: 0 !important;background-color: white;">
                  <div id="{{ 'collapse-evento'.$evento->id }}" class="collapse">

                  <div class="card mb-3">
                        <div class="card-body">
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
                                <div class="col-lg">
                                    <label for="modalidadeID">Modalidade:</label> {{$evento->modalidade->nome}}
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

                  </div>
                </td>
              </tr>
            @endforeach

            @foreach($defesas as $defesa)
              <tr data-toggle="collapse"  class="accordion-toggle" data-target="{{ '#collapse-defesa'.$defesa->id }}">
                <td>{!! $defesa->trabalho->titulo !!} </td>
                <td>{{ $defesa->aluno->nome }}</td>
                <td>{{ str_contains($defesa->nivel, "Doutorado") ? "Defesa de Doutorado" : "Defesa de Mestrado" }}</td>
                <td style="vertical-align: middle;text-align: center;">{{ $defesa->data }}</td>
                <td style="vertical-align: middle;text-align: center;">{{ $defesa->horario }}</td>
                <td>{{ $defesa->local->nome }}</td>
              </tr>

              <tr>
                <td colspan="6" style="padding: 0 !important;background-color: white;">

                  <div id="{{ 'collapse-defesa'.$defesa->id }}" class="collapse">

                  <div class="card mb-3">
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
                                            @foreach($defesa->banca->membros()->where("vinculo", "Presidente")->get() as $membro)
                                                {!! $membro->nome.( $membro->staptp ? " (P) " : " " ).( $membro->instituicao->sigla ?? "" ) !!}<br>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="row col-lg lg-pb-3">
                                        <div class="col-lg-auto pr-0">
                                            <label>Titulares:</label>
                                        </div>
                                        <div class="col-lg-auto">
                                            @foreach($defesa->banca->membros()->where("vinculo", "Titular")->get() as $membro)
                                                {!! $membro->nome.( $membro->staptp ? " (P) " : " " ).( $membro->instituicao->sigla ?? "" ) !!}<br>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="row col-lg {{ $defesa->banca->membros()->where('vinculo', 'Substituto')->exists() ? 'lg-pb-3' : '' }}">
                                        <div class="col-lg-auto pr-0">
                                            <label>Suplentes:</label>
                                        </div>
                                        <div class="col-lg-auto">
                                            @foreach($defesa->banca->membros()->where("vinculo", "Suplente")->get() as $membro)
                                                {!! $membro->nome.( $membro->staptp ? " (P) " : " " ).( $membro->instituicao->sigla ?? "" ) !!}<br>
                                            @endforeach
                                        </div>
                                    </div>
                                    @if($defesa->banca->membros()->where('vinculo', 'Substituto')->exists())
                                        <div class="row col-lg">
                                            <div class="col-lg-auto pr-0">
                                                <label>Substitutos:</label>
                                            </div>
                                            <div class="col-lg-auto">
                                                @foreach($defesa->banca->membros()->where("vinculo", "Substituto")->get() as $membro)
                                                {!! $membro->nome.( $membro->staptp ? " (P) " : " " ).( $membro->instituicao->sigla ?? "" ) !!}<br>
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
              </div>    
              </td>
            </tr>          
            @endforeach

          </table>
        @endif
      </div>
    </div>
  </div>
@endsection