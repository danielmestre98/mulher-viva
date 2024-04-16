import $ from "jquery";
import axios from "../assets/axiosInstance";
import { Modal } from "bootstrap";
import "jquery-validation";
import "../assets/validation-defaults";

$(() => {
    axios
        .get(`${process.env.APP_URL}/restrito/check-password`)
        .then(({ data }) => {
            if (data) resetPassword();
        });

    const resetPassword = async () => {
        const modal = new Modal("#modalResetPassword");
        modal.show();

        $("#form-senha-reset").validate({
            rules: {
                novaSenhaReset: {
                    required: true,
                    minlength: 6,
                },
                confirmSenhaReset: {
                    required: true,
                    minlength: 6,
                    equalTo: "#novaSenhaReset",
                },
            },
        });
    };
});
