<template>
    <div class="card bg-light ">
        <div class="card-header">
            <div v-if="isAuth && this.$route.name == 'admin-panel-main'">
                <router-link :to="{ name: 'admin-update-article', query: { id: post._id } }">
                    <h2>
                        <strong>
                            {{ post.title }}
                        </strong>
                    </h2>
                </router-link>
            </div>
            <div v-else>
                <router-link :to="{ name: 'article-main', query: { id: post._id } }">
                    <h2>
                        <strong>
                            {{ post.title }}
                        </strong>
                    </h2>
                </router-link>
            </div>
        </div>

        <div class="d-flex flex-column card-body"><!--justify-content-between align-items-center-->

            <img class="rounded border image-fluid  " v-if="post.photo" :src="post.photo">
            <img v-else class="rounded border image-fluid  " src="../assets/no-photo-svgrepo-com.svg">
        </div>
    </div>
</template>
    
<script>
import authService from '../services/auth.service'
export default {
    props: {
        post: {
            type: Object,
            required: true,
        },
    },
    data(){
        return{
            isAuth: false
        }
    },
    mounted(){
        this.isAuth = authService.isLoggedIn()
    }
}
</script>
    
<style scoped>
.card:hover {
    scale: 1.02;
}
</style>