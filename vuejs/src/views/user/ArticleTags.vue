<template>
    <Suspense>
        <div class="container-fluid ">
            <div class="content-header">
                <div class="row mb-2">
                    <div class="col-sm-6">
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right me-3">
                            <li class="breadcrumb-item"><router-link to="/">Главная</router-link></li>
                            <li class="breadcrumb-item active">{{ tags }}</li>
                        </ol>
                    </div>
                </div>
            </div>
            <ArticleList :posts="posts"></ArticleList>
            <Paginator v-if="posts.length!=0" :totalCount="totalCount" :size="size" @changePage="changePage">
            </Paginator>
        </div>
    </Suspense>
</template>
  
<script>
import { onMounted, ref } from "vue"
import httpClient from '@/services/http.service'
import ArticleList from '../../components/ArticleList.vue'
import Paginator from "../../components/Pagination.vue"

export default {
    name: 'ArticleTags',
    props: {
        tags: {
            type: String,
            required: false,
        },
    },
    components: {
        ArticleList,
        Paginator
    },
    setup(props) {
        const posts = ref([])
        const stat = ref([])
        const totalCount = ref([])
        const size = ref([])

        onMounted(async () => {

            await httpClient.get('article/get-count', { params: { status: "Опубликовано", tags: props.tags } }).then(res => {
                totalCount.value = res.data
            })
            await httpClient.get('settings/view', {params: {name: "user_page_size"}}).then(res => {
                size.value = res.data.value
            })

            if (props.tags) {
                const { status, data } = await httpClient.get('articles', { params: { status: "Опубликовано", tags: props.tags, limit: size.value, sort: '-date' } })

                if (status === 200) {
                    posts.value = data
                }
            }
        })
        return {
            posts, stat, totalCount, size
        }
    },
    methods: {
        async changePage(page) {
            const { status, data } = await httpClient.get('articles', { params: { status: "Опубликовано",tags: this.tags, limit: this.size, sort: '-date', page: page } })

            if (status === 200) {
                this.posts = data
            }
        },
    }
}
</script>
  