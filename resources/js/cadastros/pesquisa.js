import $ from "jquery";
import Inputmask from "inputmask";
import axios from "axios";
import { Modal } from "bootstrap";

$(() => {
    const modalSearch = new Modal("#cadastrarBeneficiaria");
    const modalSucesso = new Modal("#sucessoModal");
    const modalErro = new Modal("#erroModal");
    var dadosMulher;

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

    $("#search-new").on("submit", function (e) {
        e.preventDefault();
        let formData = {
            tipoPesquisa: $("#tipo-search-new").val(),
            valorPesquisa: $("#search-value-new").val().replace(/\D/g, ""),
        };
        axios
            .post("/restrito/cadastros/search-new", formData)
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
                        "Pessoa não encontrada na base do CadÚnico"
                    );
                    modalErro.show();
                }
            });
    });
});
