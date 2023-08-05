import axios from 'axios';
import authService from "./auth.service";
import router from '../router/index';
import { getToastr } from '../scripts/toastr'

const API_ENDPOINT = process.env.VUE_APP_URL;
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
  async (response) => {
    return response;
  },
  async (error) => {
    const originalRequest = error.config;

    if (error.config.url === '/auth/refresh') {
      console.log('REDIRECT TO LOGIN');
      authService.logout();
      router.push({ name: 'login' });
    }
    if (error.response.status === 401) {
      try {
        await authService.refreshToken();

        if (!authService.isLoggedIn()) {
          console.log('some error occurred!');
          router.push({ name: 'login' });
        } else {
          originalRequest.headers["Authorization"] = 'Bearer ' + authService.getToken();
          const response = await axios(originalRequest);
          return response;
        }
      } catch (error) {
        getToastr.error(error.response.data[0].message);
        return Promise.reject(error);
      }
    }

    return Promise.reject(error);
  });

export default httpClient;