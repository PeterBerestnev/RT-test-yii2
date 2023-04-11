<template>
    <div class="d-flex">
        <div class="fa fa-angles-left"></div>
        <div v-for="el in elementArr">

        </div>
        <div class="fa fa-angles-right"></div>
    </div>
</template>

<script>
export default{
    name: 'my-pagination',
    props: ['totalCount','adminCount'],
    data(){
        return{
            elementArr: [],
            currentPage: 1
        }
    },
    mounted(){
        for(let i = 1; i <= this.totalCount/this.adminCount; i++){
            this.elementArr.push(i)
        }
    }
}
</script>

<style>

</style>