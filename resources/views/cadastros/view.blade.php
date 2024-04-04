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
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nascimento">Data de nascimento</label>
                                <input readonly type="text" class="form-control" id="nascimento" name="nascimento"
                                    value="{{ date('d/m/Y', strtotime($beneficiaria->nascimento)) }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="cpf">CPF</label>
                                <input readonly type="text" class="form-control" id="cpf" name="cpf"
                                    value="{{ substr($beneficiaria->cpf, 0, 3) . '.' . substr($beneficiaria->cpf, 3, 3) . '.' . substr($beneficiaria->cpf, 6, 3) . '-' . substr($beneficiaria->cpf, 9, 2) }}">
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
                    <h5 class=" mb-1"><span class="red">*</span> EXISTE PRESENÇA NO NÚCLEO FAMILIAR DE CRIANÇA OU
                        ADOLESCENTE
                        EM SITUAÇÃO DE
                        ABRIGAMENTO?
                    </h5>
                    <div>
                        <div class="form-check form-check-inline">
                            <input @cannot('super-admin') disabled @endcannot
                                @if ($beneficiaria->presenca_jovem_sit_abrigamento) checked @endif class="form-check-input questions"
                                type="radio" name="criancaAbrig" id="criancaAbrigSim" value="true">
                            <label class="form-check-label lead" for="criancaAbrigSim">Sim</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input @cannot('super-admin') disabled @endcannot
                                @if (!$beneficiaria->presenca_jovem_sit_abrigamento) checked @endif class="form-check-input questions"
                                type="radio" name="criancaAbrig" id="criancaAbrigNão" value="false">
                            <label class="form-check-label lead" for="criancaAbrigNão">Não</label>
                        </div>
                    </div>

                    <h5 class="mt-2 mb-1"><span class="red">*</span> EXISTE PRESENÇA NO NÚCLEO FAMILIAR DE ADOLESCENTE EM
                        SITUAÇÃO DE CUMPRIMENTO DE
                        MEDIDA SÓCIO EDUCATIVA NA MODALIDADE INTERNAÇÃO?
                    </h5>
                    <div>
                        <div class="form-check form-check-inline">
                            <input @cannot('super-admin') disabled @endcannot
                                @if ($beneficiaria->presenca_adolec_medida_socio_educativa) checked @endif class="form-check-input questions"
                                type="radio" name="adolecMedidaSocio" id="adolecMedidaSocioSim" value="true">
                            <label class="form-check-label lead" for="adolecMedidaSocioSim">Sim</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input @cannot('super-admin') disabled @endcannot
                                @if (!$beneficiaria->presenca_adolec_medida_socio_educativa) checked @endif class="form-check-input questions"
                                type="radio" name="adolecMedidaSocio" id="adolecMedidaSocioNão" value="false">
                            <label class="form-check-label lead" for="adolecMedidaSocioNão">Não</label>
                        </div>
                    </div>


                    <h5 class="mt-2 mb-1"><span class="red">*</span> MULHER BENEFICIÁRIA QUE ESTÁ EM CONDIÇÕES DE INICIAR
                        O
                        PROCESSO DE DESACOLHIMENTO
                        DE SERVIÇO DE ACOLHIMENTO INSTITUCIONAL
                        PARA MULHERES EM SITUAÇÃO DE VIOLÊNCIA?
                    </h5>
                    <div>
                        <div class="form-check form-check-inline">
                            <input @if ($beneficiaria->inic_serv_acolh_institucional) checked @endif
                                @cannot('super-admin') disabled @endcannot class="form-check-input questions"
                                type="radio" name="mulherCondDesacolh" id="mulherCondDesacolhSim" value="true">
                            <label class="form-check-label lead" for="mulherCondDesacolhSim">Sim</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input @if (!$beneficiaria->inic_serv_acolh_institucional) checked @endif
                                @cannot('super-admin') disabled @endcannot class="form-check-input questions"
                                type="radio" name="mulherCondDesacolh" id="mulherCondDesacolhNão" value="false">
                            <label class="form-check-label lead" for="mulherCondDesacolhNão">Não</label>
                        </div>
                    </div>

                    <h5 class="mt-2 mb-1"><span class="red">*</span> FAMÍLIA BENEFICIÁRIA DE PROGRAMAS DE TRANSFERÊNCIA
                        DE RENDA?
                    </h5>
                    <div>
                        <div class="form-check form-check-inline">
                            <input @cannot('super-admin') disabled @endcannot
                                @if ($beneficiaria->particip_programas_transferencia_renda) checked @endif class="form-check-input questions"
                                type="radio" name="familiaTransfRenda" id="familiaTransfRendaSim" value="true">
                            <label class="form-check-label lead" for="familiaTransfRendaSim">Sim</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input @cannot('super-admin') disabled @endcannot
                                @if (!$beneficiaria->particip_programas_transferencia_renda) checked @endif class="form-check-input questions"
                                type="radio" name="familiaTransfRenda" id="familiaTransfRendaNão" value="false">
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
                        <div class="d-grid col-6 gap-2 mx-auto">
                            <a target="_blank"
                                href="{{ route('restrito.view-file', [$beneficiaria->id, 'medidaProtetiva.pdf']) }}"
                                class="btn btn-info btn-lg">Medida protetiva <i class="fa-solid fa-download"></i></a>
                        </div>
                        <div class="d-grid col-6 gap-2 mx-auto">
                            <a target="_blank"
                                href="{{ route('restrito.view-file', [$beneficiaria->id, 'examePsicosocial.pdf']) }}"
                                class="btn btn-info btn-lg">Exame psicosocial <i class="fa-solid fa-download"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-buttons mt-2 mb-3 d-flex justify-content-between">
                <button onclick="goBack()" type="button" class="btn btn-secondary btn-lg"
                    style="margin-right: 5px">Voltar</button>
                @can('super-admin')
                    <div>
                        <button class="btn btn-danger btn-lg" style="margin-right: 5px">Negar</button>
                        <button class="btn btn-success btn-lg">Aprovar</button>
                    </div>
                @endcan
            </div>
        </form>
    </div>

    <script>
        function goBack() {
            window.history.back();
        }
    </script>
@endsection
