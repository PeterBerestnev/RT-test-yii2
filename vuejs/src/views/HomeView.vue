<template>
  <ArticleList
  :posts="articles"
  >

  </ArticleList>
</template>

<script>
import httpClient from '@/services/http.service'
import ArticleList from '../components/ArticleList.vue'
export default {
  name: 'HomeView',
  data(){
    return{
      articles: []
    }
  },
  components:{
    ArticleList
  },
  async mounted(){
    const {status, data} = await httpClient.get('articles')
    if (status === 200){
      this.articles = data
    }
  }
}
</script>
