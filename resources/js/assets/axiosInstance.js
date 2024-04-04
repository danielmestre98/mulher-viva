import axios from "axios";

// Cria uma instância do Axios
const instance = axios.create();

// Adiciona um interceptor de solicitação
instance.interceptors.request.use((config) => {
    config.baseURL = process.env.APP_URL;
    return config;
});

export default instance;
