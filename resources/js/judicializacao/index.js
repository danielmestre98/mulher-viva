import $ from "jquery";
import DataTable from "datatables.net-bs5";
import ptBR from "../assets/pt-BR.json";

$(() => {
    let table = new DataTable("#beneficiarias-table", {
        language: ptBR,
        searching: true,
        lengthChange: false,
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
        }/restrito/cadastros/judicializacoes/view/${$(e.currentTarget).attr(
            "name"
        )}`;
    });
});
