@extends('layouts.app')

@section('title', 'Editar Defesa')

@section('content')
@parent
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <b>
                        Editar Defesa
                    </b>
                </div>
                <div class="card-body">
                    <p class="alert alert-info rounded-0">
                        <b>Atenção:</b>
                        Os campos assinalados com * são de preenchimento obrigatório.
                    </p>
                    @include('defenses.modals.locationCreate')
                    @include('defenses.modals.addInstitution')
                    <form method="POST" enctype="multipart/form-data"
                        action="{{ route('defenses.update', $defesa) }}"
                    >
                        @csrf
                        @method('patch')
                        @include('defenses.partials.form', ['buttonText' => 'Editar'])
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
    $("#addInstitutionModal").on("show.bs.modal", function(e){
        $("#member_id").val($(e.relatedTarget).data("id"));
        $("#institution_name_modal").val("");
        $("#institution_abbreviation_modal").val("");
        $("#error-modal").empty();
    });
    $("#btn-addInstitution2").on("click", function(e){
        e.preventDefault();
        e.stopPropagation();
        var member_id = $("#member_id").val();
        var name = $("#institution_name_modal").val();
        var abbrev = $("#institution_abbreviation_modal").val().toUpperCase();

        if(abbrev != ""){
            var html = [
                '<input id="instituicoes['+member_id+'][nome]" name="instituicoes['+member_id+'][nome]" type="hidden" value='+name+'>',
                '<input id="instituicoes['+member_id+'][sigla]" name="instituicoes['+member_id+'][sigla]" type="hidden" value='+abbrev+'>',
                '<label id="label-institution-'+member_id+'" class="pl-2 font-weight-normal">'+abbrev+'</label>',
                '<a class="btn btn-link btn-sm text-dark text-decoration-none"',
                '    id="btn-remove-institution-'+member_id+'" style="position:relative;top:-3px;"',
                '    onclick="removeInstitution(\''+member_id+'\')"',
                '>',
                '    <i class="fas fa-trash-alt"></i>',
                '</a>',
            ].join("\n");        
            $("#membro-"+member_id+"-instituicao").empty();
            $("#membro-"+member_id+"-instituicao").append(html);
            $('#addInstitutionModal').hide();
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove(); 
        }else{
            $("#error-modal").empty();
            $("#error-modal").append("<p class='alert alert-warning align-items-center'>É necessárion informar ao menos a sigla da instituição!</p>");
        }
    });
    function removeInstitution(id){
        var html = [
            '<a class="btn btn-link btn-sm text-dark text-decoration-none" id="btn-addInstitution"',
            'data-toggle="modal" data-target="#addInstitutionModal" data-id="'+id+'" style="position:relative;top:-3px;"',
            'title="Adicionar Instituição">',
            '<i class="fas fa-plus-circle"></i>',
            '</a>'
            ].join("\n");
        $("#membro-"+id+"-instituicao").empty();
        $("#membro-"+id+"-instituicao").append(html);
    }
</script>
@endsection