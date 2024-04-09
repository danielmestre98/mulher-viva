import $ from "jquery";
import Inputmask from "inputmask";
import axios from "../assets/axiosInstance";
import { Modal } from "bootstrap";
import DataTable from "datatables.net-bs5";
import ptBR from "../assets/pt-BR.json";

$(() => {
    if (
        window.location.href ===
        `${process.env.APP_URL}/restrito/cadastros/beneficiarias/filter`
    ) {
        const leftbarControl = $("#leftbar-control").val();
        switch (leftbarControl) {
            case "":
                $("#all-s").addClass("active");
                break;
            case "1":
                $("#app-s").addClass("active");
                break;
            case "2":
                $("#pen-s").addClass("active");
                break;
            case "3":
                $("#rec-s").addClass("active");
                break;
            case "4":
                $("#nao-s").addClass("active");
                break;
            default:
                break;
        }
    }

    const modalSearch = new Modal("#cadastrarBeneficiaria");
    const modalSucesso = new Modal("#sucessoModal");
    const modalErro = new Modal("#erroModal");
    var dadosMulher;

    let table = new DataTable("#beneficiarias-table", {
        language: ptBR,
        searching: true, // Disable search input
        lengthChange: false,
    });

    const newBenefSearch = $("#search-value-new").get(0);
    var cpfIm = new Inputmask("999.999.999-99");
    var nisIm = new Inputmask("999.99999.99.9");
    cpfIm.mask(newBenefSearch);
    $("#tipo-search-new").on("change", () => {
        if ($("#tipo-search-new").val() == "cpf") {
            cpfIm.mask(newBenefSearch);
        } else {
            nisIm.mask(newBenefSearch);
        }
    });

    $(".row-table-pesquisa").on("click", (e) => {
        window.location.href = `${
            process.env.APP_URL
        }/restrito/cadastros/beneficiarias/view/${$(e.currentTarget).attr(
            "name"
        )}`;
    });

    $("#searchBeneficiaria").on("input", function () {
        // Get value of search input
        var searchValue = $(this).val();

        // Use DataTables API to search DataTable
        table.search(searchValue).draw();
    });

    $(".filtros").on("change", function (e) {
        if (e.target.value) {
            $(".filtros").not(this).attr("disabled", true);
        } else {
            $(".filtros").attr("disabled", false);
        }
    });

    $("#search-new").on("submit", function (e) {
        e.preventDefault();
        let formData = {
            tipoPesquisa: $("#tipo-search-new").val(),
            valorPesquisa: $("#search-value-new").val().replace(/\D/g, ""),
        };
        axios
            .post("/restrito/cadastros/beneficiarias/search-new", formData)
            .then(({ data }) => {
                console.log(data);
                if (data.aprovada) {
                    dadosMulher = data;
                    modalSearch.hide();
                    $("#json-mulher").val(JSON.stringify(data));
                    $("#nome-beneficiaria").html(data.solicitante.NOM_PESSOA);
                    modalSucesso.show();
                } else {
                    $("#error-text").html(
                        "Pessoa encontrada na base porém não elegível para o benefício."
                    );
                    modalErro.show();
                }
            })
            .catch((error) => {
                if (error.response.status === 401) {
                    $("#error-text").html(
                        "Pessoa não encontrada na base do CadÚnico."
                    );
                    modalErro.show();
                } else if (error.response.status === 403) {
                    $("#error-text").html("Pessoa já cadastrada no sistema.");
                    modalErro.show();
                }
            });
    });

    const formatDate = (date) => {
        // Converter para objeto Date
        var date = new Date(date);
        // Formatar data e hora
        var dia = ("0" + date.getDate()).slice(-2);
        var mes = ("0" + (date.getMonth() + 1)).slice(-2);
        var ano = date.getFullYear();
        var hora = ("0" + date.getHours()).slice(-2);
        var minutos = ("0" + date.getMinutes()).slice(-2);

        // Resultado no formato desejado
        var formatoDesejado =
            dia + "/" + mes + "/" + ano + " " + hora + ":" + minutos;

        return formatoDesejado; // Saída: 14/03/2024 19:29
    };
});
