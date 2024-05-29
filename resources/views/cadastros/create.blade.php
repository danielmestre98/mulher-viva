@extends('assets.page')

@section('content')
    <div class="container">
        <h4 class="display-4 pt-4">Informações da beneficiária</h4>
        <hr>
        <form action="{{ route('restrito.benefiaria.store') }}" id="submit-benef" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="card">
                <div class="card-header form-card-header">
                    <i class="fa-solid fa-user"></i> Informações básicas
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="nome">Nome</label>
                                <input readonly type="text" class="form-control" id="nome" name="nome"
                                    value="{{ $dados['nome'] }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nis">NIS</label>
                                <input readonly type="text" class="form-control" id="nis" name="nis"
                                    value="{{ $dados['nis'] }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="nascimento">Data de nascimento</label>
                                <input readonly type="text" class="form-control" id="nascimento" name="nascimento"
                                    value="{{ $dados['nascimento'] }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="cpf">CPF</label>
                                <input readonly type="text" class="form-control" id="cpf" name="cpf"
                                    value="{{ $dados['cpf'] }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="tipo_telefone"><span class="red">*</span> Tipo Telefone</label>
                            <select class="form-select" id="tipo_telefone" name="tipo_telefone">
                                <option value="">Selecione...</option>
                                <option @if ($dados['tipo_telefone'] == 'RES') selected @endif value="RES">Residencial
                                </option>
                                <option @if ($dados['tipo_telefone'] == 'COM') selected @endif value="COM">Comercial</option>
                                <option @if ($dados['tipo_telefone'] == 'CEL') selected @endif value="CEL">Celular</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="telefone"><span class="red">*</span> Telefone</label>
                            <input type="text" class="form-control" id="telefone" name="telefone"
                                value="{{ $dados['telefone'] }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header form-card-header">
                    <i class="fa-solid fa-dollar-sign"></i> Dados bancários
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="row">
                            <div class="col-md-2">
                                <label for="banco"><span class="red">*</span> Banco</label>
                                <select name="banco" id="banco" class="form-select">
                                    <option value="">Selecione...</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="tipo_conta"><span class="red">*</span> Tipo conta</label>
                                <select class="form-select" name="tipo_conta" id="tipo_conta">
                                    <option value="">Selecione...</option>
                                    <option value="Conta Corrente">Conta Corrente</option>
                                    <option value="Poupança">Poupança</option>
                                    <option value="Conta Salário">Conta Salário</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="agencia"><span class="red">*</span> Agência</label>
                                <input type="text" class="form-control" id="agencia" name="agencia">
                            </div>
                            <div class="col-md-2">
                                <label for="conta"><span class="red">*</span> Conta</label>
                                <input type="text" class="form-control" id="conta" name="conta">
                            </div>
                            <div class="col-md-3">
                                <div class="form-check" style="margin-top: 30px">
                                    <input class="form-check-input" type="checkbox" value="1" name="pix"
                                        id="pix">
                                    <label class="form-check-label" for="pix">
                                        Possuí chave pix? (CPF)
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header form-card-header">
                    <i class="fa-solid fa-question fa-lg"></i> Questionário
                </div>
                <div class="card-body">
                    <h5 class=" mb-1"><span class="red">*</span>1 - EXISTE PRESENÇA NO NÚCLEO FAMILIAR DE CRIANÇA OU
                        ADOLESCENTE
                        EM SITUAÇÃO DE
                        ABRIGAMENTO?
                    </h5>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input questions" type="radio" name="criancaAbrig"
                                id="criancaAbrigSim" value="true">
                            <label class="form-check-label lead" for="criancaAbrigSim">Sim</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input questions" type="radio" name="criancaAbrig"
                                id="criancaAbrigNão" value="false">
                            <label class="form-check-label lead" for="criancaAbrigNão">Não</label>
                        </div>
                    </div>

                    <h5 class="mt-2 mb-1"><span class="red">*</span>2 - EXISTE PRESENÇA NO NÚCLEO FAMILIAR DE
                        ADOLESCENTE
                        EM
                        SITUAÇÃO DE CUMPRIMENTO DE
                        MEDIDA SÓCIO EDUCATIVA NA MODALIDADE INTERNAÇÃO?
                    </h5>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input questions" type="radio" name="adolecMedidaSocio"
                                id="adolecMedidaSocioSim" value="true">
                            <label class="form-check-label lead" for="adolecMedidaSocioSim">Sim</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input questions" type="radio" name="adolecMedidaSocio"
                                id="adolecMedidaSocioNão" value="false">
                            <label class="form-check-label lead" for="adolecMedidaSocioNão">Não</label>
                        </div>
                    </div>


                    <h5 class="mt-2 mb-1"><span class="red">*</span>3 - MULHER BENEFICIÁRIA QUE ESTÁ EM CONDIÇÕES DE
                        INICIAR
                        O
                        PROCESSO DE DESACOLHIMENTO
                        DE SERVIÇO DE ACOLHIMENTO INSTITUCIONAL
                        PARA MULHERES EM SITUAÇÃO DE VIOLÊNCIA?
                    </h5>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input questions" type="radio" name="mulherCondDesacolh"
                                id="mulherCondDesacolhSim" value="true">
                            <label class="form-check-label lead" for="mulherCondDesacolhSim">Sim</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input questions" type="radio" name="mulherCondDesacolh"
                                id="mulherCondDesacolhNão" value="false">
                            <label class="form-check-label lead" for="mulherCondDesacolhNão">Não</label>
                        </div>
                    </div>

                    <h5 class="mt-2 mb-1"><span class="red">*</span>4 - FAMÍLIA BENEFICIÁRIA DE PROGRAMAS DE
                        TRANSFERÊNCIA
                        DE RENDA?
                    </h5>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input questions" type="radio" name="familiaTransfRenda"
                                id="familiaTransfRendaSim" value="true">
                            <label class="form-check-label lead" for="familiaTransfRendaSim">Sim</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input questions" type="radio" name="familiaTransfRenda"
                                id="familiaTransfRendaNão" value="false">
                            <label class="form-check-label lead" for="familiaTransfRendaNão">Não</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header form-card-header">
                    <i class="fa-solid fa-paperclip"></i> Anexos
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="anexoMedidaProt"><span class="red">*</span> Anexar a medida protetetiva</label>
                            <input type="file" class="form-control" accept=".pdf" id="anexoMedidaProt"
                                name="anexoMedidaProt">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="anexoExamePsico"><span class="red">*</span> Anexar o exame psicosocial</label>
                            <input type="file" class="form-control" accept=".pdf" id="anexoExamePsico"
                                name="anexoExamePsico">
                        </div>
                    </div>
                </div>
            </div>
            <textarea hidden name="jsonDados" id="jsonDados" cols="30" rows="10">{{ json_encode($dados) }}</textarea>
            <div class="form-buttons mt-2 d-flex justify-content-end">
                <button type="submit" class="btn btn-success btn-lg mb-3">Cadastrar beneficiária</button>
            </div>
        </form>
    </div>
@endsection
