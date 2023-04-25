import axios from 'axios';
import authService from "./auth.service";
import router from '../router/index';

const API_ENDPOINT = process.env.VUE_APP_API_ENDPOINT || 'http://localhost:8080/';
let config = {
  baseURL: `${API_ENDPOINT}api/`
};

const httpClient = axios.create(config);

const authInterceptor = config => {
  config.headers.Authorization = `Bearer ${authService.getToken()}`;
  return config;
};

httpClient.interceptors.request.use(authInterceptor);

httpClient.interceptors.response.use(
  response => {

    return response;
  },
  error => {
    const originalRequest = error.config;
    const status = error.response ? error.response.status : false;
    let refresh = null;
    console.log(originalRequest)
    console.log(status)
    if (error.response.status === 401) {
        refresh = authService.refreshToken()
        console.log(refresh)
        router.push({ name: 'login' })
      
    }

    return Promise.reject(error);
  }
);

export default httpClient;