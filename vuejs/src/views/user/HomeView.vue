<template>
  <div class="container-fluid ">
    <ArticleList :posts="posts"></ArticleList>
    <Paginator v-if="totalCount" :size="posts.length" :listData="totalCount " ></Paginator>
  </div>
</template>

<script>
import { onMounted, ref } from "vue";
import httpClient from "@/services/http.service"
import ArticleList from "../../components/ArticleList.vue"
import Paginator from "../../components/Pagination.vue"

export default {
  name: 'HomeView',
  components: {
    ArticleList,
    Paginator
  },
  setup() {
    const posts = ref([])
    const stat = ref([])
    const totalCount = ref([])
    
    onMounted(async () => {
      const { count } = await httpClient.get('article/get-count')
      totalCount.value = count
      const { status, data } = await httpClient.get('articles', { params: { status: "Опубликованно", limit: (await httpClient.get('settings/view')).data.count, sort: '-date' } })

      if (status === 200) {
        posts.value = data
      }
    })
    
    return {
      posts, stat, totalCount
    }
  },
}
</script>
