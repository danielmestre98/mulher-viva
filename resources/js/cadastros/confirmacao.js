import $ from "jquery";
import Inputmask from "inputmask";
import "jquery-validation";
import "../assets/validation-defaults";
import axios from "axios";

$(() => {
    var cpfIm = new Inputmask("999.999.999-99");
    var nisIm = new Inputmask("999.99999.99.9");
    nisIm.mask("#nis");
    cpfIm.mask("#cpf");
    // $("#nis").

    axios.get("https://brasilapi.com.br/api/banks/v1").then(({ data }) => {
        data.forEach((element) => {
            if (element.code) {
                $("#banco").append(
                    `<option value="${element.code}">${element.fullName}</option>`
                );
            }
        });
    });

    $("#submit-benef").validate({
        rules: {
            criancaAbrig: {
                required: true,
            },
            adolecMedidaSocio: {
                required: true,
            },
            mulherCondDesacolh: {
                required: true,
            },
            anexoMedidaProt: {
                required: true,
                pdf: true,
            },
            anexoExamePsico: {
                required: true,
                pdf: true,
            },
            familiaTransfRenda: {
                required: true,
            },
        },
    });
});
