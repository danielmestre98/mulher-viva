@extends('assets.page')

@section('content')
    <div class="container">
        <h4 class="display-4 pt-4">Judicializações (Cadastrar beneficiária)</h4>
        <hr>
        <form action="{{ route('restrito.judicializacoes.store') }}" enctype="multipart/form-data" method="POST"
            id="form-judicializacao">
            @csrf
            <div class="card">
                <div class="card-header form-card-header">
                    <i class="fa-solid fa-user"></i> Informações básicas
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nome">Nome</label>
                                <input type="text" class="form-control" id="nome" name="nome">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="cpf">CPF</label>
                                <input type="text" class="form-control" id="cpf" name="cpf">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="rg">RG</label>
                                <input type="text" class="form-control" id="rg" name="rg">
                            </div>
                        </div>
                    </div>
                    <div class="row">
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
            <div class="d-flex justify-content-between">
                <div style="width: 49%" class="card mt-3 ">
                    <div class="card-header form-card-header">
                        <i class="fa-solid fa-gavel"></i> Informações do processo
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="numero_processo">Número do processo</label>
                                <input type="text" class="form-control" id="numero_processo" name="numero_processo">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="data_processo">Data do processo</label>
                                <input type="date" class="form-control" id="data_processo" name="data_processo">
                            </div>
                        </div>
                    </div>
                </div>

                <div style="width: 49%" class="card mt-3">
                    <div class="card-header form-card-header">
                        <i class="fa-solid fa-paperclip"></i> Anexos
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="anexoDespacho"><span class="red">*</span> Anexar despacho final</label>
                                <input type="file" class="form-control" accept=".pdf" id="anexoDespacho"
                                    name="anexoDespacho">
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="form-buttons mt-2 d-flex justify-content-between">
                <a href="{{ route('restrito.judicializacoes') }}" class="btn btn-secondary">Voltar</a>
                <button class="btn btn-primary">Salvar</button>
            </div>
        </form>
    </div>
@endsection
