<div class="row custom-form-group justify-content-center">
    <div class="col-12 col-md-6 text-md-right">
        <label for="nome">Nome *</label>
    </div>
    <div class="col-12 col-md-6">
        <input class="custom-form-control" type="text" name="name" id="name" style="max-width:400px;"
            value='{{ $user->name ?? ""}}'
        />
    </div>
</div>

@error('name')
    <div class="row mb-2">
        <div class="col-4 d-none d-lg-block"></div>
        <div class="col-12 col-md-5">
            <div class="alert alert-danger rounded-0">
                * Campo obrigatório.
            </div>
        </div>
    </div>
@enderror

<div class="row custom-form-group justify-content-center">
    <div class="col-12 col-md-6 text-md-right">
        <label for="email">E-mail *</label>
    </div>
    <div class="col-12 col-md-6">
        <input class="custom-form-control" type="text" name="email" style="max-width:400px;"
            id="email" value='{{ $user->email ?? ""}}'
        />
    </div>
</div>


@error('email')
    <div class="row mb-2">
        <div class="col-4 d-none d-lg-block"></div>
        <div class="col-12 col-md-5">
            <div class="alert alert-danger rounded-0">
                * Campo obrigatório.
            </div>
        </div>
    </div>
@enderror

<div class="row custom-form-group justify-content-center">
    <div class="col-12 col-md-6 text-md-right">
        <label for="role">Perfis *</label>
    </div>
    <div class="col-12 col-md-6">
        @foreach ($roles as $role)
            <div>
                <input class="checkbox" type="checkbox" name="roles[]" id="check-box-{{$role->id}}" 
                value="{{ $role->name }}" {{ $user->roles->contains("name", $role->name) ? "checked" : "" }} />
                <label for="check-box-{{$role->id}}">{{$role->name}}</label>
            </div>
        @endforeach 
    </div>
</div>


@error('roles')
    <div class="row mb-2">
        <div class="col-4 d-none d-lg-block"></div>
        <div class="col-12 col-md-5">
            <div class="alert alert-danger rounded-0">
                * Você deve escolher ao menos um perfil.
            </div>
        </div>
    </div>
@enderror


<div class="row custom-form-group justify-content-center">
    <div class="col-sm-6 text-center text-sm-right my-1">
        <button type="submit" class="btn btn-outline-dark">
            {{ $buttonText }}
        </button>
    </div>
    <div class="col-sm-6 text-center text-sm-left my-1">
        <a class="btn btn-outline-dark"
            href="{{ route('users.index') }}"
        >
            Cancelar
        </a>
    </div>
</div>