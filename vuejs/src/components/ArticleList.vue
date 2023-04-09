<template>
    <div class="row ps-4 pe-4 pt-3 pb-0">
        <div class="col-12 col-sm-6 col-md-4 col-lg-4" v-for="post in posts" v-bind:key="post.id">
            <attribute-item :post="post" @deleteItem="deleteItem" />
        </div>
    </div>
</template>
    
<script>
import AttributeItem from "./ArticleItem.vue"

export default {
    props: {
        posts: {
            type: Array,
            required: true,
        }
    },
    methods: {
        deleteItem(data) {
            this.$emit('deleteItem', data)
        }
    },
    components: {
        AttributeItem
    }
}
</script>
    
<style scoped>
.list-enter-active {
    transition: all 1.5s ease;
}

.list-leave-active {
    transition: all 0.8s ease;
}

.list-enter-from,
.list-leave-to {
    opacity: 0;
    transform: translateX(100px);
}
</style>