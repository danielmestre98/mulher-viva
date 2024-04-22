@extends('assets.page')

@section('content')
    <div class="container">
        <h4 class="display-4 pt-4">Judicializações</h4>
        <hr>
        <div class="row justify-content-between mb-2">
            <div class="col-2">
                <a href="{{ route('restrito.judicializacoes.create') }}" class="btn btn-warning mb-2">Cadastrar
                    beneficiária</a>
            </div>
            <div class="col-4">
                <div class="input-group">
                    <div class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></div>
                    <input type="text" class="form-control" id="searchBeneficiaria" placeholder="Pesquisar...">
                </div>
            </div>
        </div>
        <table class="table table-hover table-bordered" id="beneficiarias-table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">CPF</th>
                    <th scope="col">RG</th>
                    <th scope="col">Municipio</th>
                    <th width="15.5%" scope="col">Número do processo</th>
                    <th width="15.5%" scope="col">Data do processo</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($judicializacoes as $item)
                    <tr name="{{ $item->id }}" class="row-table-pesquisa">
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->nome }}</td>
                        <td>
                            {{ substr($item->cpf, 0, 3) . '.' . substr($item->cpf, 3, 3) . '.' . substr($item->cpf, 6, 3) . '-' . substr($item->cpf, 9, 2) }}
                        </td>
                        <td>
                            {{ substr($item->rg, 0, 2) . '.' . substr($item->rg, 2, 3) . '.' . substr($item->rg, 5, 3) . '-' . substr($item->rg, 8, 2) }}
                        </td>
                        <td>{{ $item->municipios->nome }}</td>
                        <td>{{ $item->numero_processo }}</td>
                        <td>{{ date('d/m/Y', strtotime($item->data_processo)) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
@endsection
