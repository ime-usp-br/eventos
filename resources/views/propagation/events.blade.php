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
        @endphp

        @if($eventos->isNotEmpty())
          <h1 class='text-center mb-5'>Próximos eventos</h1>

          <table class="table table-bordered table-hover" style="font-size:12px;">
            <tr style="background-color: rgba(0,0,0,.075);vertical-align: middle;text-align: center;">
              <th style="width:800px;"><b>Titulo</b></th>
              <th class="d-none d-sm-table-cell">Organizador</th>
              <th>Tipo</th>
              <th>Data</th>
              <th>Horário</th>
              <th class="d-none d-sm-table-cell">Local</th>
            </tr>

            @foreach($eventos as $evento)
              <tr data-toggle="collapse"  class="accordion-toggle" data-target="{{ '#collapse-evento'.$evento->id }}">
                <td style="vertical-align: middle;">{!! $evento->titulo !!}</td>
                <td class="d-none d-sm-table-cell">{{ $evento->nomeOrganizador }}</td>
                <td style="vertical-align: middle;text-align: center;">{{ $evento->tipo->nome }}</td>
                <td style="vertical-align: middle;text-align: center;">{{ $evento->dataInicial . ( $evento->dataFinal ? " à " . $evento->dataFinal : "") }}</td>
                <td style="vertical-align: middle;text-align: center;">{{ $evento->horarioInicial . ( $evento->horarioFinal ? " às " . $evento->horarioFinal : "" ) }}</td>
                <td class="d-none d-sm-table-cell">{{ $evento->local->nome }}</td>
              </tr>

              <tr>
                <td colspan="6" style="padding: 0 !important;background-color: white;">
                  <div id="{{ 'collapse-evento'.$evento->id }}" class="collapse">

                  <div class="card mb-3">
                        <div class="card-body">

                            <div class="d-block d-sm-none">
                                <div class="row custom-form-group ">
                                    <div class="row col-lg lg-pb-3">
                                        <div class="col-lg-auto pr-0">
                                            <label>Autor/Organizador:</label>
                                        </div>
                                        <div class="col-lg-auto">
                                        {{ $evento->nomeOrganizador }}
                                        </div>
                                    </div>
                                    <div class="row col-lg">
                                        <div class="col-lg-auto pr-0">
                                            <label>Local:</label>
                                        </div>
                                        <div class="col-lg-auto">
                                        {{ $evento->local->nome }}
                                        </div>
                                    </div>
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

          </table>
        @endif
      </div>
    </div>
  </div>
@endsection