<template>
    <div class="card bg-light ">
        <div class="card-header">
            <div class="d-flex flex-row justify-content-between"
                v-if="isAuth && this.$route.name == 'admin-panel-main' || this.$route.name == 'admin-popular'">
                <router-link class="sl-none" :to="{ name: 'admin-update-article', query: { id: post._id } }">
                    <h2 class="text-break">
                        <strong>
                            {{ post.title }}
                        </strong>
                    </h2>
                </router-link>
                <div @click="deleteItem" v-if="this.$route.name == 'admin-panel-main'" class="fa-solid fa-xmark mt-2 fs-3">
                </div>
                <div v-else-if="this.$route.name == 'admin-popular'" class="fa-solid fa-eye align-self-center d-flex ms-2">
                    <div class="ms-1">{{ post.views }}</div>
                </div>
            </div>
            <div v-else>
                <router-link class="sl-none" :to="{ name: 'article-main', query: { id: post._id } }">
                    <h2>
                        <strong>
                            {{ post.title }}
                        </strong>
                    </h2>
                </router-link>
            </div>
        </div>
        <div class="d-flex flex-column card-body"><!--justify-content-between align-items-center-->
            <img class="rounded border image-fluid sl-none" v-if="post.photo" :src="img+post.photo">
            <img style="max-height:270px" v-else class="rounded border image-fluid sl-none" src="../assets/no-photo-svgrepo-com.svg">
        </div>
        <div class="card-footer d-flex flex-column" v-if="isAuth && this.$route.name == 'admin-panel-main' || this.$route.name == 'admin-popular'">
            <div :class="{ active: post.status == 'Опубликовано', 'text-danger': post.status != 'Опубликовано' }">{{ post.status }}</div>
            <div v-if="post.status == 'Опубликовано'" >{{ date }}</div>
        </div>
    </div>
</template>
    
<script>
import authService from '../services/auth.service'
import {convertData} from '../scripts/convertData'

export default {
    props: {
        post: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            isAuth: false,
            errorClass: 'notPublished',
            img: process.env.VUE_APP_IMG_URL ,
            date: ''
        }
    },
    methods: {
        deleteItem() {
            this.$emit('deleteItem', this.post._id)
        },
    },
    mounted() {
        this.isAuth = authService.isLoggedIn()
        this.date = convertData(this.post).date
    },
    // watch:{
    //     post: function(newVal, oldVal){
    //         if (newVal != oldVal){
    //             this.date = convertData(this.post).date
    //         }
    //     }
    // }
}
</script>
    
<style scoped> 
.fa-xmark:hover {
    opacity: 0.8;
    cursor: pointer;
}
.active{
    color: green
}
</style>