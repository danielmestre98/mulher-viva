import $ from "jquery";
import DataTable from "datatables.net-bs5";
import ptBR from "../assets/pt-BR.json";
import axios from "../assets/axiosInstance";

$(() => {
    let table = new DataTable("#users-table", {
        language: ptBR,
        searching: true, // Disable search input
        lengthChange: false,
    });

    $(".delete-user").on("click", (e) => {
        const user = {
            id: $(e.currentTarget).attr("name"),
            nome: $(e.currentTarget).attr("data-name"),
        };

        if (confirm(`Deseja realmente excluir o usuário`)) {
            axios.delete(`/restrito/cadastros/usuarios/${user.id}`).then(() => {
                window.location.reload();
            });
        }
    });
});
