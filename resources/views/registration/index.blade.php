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
                <table id="tabela-inscritos" class="table table-bordered table-striped table-hover" style="font-size:15px;">

                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Telefone</th>
                            <th>Instituição</th>
                            <th>País</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($inscritos as $inscrito)
                            <tr class="text-center">
                                <td>{{ $inscrito->fullName }}</td>
                                <td>{{ $inscrito->email }}</td>
                                <td>{{ $inscrito->phone }}</td>
                                <td>{{ $inscrito->affiliation }}</td>
                                <td>{{ $inscrito->country }}</td>
                                <td>                                    
                                    <a class="btn btn-outline-dark btn-sm"
                                        data-toggle="tooltip" data-placement="top"
                                        title="Ver ficha de inscrição completa"
                                        href="{{ route('registration.show', $inscrito) }}"
                                    >
                                        Ver Ficha
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-center">Não há inscritos neste evento</p>                
            @endif
        </div>
    </div>
</div>
@endsection



@section('javascripts_bottom')
  <script>
    $(document).ready(function() {
        $('#tabela-inscritos').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf'
            ]
        });
    } );
  </script>
@endsection