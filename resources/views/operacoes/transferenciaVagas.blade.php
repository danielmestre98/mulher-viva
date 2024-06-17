@extends('assets.page')

@section('content')
    <div class="container pt-4">
        <p class="display-4">Transferência de Vagas</p>
        <hr>

        <div class="text-end mt-4">
            <button id="submit-transfer" class="btn btn-warning"><i class="fa-solid fa-right-left"></i> Transferir</button>
        </div>
        <div class="d-flex justify-content-between">
            <div style="width: 49.5%">
                <p class="display-6 text-center">Origem</p>
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="col-6">
                                <div class="input-group">
                                    <div class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></div>
                                    <input type="text" class="form-control" id="searchOrigem" placeholder="Pesquisar...">
                                </div>
                            </div>
                            <div class="col-5 mt-2 text-end"><b>Quantidade selecionada:</b> <span
                                    id="total-selected">0</span></div>
                        </div>
                        <table id="origem" class="table">
                            <thead>
                                <tr>
                                    <th>Município</th>
                                    <th style="width: 25%">Vagas Disp.</th>
                                    <th style="width: 4%">Opções</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($vagas as $item)
                                    @if ($item['quantidade'] > 0)
                                        <tr id="origem-{{ $item['id'] }}">
                                            <td>{{ $item['municipio'] }}</td>
                                            <td class="vagas-disp" style="text-align: center">{{ $item['quantidade'] }}</td>
                                            <td class="options no-select" style="text-align: right">
                                                <span class="minus disabled"><i class="fa-solid fa-minus fa-lg"></i></span>
                                                <span class="quantity">0</span>
                                                <span class="plus"><i class="fa-solid fa-plus fa-lg"></i></span>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div style="width: 49.5%">
                <p class="display-6 text-center">Destino</p>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="input-group">
                                    <div class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></div>
                                    <input type="text" class="form-control" id="searchDestino"
                                        placeholder="Pesquisar...">
                                </div>
                            </div>
                        </div>
                        <table id="destino" class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Município</th>
                                    <th width="25%">Vagas Totais</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allMunicipios as $municipio)
                                    <tr id="destino-{{ $municipio->id }}">
                                        <td>{{ $municipio->municipios->nome }}</td>
                                        <td style="text-align: center">{{ $municipio->quantidade }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalConfirmTransfer" tabindex="-1" aria-labelledby="modalConfirmTransferLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalConfirmTransferLabel">Confirmar transferência</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div id="origem-confirm" class="col-5 card">
                            <ul class="list-group list-group-flush">

                            </ul>
                        </div>
                        <div>
                            <i style="color: rgb(66, 66, 230)" class="fa-solid fa-arrow-right fa-4x"></i>
                        </div>
                        <div id="destino-confirm" class="col-5 card">
                            <ul class="list-group list-group-flush">

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" id="confirmTransfer" class="btn btn-success">Confirmar</button>
                </div>
            </div>
        </div>
    </div>
    @if (isset($action))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Select the element with id "action-text" and set its HTML content
                var actionTextElement = document.getElementById('action-text');
                actionTextElement.innerHTML = 'Transferência realizada com sucesso.';

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
