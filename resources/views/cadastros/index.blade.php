@extends('assets.page')

@section('content')
    <div class="container pt-4">
        <p class="display-4">Beneficiárias</p>
        <hr>

        <div class="card mb-4">
            <div class="card-header form-card-header">
                <i class="fa-solid fa-filter"></i> Filtros
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('restrito.cadastros.beneficiarias.filter.form') }}">
                    @csrf
                    @can('view beneficiarias')
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="drads_filtro">Drads</label>
                                <select class="form-select filtros" id="drads_filtro" name="drads_filtro">
                                    <option value="">Selecione a opção desejada...</option>
                                    @foreach ($drads as $item)
                                        <option @if (isset($filtros_default) && $filtros_default['drads'] == $item->id) selected @endif value="{{ $item->id }}">
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
                                            <option @if (isset($filtros_default) && $filtros_default['municipio'] == $item->id) selected @endif
                                                value="{{ $item->id }}">
                                                {{ $item->nome }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endcan
                    <div class="d-flex justify-content-between">
                        <div class="form-group col-md-4">
                            <label for="status_filtro">Status</label>
                            <select class="form-select filtros" id="status_filtro" name="status_filtro">
                                <option value="">Selecione a opção desejada...</option>
                                @foreach ($status as $item)
                                    <option @if (isset($filtros_default) && $filtros_default['status'] == $item->id) selected @endif value="{{ $item->id }}">
                                        {{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2 mt-4">
                            <button class="btn btn-primary" style="float: right"> Filtrar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row justify-content-between mb-2">
            <div class="col-2">
                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#cadastrarBeneficiaria">Cadastrar
                    beneficiária</button>
            </div>
            <div class="col-4">
                <div class="input-group">
                    <div class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></div>
                    <input type="text" class="form-control" id="searchBeneficiaria" placeholder="Pesquisar...">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-hover table-bordered" id="beneficiarias-table">
                    <thead>
                        <tr>
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
                        <button id="submit-button-search" type="submit" class="btn btn-warning"> <img class="loading-svg"
                                style="display: none" height="25x" src="{{ asset('assets/img/loading.svg') }}"
                                alt=""> <span class="text-submit">Buscar beneficiária</span> </button>
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
                <form id="approve-new" method="POST" action="{{ route('restrito.form.new.beneficiaria') }}">
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

    @if (isset($action))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Select the element with id "action-text" and set its HTML content
                var actionTextElement = document.getElementById('action-text');
                actionTextElement.innerHTML = 'Beneficiária excluida com sucesso.';

                // Select the element with class "alert" inside "#liveAlertPlaceholder"
                var alertElement = document.querySelector('#liveAlertPlaceholder .alert');

                // Fade in the alert element (display it with opacity transition)
                alertElement.style.display = 'block';
                alertElement.style.opacity = '1';

                // Set a timeout to fade out the alert element after 5 seconds (5000 milliseconds)
                setTimeout(function() {
                    // Fade out the alert element (reduce opacity over time)
                    var fadeOutInterval = setInterval(function() {
                        // Get the current opacity of the alert element
                        var currentOpacity = parseFloat(window.getComputedStyle(alertElement).opacity);

                        // Reduce opacity gradually
                        alertElement.style.opacity = (currentOpacity - 0.4).toFixed(2);

                        // Stop fading out when opacity reaches 0
                        if (currentOpacity <= 0) {
                            clearInterval(fadeOutInterval);
                            alertElement.style.display = 'none'; // Hide the element after fading out
                        }
                    }, 100); // Interval for fading out (100 milliseconds)
                }, 5000); // Timeout duration (5000 milliseconds)
            })
        </script>
    @endif
@endsection
