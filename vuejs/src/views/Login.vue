<template>
    <div class="my-wrap">
        <div class="login-box">
            <div class="login-logo">
                <router-link style="color:#3395ff; text-decoration:none" to="/"><b>GoodNews</b></router-link>
            </div>
            <div class="card">
                <div class="card-body login-card-body">
                    <h4 class="text-primary text-center"><b>Вход</b></h4>
                    <p v-if="errors == null" class="login-box-msg">Авторизуйтесь для начала работы</p>
                    <div class="alert alert-danger" v-else>
                        <div v-for="error in errors" :key="error">
                            {{ error[0] }}
                        </div>
                    </div>
                    <form>
                        <div class="input-group mb-3">
                            <input v-model="form.username" type="email" class="form-control" placeholder="Username">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fa-solid fa-user"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input v-model="form.password" type="password" class="form-control" placeholder="Password">
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
                </div>
            </div>
        </div>
    </div>
</template>
       
<script>
import authService from '../services/auth.service'

export default {
    name: 'my-login',
    data() {
        return {
            form: {
                username: '',
                password: '',
            },
            errors: null,
        }
    },
    methods: {
        async login() {
            const { success, errors } = await authService.login(this.form)
            if (success) {
                this.$router.push({ name: 'admin-panel-main' })
            }
            else {
                this.errors = errors
            }
        },
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