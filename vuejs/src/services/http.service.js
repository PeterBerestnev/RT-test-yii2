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

    if (error.config.url === '/auth/refresh-token') {
      console.log('REDIRECT TO LOGIN');
      authService.logout()
      router.push({ name: 'login' })
    }

    console.log(originalRequest)

    if (error.response.status === 401) {
      authService.refreshToken()
      if (!authService.isLoggedIn()) {
        console.log('some error acured!')
        router.push({ name: 'login' })
      }
      else {
        console.log('Request has been send')
        return new Promise(resolve => {
          // Replace the expired token with the new token and retry the original request
          originalRequest.headers["Authorization"] = 'Bearer ' + authService.getToken();
          resolve(axios(originalRequest));
        });
      }

    }

    return Promise.reject(error);
  }
);

export default httpClient;