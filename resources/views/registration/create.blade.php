@extends('layouts.app')

@section('title', 'Ficha de Inscriçao')

@section('content')
@parent
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-11 col-md-10 col-lg-9 col-xl-8">
            <div class="card mb-3">
                <div class="card-header">
                    <h5><b>{{$evento->titulo}}</b></h5>
                </div>
                <div class="card-body">
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
                            <label for="url">URL:</label> {{$evento->url}}
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
                            <label>Data Inicio das Inscrições:</label> {{$evento->dataInicioInscricoes}}
                        </div>
                        <div class="col-lg">
                            <label>Data Final das Inscrições:</label> {{$evento->dataFimInscricoes}}
                        </div>
                    </div>

                    <div class="custom-form-group">
                            <label for="nomeOrganizador">Nome do Organizador:</label> {{$evento->nomeOrganizador}}
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
                </div>
            </div>

            <h1 class='text-center my-5'>Ficha de Inscriçao</h1>

            <form method="POST" enctype="multipart/form-data" id="inscricaoForm"
                action="{{ route('registration.store', $evento->slug) }}"
            >
                @csrf

                <div class="row custom-form-group d-flex align-items-center">
                    <div class="col-12 col-md-auto text-md-right">
                        <label>Nome Completo (Full Name):</label>
                    </div>
                    <div class="col-12 col-md">
                        <input class="custom-form-control" type="text" name="fullName" id="fullName" value={{ old("fullName") ?? '' }}>
                    </div>        
                </div>

                <div class="row custom-form-group d-flex align-items-center">
                    <div class="col-12 col-md-auto text-md-right">
                        <label>Apelido (Nickname):</label>
                    </div>
                    <div class="col-12 col-md">
                        <input class="custom-form-control" type="text" name="nickname" id="nickname" placeholder="Will be used on the badge" value={{ old("nickname") ?? '' }}>
                    </div>        
                </div>

                <div class="row custom-form-group d-flex align-items-center">
                    <div class="col-12 col-md-auto text-md-right">
                        <label>E-mail:</label>
                    </div>
                    <div class="col-12 col-md">
                        <input class="custom-form-control" type="text" name="email" id="email" value={{ old("email") ?? '' }}>
                    </div>        
                </div>

                <div class="row custom-form-group d-flex align-items-center">
                    <div class="col-12 col-md-auto text-md-right">
                        <label>Passport:</label>
                    </div>
                    <div class="col-12 col-md">
                        <input class="custom-form-control" type="text" name="passport" id="passport" placeholder="Non-brazilians only" value={{ old("passport") ?? '' }}>
                    </div>        
                </div>

                <div class="row custom-form-group d-flex align-items-center">
                    <div class="col-12 col-md-auto text-md-right">
                        <label>RG:</label>
                    </div>
                    <div class="col-12 col-md">
                        <input class="custom-form-control" type="text" name="rg" id="rg" placeholder="Brazilians only" value={{ old("rg") ?? '' }}>
                    </div>        
                </div>

                <div class="row custom-form-group d-flex align-items-center">
                    <div class="col-12 col-md-auto text-md-right">
                        <label>Telefone (Phone number):</label>
                    </div>
                    <div class="col-12 col-md">
                        <input class="custom-form-control" type="text" name="phone" id="phone" value={{ old("phone") ?? '' }}>
                    </div>        
                </div>

                <div class="row custom-form-group d-flex align-items-center">
                    <div class="col-12 col-md-auto text-md-right">
                        <label>Instituição (Affiliation):</label>
                    </div>
                    <div class="col-12 col-md">
                        <input class="custom-form-control" type="text" name="affiliation" id="affiliation" value={{ old("affiliation") ?? '' }}>
                    </div>        
                </div>

                <div class="row custom-form-group d-flex align-items-center">
                    <div class="col-12 col-md-auto text-md-right">
                        <label>Vínculo (Position):</label>
                    </div>
                    <div class="col-12 col-md">
                        <select class="custom-form-control" name="position" style="max-width:200px;">
                            <option value=""></option>
                            <option value="Professor" {{ "Professor"==old('position') ? "selected" : "" }}>Professor</option>
                            <option value="Graduate student" {{ "Graduate student"==old('position') ? "selected" : "" }}>Graduate student</option>
                            <option value="Undergraduate student" {{ "Undergraduate student"==old('position') ? "selected" : "" }}>Undergraduate student</option>
                            <option value="Other" {{ "Other"==old('position') ? "selected" : "" }}>Other</option>
                        </select>
                    </div>        
                </div>

                <div class="row custom-form-group d-flex align-items-center">
                    <div class="col-12 col-md-auto text-md-right">
                        <label>Departamento (Department):</label>
                    </div>
                    <div class="col-12 col-md">
                        <input class="custom-form-control" type="text" name="department" id="department" value={{ old("department") ?? '' }}>
                    </div>        
                </div>

                <div class="row custom-form-group d-flex align-items-center">
                    <div class="col-12 col-md-auto text-md-right">
                        <label>CEP (Postal Code):</label>
                    </div>
                    <div class="col-12 col-md">
                        <input class="custom-form-control" type="text" name="cep" id="cep" value={{ old("cep") ?? '' }}>
                    </div>        
                </div>

                <div class="row custom-form-group d-flex align-items-center">
                    <div class="col-12 col-md-auto text-md-right">
                        <label>Endereço (Address):</label>
                    </div>
                    <div class="col-12 col-md">
                        <input class="custom-form-control" type="text" name="address" id="address" value={{ old("address") ?? '' }}>
                    </div>        
                </div>

                <div class="row custom-form-group d-flex align-items-center">
                    <div class="col-12 col-md-auto text-md-right">
                        <label>Cidade (City):</label>
                    </div>
                    <div class="col-12 col-md">
                        <input class="custom-form-control" type="text" name="city" id="city" value={{ old("city") ?? '' }}>
                    </div>        
                </div>

                <div class="row custom-form-group d-flex align-items-center">
                    <div class="col-12 col-md-auto text-md-right">
                        <label>Estado (State):</label>
                    </div>
                    <div class="col-12 col-md">
                        <input class="custom-form-control" type="text" name="state" id="state" value={{ old("state") ?? '' }}>
                    </div>        
                </div>

                <div class="row custom-form-group d-flex align-items-center">
                    <div class="col-12 col-md-auto text-md-right">
                        <label>País (Country):</label>
                    </div>
                    <div class="col-12 col-md">
                        <input class="custom-form-control" type="text" name="country" id="country" value={{ old("country") ?? '' }}>
                    </div>        
                </div>


                <div class="row custom-form-group justify-content-center mt-5">
                    <button id="btn-submit" type="submit" class="btn btn-outline-dark">
                        Enviar Inscrição
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('javascripts_bottom')
@parent
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
<script src="https://rawgithub.com/RobinHerbots/jquery.inputmask/5.x/dist/jquery.inputmask.js"></script>
<script src="{{ asset('js/jquery-captcha.min.js').'?version=1' }}"></script>

<script>
$(document).ready(function() {
    $.validator.addMethod("rg", function(value, element) {
        return this.optional(element) || /^[0-9]{2}\.[0-9]{3}\.[0-9]{3}-[0-9A-Za-z]{1}$/.test(value);
    }, "Por favor, digite um RG válido");
    $('#rg').inputmask("99.999.999-*", {
        definitions: {
        '*': {
            validator: "[0-9A-Za-z]",
            casing: "upper"
        }
        }
    });
  $('#inscricaoForm').validate({
    rules: {
      fullName: {
        required: true
      },
      nickname: {
        required: true
      },
      email: {
        required: true,
        email: true
      },
      passport: {
        required: {
            depends: function(){
                return $("#rg").val().length == 0
            }
        }
      },
      rg: {
        required: {
            depends: function(){
                return $("#passport").val().length == 0
            }
        },
        rg: true
      },
      phone: {
        required: true
      },
      affiliation: {
        required: true
      },
      position: {
        required: true
      },
      department: {
        required: true
      },
      cep: {
        required: true
      },
      address: {
        required: true
      },
      city: {
        required: true
      },
      state: {
        required: true
      },
      country: {
        required: true
      }
    },
    messages: {
      fullName: {
        required: "Por favor, informe o nome completo"
      },
      nickname: {
        required: "Por favor, informe o apelido"
      },
      email: {
        required: "Por favor, informe o e-mail",
        email: "Por favor, informe um e-mail válido"
      },
      passport: {
        required: "Por favor, informe o passaporte"
      },
      rg: {
        required: "Por favor, digite seu RG",
        rg: "Por favor, digite um RG válido"
      },
      phone: {
        required: "Por favor, digite seu número de celular",
      },
      affiliation: {
        required: "Por favor, informe a instituição"
      },
      position: {
        required: "Por favor, informe o vínculo"
      },
      department: {
        required: "Por favor, informe o departamento"
      },
      cep: {
        required: "Por favor, informe o CEP"
      },
      address: {
        required: "Por favor, informe o endereço"
      },
      city: {
        required: "Por favor, informe a cidade"
      },
      state: {
        required: "Por favor, informe o estado"
      },
      country: {
        required: "Por favor, informe o país"
      }
    },
    errorPlacement: function(error, element) {
        element.attr("data-toggle", "tooltip");
        element.attr("data-placement", "top");
        element.attr("title", error.text());
        $(element).tooltip("show");   
    },
    success: function(label,element){
        element.removeAttribute("data-toggle");
        element.removeAttribute("data-placement");
        element.removeAttribute("title");     
        element.removeAttribute("data-original-title");   
        $(element).tooltip("hide");   
    },
    submitHandler: function(form) {
        $("#btn-submit").attr('disabled', true);
        form.submit();
    }
  });
});

</script>
@endsection