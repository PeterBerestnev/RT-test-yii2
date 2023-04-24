import axios from 'axios';
import authService from "./auth.service";

const API_STATUS_UNAUTHORIZED = 401;

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

let isRefreshing = false;
let refreshSubscribers = [];

const subscribeTokenRefresh = (cb) => {
  refreshSubscribers.push(cb);
};

const onRefreshed = (token) => {
  console.log("refreshing ", refreshSubscribers.length, " subscribers");
  refreshSubscribers.map(cb => cb(token));
  refreshSubscribers = [];
};

httpClient.interceptors.response.use(
  response => {
    return response;
  },
  error => {
    const status = error.response ? error.response.status : false;
    const originalRequest = error.config;

    if (error.config.url === '/auth/refresh-token') {
      console.log('REDIRECT TO LOGIN');
      store.dispatch("logout").then(() => {
          isRefreshing = false;
      });
    }

    if (status === API_STATUS_UNAUTHORIZED) {
      if (!isRefreshing) {
        isRefreshing = true;
        console.log('dispatching refresh');
        store.dispatch("refreshToken").then(newToken => {
          isRefreshing = false;
          onRefreshed(newToken);
        }).catch(() => {
          isRefreshing = false;
        });
      }

      return new Promise(resolve => {
        subscribeTokenRefresh(token => {
          // replace the expired token and retry
          originalRequest.headers["Authorization"] = "Bearer " + token;
          resolve(axios(originalRequest));
        });
      });
    }
    return Promise.reject(error);
  }
);

export default httpClient;