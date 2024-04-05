import $ from "jquery";
import { Modal } from "bootstrap";
import "jquery-validation";
import "../assets/validation-defaults";

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
});
