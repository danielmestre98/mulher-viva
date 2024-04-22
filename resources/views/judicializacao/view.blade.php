@extends('assets.page')

@section('content')
    <div class="container">
        <h4 class="display-4 pt-4">Judicializações (Visualizar beneficiária)</h4>
        <hr>
        <div class="card">
            <div class="card-header form-card-header">
                <i class="fa-solid fa-user"></i> Informações básicas
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nome">Nome</label>
                            <input readonly type="text" value="{{ $beneficiaria->nome }}" class="form-control"
                                id="nome" name="nome">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="cpf">CPF</label>
                            <input readonly type="text" class="form-control"
                                value="{{ substr($beneficiaria->cpf, 0, 3) . '.' . substr($beneficiaria->cpf, 3, 3) . '.' . substr($beneficiaria->cpf, 6, 3) . '-' . substr($beneficiaria->cpf, 9, 2) }}"
                                id="cpf" name="cpf">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="rg">RG</label>
                            <input readonly type="text"
                                value="{{ substr($beneficiaria->rg, 0, 2) . '.' . substr($beneficiaria->rg, 2, 3) . '.' . substr($beneficiaria->rg, 5, 3) . '-' . substr($beneficiaria->rg, 8, 2) }}"
                                class="form-control" id="rg" name="rg">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="municipio"> Município</label>
                        <input name="municipio" class="form-control" readonly value="{{ $beneficiaria->municipios->nome }}"
                            id="municipio" />

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
                            <input readonly type="text" value="{{ $beneficiaria->numero_processo }}" class="form-control"
                                id="numero_processo" name="numero_processo">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="data_processo">Data do processo</label>
                            <input readonly value="{{ $beneficiaria->data_processo }}" type="date" class="form-control"
                                id="data_processo" name="data_processo">
                        </div>
                    </div>
                </div>
            </div>

            <div style="width: 49%" class="card mt-3">
                <div class="card-header form-card-header">
                    <i class="fa-solid fa-paperclip"></i> Anexos
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2 mt-2">
                        <a class="btn btn-info btn-lg" target="_blank"
                            href="{{ route('restrito.judicializacoes.view.pdf', $beneficiaria->id) }}"><i
                                class="fa-solid fa-download"></i> Ordem Judicial</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-buttons mt-2 d-flex justify-content-between">
            <a href="{{ route('restrito.judicializacoes') }}" class="btn btn-secondary">Voltar</a>
            {{-- <button class="btn btn-primary">Salvar</button> --}}
        </div>
    </div>
@endsection
