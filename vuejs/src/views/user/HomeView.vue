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
import { getToastr } from "@/scripts/toastr";

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
      await httpClient.get('article/get-count', { params: { status:"Опубликовано"} }).then(res => {
            totalCount.value = res.data
      })
      try{
        await httpClient.get('settings/view', {params: {name: "user_page_size"}}).then(res => {
        size.value = res.data.value
      })
      } catch(e) {
        getToastr().error(e.response.data[0].message)
      }
      
      const { status, data } = await httpClient.get("articles", { params: { status: "Опубликовано", limit: size.value, sort: "-date" } })

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
      const { status, data } = await httpClient.get('articles', { params: { status: "Опубликовано", limit: this.size, sort: '-date', page: page } })

      if (status === 200) {
        this.posts = data
      }
    },
  }
}
</script>
