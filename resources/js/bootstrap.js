/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from "axios";
import "@popperjs/core";
window.axios = axios;
import "bootstrap";
import "./leftbar";
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

require("./user/checkPassword");

if (
    window.location.href ===
        `${process.env.APP_URL}/restrito/cadastros/beneficiarias` ||
    window.location.href.includes("/restrito/cadastros/beneficiarias/fitro/") ||
    window.location.href ===
        `${process.env.APP_URL}/restrito/cadastros/beneficiarias/filter`
) {
    require("./cadastros/pesquisa");
}
if (window.location.href === `${process.env.APP_URL}/restrito/lista`) {
    require("./cadastros/list");
}

if (
    window.location.href ===
    `${process.env.APP_URL}/restrito/cadastros/beneficiarias/dados-new`
) {
    require("./cadastros/confirmacao");
}
if (window.location.href.includes("/restrito/cadastros/beneficiarias/view/")) {
    require("./cadastros/view");
}
if (
    window.location.href ==
    `${process.env.APP_URL}/restrito/cadastros/usuarios/criar`
) {
    require("./user/create");
}

if (
    window.location.href == `${process.env.APP_URL}/restrito/cadastros/usuarios`
) {
    require("./user/list");
}

if (
    window.location.href.includes(
        `${process.env.APP_URL}/restrito/cadastros/usuarios/`
    )
) {
    require("./user/view");
}

if (
    window.location.href ==
    `${process.env.APP_URL}/restrito/cadastros/judicializacoes`
) {
    require("./judicializacao/index");
}

if (
    window.location.href ==
    `${process.env.APP_URL}/restrito/cadastros/judicializacoes/create`
) {
    require("./judicializacao/create");
}

if (window.location.href == `${process.env.APP_URL}/restrito/listas`) {
    require("./cadastros/listAll");
}

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// import Pusher from 'pusher-js';
// window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
//     wsHost: import.meta.env.VITE_PUSHER_HOST ? import.meta.env.VITE_PUSHER_HOST : `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
//     wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
//     wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
//     forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
//     enabledTransports: ['ws', 'wss'],
// });
