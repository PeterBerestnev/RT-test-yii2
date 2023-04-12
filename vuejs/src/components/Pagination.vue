<template>
    <div class="d-flex"> 
        <div :disabled="pageNumber==0" class="fa fa-angles-left"></div>
        <div v-for="el in elementArr" :key="el">
            <div class="border p-2">{{ el }}</div>
        </div>
        <div :disabled="pageNumber==0" class="fa fa-angles-right"></div>
    </div>
</template>

<script>
export default {
    name: 'my-pagination',
    props: {
        listData: {
            type: Number,
            required: true
        },
        size: {
            type: Number,
            required: false,
            default: 10
        }
    },
    data() {
        return {
            elementArr: [],
            pageNumber: 1
        }
    },
    methods: {
        nextPage() {
            this.pageNumber++;
        },
        prevPage() {
            this.pageNumber--;
        }
    },
    computed: {
        pageCount() {
            let l = this.listData.length,
                s = this.size;

            return Math.ceil(l / s);
        },
        paginatedData() {
            const start = this.pageNumber * this.size,
                end = start + this.size;
            return this.listData.slice(start, end);
        }
    },
    mounted() {
        for (let i = 1; i <= this.totalCount / this.adminCount; i++) {
            this.elementArr.push(i)
        }
    }
}
</script>

<style></style>