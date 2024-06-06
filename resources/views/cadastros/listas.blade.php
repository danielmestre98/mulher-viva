@extends('assets.page')

@section('content')
    <div class="container pt-4">
        <p class="display-4">Listas Aprovadas</p>
        <hr>

        <div class="card mb-4">
            <div class="card-header form-card-header">
                <i class="fa-solid fa-filter"></i> Filtros
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('restrito.lists.filter') }}">
                    @csrf
                    @can('view beneficiarias')
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="drads_filtro">Drads</label>
                                <select class="form-select filtros" id="drads_filtro" name="drads_filtro">
                                    <option value="">Selecione a opção desejada...</option>
                                    @foreach ($drads as $item)
                                        <option @if (isset($filtros) && $filtros['drads'] == $item->id) selected @endif value="{{ $item->id }}">
                                            {{ $item->nome }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="municipio_filtro">Municipio</label>
                                <select class="form-select filtros" id="municipio_filtro" name="municipio_filtro">
                                    <option value="">Selecione a opção desejada...</option>
                                    @foreach ($municipios as $item)
                                        @if ($item->id != 0)
                                            <option @if (isset($filtros) && $filtros['municipio'] == $item->id) selected @endif
                                                value="{{ $item->id }}">
                                                {{ $item->nome }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endcan
                    <div class="d-flex justify-content-between">
                        <div class=" col-md-10 row">
                            <div class="col-md-4">
                                <label for="mesReferencia">Mês de referência</label>
                                <select name="mesReferencia" id="mesReferencia" class="form-select">
                                    <option value="">Selecione...</option>
                                    @foreach ($referencias as $item)
                                        <option @if (isset($filtros) && $filtros['mesReferencia'] == $item['mes_referencia']) selected @endif
                                            value="{{ $item['mes_referencia'] }}">{{ $item['mes_referencia'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2 mt-4">
                            <button class="btn btn-primary" style="float: right"> Filtrar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div id="listas-tabela" class="mt-2">
            <table class="table table-hover table-bordered" id="lista-table">
                <thead>
                    <tr>
                        <th width="8%">#</th>
                        <th width="15%">Mês referencia</th>
                        <th>Aprovado por</th>
                        <th width="15%">Aprovado em</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lista as $item)
                        <tr style="cursor: pointer" name="{{ $item->id }}" class="list-item">
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->mes_referencia }}</td>
                            <td>{{ $item->users->name }}</td>
                            <td>{{ date('d/m/Y H:i', strtotime($item->created_at)) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
    <div class="modal fade" id="modal-list" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="modal-list-title" class="modal-title"><b>Município:</b> <span id="municipio-title"></span> |
                        <b>Referência:</b> <span id="referencia-tile"></span> | <b>Aprovado em:</b> <span
                            id="data-aprovacao-title"></span>
                        | <b>Aprovado por:</b> <span id="created-by-title"></span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table id="lista-table-modal-benef" class="table">
                        <thead>
                            <tr>
                                <th>Posição</th>
                                <th>Nome</th>
                                <th>CPF</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
