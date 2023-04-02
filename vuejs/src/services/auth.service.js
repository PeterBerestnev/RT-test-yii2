import axios from "axios";

const authService = {
    user: null,
    async login(formData){
        try
        {   
            const {status,data} = await axios.post('http://localhost/api/user/login', formData)    
            if(status === 200)
            {
                this.setUser(data);
                return {success: true};
            }
        }
        catch(e)
        {
            return{ success: false, errors: e.response.data.errors };
        }
    },
    isLoggedIn(){
        return !!localStorage.getItem('ACCESS_TOKEN');
    },
    getToken(){
        return localStorage.getItem('ACCESS_TOKEN');
    },
    setUser(user){
        this.user = user;
        localStorage.setItem('ACCESS_TOKEN', user.access_token);
    }
};

export default authService;
