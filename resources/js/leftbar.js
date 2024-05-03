import { Modal } from "bootstrap";
import Toastify from "toastify-js";
import $ from "jquery";
import "jquery-validation";
import "./assets/validation-defaults";
import axios from "axios";

$(() => {
    const modalSenha = new Modal("#modalSenha");
    $(".menu-item-dropdown").on("click", "button", function () {
        const menu = $($(this).parent()).children()[1];
        $(".menu-item-button").not(this).removeClass("active");
        // $(".menu-item-dropdown button .fa-chevron-down")
        //     .not($(this).children()[2])
        //     .removeClass("fa-chevron-down")
        //     .addClass("fa-chevron-right");
        $(".box-dropdown").not(menu).slideUp();
        console.log($(this).children());
        $($(this).children("i")).toggleClass("fa-chevron-right");
        $($(this).children("i")).toggleClass("fa-chevron-down");
        $(this).toggleClass("active");
        $(menu).slideToggle();
    });
    $("#alterar-senha").on("click", function () {
        modalSenha.show();
    });
    $("#form-senha").validate({
        rules: {
            novaSenha: {
                required: true,
                minlength: 6,
            },
            confirmSenha: {
                required: true,
                equalTo: "#novaSenha",
            },
        },
        submitHandler: (form) => {
            console.log(form);
            const formData = { password: $("#novaSenha").val() };
            axios
                .put(
                    `/restrito/usuario/${$("#userId").val()}/alterar-senha`,
                    formData
                )
                .then(({ data }) => {
                    Toastify({
                        text: data.success,
                        duration: 3000,
                        newWindow: true,
                        close: true,
                        gravity: "top",
                        position: "right",
                        backgroundColor: "#28a745",
                        stopOnFocus: true,
                    }).showToast();
                    modalSenha.hide();
                });
        },
    });
    // $("#form-senha").on("submit", function (e) {
    //     e.preventDefault();
    //     var token = $('input[name="_token"]').attr("value");
    //     $.ajaxSetup({
    //         beforeSend: function (xhr) {
    //             xhr.setRequestHeader("X-CSRF-Token", token);
    //         },
    //     });
    //     $.ajax({
    //         type: "POST",
    //         url: "/api-service/alterar-senha",
    //         data: {
    //             senha: $("#novaSenha").val(),
    //         },
    //         success: function (response) {
    //             $("#modalSenha").modal("hide");
    //             $("#form-senha input").val("");
    //             $("#senha-alterada").show().delay(5000).fadeOut();
    //         },
    //     });
    // });
});
