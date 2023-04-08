<template>
  <Suspense>
    <div class="container-fluid ">
      <div v-if="tags"  class="content-header">

            <div class="row mb-2">
                <div class="col-sm-6">
            
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right me-3">
                        <li class="breadcrumb-item"><router-link to="/">Главная</router-link></li>
                        <li class="breadcrumb-item active">{{ tags }}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->

    </div>
      <ArticleList :posts="posts">

      </ArticleList>
    </div>
  </Suspense>
</template>

<script>
import { defineComponent, onMounted, ref } from "vue";
import httpClient from '@/services/http.service'
import ArticleList from '../../components/ArticleList.vue'

export default defineComponent({
  name: 'HomeView',
  data() {
    return {
      componentKey: 0,
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
        const { status, data } = await httpClient.get('articles', { params: { status: "Опубликованно", tags: props.tags,limit: (await httpClient.get('settings/view')).data.count, sort:'-date' } })
        if (status === 200) {
          posts.value = data
        }
      }
      else {
        const { status, data } = await httpClient.get('articles', { params: { status: "Опубликованно", limit: (await httpClient.get('settings/view')).data.count, sort:'-date'} })
        if (status === 200) {
          posts.value = data
        }
      }

    })
    return {
      posts, stat
    }
  },
  watch: {
    tags: async function (newVal) { // watch it
      if (typeof newVal === 'undefined') {
        const { status, data } = await httpClient.get('articles', { params: { status: "Опубликованно",limit: (await httpClient.get('settings/view')).data.count, sort:'-date' } })
        if (status === 200) {
          this.posts = data
        }
      }
    }

  },
})
</script>
