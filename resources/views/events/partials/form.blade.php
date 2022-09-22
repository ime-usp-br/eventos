<div class="custom-form-group">
        <label for="titulo">Título*:</label>
        <input class="custom-form-control" type="text" name="titulo" id="titulo"
            value="{{ old('titulo') ?? $evento->titulo ?? ''}}"
        />
</div>

<div class="row custom-form-group">
    <div class="col-lg lg-pb-3">
        <label for="dataInicial">Data Inicial*:</label>
        <div class="col-12 px-0" style="white-space: nowrap;">
            <input class="custom-form-control custom-datepicker"
                type="text" name="dataInicial" id="dataInicial" autocomplete="off"
                value="{{ old('dataInicial') ?? $evento->dataInicial ?? ''}}" style="max-width:200px;"
            />
        </div>
    </div>
    <div class="col-lg lg-pb-3">
        <label for="dataFinal" title="Vazio indica evento em dia único">Data Final:</label>
        <div class="col-12 px-0" style="white-space: nowrap;">
            <input class="custom-form-control custom-datepicker"
                type="text" name="dataFinal" id="dataFinal" autocomplete="off"
                value="{{ old('dataFinal') ?? $evento->dataFinal ?? ''}}" style="max-width:200px;"
            />
        </div>
    </div>
    <div class="col-lg lg-pb-3">
        <label for="horarioInicial">Horário Inicial*:</label>
        <div class="col-12 px-0">
            <input class="custom-form-control"
                type="time" name="horarioInicial" id="horarioInicial" autocomplete="off" style="max-width:100px;"
                value="{{ old('horarioInicial') ?? $evento->horarioInicial ?? ''}}"
            />
        </div>
    </div>
    <div class="col-lg">
        <label for="horarioFinal">Horário Final:</label>
        <div class="col-12 px-0">
            <input class="custom-form-control"
                type="time" name="horarioFinal" id="horarioFinal" autocomplete="off" style="max-width:100px;"
                value="{{ old('horarioFinal') ?? $evento->horarioFinal ?? ''}}"
            />
        </div>
    </div>
</div>

<div class="row custom-form-group">
    <div class="col-lg lg-pb-3">
        <label for="localID">Local*:</label>
        <a  class="text-dark text-decoration-none"
            data-toggle="modal"
            data-target="#locationCreateModal"
            title="Cadastrar Novo Local"  style="cursor: pointer;"
        >
            <i class="fas fa-plus-circle"></i>
        </a>
        <div class="col-12 px-0">
            <select class="custom-form-control pr-5" name="localID">
                <option value=""></option>
                @foreach(App\Models\Location::all() as $local)
                    <option value="{{ $local->id }}" {{ $local->id==old('localID') ? "selected" : ($local->id==$evento->localID  ? "selected" : "" ) }}>{{ $local->nome }}</option>
                @endforeach
            </select>
        </div>
        <?php Session::forget('_old_input.localID') ?>
    </div>
    <div class="col-lg">
        <label for="url">URL*:</label>
        <input class="custom-form-control" type="text" name="url" id="url"
            value="{{ old('url') ?? $evento->url ?? ''}}"
        />
    </div>
</div>

<div class="row custom-form-group">
    <div class="col-lg lg-pb-3">
        <label for="exigeInscricao">Exige Inscrição:</label>
        <input class="checkbox" type="checkbox" name="exigeInscricao"
        value="1" {{ old('exigeInscricao') ? 'checked' : ($evento->exigeInscricao ? 'checked' : '')  }}/>
    </div>
    <div class="col-lg lg-pb-3">
        <label for="gratuito">Gratuito:</label>
        <input class="checkbox" type="checkbox" name="gratuito"
        value="1" {{ old('gratuito') ? 'checked' : ($evento->gratuito ? 'checked' : '')  }}/>
    </div>
    <div class="col-lg">
        <label for="emiteCertificado">Emite Certificado:</label>
        <input class="checkbox" type="checkbox" name="emiteCertificado"
        value="1" {{ old('emiteCertificado') ? 'checked' : ($evento->emiteCertificado ? 'checked' : '')  }}/>
    </div>
</div>

<div class="custom-form-group">
        <label for="nomeOrganizador">Nome do Organizador*:</label>
        <input class="custom-form-control" type="text" name="nomeOrganizador" id="nomeOrganizador"
            value="{{ old('nomeOrganizador') ?? $evento->nomeOrganizador ?? ''}}"
        />
</div>

<div class="row custom-form-group">
    <div class="col-lg lg-pb-3">
        <label for="idiomaID">Idioma*:</label>
        <div class="col-12 px-0">
            <select class="custom-form-control" name="idiomaID" style="max-width:170px;">
                @foreach(App\Models\Language::all() as $idioma)
                    <option value="{{ $idioma->id }}" {{ $idioma->id==old('idiomaID') ? "selected" : ($idioma->id==$evento->idiomaID  ? "selected" : ( $idioma->nome=="Português" ? "selected" : "" ) ) }}>{{ $idioma->nome }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-lg lg-pb-3">
        <label for="modalidadeID">Modalidade*:</label>
        <div class="col-12 px-0">
            <select class="custom-form-control" name="modalidadeID" style="max-width:170px;">
                <option value=""></option>
                @foreach(App\Models\Modality::all() as $modalidade)
                    <option value="{{ $modalidade->id }}" {{ $modalidade->id==old('modalidadeID') ? "selected" : ($modalidade->id==$evento->modalidadeID  ? "selected" : "") }}>{{ $modalidade->nome }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-lg">
        <label for="tipoID">Tipo*:</label>
        <a  class="text-dark text-decoration-none"
            data-toggle="modal"
            data-target="#kindCreateModal"
            title="Cadastrar Novo Tipo"  style="cursor: pointer;"
        >
            <i class="fas fa-plus-circle"></i>
        </a>
        <div class="col-12 px-0">
            <select class="custom-form-control" name="tipoID" style="max-width:170px;">
                <option value=""></option>
                @foreach(App\Models\Kind::all() as $tipo)
                    <option value="{{ $tipo->id }}" {{ $tipo->id==old('tipoID') ? "selected" : ($tipo->id==$evento->tipoID  ? "selected" : "") }}>{{ $tipo->nome }}</option>
                @endforeach
            </select>
        </div>
        <?php Session::forget('_old_input.tipoID') ?>
    </div>
</div>

<div class="custom-form-group">
        <label for="descricao">Descrição*:</label>
        <textarea class="custom-form-control" type="text" name="descricao" id="descricaoEvento">{{ old('descricao') ?? $evento->descricao ?? ''}}</textarea>
</div>

<div class="custom-form-group">
    <label for="descricao">Anexos:</label>

    <input name="anexosIDs[]" type="hidden">
    @foreach($evento->anexos as $anexo)
        <div class="col-12" id="{{ 'anexo-'.$anexo->id }}">
            <a href="{{ route('attachments.download', $anexo) }}">{{ $anexo->nome }}</a>
            <input name="anexosIDs[]" value="{{ $anexo->id }}" type="hidden">
            <a class="btn btn-link btn-sm text-dark text-decoration-none"
              style="padding-left:0px"
              id="btn-remove-anexo-'+id+'"
              onclick="removeAnexo({{$anexo->id}})"
            >
                <i class="fas fa-trash-alt"></i>
            </a>
        </div>
    @endforeach

    <div class="col-lg px-0">
        <div id="novos-anexos"></div>
            <label class="font-weight-normal">Adicionar anexo</label> 
            <input id="count-new-attachment" value=0 type="hidden" disabled>
            <a class="btn btn-link btn-sm text-dark text-decoration-none" id="btn-addAttachment" 
                title="Adicionar novo anexo">
                <i class="fas fa-plus-circle"></i>
            </a>

            <script>
                function removeAnexo(id){
                    document.getElementById("anexo-"+id).remove();
                }
            </script>
        </div>
    </div>
</div>
        

<div class="row custom-form-group justify-content-center">
    <div class="col-sm-6 text-center text-sm-right my-1">
        <button type="submit" class="btn btn-outline-dark">
            {{ $buttonText }}
        </button>
    </div>
    <div class="col-sm-6 text-center text-sm-left my-1">
        <a class="btn btn-outline-dark"
            href="{{ route('events.index') }}"
        >
            Cancelar
        </a>
    </div>
</div>