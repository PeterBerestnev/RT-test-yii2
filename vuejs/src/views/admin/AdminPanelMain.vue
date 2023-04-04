<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Новости</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><router-link to="/">Главная</router-link></li>
                        <li class="breadcrumb-item active">Новости</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div>
            <ArticleList :posts="articles">
            </ArticleList>
        </div>
    </section>
</template>

<script>
import httpClient from '@/services/http.service'
import ArticleList from '../../components/ArticleList.vue'
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