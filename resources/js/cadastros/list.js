import $ from "jquery";
import axios from "../assets/axiosInstance";
import { Modal } from "bootstrap";
import DataTable from "datatables.net-bs5";
import ptBR from "../assets/pt-BR.json";

$(() => {
    let table = new DataTable("#beneficiarias-table", {
        language: ptBR,
        searching: true, // Disable search input
        lengthChange: false,
        order: [[0, "asc"]],
    });

    $("#searchBeneficiaria").on("input", function () {
        // Get value of search input
        var searchValue = $(this).val();

        // Use DataTables API to search DataTable
        table.search(searchValue).draw();
    });

    $(".row-table-pesquisa").on("click", (e) => {
        window.location.href = `${
            process.env.APP_URL
        }/restrito/cadastros/beneficiarias/view/${$(e.currentTarget).attr(
            "name"
        )}`;
    });

    const buttonApprove = $("#approve-list-btn").get(0);

    if (buttonApprove) {
        $(buttonApprove).on("click", function () {
            const modal = new Modal("#approveList");
            modal.show();
        });
        $("#send-approve").on("click", function () {
            axios.get("/restrito/lista/approve").then(() => {
                window.location.reload();
            });
        });
    }
});
