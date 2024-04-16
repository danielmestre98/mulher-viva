@extends('assets.page')

@section('content')
    <div class="container">
        <h4 class="display-4 pt-4">Usuários</h4>
        <hr>
        <div class="row justify-content-between mb-2">
            <div class="col-2">
                <a class="btn btn-warning" href="{{ route('restrito.usuarios.create') }}">Cadastrar
                    usuário</a>
            </div>
            <div class="col-4">
                <div class="input-group">
                    <div class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></div>
                    <input type="text" class="form-control" id="searchUser" placeholder="Pesquisar...">
                </div>
            </div>
        </div>

        <table class="table table-hover table-bordered" id="users-table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th width="45%" scope="col">Nome</th>
                    <th scope="col">E-mail</th>
                    <th width="10%" scope="col">CPF</th>
                    <th width="13%" scope="col">Criado em</th>
                    <th>Opções</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ substr($user->cpf, 0, 3) . '.' . substr($user->cpf, 3, 3) . '.' . substr($user->cpf, 6, 3) . '-' . substr($user->cpf, 9, 2) }}
                        </td>
                        <td>{{ date('d/m/Y H:i', strtotime($user->created_at)) }}</td>
                        <td style="text-align: center">
                            <a href="{{ route('restrito.usuarios.view', $user->id) }}" class="btn btn-primary btn-sm">
                                <i class="fa-solid fa-pencil"></i>
                            </a>
                            <button data-name={{ $user->name }} name="{{ $user->id }}"
                                class="btn btn-danger btn-sm delete-user">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
