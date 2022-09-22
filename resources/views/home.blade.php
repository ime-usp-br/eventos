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

          <table class="table table-bordered table-striped table-hover" style="font-size:12px;">
            <tr>
              <th><b>Titulo</b></th>
              <th>Autor</th>
              <th>Tipo</th>
              <th>Data</th>
              <th>Horário</th>
              <th>Local</th>
            </tr>

            @foreach($eventos as $evento)
              <tr>
                <td>{!! $evento->titulo !!}</td>
                <td>{{ $evento->nomeOrganizador }}</td>
                <td>{{ $evento->tipo->nome }}</td>
                <td>{{ $evento->dataInicial . ( $evento->dataFinal ? " à " . $evento->dataFinal : "") }}</td>
                <td>{{ $evento->horarioInicial . ( $evento->horarioFinal ? " às " . $evento->horarioFinal : "" ) }}</td>
                <td>{{ $evento->local->nome }}</td>
              </tr>
            @endforeach

            @foreach($defesas as $defesa)
              <tr>
                <td>{!! $defesa->trabalho->titulo !!}</td>
                <td>{{ $defesa->aluno->nome }}</td>
                <td>{{ $defesa->nivel }}</td>
                <td>{{ $defesa->data }}</td>
                <td>{{ $defesa->horario }}</td>
                <td>{{ $defesa->local->nome }}</td>
              </tr>
            @endforeach

          </table>
        @endif
      </div>
    </div>
  </div>
@endsection