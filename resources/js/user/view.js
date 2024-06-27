import $ from "jquery";
import "jquery-validation";
import "../assets/validation-defaults";

$(() => {
    $("#form-edit-user").validate({
        submitHandler: () => {
            if (
                confirm(
                    "Deseja redefinir a senha desse usuário para o padrão (CPF)?"
                )
            ) {
                axios
                    .put(
                        `${process.env.APP_URL}/restrito/cadastros/usuarios/${$(
                            "#userIdEdit"
                        ).val()}`
                    )
                    .then(() => {
                        window.location.href =
                            process.env.APP_URL +
                            "/restrito/cadastros/usuarios";
                    });
            }
        },
    });
});
