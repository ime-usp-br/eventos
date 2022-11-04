<div class="row custom-form-group">
    <div class="row col-lg lg-pb-3">
        <div class="col-lg-auto pr-0">
            <label>{!! $defesa->nivel == "Mestrado" ? "Mestrando" : "Doutorando" !!}:</label>
        </div>
        <div class="col-lg-auto">
        {{$defesa->aluno->nome}}
        </div>
    </div>
    <div class="row col-lg lg-pb-3">
        <div class="col-lg-auto pr-0">
            <label>Programa:</label>
        </div>
        <div class="col-lg-auto">
        {{$defesa->programa}}
        </div>
    </div>
    <div class="row col-lg">
        <div class="col-lg-auto pr-0">
            <label>Nível:</label>
        </div>
        <div class="col-lg-auto">
        {!! $defesa->nivel !!}
        </div>
    </div>
</div>

<div class="row custom-form-group">
    <div class="row col-lg {{ $defesa->aluno->orientadores()->where('tipo', 'Coorientador')->exists() ? 'lg-pb-3' : '' }}">
        <div class="col-lg-auto pr-0">
            <label>Orientador{!! count($defesa->aluno->orientadores()->where("tipo", "Orientador")->get()) > 1 ? "es" : "" !!}:</label>
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
            <label>Coorientador{!! count($defesa->aluno->orientadores()->where("tipo", "Coorientador")->get()) > 1 ? "es" : "" !!}:</label>
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
        <div class="col-lg-auto pr-0 mt-1">
            <label for="local">Local*:</label>
            <a  class="text-dark text-decoration-none"
                data-toggle="modal"
                data-target="#locationCreateModal"
                title="Cadastrar Novo Local"  style="cursor: pointer;"
            >
                <i class="fas fa-plus-circle"></i>
            </a>
        </div>
        <div class="col-lg">
            <select class="custom-form-control" name="local" id="local">
                <option value=""></option>
                @foreach(App\Models\Location::all() as $local)
                    <option value="{{ $local->nome }}" {{ $local->nome==old('local') ? "selected" : ($local->id==$defesa->localID  ? "selected" : "" ) }}>{{ $local->nome }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row col-lg">
        <div class="col-lg-auto pr-0 mt-1">
            <label for="link">Link*:</label>
        </div>
        <div class="col-lg">
            <input class="custom-form-control" type="text" name="link" id="link"
                value="{{ old('link') ?? $defesa->link ?? ''}}"
            />
        </div>
    </div>
</div>

<div class="row custom-form-group">
    <div class="row col-lg lg-pb-3">
        <div class="col-lg-auto pr-0 mt-1">
            <label for="data">Data*:</label>
        </div>
        <div class="col-lg-auto">
            <input class="custom-form-control custom-datepicker"
                type="text" name="data" id="data" autocomplete="off"
                value="{{ old('data') ?? $defesa->data ?? ''}}" style="max-width:150px;"
            />
        </div>
    </div>
    <div class="row col-lg">
        <div class="col-lg-auto pr-0 mt-1">
            <label for="horario">Horário*:</label>
        </div>
        <div class="col-lg-auto">
            <input class="custom-form-control custom-timepicker"
                name="horario" id="horario" autocomplete="off" style="max-width:100px;"
                value="{{ old('horario') ?? $defesa->horario ?? ''}}"
            />
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
                        <div class="row">
                            <div class="pl-3" id="{{ 'membro-'.$membro->id }}">
                                {!! $membro->nome.( $membro->staptp ? " (P)" : "" ) !!}
                            </div>
                            <div id="{{ 'membro-'.$membro->id.'-instituicao' }}">
                                @if($membro->instituicao)
                                    <input id="{{ 'instituicoes['.$membro->id.'][nome]' }}" name="{{ 'instituicoes['.$membro->id.'][nome]' }}" type="hidden" value="{{ $membro->instituicao->nome }}">
                                    <input id="{{ 'instituicoes['.$membro->id.'][sigla]' }}" name="{{ 'instituicoes['.$membro->id.'][sigla]' }}" type="hidden" value="{{ $membro->instituicao->sigla }}">
                                    <label id="label-institution-'+member_id+'" class="pl-2 font-weight-normal">{{ $membro->instituicao->sigla }}</label>
                                    <a class="btn btn-link btn-sm text-dark text-decoration-none"
                                        id="btn-remove-institution-'+member_id+'" style="position:relative;top:-3px;"
                                        onclick="{{ 'removeInstitution(\''.$membro->id.'\')' }}"
                                    >
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                @else
                                    <a class="btn btn-link btn-sm text-dark text-decoration-none" id="btn-addInstitution" 
                                        data-toggle="modal" data-target="#addInstitutionModal" data-id="{{$membro->id}}" style="position:relative;top:-3px;"
                                        title="Adicionar Instituição">
                                        <i class="fas fa-plus-circle"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="row col-lg lg-pb-3">
                <div class="col-lg-auto pr-0">
                    <label>Titulares:</label>
                </div>
                <div class="col-lg-auto">
                    @foreach($defesa->banca->membros()->where("vinculo", "Titular")->get() as $membro)
                        <div class="row">
                            <div class="pl-3" id="{{ 'membro-'.$membro->id }}">
                                {!! $membro->nome.( $membro->staptp ? " (P)" : "" ) !!}
                            </div>
                            <div id="{{ 'membro-'.$membro->id.'-instituicao' }}">
                                @if($membro->instituicao)
                                    <input id="{{ 'instituicoes['.$membro->id.'][nome]' }}" name="{{ 'instituicoes['.$membro->id.'][nome]' }}" type="hidden" value="{{ $membro->instituicao->nome }}">
                                    <input id="{{ 'instituicoes['.$membro->id.'][sigla]' }}" name="{{ 'instituicoes['.$membro->id.'][sigla]' }}" type="hidden" value="{{ $membro->instituicao->sigla }}">
                                    <label id="label-institution-'+member_id+'" class="pl-2 font-weight-normal">{{ $membro->instituicao->sigla }}</label>
                                    <a class="btn btn-link btn-sm text-dark text-decoration-none"
                                        id="btn-remove-institution-'+member_id+'" style="position:relative;top:-3px;"
                                        onclick="{{ 'removeInstitution(\''.$membro->id.'\')' }}"
                                    >
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                @else
                                    <a class="btn btn-link btn-sm text-dark text-decoration-none" id="btn-addInstitution" 
                                        data-toggle="modal" data-target="#addInstitutionModal" data-id="{{$membro->id}}" style="position:relative;top:-3px;"
                                        title="Adicionar Instituição">
                                        <i class="fas fa-plus-circle"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="row col-lg {{ $defesa->banca->membros()->where('vinculo', 'Substituto')->exists() ? 'lg-pb-3' : '' }}">
                <div class="col-lg-auto pr-0">
                    <label>Suplentes:</label>
                </div>
                <div class="col-lg-auto">
                    @foreach($defesa->banca->membros()->where("vinculo", "Suplente")->get() as $membro)
                        <div class="row">
                            <div class="pl-3" id="{{ 'membro-'.$membro->id }}">
                                {!! $membro->nome.( $membro->staptp ? " (P)" : "" ) !!}
                            </div>
                            <div id="{{ 'membro-'.$membro->id.'-instituicao' }}">
                                @if($membro->instituicao)
                                    <input id="{{ 'instituicoes['.$membro->id.'][nome]' }}" name="{{ 'instituicoes['.$membro->id.'][nome]' }}" type="hidden" value="{{ $membro->instituicao->nome }}">
                                    <input id="{{ 'instituicoes['.$membro->id.'][sigla]' }}" name="{{ 'instituicoes['.$membro->id.'][sigla]' }}" type="hidden" value="{{ $membro->instituicao->sigla }}">
                                    <label id="label-institution-'+member_id+'" class="pl-2 font-weight-normal">{{ $membro->instituicao->sigla }}</label>
                                    <a class="btn btn-link btn-sm text-dark text-decoration-none"
                                        id="btn-remove-institution-'+member_id+'" style="position:relative;top:-3px;"
                                        onclick="{{ 'removeInstitution(\''.$membro->id.'\')' }}"
                                    >
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                @else
                                    <a class="btn btn-link btn-sm text-dark text-decoration-none" id="btn-addInstitution" 
                                        data-toggle="modal" data-target="#addInstitutionModal" data-id="{{$membro->id}}" style="position:relative;top:-3px;"
                                        title="Adicionar Instituição">
                                        <i class="fas fa-plus-circle"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
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
                        <div class="row">
                            <div class="pl-3" id="{{ 'membro-'.$membro->id }}">
                                {!! $membro->nome.( $membro->staptp ? " (P)" : "" ) !!}
                            </div>
                            <div id="{{ 'membro-'.$membro->id.'-instituicao' }}">
                                @if($membro->instituicao)
                                    <input id="{{ 'instituicoes['.$membro->id.'][nome]' }}" name="{{ 'instituicoes['.$membro->id.'][nome]' }}" type="hidden" value="{{ $membro->instituicao->nome }}">
                                    <input id="{{ 'instituicoes['.$membro->id.'][sigla]' }}" name="{{ 'instituicoes['.$membro->id.'][sigla]' }}" type="hidden" value="{{ $membro->instituicao->sigla }}">
                                    <label id="label-institution-'+member_id+'" class="pl-2 font-weight-normal">{{ $membro->instituicao->sigla }}</label>
                                    <a class="btn btn-link btn-sm text-dark text-decoration-none"
                                        id="btn-remove-institution-'+member_id+'" style="position:relative;top:-3px;"
                                        onclick="{{ 'removeInstitution(\''.$membro->id.'\')' }}"
                                    >
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                @else
                                    <a class="btn btn-link btn-sm text-dark text-decoration-none" id="btn-addInstitution" 
                                        data-toggle="modal" data-target="#addInstitutionModal" data-id="{{$membro->id}}" style="position:relative;top:-3px;"
                                        title="Adicionar Instituição">
                                        <i class="fas fa-plus-circle"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
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
            <label>Título:</label> {!! $defesa->trabalho ? $defesa->trabalho->titulo : ( $defesa->nivel == "Mestrado" ? "Dissertação " : "Tese " ) . "não encontrada." !!}
        </div>

        <div class="custom-form-group">
            <label>Resumo:</label> {!! $defesa->trabalho ? $defesa->trabalho->resumo : ( $defesa->nivel == "Mestrado" ? "Dissertação " : "Tese " ) . "não encontrada." !!}
        </div>

        <div class="custom-form-group">
            <label>Palavras-chave:</label> {!! $defesa->trabalho ? $defesa->trabalho->palavrasChave : ( $defesa->nivel == "Mestrado" ? "Dissertação " : "Tese " ) . "não encontrada." !!}
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
            href="{{ route('defenses.index') }}"
        >
            Cancelar
        </a>
    </div>
</div>