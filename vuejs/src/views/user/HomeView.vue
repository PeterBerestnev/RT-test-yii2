<template>
  <div class="container-fluid mt-5">
    <ArticleList :posts="articles">

    </ArticleList>
  </div>
</template>

<script>
import httpClient from '@/services/http.service'
import ArticleList from '../../components/ArticleList.vue'
export default {
  name: 'HomeView',
  props: {
    tags: {
      type: String,
      required: false,
    },
  },
  data() {
    return {
      articles: []
    }
  },
  components: {
    ArticleList
  },
  async mounted() {
    console.log(this.tags)
    const { status, data } = await httpClient.get('articles', { params: { status: "Опубликованно", tags: this.tags } })
    if (status === 200) {
      this.articles = data
    }
  }
}
</script>
