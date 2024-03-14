import $ from "jquery";
$.validator.setDefaults({
    highlight: function (element) {
        $(element).closest(".form-control").addClass("is-invalid");
        $(element).closest(".form-select").addClass("is-invalid");
    },
    unhighlight: function (element) {
        $(element).closest(".form-control").removeClass("is-invalid");
        $(element).closest(".form-select").removeClass("is-invalid");
        $(element).closest(".form-control").addClass("is-valid");
        $(element).closest(".form-select").addClass("is-valid");
    },
    submitHandler: function (form) {
        $(":submit").attr("disabled", "disabled");
        return ($this) => form;
    },
    errorElement: "span",
    errorClass: "invalid-feedback",
    errorPlacement: function (error, element) {
        if (element.parent(".input-group").length) {
            error.insertAfter(element.parent());
        } else if (element.hasClass("select2-hidden-accessible")) {
            error.insertAfter(element.next("span.select2"));
        } else if (element.hasClass("form-check-input")) {
            error.insertAfter($(element[0]).parent().parent());
        } else {
            error.insertAfter(element);
        }
    },
});
$.extend($.validator.messages, {
    required: "Este campo é necessário.",
    remote: "Please fix this field.",
    email: "Por favor, insira um endereço de email válido.",
    url: "Please enter a valid URL.",
    date: "Please enter a valid date.",
    dateISO: "Please enter a valid date (ISO).",
    number: "Please enter a valid number.",
    digits: "Please enter only digits.",
    creditcard: "Please enter a valid credit card number.",
    equalTo: "As senhas não coincidem.",
    accept: "Por favor, escolha uma extensão válida.",
    maxlength: $.validator.format("Please enter no more than {0} characters."),
    minlength: $.validator.format(
        "Por favor preencha pelo menos {0} caracteres."
    ),
    rangelength: $.validator.format(
        "Please enter a value between {0} and {1} characters long."
    ),
    range: $.validator.format("Please enter a value between {0} and {1}."),
    max: $.validator.format("Please enter a value less than or equal to {0}."),
    min: $.validator.format(
        "Please enter a value greater than or equal to {0}."
    ),
});

$.validator.addMethod(
    "cpf",
    function (value, element) {
        value = $.trim(value);

        value = value.replace(".", "");
        value = value.replace(".", "");
        cpf = value.replace("-", "");
        while (cpf.length < 11) cpf = "0" + cpf;
        var expReg = /^0+$|^1+$|^2+$|^3+$|^4+$|^5+$|^6+$|^7+$|^8+$|^9+$/;
        var a = [];
        var b = new Number();
        var c = 11;
        for (i = 0; i < 11; i++) {
            a[i] = cpf.charAt(i);
            if (i < 9) b += a[i] * --c;
        }
        if ((x = b % 11) < 2) {
            a[9] = 0;
        } else {
            a[9] = 11 - x;
        }
        b = 0;
        c = 11;
        for (y = 0; y < 10; y++) b += a[y] * c--;
        if ((x = b % 11) < 2) {
            a[10] = 0;
        } else {
            a[10] = 11 - x;
        }

        var retorno = true;
        if (
            cpf.charAt(9) != a[9] ||
            cpf.charAt(10) != a[10] ||
            cpf.match(expReg)
        )
            retorno = false;

        return this.optional(element) || retorno;
    },
    "Informe um CPF válido."
);

$.validator.addMethod(
    "cnpj",
    function (value, element) {
        cnpj = value.replace(/[^\d]+/g, "");
        if (cnpj == "") return false;
        if (cnpj.length != 14) return false;
        // Elimina CNPJs invalidos conhecidos
        if (
            cnpj == "00000000000000" ||
            cnpj == "11111111111111" ||
            cnpj == "22222222222222" ||
            cnpj == "33333333333333" ||
            cnpj == "44444444444444" ||
            cnpj == "55555555555555" ||
            cnpj == "66666666666666" ||
            cnpj == "77777777777777" ||
            cnpj == "88888888888888" ||
            cnpj == "99999999999999"
        )
            return false;

        // Valida DVs
        tamanho = cnpj.length - 2;
        numeros = cnpj.substring(0, tamanho);
        digitos = cnpj.substring(tamanho);
        soma = 0;
        pos = tamanho - 7;
        for (i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2) pos = 9;
        }
        resultado = soma % 11 < 2 ? 0 : 11 - (soma % 11);
        if (resultado != digitos.charAt(0)) return false;

        tamanho = tamanho + 1;
        numeros = cnpj.substring(0, tamanho);
        soma = 0;
        pos = tamanho - 7;
        for (i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2) pos = 9;
        }
        resultado = soma % 11 < 2 ? 0 : 11 - (soma % 11);
        var retorno = true;
        if (resultado != digitos.charAt(1)) retorno = false;

        return this.optional(element) || retorno;
    },
    "Informe um CNPJ válido."
);

$.validator.addMethod(
    "greaterThan",
    function (value, element, params) {
        if (!/Invalid|NaN/.test(new Date(value))) {
            return new Date(value) >= new Date($(params).val());
        }

        return (
            (isNaN(value) && isNaN($(params).val())) ||
            Number(value) >= Number($(params).val())
        );
    },
    "A data precisa ser maior ou igual que a data de início."
);
