<!DOCTYPE html>
<html lang="en">
    <head>

        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>IME-USP</title>
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />

        <!-- Google fonts-->

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=Anybody&family=Inter&family=Mulish&family=Roboto+Mono:wght@400;700&display=swap"
            rel="stylesheet">

        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="{{ asset('css/tv/bootstrap.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('css/tv/styles.css').'?v=1' }}" rel="stylesheet" />


        <!-- JQuery -->
        <script src="{{ asset('js/tv/jquery-3.6.0.min.js') }}"></script>

        <!-- Bootstrap JS -->
        <script src="{{ asset('js/tv/bootstrap.bundle.min.js') }}"></script>

        <!-- scripts -->
        <script src="{{ asset('js/tv/scripts.js') }}"></script>
    </head>
    <body id="page-top">
        <div class="container-fluid p-0" id="page">
            <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @php $first = true; @endphp
                    @foreach($defesas as $defesa)
                        <div class="{{ $first ? 'carousel-item active' : 'carousel-item' }}" data-bs-interval="15000">
                            @php $first = false; @endphp
                            <div class="row horizontal">
                                <h1 class="text-center text-white lateral-titulo">DEFESAS AGENDADAS</h1>
                            </div>

                            <div class="row p-5">
                                <table class="table table-striped">
                                    <tr>
                                        <th>Data</th>
                                        <th>Horário</th>
                                        <th>Local</th>
                                        <th>Candidato(a)</th>
                                        <th>Orientador(a)</th>
                                        <th>Nível</th>
                                        <th>Programa</th>
                                    </tr>
                                    @foreach($defesas as $defesa2)
                                        <tr>
                                            <td>{{$defesa2->data}}</td>
                                            <td>{{$defesa2->horario}}</td>
                                            <td>{{$defesa2->local->nome}}</td>
                                            <td>{{$defesa2->aluno->nome}}</td>
                                            <td>{{ $defesa2->aluno->getOrientador()->sexo == "M" ? "Prof. Dr. " : "Profa. Dra. " }}{{ $defesa2->aluno->getOrientador()->nome }}</td>
                                            <td>{{$defesa2->nivel}}</td>
                                            <td>{{$defesa2->sigla}}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>

                            <img src="{{ asset('img/qrcode_defesas.png') }}" class="lateral-qrcode" />
                            <p class="text-center">www.ime.usp.br/defesas</p>
                        </div>

                        <div class="carousel-item" data-bs-interval="17000">

                            <div class="row">
                                <div class="col-3 lateral">
                                    <p class="lateral-titulo">DEFESA DE {{$defesa->nivel}}</p>

                                    <p class="lateral-data">{{$defesa->data}}</p>

                                    <p class="lateral-hora">{{$defesa->horario}}</p>

                                    <p class="lateral-local-titulo">{{$defesa->local->nome}}</p>

                                    <img src="{{ asset('img/qrcode_defesas.png') }}" class="lateral-qrcode" />

                                    <p class="lateral-url">www.ime.usp.br/defesas</p>
                                </div>

                                <div class="col-9 corpo">
                                    <p class="txt-nome-autor">{{$defesa->aluno->nome}}</p>

                                    <p class="titulo-trabalho">{{$defesa->trabalho->titulo}}</p>

                                    <p class="txt-banca-titulo">Comissão julgadora</p>

                                    <p class="txt-banca">{{ $defesa->banca->getPresidente()->sexo == "M" ? "Prof. Dr. " : "Profa. Dra. " }}{{ $defesa->banca->getPresidente()->nome }}{{ $defesa->banca->getPresidente()->instituicao ? ", ".$defesa->banca->getPresidente()->instituicao->sigla : "" }}</p>

                                    @foreach($defesa->banca->getTitulares() as $titular)
                                        <p class="txt-banca">{{ $titular->sexo == "M" ? "Prof. Dr. " : "Profa. Dra. " }}{{ $titular->nome }}{{ $titular->instituicao ? ", ".$titular->instituicao->sigla : "" }}</p>
                                    @endforeach

                                    @if($defesa->programa == "Mestrado Profissional em Ensino de Matemática")
                                        <p class="txt-programa-titulo">{{$defesa->programa}}</p>
                                    @else
                                        <p class="txt-programa-titulo">Programa de Pós-Graduação em {{$defesa->programa}}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div id="footer" style="display:none;">
                <div class="row">
                    <div class="col-1"></div>
                    <div class="col-3"><img src="img/assinatura.png" class="assinatura"></div>
                    <div class="col-4 info text-center">Sistema em testes<br>Fale conosco:
                        gt-comunica@ime.usp.br</div>
                    <div class="col-3 p-2" id="clock"></div>
                    <div class="col-1"></div>
                </div>
            </div>
        </div>
    </body>
</html>