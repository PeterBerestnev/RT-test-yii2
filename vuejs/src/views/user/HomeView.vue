<template>
  <div class="container-fluid ">
    <ArticleList :posts="posts"></ArticleList>
    <div v-if="posts.length!=0">
      <Paginator 
      :totalCount="totalCount" 
      :size="size"
      @changePage="changePage">
      </Paginator>
    </div>
    



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
    Paginator,
  },
  setup() {
    const posts = ref([])
    const stat = ref([])
    const totalCount = ref([])
    const size = ref([])

    onMounted(async () => {
      await httpClient.get('article/get-count', { params: { status:"Опубликованно", tags: "" } }).then(res => {
            totalCount.value = res.data
      })
      await httpClient.get('settings/view').then(res => {
        size.value = res.data.count
      })
      const { status, data } = await httpClient.get("articles", { params: { status: "Опубликованно", limit: size.value, sort: "-date" } })

      if (status === 200) {
        posts.value = data
      }
    })

    return {
      posts, stat, totalCount, size
    }
  },
  methods: {
    async changePage(page) {
      const { status, data } = await httpClient.get('articles', { params: { status: "Опубликованно", limit: this.size, sort: '-date', page: page } })

      if (status === 200) {
        this.posts = data
      }
    },
  }
}
</script>
