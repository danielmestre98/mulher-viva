<div class="left-bar">
    <div class="alert alert-success senha" style="display: none" id="senha-alterada" role="alert">
        <b>Senha alterada com sucesso!</b>
    </div>
    <div class="logo-sp">
        <a class="title" href="{{ route('restrito.cadastros.beneficiarias') }}">
            <h2>Programa Mulher Viva</h2>
        </a>
    </div>
    <hr>
    <div class="category-divider">Cadastros</div>
    <div class="menu-group">
        <div class="menu-item-dropdown">
            <button class="menu-item-button"><i class="fa-solid fa-person-dress"></i> <span>Mulheres</span>
                @if (request()->is('*/cadastros/beneficiarias*'))
                    <i class="fa-solid fa-chevron-down fa-sm"></i>
                @else
                    <i class="fa-solid fa-chevron-right fa-sm"></i>
                @endif
            </button>
            <div class="box-dropdown" @if (request()->is('*/cadastros/beneficiarias*')) style="display: block" @endif>
                <ul>
                    <li><a id="all-s" @if (request()->routeIs('restrito.cadastros.beneficiarias')) class="active" @endif
                            href={{ route('restrito.cadastros.beneficiarias') }}>Solicitações</a></li>
                    <li><a id="app-s" @if (request()->is('restrito/cadastros/beneficiarias/fitro/1')) class="active" @endif
                            href={{ route('restrito.cadastros.beneficiarias.filtro', 1) }}>Aprovadas</a></li>
                    <li><a id="nao-s" @if (request()->is('restrito/cadastros/beneficiarias/fitro/4')) class="active" @endif
                            href={{ route('restrito.cadastros.beneficiarias.filtro', 4) }}>Não elegíveis</a></li>
                </ul>
            </div>
        </div>
        <div class="menu-item-dropdown">
            <button class="menu-item-button"><i class="fa-solid fa-user"></i> <span>Usuários</span>
                @if (request()->is('*/cadastros/usuarios*'))
                    <i class="fa-solid fa-chevron-down fa-sm"></i>
                @else
                    <i class="fa-solid fa-chevron-right fa-sm"></i>
                @endif
            </button>
            <div class="box-dropdown" @if (request()->is('*/cadastros/usuarios*')) style="display: block" @endif>
                <ul>
                    <li><a @if (request()->routeIs('restrito.usuarios.create')) class="active" @endif
                            href="{{ route('restrito.usuarios.create') }}">Novo</a></li>
                    <li><a @if (request()->routeIs('restrito.usuarios')) class="active" @endif
                            href="{{ route('restrito.usuarios') }}">Consultar / Alterar</a></li>
                </ul>
            </div>
        </div>
        {{-- <div class="menu-item-dropdown">
            <button class="menu-item-button"><i class="fa-solid fa-user"></i> <span>Usuários</span> <i
                    class="fa-solid fa-chevron-right fa-sm"></i></button>
            <div class="box-dropdown">
                <ul>
                    <li><a href="">Incluir</a></li>
                    <li><a href="">Consultar / Alterar</a></li>
                </ul>
            </div>
        </div> --}}
    </div>
    {{-- <hr> --}}
    {{-- <div class="category-divider">Autorizações</div>
    <div class="menu-group">
        <div class="menu-item-dropdown">
            <button class="menu-item-button"><i class="fa-solid fa-key"></i> <span>Tokens</span> <i
                    class="fa-solid fa-chevron-right fa-sm"></i></button>
            <div class="box-dropdown">
                <ul>
                    <li><a href="">Gerar</a></li>
                    <li><a href="">Consultar / Alterar</a></li>
                </ul>
            </div>
        </div>
    </div>
    <hr> --}}
    {{-- <div class="category-divider">Administração</div>
    <div class="menu-group">
        <div class="menu-item-dropdown">
            <button class="menu-item-button"><i class="fa-solid fa-file-lines"></i> <span>Relatórios</span> <i
                    class="fa-solid fa-chevron-right fa-sm"></i></button>
            <div class="box-dropdown">
                <ul>
                    <li><a href="">Acessos API</a></li>
                    <li><a href="">Log Modificacoes</a></li>
                </ul>
            </div>
        </div>
    </div> --}}
    {{-- <div class="menu-group">
        <div class="menu-item">
            <a href="" class="menu-item-button">
                <i class="fa-solid fa-laptop-file"></i>
                <span>Baixar documentação</span>
            </a>
        </div>
    </div> --}}

    <div class="left-bar-footer">
        <hr>

        <div class="user-card">
            <div class="user-info">
                <div class="user-img">
                    {{-- <img src="{{ asset('assets/img/default-user-image.png') }}" alt=""> --}}
                </div>
                <div class="user-card-info">
                    <div class="nome">
                        <p><b>{{ $user->name }}</b></p>
                    </div>
                    <div class="nivel">
                        <p>{{ ucfirst(str_replace('Super-', '', $user->getRoleNames()[0])) }}</p>
                    </div>
                </div>
            </div>
            <div class="user-card-options dropup">
                <button type="button" data-bs-toggle="dropdown">
                    <span><i class="fa-solid fa-gear fa-lg"></i></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="#" id="alterar-senha" class="dropdown-item">Alterar senha</a></li>
                    <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalSenha" tabindex="-1" aria-labelledby="modalSenhaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalSenhaLabel">Alteração de senha</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('restrito.usuario.alterar.senha') }}" id="form-senha">
                @csrf
                <div class="modal-body">
                    <div class="form-group mb-2">
                        <label for="novaSenha"><span class="red">*</span> Nova senha</label>
                        <input type="password" id="novaSenha" name="novaSenha" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="confirmSenha"><span class="red">*</span> Confirme a senha</label>
                        <input type="password" id="confirmSenha" name="confirmSenha" class="form-control">
                    </div>
                    <p>Campos com <span class="red">*</span> são obrigatórios.</p>
                </div>
                <input type="hidden" name="userId" id="userId" value="{{ Auth::user()->id }}">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@if (auth()->user()->reset_password == true)
    <div class="modal fade" id="modalResetPassword" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modalResetPasswordLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalResetPasswordLabel">Criar nova senha</h1>
                </div>
                <form action="{{ route('restrito.usuario.alterar.senha') }}" method="POST" id="form-senha-reset">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-2">
                            <label for="novaSenhaReset"><span class="red">*</span> Nova senha</label>
                            <input type="password" id="novaSenhaReset" name="novaSenhaReset" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="confirmSenhaReset"><span class="red">*</span> Confirme a senha</label>
                            <input type="password" id="confirmSenhaReset" name="confirmSenhaReset"
                                class="form-control">
                        </div>
                        <p>Campos com <span class="red">*</span> são obrigatórios.</p>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
