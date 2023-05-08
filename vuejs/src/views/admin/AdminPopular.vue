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
    <section  class="content">
        <div>
            <ArticleList :posts="articles"></ArticleList>
        </div>
            <Paginator v-if="loaded"
            :totalCount="totalCount" 
            :size="size" 
            @changePage="changePage">
            </Paginator>
            <div class="d-flex justify-content-center">
                <Spinner class="align-self-center" v-if="!loaded" />
            </div>
    </section>
   
</template>

<script>
import httpClient from "@/services/http.service"
import { getYesterdayDate } from "@/scripts/getYesterday"
import ArticleList from "../../components/ArticleList.vue"
import Paginator from "../../components/Pagination.vue"
import Spinner from "../../components/Spinner.vue"
import { getToastr } from "@/scripts/toastr"

export default {
    name: "admin-popular",
    data() {
        return {
            articles: [],
            date: "",
            totalCount: 0,
            size: 0,
            loaded: false
        }
    },
    components: {
        ArticleList,
        Paginator,
        Spinner
    },
    async mounted() {
            
        await httpClient.get('article/get-count', { params: { date: true } }).then(res => {
            this.totalCount = res.data
        })

        try {
            const { status, data } = await httpClient.get('settings/view', { params: { name: 'admin_page_size' } })
            if (status === 200) {
                this.size = data.value
            }
        } catch (e) {
            if (e.response.data.status != 401) {
                getToastr().error(e.response.data[0].message)
            }
        }
        try {
            const { status, data } = await httpClient.get('articles', { params: { sort: "views", status: "", date: getYesterdayDate(), limit: this.size } })
            if (status === 200) {
                this.articles = data
                this.loaded = true
            }
        }
        catch (e) {
            console.log(e)
        }
    },
    methods: {
        async changePage(page) {
            const { status, data } = await httpClient.get('articles', { params: { sort: "views", limit: this.size,date: true ,page: page } })

            if (status === 200) {
                this.articles = data
            }
        },
    },
}
</script>