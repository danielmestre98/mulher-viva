import $ from "jquery";
import "jquery-validation";
import "../assets/validation-defaults";

$(() => {
    $("#form-edit-user").validate({
        rules: {
            password: {
                required: true,
                minlength: 6,
            },
            confirmPassword: {
                required: true,
                minlength: 6,
                equalTo: "#password",
            },
        },
        submitHandler: () => {
            const formData = { password: $("#password").val() };
            axios
                .put(
                    `${process.env.APP_URL}/restrito/cadastros/usuarios/${$(
                        "#userId"
                    ).val()}`,
                    formData
                )
                .then(() => {
                    window.location.href =
                        process.env.APP_URL + "/restrito/cadastros/usuarios";
                });
        },
    });
});
