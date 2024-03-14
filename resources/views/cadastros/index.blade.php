@extends('assets.page')

@section('content')
    <div class="container container-table">
        <div class="row justify-content-between mb-2">
            <div class="col-2">
                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#cadastrarBeneficiaria">Cadastrar
                    beneficiária</button>
            </div>
            <div class="col-4">
                <div class="input-group">
                    <div class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></div>
                    <input type="text" class="form-control" id="autoSizingInputGroup" placeholder="Pesquisar...">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive card">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Nome da Solicitante</th>
                                <th scope="col">CPF</th>
                                <th scope="col">NIS</th>
                                <th scope="col">Pontuação</th>
                                <th width="14%" scope="col">Data da Solicitação</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($beneficiarias as $beneficiaria)
                                <tr>
                                    <td>{{ $beneficiaria->nome }}</td>
                                    <td>{{ $beneficiaria->cpf }}</td>
                                    <td>{{ $beneficiaria->nis }}</td>
                                    <td>{{ $beneficiaria->pontuacao }}</td>
                                    <td>{{ date('d/m/Y H:i', strtotime($beneficiaria->created_at)) }}</td>
                                    <td>{{ $beneficiaria->statusCodes->name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="cadastrarBeneficiaria" tabindex="-1" aria-labelledby="cadastrarBeneficiariaLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="cadastrarBeneficiariaLabel">Buscar beneficiária</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="search-new" action="#">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-froup">
                                    <select class="form-select" name="tipo" id="tipo-search-new">
                                        <option value="cpf">CPF</option>
                                        <option value="nis">NIS</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="search-value-new">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-warning">Buscar beneficiária</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="sucessoModal" tabindex="-1" aria-labelledby="sucessoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="sucessoModalLabel">Buscar beneficiária</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="approve-new" method="POST" action="/restrito/cadastros/dados-new">
                    @csrf
                    <div class="modal-body">
                        <p class="lead text-center">Beneficiária encontrada e Elegível</p>
                        <p class="lead text-center" id="nome-beneficiaria"></p>
                        <p class="lead text-center">Você confirma a beneficiária?</p>
                    </div>
                    <textarea name="jsonMulher" id="json-mulher" hidden></textarea>
                    <div class="modal-footer">
                        <button type="button" data-bs-dismiss="modal" class="btn btn-danger">Não Confirmar</button>
                        <button type="submit" class="btn btn-success">Confirmar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="erroModal" tabindex="-1" aria-labelledby="erroModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h1 style="color: #fff" class="modal-title fs-5" id="erroModalLabel">Atenção!</h1>
                </div>
                <div class="modal-body">
                    <p id="error-text" class="lead text-center"></p>
                </div>
                <div class="modal-footer">
                    <button data-bs-dismiss="modal" class="btn btn-primary">Ok</button>
                </div>
            </div>
        </div>
    </div>
@endsection
