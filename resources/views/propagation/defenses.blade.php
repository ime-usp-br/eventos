@extends('layouts.app')

@section('content')
  @parent
  <div id="layout_conteudo">
    <div class="justify-content-center">
      <div class="col-12">
        @php
          $defesas = App\Models\Defense::whereHas("local")->whereNotNull(["data","horario"])->where("data", ">=", date("Y-m-d"))->orderBy("data")->get();
        @endphp

        @if($defesas->isNotEmpty())
          <h1 class='text-center mb-5'>Próximas defesas</h1>

          <table class="table table-bordered table-hover" style="font-size:12px;">
            <tr style="background-color: rgba(0,0,0,.075);vertical-align: middle;text-align: center;">
              <th style="width:800px;"><b>Titulo</b></th>
              <th class="d-none d-sm-table-cell">Autor</th>
              <th>Tipo</th>
              <th>Data</th>
              <th>Horário</th>
              <th class="d-none d-sm-table-cell">Local</th>
            </tr>

            @foreach($defesas as $defesa)
              <tr data-toggle="collapse"  class="accordion-toggle" data-target="{{ '#collapse-defesa'.$defesa->id }}">
                <td style="vertical-align: middle;">{!! $defesa->trabalho->titulo !!} </td>
                <td class="d-none d-sm-table-cell">{{ $defesa->aluno->nome }}</td>
                <td style="vertical-align: middle;text-align: center;">{{ str_contains($defesa->nivel, "Doutorado") ? "Defesa de Doutorado" : "Defesa de Mestrado" }}</td>
                <td style="vertical-align: middle;text-align: center;">{{ $defesa->data }}</td>
                <td style="vertical-align: middle;text-align: center;">{{ $defesa->horario }}</td>
                <td class="d-none d-sm-table-cell">{{ $defesa->local->nome }}</td>
              </tr>

              <tr>
                <td colspan="6" style="padding: 0 !important;background-color: white;">

                  <div id="{{ 'collapse-defesa'.$defesa->id }}" class="collapse">

                  <div class="card mb-3">
                    <div class="card-body">

                        <div class="d-block d-sm-none">
                            <div class="row custom-form-group ">
                                <div class="row col-lg">
                                    <div class="col-lg-auto pr-0">
                                        <label>{{ $defesa->aluno->sexo == "F" ? "Candidata:" : "Candidato:"}}</label>
                                    </div>
                                    <div class="col-lg-auto">
                                    {{ $defesa->aluno->nome }}
                                    </div>
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
                            <div class="row col-lg">
                                <div class="col-lg-auto pr-0">
                                    <label>Programa:</label>
                                </div>
                                <div class="col-lg-auto">
                                {{$defesa->programa}}
                                </div>
                            </div>
                        </div>

                        <div class="d-block d-sm-none">
                            <div class="row custom-form-group ">
                                <div class="row col-lg">
                                    <div class="col-lg-auto pr-0">
                                        <label>Local:</label>
                                    </div>
                                    <div class="col-lg-auto">
                                    {{ $defesa->local->nome }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row custom-form-group">
                            <div class="row col-lg">
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