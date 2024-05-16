@extends('assets.page')

@section('content')
    <div class="container pt-4">
        <p class="display-4">Lista para aprovação (Mês Ref: {{ $mesReferencia }}) </p>
        <hr>
        <div class="row justify-content-between mb-2">
            <div class="col-4">
                <div class="input-group">
                    <div class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></div>
                    <input type="text" class="form-control" id="searchBeneficiaria" placeholder="Pesquisar...">
                </div>

            </div>
            <div class="col-2">
                @if (!$approved && count($beneficiarias) > 0)
                    <button style="width: 100%" class="btn btn-success" id="approve-list-btn">Aprovar Lista</button>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-hover table-bordered" id="beneficiarias-table">
                    <thead>
                        <tr>
                            <th @can('view benefPontuacao') style="text-align: center" @endcan width="5%"
                                scope="col">Posição
                                @can('view benefPontuacao')
                                    (Município)
                                @endcan
                            </th>
                            <th scope="col">Nome da Solicitante</th>
                            <th width="10%" scope="col">CPF</th>
                            <th width="10%" scope="col">NIS</th>
                            @can('view benefPontuacao')
                                <th width="5%" scope="col">Pontuação</th>
                                <th scope="col">Município</th>
                            @endcan
                            <th width="15.5%" scope="col">Data da Solicitação</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($i = 0; $i < count($beneficiarias); $i++)
                            @php
                                $beneficiaria = $beneficiarias[$i];
                            @endphp

                            <tr name="{{ $beneficiaria->id }}" class="row-table-pesquisa">
                                @if ($beneficiaria->status != 4)
                                    <td>{{ $i + 1 }}</td>
                                @else
                                    <td>N/A</td>
                                @endif
                                <td>{{ $beneficiaria->nome }}</td>
                                <td>{{ substr($beneficiaria->cpf, 0, 3) . '.' . substr($beneficiaria->cpf, 3, 3) . '.' . substr($beneficiaria->cpf, 6, 3) . '-' . substr($beneficiaria->cpf, 9, 2) }}
                                </td>
                                <td>{{ $beneficiaria->nis }}</td>

                                @can('view benefPontuacao')
                                    <td>{{ $beneficiaria->pontuacao }}</td>
                                    <td>{{ $beneficiaria->municipios->nome }}</td>
                                @endcan

                                <td>{{ date('d/m/Y H:i', strtotime($beneficiaria->created_at)) }}</td>
                                <td>{{ $beneficiaria->statusCodes->name }}</td>
                            </tr>
                        @endfor
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <div class="modal fade" id="approveList" tabindex="-1" aria-labelledby="approveListLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="approveListLabel">Aprovar Lista</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <p class="lead">Confirma aprovação dessa lista?</p>
                </div>
                <div class="modal-footer">
                    <button data-bs-dismiss="modal" class="btn btn-secondary">Cancelar</button>
                    <button id="send-approve" class="btn btn-success">Aprovar</button>
                </div>

            </div>
        </div>
    </div>
@endsection
