import router from "@/router";
import axios from "axios"

const axiosInstance = axios.create({
    withCredentials: true,
  });

const authService = {
    user: null,
    async login(formData) {
        try {
            console.log(process.env)
            const { status, data } = await axiosInstance.post(process.env.VUE_APP_URL+'api/user/login', formData, { headers: { "Content-Type": " multipart/form-data" }})
            if (status === 200) {
                this.setUser(data)
                return { success: true }
            }
        }
        catch (e) {
            if(!e.response || e.response.status === 500){
    
                return { success: false, errors: [['Ошибка сервера, повторите попытку позже']]}
            }
            
            return { success: false, errors: e.response.data.errors }
        }
    },
    async refreshToken() {
        try {
            const { status, data } = await axiosInstance.post('http://localhost:8080/api/user/refresh-token')
            if (!data.statusCode  && status === 200) {
                this.logout()
                this.setUser(data)
                return { success: true }
            }
            else{
                this.logout()
                router.push('login')
            }
        }
        catch (e) {
            this.logout()
            return { success: false, errors: e.response.data.errors }
        }
    },
    isLoggedIn() {
        return !!localStorage.getItem('ACCESS_TOKEN')
    },
    getToken() {
        return localStorage.getItem('ACCESS_TOKEN')
    },
    setUser(user) {
        this.user = user
        localStorage.setItem('ACCESS_TOKEN', user.token);
    },
    logout() {
        localStorage.removeItem('ACCESS_TOKEN')
    }
};

export default authService;
