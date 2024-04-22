import $ from "jquery";
import Inputmask from "inputmask";
import "jquery-validation";
import "../assets/validation-defaults";

$(() => {
    const cpfIm = new Inputmask("999.999.999-99");
    const rgIm = new Inputmask("99.999.999-9");

    cpfIm.mask($("#cpf").get(0));
    rgIm.mask($("#rg").get(0));

    $("#form-judicializacao").validate({
        rules: {
            nome: {
                required: true,
            },
            cpf: {
                required: true,
                cpf: true,
            },
            rg: {
                required: true,
            },
            municipio: {
                required: true,
            },
            numero_processo: {
                required: true,
            },
            data_processo: {
                required: true,
            },
            anexoDespacho: {
                required: true,
                pdf: true,
            },
        },
    });
});
