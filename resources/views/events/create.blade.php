@extends('layouts.app')

@section('title', 'Cadastrar Evento')

@section('content')
@parent
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <b>
                        Cadastro de novo evento
                    </b>
                </div>
                <div class="card-body">
                    <p class="alert alert-info rounded-0">
                        <b>Atenção:</b>
                        Os campos assinalados com * são de preenchimento obrigatório.
                    </p>
                    @include('events.modals.locationCreate')
                    @include('events.modals.kindCreate')
                    <form method="POST" enctype="multipart/form-data"
                        action="{{ route('events.store', $evento) }}"
                    >
                        @csrf
                        <input name="cadastradorID" value="{{Auth::user()->id}}" type="hidden">

                        @include('events.partials.form', ['buttonText' => 'Cadastrar'])
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection



@section('javascripts_bottom')
 @parent
<script>
    tinymce.init({
    selector: '#descricaoEvento',
    plugins: 'link,code',
    link_default_target: '_blank'
    });

    $(window).on('load', function() {
        if ($("#inscricaoPeloSistema").prop('checked')) {
            $("#dataInicioInscricoes").prop("disabled", false);
            $("#dataFimInscricoes").prop("disabled", false);
            $("#dataInicioInscricoes").datepicker( "option", "disabled", false );
            $("#dataFimInscricoes").datepicker( "option", "disabled", false );
        }
        else {
            $("#dataInicioInscricoes").prop("disabled", true);
            $("#dataFimInscricoes").prop("disabled", true);
            $("#dataInicioInscricoes").datepicker( "option", "disabled", true );
            $("#dataFimInscricoes").datepicker( "option", "disabled", true );
        }    
    });

    function ckChange(ckType){
        var checked = document.getElementById(ckType.id);
        if (checked.checked) {
            if(ckType.id == "inscricaoPeloSistema"){
                $("#dataInicioInscricoes").prop("disabled", false);
                $("#dataFimInscricoes").prop("disabled", false);
                $("#dataInicioInscricoes").datepicker( "option", "disabled", false );
                $("#dataFimInscricoes").datepicker( "option", "disabled", false );
            }
        }
        else {
            if(ckType.id == "inscricaoPeloSistema"){
                $("#dataInicioInscricoes").prop("disabled", true);
                $("#dataFimInscricoes").prop("disabled", true);
                $("#dataInicioInscricoes").datepicker( "option", "disabled", true );
                $("#dataFimInscricoes").datepicker( "option", "disabled", true );
            }
        }    
    };
</script>
@endsection