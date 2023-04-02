<template>
    <div class="card bg-light">
        <div class="d-flex flex-column"><!--justify-content-between align-items-center-->
                <router-link :to="{ name: 'article-main',  query:{ id: post._id }}"> <!--'/article?id='+post._id-->
                    <h4>
                        <strong>
                            {{post.title}}
                        </strong>
                    </h4>
                </router-link>
                <div>{{ post.status}}</div>
        </div>
    </div>    
</template>
    
<script>
    export default{
        props:{
            post:{
                type: Object,
                required: true,
            },
        },
    }
</script>
    
<style scoped>
.card{
    padding: 15px;
    background-color: rgba(0,0,0,0.2);
    margin-top: 15px;
    display: flex;
    justify-content: space-between;
}
.card:hover{
    scale: 1.02;
}

</style>