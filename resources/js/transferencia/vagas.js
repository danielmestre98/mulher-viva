import $ from "jquery";
import axios from "../assets/axiosInstance";
import { Modal } from "bootstrap";
import DataTable from "datatables.net-bs5";
import ptBR from "../assets/pt-BR.json";

$(() => {
    var vagasTransferir = {};
    var destino;

    $(".options").on("click", ".plus:not(.disabled)", (e) => {
        const totalSelected = parseInt($("#total-selected").html());

        const id = $(e.currentTarget)
            .parent()
            .parent()
            .attr("id")
            .replace("origem-", "");
        let currentQuantity = parseInt(
            $(e.currentTarget).siblings(".quantity").html()
        );

        const name = $(e.currentTarget).parent().siblings().html();

        const maxQuantity = parseInt(
            $(e.currentTarget).parent().siblings(".vagas-disp").html()
        );

        currentQuantity++;
        $(e.currentTarget).siblings(".quantity").html(currentQuantity);
        $(e.currentTarget).siblings(".minus").removeClass("disabled");

        vagasTransferir[id] = { qtd: currentQuantity, name: name };

        if (currentQuantity == maxQuantity) {
            $(e.currentTarget).addClass("disabled");
        }

        $("#total-selected").html(totalSelected + 1);
    });

    $(".options").on("click", ".minus:not(.disabled)", (e) => {
        const totalSelected = parseInt($("#total-selected").html());

        const id = $(e.currentTarget)
            .parent()
            .parent()
            .attr("id")
            .replace("origem-", "");
        const name = $(e.currentTarget).parent().siblings().html();
        let currentQuantity = parseInt(
            $(e.currentTarget).siblings(".quantity").html()
        );

        currentQuantity--;
        $(e.currentTarget).siblings(".quantity").html(currentQuantity);
        $(e.currentTarget).siblings(".plus").removeClass("disabled");
        vagasTransferir[id] = { qtd: currentQuantity, name: name };
        if (currentQuantity == 0) {
            $(e.currentTarget).addClass("disabled");
            delete vagasTransferir[id];
        }
        $("#total-selected").html(totalSelected - 1);
    });

    let tableOrigem = new DataTable("#origem", {
        language: ptBR,
        searching: true, // Disable search input
        lengthChange: false,
        columnDefs: [{ targets: 2, orderable: false, searchable: false }],
    });

    $("#searchOrigem").on("input", function () {
        // Get value of search input
        var searchValue = $(this).val();

        // Use DataTables API to search DataTable
        tableOrigem.search(searchValue).draw();
    });

    let tableDestino = new DataTable("#destino", {
        language: ptBR,
        searching: true, // Disable search input
        lengthChange: false,
    });

    $("#destino").on("click", "tbody tr", (e) => {
        tableDestino
            .rows()
            .nodes()
            .each(function (node) {
                $(node).removeClass("selected");
            });
        $(e.currentTarget).addClass("selected");
    });

    $("#searchDestino").on("input", function () {
        // Get value of search input
        var searchValue = $(this).val();

        // Use DataTables API to search DataTable
        tableDestino.search(searchValue).draw();
    });

    $("#submit-transfer").on("click", () => {
        $("#origem-confirm ul").html("");
        $("#destino-confirm ul").html("");
        let total = 0;
        const modal = new Modal("#modalConfirmTransfer");
        for (let key in vagasTransferir) {
            $("#origem-confirm ul").append(
                `<li class="list-group-item">${vagasTransferir[key].name}: ${vagasTransferir[key].qtd}</li>`
            );
            total += vagasTransferir[key].qtd;
        }
        $("#origem-confirm ul").append(
            `<li class="list-group-item"><b>Total: ${total}</b></li>`
        );

        tableDestino
            .rows()
            .nodes()
            .each(function (node) {
                if ($(node).hasClass("selected")) {
                    destino = parseInt(
                        $(node).attr("id").replace("destino-", "")
                    );
                    $("#destino-confirm ul").append(`
                    <li class="list-group-item">${$(node)
                        .children()
                        .html()}</li>
                    `);
                }
            });

        if (destino == null || Object.keys(vagasTransferir).length == 0) {
            alert("Transferencia inválida. Verifique as informações.");
            return;
        }
        modal.show();
    });

    $("#confirmTransfer").on("click", (e) => {
        $(e.target).prop("disabled", true);
        axios
            .post(`${process.env.APP_URL}/restrito/operacoes/transferencia`, {
                origens: vagasTransferir,
                destino: destino,
            })
            .then(() => {
                window.location.href = window.location.href + "?success=true";
            });
    });
});
