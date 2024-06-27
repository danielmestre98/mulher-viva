@extends('assets.page')

@section('content')
    <div class="container">
        <h4 class="display-4 pt-4">Alterar usuário</h4>
        <hr>
        <form id="form-edit-user" action="" method="put">
            @csrf
            <div class="card">
                <div class="card-header form-card-header">
                    <i class="fa-solid fa-user"></i> Informações básicas
                </div>
                <div class="card-body">
                    <input id="userIdEdit" type="text" hidden value="{{ $user->id }}">
                    <div class="row">
                        <div class="form-group col-md-5">
                            <label for="nome"><span class="red">*</span> Nome</label>
                            <input type="text" class="form-control" id="nome" disabled value="{{ $user->name }}"
                                name="nome">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="cpf"><span class="red">*</span> CPF</label>
                            <input type="text" disabled value="{{ $user->cpf }}" class="form-control" id="cpf"
                                name="cpf">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="municipio"><span class="red">*</span> Município</label>
                            <input disabled value="{{ $user->municipios->nome }}" type="text" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-4">
                <div class="card-header form-card-header">
                    <i class="fa-solid fa-key"></i> Informações de autenticação
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="email"><span class="red">*</span> E-mail</label>
                            <input disabled value="{{ $user->email }}" autocomplete="off" type="email"
                                class="form-control" id="email" name="email">
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between mt-3">
                <a href="{{ route('restrito.usuarios') }}" class="btn btn-secondary">Voltar</a>
                <button class="btn btn-warning">Resetar senha</button>
            </div>
        </form>
    </div>
@endsection
