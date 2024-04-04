import $ from "jquery";
import Inputmask from "inputmask";
import "jquery-validation";
import "../assets/validation-defaults";

$(() => {
    var cpfIm = new Inputmask("999.999.999-99");
    var nisIm = new Inputmask("999.99999.99.9");
    nisIm.mask("#nis");
    cpfIm.mask("#cpf");
    // $("#nis").

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
