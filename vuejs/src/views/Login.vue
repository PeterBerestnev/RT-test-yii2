<template>
    <div class="my-wrap">
        <div class="login-box">
            <div class="login-logo">
                <router-link style="color:#3395ff; text-decoration:none" to="/"><b>GoodNews</b></router-link>
            </div>
            <!-- /.login-logo -->
            <div class="card">
                <div class="card-body login-card-body">
                    <h4 class="text-primary text-center"><b>Вход</b></h4>
                    <p class="login-box-msg">Авторизуйтесь для начала работы</p>

                    <form>
                        <div class="input-group mb-3">
                            <input v-model="email" type="email" class="form-control" placeholder="Email">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input v-model="password" type="password" class="form-control" placeholder="Пароль">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                        
                            <div class="col-4">
                                <button @click.prevent="login" type="submit"
                                    class="btn btn-primary btn-block">Войти</button>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>
                    <!-- /.social-auth-links -->



                </div>
            </div>
        </div>
    </div>
</template>
    
    
<script>
export default {
    name: 'my-login',
    data() {
        return {
            email: '',
            password: ''
        }
    },
    methods: {
        // login() {
        //     console.log(this.email)
        //     axios.post('/api/auth/login', { email: this.email, password: this.password })
        //         .then(res => {
        //             console.log(res);
        //         })
        // },

    },
}
</script>
    
<style>
.my-wrap {
    position: absolute;
    min-height: 300px;
    top: 0;
    width: 100%;
    height: 100vh;
    display: flex;
}

.login-box {
    align-self: center;
    position: absolute;
    left: 50%;
    margin-left: -180px;
}
</style>