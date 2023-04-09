<template>
    <div class="card bg-light ">
        <div class="card-header">
            <div class="d-flex flex-row justify-content-between" v-if="isAuth && this.$route.name == 'admin-panel-main' || this.$route.name == 'admin-popular'">
                <router-link :to="{ name: 'admin-update-article', query: { id: post._id } }">
                    <h2>
                        <strong>
                            {{ post.title }}
                        </strong>
                    </h2>
                </router-link>
                <div @click="deleteItem" v-if="this.$route.name == 'admin-panel-main'" class="fa-solid fa-xmark mt-2 fs-3"></div>
                <div v-else-if="this.$route.name == 'admin-popular'" class="fa-solid fa-eye ms-auto align-self-center">{{ post.views }}</div>
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
            isAuth: false,
        }
    },
    methods:{
        deleteItem(){
            this.$emit('deleteItem',this.post._id)
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
.fa-xmark:hover{
    opacity: 0.8;
    cursor: pointer;
}
</style>