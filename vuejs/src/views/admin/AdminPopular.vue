<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Популярное</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Главная</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
        {{ date }}
    </div>
    <section class="content">
        <div>
            <ArticleList 
            :posts="articles"
            >
            </ArticleList>
        </div>
    </section>
</template>

<script>
import httpClient from '@/services/http.service'
import ArticleList from '../../components/ArticleList.vue'
export default {
    name: "admin-popular",
    data() {
        return {
            articles: [],
            date: ""
        }
    },

    components: {
        ArticleList
    },
    async mounted() {
        const today = new Date();
                    let date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
                    const time = today.getHours() + ":" + today.getMinutes();
                    date = date.split('-').reverse().join(".")
                    const dateTime = date +' '+ time;
                    this.date = dateTime
        try{
            const { status, data } = await httpClient.get('articles',{ params: { sort: "-views", status: "Опубликованно" } })
            if (status === 200) {
                console.log(data)
                this.articles = data
            }
        }
        catch(e){
            console.log(e)
        }
    }
}
</script>