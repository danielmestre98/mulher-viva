@extends('assets.page')

@section('content')
    <div class="container">
        <h4 class="display-4 pt-4 d-flex justify-content-between">
            <p class="mb-0"> Informações da beneficiária</p>
            <button id="delete-benef" class="btn btn-danger btn-lg"><i class="fa-solid fa-trash-can fa-2x"></i></button>
        </h4>
        <hr>
        <form action="#" method="put" id="edit-benef">
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
                                    value="{{ $beneficiaria->nome }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nis">NIS</label>
                                <input readonly type="text" class="form-control" id="nis" name="nis"
                                    value="{{ $beneficiaria->nis }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="nascimento">Data de nascimento</label>
                                <input readonly type="text" class="form-control" id="nascimento" name="nascimento"
                                    value="{{ date('d/m/Y', strtotime($beneficiaria->nascimento)) }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="cpf">CPF</label>
                                <input readonly type="text" class="form-control" id="cpf" name="cpf"
                                    value="{{ substr($beneficiaria->cpf, 0, 3) . '.' . substr($beneficiaria->cpf, 3, 3) . '.' . substr($beneficiaria->cpf, 6, 3) . '-' . substr($beneficiaria->cpf, 9, 2) }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="tipo_telefone">Tipo Telefone</label>
                            <input readonly type="text" class="form-control" id="tipo_telefone" name="tipo_telefone"
                                value="@if ($beneficiaria->tipo_telefone == 'RES') Residencial @elseif($beneficiaria->tipo_telefone == 'CEL')Celular @elseif($beneficiaria->tipo_telefone == 'COM')Comercial @endif ">
                        </div>
                        <div class="col-md-4">
                            <label for="telefone">Telefone</label>
                            <input readonly type="text" class="form-control" id="telefone" name="telefone"
                                value="{{ $beneficiaria->telefone }}">
                        </div>
                    </div>
                </div>
            </div>
            @if ($beneficiaria->status != 4)
                <div class="card mt-3">
                    <div class="card-header form-card-header">
                        <i class="fa-solid fa-dollar-sign"></i> Dados bancários
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="banco"> Banco</label>
                                    <input readonly type="text" class="form-control" id="banco"
                                        value="{{ $beneficiaria->banco }}" name="banco">
                                </div>
                                <div class="col-md-2">
                                    <label for="tipo_conta"> Tipo conta</label>
                                    <input readonly type="text" value="{{ $beneficiaria->tipo_conta }}"
                                        class="form-control">
                                </div>
                                <div class="col-md-2">
                                    <label for="agencia"> Agência</label>
                                    <input readonly type="text" value="{{ $beneficiaria->agencia }}" class="form-control"
                                        id="agencia" name="agencia">
                                </div>
                                <div class="col-md-2">
                                    <label for="conta"> Conta</label>
                                    <input readonly type="text" value="{{ $beneficiaria->conta }}" class="form-control"
                                        id="conta" name="conta">
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check" style="margin-top: 30px">
                                        <input disabled @if ($beneficiaria->pix) checked @endif
                                            class="form-check-input" type="checkbox" value="1" name="pix"
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
                        <div>
                            <i class="fa-solid fa-question fa-lg"></i> Questionário
                        </div>

                    </div>
                    <div class="card-body">
                        <h5 class=" mb-1"><span class="red">*</span> 1 - EXISTE PRESENÇA NO NÚCLEO FAMILIAR DE CRIANÇA
                            OU
                            ADOLESCENTE
                            EM SITUAÇÃO DE
                            ABRIGAMENTO?
                        </h5>
                        <div>
                            <div class="form-check form-check-inline">
                                <input @if (array_search(1, $editPermissions) === false) disabled @endif
                                    @if ($beneficiaria->presenca_jovem_sit_abrigamento) checked @endif class="form-check-input questions"
                                    type="radio" name="presenca_jovem_sit_abrigamento" id="criancaAbrigSim"
                                    value="true">
                                <label class="form-check-label lead" for="criancaAbrigSim">Sim</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input @if (array_search(1, $editPermissions) === false) disabled @endif
                                    @if (!$beneficiaria->presenca_jovem_sit_abrigamento) checked @endif class="form-check-input questions"
                                    type="radio" name="presenca_jovem_sit_abrigamento" id="criancaAbrigNão"
                                    value="false">
                                <label class="form-check-label lead" for="criancaAbrigNão">Não</label>
                            </div>
                        </div>

                        <h5 class="mt-2 mb-1"><span class="red">*</span>2 - EXISTE PRESENÇA NO NÚCLEO FAMILIAR DE
                            ADOLESCENTE EM
                            SITUAÇÃO DE CUMPRIMENTO DE
                            MEDIDA SÓCIO EDUCATIVA NA MODALIDADE INTERNAÇÃO?
                        </h5>
                        <div>
                            <div class="form-check form-check-inline">
                                <input @if (array_search(2, $editPermissions) === false) disabled @endif
                                    @if ($beneficiaria->presenca_adolec_medida_socio_educativa) checked @endif class="form-check-input questions"
                                    type="radio" name="presenca_adolec_medida_socio_educativa"
                                    id="adolecMedidaSocioSim" value="true">
                                <label class="form-check-label lead" for="adolecMedidaSocioSim">Sim</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input @if (array_search(2, $editPermissions) === false) disabled @endif
                                    @if (!$beneficiaria->presenca_adolec_medida_socio_educativa) checked @endif class="form-check-input questions"
                                    type="radio" name="presenca_adolec_medida_socio_educativa"
                                    id="adolecMedidaSocioNão" value="false">
                                <label class="form-check-label lead" for="adolecMedidaSocioNão">Não</label>
                            </div>
                        </div>


                        <h5 class="mt-2 mb-1"><span class="red">*</span>3 - MULHER BENEFICIÁRIA QUE ESTÁ EM CONDIÇÕES
                            DE
                            INICIAR
                            O
                            PROCESSO DE DESACOLHIMENTO
                            DE SERVIÇO DE ACOLHIMENTO INSTITUCIONAL
                            PARA MULHERES EM SITUAÇÃO DE VIOLÊNCIA?
                        </h5>
                        <div>
                            <div class="form-check form-check-inline">
                                <input @if (array_search(3, $editPermissions) === false) disabled @endif
                                    @if ($beneficiaria->inic_serv_acolh_institucional) checked @endif class="form-check-input questions"
                                    type="radio" name="inic_serv_acolh_institucional" id="mulherCondDesacolhSim"
                                    value="true">
                                <label class="form-check-label lead" for="mulherCondDesacolhSim">Sim</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input @if (array_search(3, $editPermissions) === false) disabled @endif
                                    @if (!$beneficiaria->inic_serv_acolh_institucional) checked @endif class="form-check-input questions"
                                    type="radio" name="inic_serv_acolh_institucional" id="mulherCondDesacolhNão"
                                    value="false">
                                <label class="form-check-label lead" for="mulherCondDesacolhNão">Não</label>
                            </div>
                        </div>

                        <h5 class="mt-2 mb-1"><span class="red">*</span>4 - FAMÍLIA BENEFICIÁRIA DE PROGRAMAS DE
                            TRANSFERÊNCIA
                            DE RENDA?
                        </h5>
                        <div>
                            <div class="form-check form-check-inline">
                                <input @if (array_search(4, $editPermissions) === false) disabled @endif
                                    @if ($beneficiaria->particip_programas_transferencia_renda) checked @endif class="form-check-input questions"
                                    type="radio" name="particip_programas_transferencia_renda"
                                    id="familiaTransfRendaSim" value="true">
                                <label class="form-check-label lead" for="familiaTransfRendaSim">Sim</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input @if (array_search(4, $editPermissions) === false) disabled @endif
                                    @if (!$beneficiaria->particip_programas_transferencia_renda) checked @endif class="form-check-input questions"
                                    type="radio" name="particip_programas_transferencia_renda"
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
                        <div class="row align-items-center">
                            <div class="d-grid col-6 gap-2 mx-auto">
                                @if (array_search(5, $editPermissions) !== false)
                                    <div class="form-group">
                                        <label for="medidaProtetiva">Medida protetiva</label>
                                        <input type="file" name="medidaProtetiva" id="medidaProtetiva"
                                            class="form-control">
                                    </div>
                                @else
                                    <a target="_blank"
                                        href="{{ route('restrito.view-file', [$beneficiaria->id, 'medidaProtetiva.pdf']) }}"
                                        class="d-flex align-items-center flex-column">
                                        <img src="{{ asset('assets/img/pdf.png') }}" alt="">

                                        <p class="m-0 lead">
                                            Medida protetiva
                                        </p>
                                    </a>
                                @endif


                            </div>
                            <div class="d-grid col-6 gap-2 mx-auto">
                                @if (array_search(6, $editPermissions) !== false)
                                    <div class="form-group">
                                        <label for="medidaProtetiva">Exame psicosocial</label>
                                        <input type="file" name="examePsicosocial" class="form-control">
                                    </div>
                                @else
                                    <a target="_blank"
                                        href="{{ route('restrito.view-file', [$beneficiaria->id, 'examePsicosocial.pdf']) }}"
                                        class="d-flex align-items-center flex-column">
                                        <img src="{{ asset('assets/img/pdf.png') }}" alt="">
                                        <p class="m-0 lead">
                                            Exame psicosocial</p>
                                    </a>
                                @endif


                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="form-buttons mt-2 mb-3 d-flex justify-content-between">
                <button onclick="goBack()" type="button" class="btn btn-secondary btn-lg"
                    style="margin-right: 5px">Voltar</button>

                <div>
                    @if ($beneficiaria->status != 4)
                        @can('give edit permissions')
                            <button type="button" id="allowChangeButton" class="btn btn-warning btn-lg"
                                style="margin-right: 5px">Dar permissão para
                                edições</button>
                        @endcan
                        @if (!empty($editPermissions))
                            <button id="saveEdit" type="submit" class="btn btn-primary btn-lg">Salvar</button>
                        @endif
                    @endif
                </div>
            </div>
        </form>
    </div>
    @if ($beneficiaria->status != 2)
        <div class="modal fade" id="confirmApprove" tabindex="-1" aria-labelledby="confirmApproveLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="confirmApproveLabel">Confirmação</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="approve-form" method="POST"
                        action="{{ route('restrito.beneficiaria.approve', [$beneficiaria->id, 1]) }}">
                        @csrf
                        <div class="modal-body">
                            <p class="lead text-center">Tem certeza que deseja aprovar essa solicitação?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" data-bs-dismiss="modal" class="btn btn-danger">Não</button>
                            <button type="submit" class="btn btn-success">Sim</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @can('give edit permissions')
            <div class="modal fade" id="allowChange" tabindex="-1" aria-labelledby="allowChangeLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="allowChangeLabel">Permissão de alteração</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="add-edit-form" method="POST"
                            action="{{ route('restrito.beneficiaria.add.edit', $beneficiaria->id) }}">
                            @csrf
                            <div class="modal-body">
                                <p style="font-size: 30px" class="display-6 text-center"> Quais campos você deseja <b>
                                        permitir</b> a
                                    alteração:</p>
                                <p class="mb-0" style="font-size: 20px"><b>Questionário:</b></p>
                                <div class="permission-option">
                                    <label class="form-check-label" style="font-weight: 400" for="opt1">
                                        1 - Existe presença no núcleo familiar de criança ou adolescente em situação de
                                        abrigamento?
                                    </label>
                                    <input class="form-check-input " type="checkbox" value="1" name="opt1"
                                        id="opt1">
                                </div>

                                <div class="permission-option">
                                    <label class="form-check-label" style="font-weight: 400" for="opt2">
                                        2 - Existe presença no núcleo familiar de adolescente em situação de cumprimento de
                                        medida
                                        sócio educativa na modalidade internação?
                                    </label>
                                    <input class="form-check-input " type="checkbox" value="1" name="opt2"
                                        id="opt2">
                                </div>

                                <div class="permission-option">
                                    <label class="form-check-label" style="font-weight: 400" for="opt3">
                                        3 - Mulher beneficiária que está em condições de iniciar o processo de desacolhimento de
                                        serviço de acolhimento institucional para mulheres em situação de violência?
                                    </label>
                                    <input class="form-check-input " type="checkbox" value="1" name="opt3"
                                        id="opt3">
                                </div>

                                <div class="permission-option mb-2">
                                    <label class="form-check-label" style="font-weight: 400" for="opt4">
                                        4 - Família beneficiária de programas de transferência de renda?
                                    </label>
                                    <input class="form-check-input " type="checkbox" value="1" name="opt4"
                                        id="opt4">
                                </div>

                                <p class="mb-0" style="font-size: 20px"><b>Anexos:</b></p>
                                <div class="permission-option">
                                    <label class="form-check-label " style="font-weight: 400" for="opt5">
                                        Medida protetiva
                                    </label>
                                    <input class="form-check-input " type="checkbox" value="1" name="opt5"
                                        id="opt5">
                                </div>
                                <div class="permission-option">
                                    <label class="form-check-label" style="font-weight: 400" for="opt6">
                                        Exame psicosocial
                                    </label>
                                    <input class="form-check-input " type="checkbox" value="1" name="opt6"
                                        id="opt6">
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" data-bs-dismiss="modal" class="btn btn-danger">Fechar</button>
                                <button type="submit" class="btn btn-success">Salvar</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        @endcan

        <div class="modal fade" id="confirmDelete" tabindex="-1" aria-labelledby="confirmDeleteLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="confirmDeleteLabel">Confirmação</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="delete-form" action="{{ route('restrito.beneficiaria.delete', [$beneficiaria->id]) }}">
                        @csrf
                        <div class="modal-body">
                            <p class="lead text-center">Tem certeza que deletar essa beneficiária?</p>
                            <div class="form-group">
                                <label for="motivo_delete">Motivo</label>
                                <textarea class="form-control" id="motivo_delete" name="motivo_delete" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" data-bs-dismiss="modal" class="btn btn-secondary">Não</button>
                            <button type="submit" class="btn btn-danger">Sim</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    @endif

    <script>
        function goBack() {
            window.history.back();
        }
    </script>
@endsection
