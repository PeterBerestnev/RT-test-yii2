<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Новости</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Главная</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div>
            <ArticleList 
            :posts="articles"
            @deleteItem="deleteItem"
            >
            </ArticleList>
        </div>
    </section>
</template>

<script>
import httpClient from '@/services/http.service'
import ArticleList from '../../components/ArticleList.vue'
export default {
    name: "admin-panel-main",
    data() {
        return {
            articles: []
        }
    },
    methods:{
        async deleteItem(dataToDelete){
            try{
                await httpClient.delete('article/delete',{params:{id:dataToDelete}})
                const { status, data } = await httpClient.get('articles')
                if (status === 200) {
                    this.articles = data
                }
            }
            catch(e){
                console.log(e)
            }       
        }
    },
    components: {
        ArticleList
    },
    async mounted() {
        try{
            const { status, data } = await httpClient.get('articles')
            if (status === 200) {
                this.articles = data
            }
        }
        catch(e){
            console.log(e)
        }
    }
}
</script>

<style></style>