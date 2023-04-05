<template>
    <div class="container">
        <div class="card mt-4">
            <div class="card-header">
                <h1>{{ post.title }}</h1>
            </div>
            <div class="card-body">
                <img  v-if = "post.photo" class="rounded img-fluid border w-100" :src="post.photo">
                <img  v-else  class="rounded img-fluid border w-100" src="../../assets/no-photo-svgrepo-com.svg">
                <div class="mt-3">
                    <span v-html="post.text"> </span>
                </div>
                
            </div>
            <div class="card-footer">
                <div>Дата: {{post.date}}</div>
                <div class="d-flex flex-row">Теги:
                    <div  v-for="tag in post.tags" :key="tag">
                        <router-link to="/">#{{ tag }}</router-link>
                        &nbsp;
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import httpClient from '@/services/http.service'
export default {
    name: "article-main",
    props: {
        id: {
            type: String,
            required: true,
        },

    },
    data() {
        return {
            post: [],
        }
    },
    async mounted() {
        const { status, data } = await httpClient.get('article/view', { params: { id: this.id } })
        if (status === 200) {
            this.post = data
        }
    }
}

</script>

<style scoped>

</style>