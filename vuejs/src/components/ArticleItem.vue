<template>
    <div class="card bg-light">
        <div class="card-header">
            <router-link :to="{ name: 'article-main', query: { id: post._id } }"> <!--'/article?id='+post._id-->
            <h2>
                <strong>
                    {{ post.title }}
                </strong>
            </h2>
        </router-link>
        </div>

        <div class="d-flex flex-column card-body"><!--justify-content-between align-items-center-->

            <img class="rounded border image-fluid" v-if="post.photo" :src="post.photo">
            <img v-else class="rounded border image-fluid" src="../assets/no-photo-svgrepo-com.svg">
        </div>
    </div>
</template>
    
<script>
export default {
    props: {
        post: {
            type: Object,
            required: true,
        },
    },
}
</script>
    
<style scoped>
.card:hover {
    scale: 1.02;
}
</style>