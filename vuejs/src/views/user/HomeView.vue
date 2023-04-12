<template>
  <div class="container-fluid ">
    <ArticleList :posts="posts"></ArticleList>

    <Paginator :size="posts.length" :listData="totalArr" @changePage="changePage">
    </Paginator>



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
    const totalArr = ref([])

    onMounted(async () => {
      await httpClient.get('article/get-count').then(res => {
            for (let i = 1; i <= res.data; i++) {
              totalArr.value.push(i)
            }
      })

      const { status, data } = await httpClient.get('articles', { params: { status: "Опубликованно", limit: (await httpClient.get('settings/view')).data.count, sort: '-date' } })

      if (status === 200) {
        posts.value = data
      }
    })

    return {
      posts, stat, totalArr
    }
  },
  methods: {
    async changePage(page) {
      const { status, data } = await httpClient.get('articles', { params: { status: "Опубликованно", limit: (await httpClient.get('settings/view')).data.count, sort: '-date', page: page } })

      if (status === 200) {
        this.posts = data
      }
    },
  }
}
</script>
