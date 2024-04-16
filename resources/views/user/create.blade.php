@extends('assets.page')

@section('content')
    <div class="container">
        <h4 class="display-4 pt-4">Cadastrar novo usuário</h4>
        <hr>
        <form id="form-new-user" action="" method="post">
            @csrf
            <div class="card">
                <div class="card-header form-card-header">
                    <i class="fa-solid fa-user"></i> Informações básicas
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-5">
                            <label for="nome"><span class="red">*</span> Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="cpf"><span class="red">*</span> CPF</label>
                            <input type="text" class="form-control" id="cpf" name="cpf">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="municipio"><span class="red">*</span> Município</label>
                            <select name="municipio" class="form-select" id="municipio">
                                <option value="">Selecione a opção desejada...</option>
                                @foreach ($municipios as $municipio)
                                    <option value="{{ $municipio->id }}">{{ $municipio->nome }}</option>
                                @endforeach
                            </select>
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
                            <input autocomplete="off" type="email" class="form-control" id="email" name="email">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="password"><span class="red">*</span> Senha</label>
                            <input autocomplete="off" type="password" class="form-control" id="password" name="password">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="confirmPassword"><span class="red">*</span> Confirmar senha</label>
                            <input autocomplete="off" type="password" class="form-control" id="confirmPassword"
                                name="confirmPassword">
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end mt-3">
                {{-- <a class="btn btn-secondary">Voltar</a> --}}
                <button class="btn btn-primary">Salvar</button>
            </div>
        </form>
    </div>
@endsection
