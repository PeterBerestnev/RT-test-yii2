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
        </div>
    </Suspense>
</template>
  
<script>
import { onMounted, ref } from "vue";
import httpClient from '@/services/http.service'
import ArticleList from '../../components/ArticleList.vue'

export default {
    name: 'ArticleTags',
    data() {
        return {
        }
    },
    props: {
        tags: {
            type: String,
            required: false,
        },
    },
    components: {
        ArticleList
    },
    setup(props) {
        const posts = ref([])
        const stat = ref([])
        onMounted(async () => {
            if (props.tags) {
                const { status, data } = await httpClient.get('articles', { params: { status: "Опубликованно", tags: props.tags, limit: (await httpClient.get('settings/view')).data.count, sort: '-date' } })
                if (status === 200) {
                    posts.value = data
                }
            }
        })
        return {
            posts, stat
        }
    },
}
</script>
  