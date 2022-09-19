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