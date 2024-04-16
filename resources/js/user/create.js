import $ from "jquery";
import Inputmask from "inputmask";
import "jquery-validation";
import "../assets/validation-defaults";

$(() => {
    const cpfIm = new Inputmask("999.999.999-99");
    cpfIm.mask($("#cpf").get(0));

    $("#form-new-user").validate({
        rules: {
            nome: {
                required: true,
            },
            cpf: {
                cpf: true,
                required: true,
            },
            email: {
                required: true,
                email: true,
            },
            password: {
                required: true,
                minlength: 6,
            },
            municipio: {
                required: true,
            },
            confirmPassword: {
                required: true,
                minlength: 6,
                equalTo: "#password",
            },
        },
    });
});
