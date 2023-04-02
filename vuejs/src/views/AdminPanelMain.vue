<template>
    <div class="d-flex flex-column">
        <div class="alert alert-info">
            <h1>Main page of admin panel</h1>
        </div>
        <ArticleList :posts="articles">
        </ArticleList>
    </div>
</template>

<script>
import httpClient from '@/services/http.service'
import ArticleList from '../components/ArticleList.vue'
export default {
    name: "admin-panel-main",
    data() {
        return {
            articles: []
        }
    },
    components: {
        ArticleList
    },
    async mounted() {
        const { status, data } = await httpClient.get('articles')
        if (status === 200) {
            this.articles = data
        }
    }
}
</script>

<style></style>