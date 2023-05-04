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
    if (error.response.status === 401) {
      authService.refreshToken().then(()=>{
        if (!authService.isLoggedIn()) {
          console.log('some error accured!')
          router.push({ name: 'login' })
        }
        else {
          console.log('Request has been send')
          return new Promise((resolve, reject) => {
            originalRequest.headers["Authorization"] = 'Bearer ' + authService.getToken();
            axios(originalRequest)
              .then(response => {
                resolve(response);
                router.go(0)
                localStorage.setItem('toastrMessage', 'Вы били переавторизованы, последняя операция завершена успешно!');
              })
              .catch(error => {
                getToastr().error(error.response.data[0].message);
                reject(error);
              });
          });
        }
      })
    }
  
    return Promise.reject(error);
  });

export default httpClient;