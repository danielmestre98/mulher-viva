import $ from "jquery";
import { Modal } from "bootstrap";
import "jquery-validation";
import "../assets/validation-defaults";
import axios from "../assets/axiosInstance";
import prepareMultipartFormData from "../assets/formHelper";

$(() => {
    $("#approve-submit").on("click", () => {
        const modal = new Modal("#confirmApprove");
        modal.show();
    });

    $("#deny-submit").on("click", () => {
        const modal = new Modal("#confirmDeny");
        modal.show();
    });

    $("#deny-form").validate({
        rules: {
            "motivo-recusa": {
                required: true,
                minlength: 10,
            },
        },
    });
    if ($("#allowChange").get(0)) {
        const modalChange = new Modal("#allowChange");

        $("#allowChangeButton").on("click", () => {
            modalChange.show();
        });

        $("#add-edit-form").validate({
            submitHandler: (form) => {
                const action = $(form).attr("action");
                var inputs = {};
                $(form)
                    .find("input:checked")
                    .each(function () {
                        inputs[$(this).attr("name")] = $(this).attr("value");
                    });
                console.log(inputs);
                axios.post(action, inputs).then(({ data }) => {
                    $("#action-text").html("Permissão concedida.");
                    modalChange.hide();
                    $("#liveAlertPlaceholder .alert").fadeIn();
                    setTimeout(function () {
                        $("#liveAlertPlaceholder .alert").fadeOut();
                    }, 5000);
                    $(form).trigger("reset");
                });
            },
        });
    }
    $("#edit-benef").validate({
        submitHandler: (form) => {
            const segments = window.location.href.split("/");
            const beneficiaria = segments.pop();
            const inputs = $(form)
                .find(
                    "input:not(:disabled):not(:hidden):not(:radio):not([readonly]), input[type='radio']:checked:not([disabled])"
                )
                .toArray();
            const formData = prepareMultipartFormData(inputs);
            console.log(formData);
            axios
                .post(
                    `${process.env.APP_URL}/restrito/cadastros/beneficiarias/view-edit/${beneficiaria}`,
                    formData,
                    {
                        headers: {
                            "Content-Type": "multipart/form-data",
                        },
                    }
                )
                .then(() => {
                    window.location.reload();
                });
        },
    });

    $("#delete-benef").on("click", function () {
        const modal = new Modal("#confirmDelete");
        modal.show();
    });

    $("#delete-form").validate({
        rules: {
            motivo_delete: {
                required: true,
                minlength: 10,
            },
        },
        submitHandler: (form) => {
            const motivo = $("#motivo_delete").val();
            const route = $(form).attr("action");
            axios
                .delete(route, {
                    data: { motivo: motivo },
                })
                .then(() => {
                    window.location.href = `${process.env.APP_URL}/restrito/cadastros/beneficiarias?action=success`;
                });
            console.log(route);
        },
    });
});
