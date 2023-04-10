<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Популярное</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Главная</li>
                    </ol>
                </div>
            </div>
        </div>
        {{ date }}
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
import { getYesterdayDate } from '@/scripts/getYesterday'
import ArticleList from '../../components/ArticleList.vue'
export default {
    name: "admin-popular",
    data() {
        return {
            articles: [],
            date: ""
        }
    },
    components: {
        ArticleList
    },
    async mounted() {
        let dateTime = getYesterdayDate()
        try {
            const { status, data } = await httpClient.get('articles', { params: { sort: "-views", status: "Опубликованно", date: dateTime } })
            if (status === 200) {
                this.articles = data
            }
        }
        catch (e) {
            console.log(e)
        }
    }
}
</script>