<template>
  <div class="container-fluid ">
    <ArticleList :posts="posts"></ArticleList>
  </div>
</template>

<script>
import { onMounted, ref } from "vue";
import httpClient from '@/services/http.service'
import ArticleList from '../../components/ArticleList.vue'

export default {
  name: 'HomeView',
  components: {
    ArticleList
  },
  setup() {
    const posts = ref([])
    const stat = ref([])

    onMounted(async () => {
      const { status, data } = await httpClient.get('articles', { params: { status: "Опубликованно", limit: (await httpClient.get('settings/view')).data.count, sort: '-date' } })

      if (status === 200) {
        posts.value = data
      }
    })
    return {
      posts, stat
    }
  },
}
</script>
