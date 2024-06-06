import $ from "jquery";
import axios from "../assets/axiosInstance";
import { Modal } from "bootstrap";
import DataTable from "datatables.net-bs5";
import ptBR from "../assets/pt-BR.json";

$(() => {
    const formatDate = (dateString) => {
        const date = new Date(dateString);

        const day = String(date.getDate()).padStart(2, "0");
        const month = String(date.getMonth() + 1).padStart(2, "0"); // Months are zero-based
        const year = date.getFullYear();
        const hours = String(date.getHours()).padStart(2, "0");
        const minutes = String(date.getMinutes()).padStart(2, "0");

        return `${day}/${month}/${year} ${hours}:${minutes}`;
    };

    function formatCPF(cpf) {
        // Remove any non-digit characters
        cpf = cpf.replace(/\D/g, "");

        // Apply the formatting
        if (cpf.length === 11) {
            return cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4");
        } else {
            // Return the original input if it's not 11 digits long
            return cpf;
        }
    }

    let table = new DataTable("#lista-table", {
        language: ptBR,
        searching: true, // Disable search input
        lengthChange: false,
        order: [[0, "desc"]],
    });

    $(".list-item").on("click", function (e) {
        $("#municipio-title").html("");
        $("#referencia-tile").html("");
        $("#data-aprovacao-title").html("");
        $("#created-by-title").html("");
        $("#lista-table-modal-benef tbody").html("");
        const listId = $(e.currentTarget).attr("name");
        console.log(listId);
        let modal = new Modal("#modal-list");
        axios
            .get(`${process.env.APP_URL}/restrito/listas/${listId}`)
            .then(({ data }) => {
                $("#municipio-title").html(data.lista.municipios.nome);
                $("#referencia-tile").html(data.lista.mes_referencia);
                $("#data-aprovacao-title").html(
                    formatDate(data.lista.created_at)
                );
                $("#created-by-title").html(data.lista.users.name);

                data.lista.beneficiarias.forEach((item) => {
                    console.log(item);
                    $("#lista-table-modal-benef tbody").append(`
                        <tr>
                            <td>${item.posicao}</td>
                            <td>${item.nome}</td>
                            <td>${formatCPF(item.cpf)}</td>
                            <td>${item.status_codes.name}</td>
                        </tr>
                    `);
                });
            });
        modal.show();
    });
});
