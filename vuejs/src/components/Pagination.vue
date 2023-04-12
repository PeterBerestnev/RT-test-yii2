<template>
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <li class="page-item">
                <button :class="{disabled:!isLeftActive}" @click="prevPage"  class="page-link fa fa-angle-left" ></button>
            </li>
            <div v-for="el in paginatedData" :key="el">
                <li class="page-item d-flex align-content-center">
                    <div @click="pageNumber=el" class="page-link my-cursor">{{ el }}</div>
                </li>
            </div>

            <li class="page-item">
                <button :class="{disabled:!isRightActive}" @click="nextPage"  class="page-link fa fa-angle-right "></button>
            </li>
        </ul>
    </nav>
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
            tempElementArr: [],
            pageNumber: 1,
        }
    },
    methods: {
        nextPage() {
            if (this.pageNumber != this.pageCount-3) {
                this.pageNumber++;
            }
        },
        prevPage() {
            if (this.pageNumber != 1) {
                this.pageNumber--;
            }
        },
    },
    computed: {
        pageCount() {
            let l = this.listData.length,
                s = this.size;
            return Math.ceil(l / s);
        },
        paginatedData() {
            let arr = []
            if (this.listData.length > 3) {
                if (this.pageNumber <= this.listData.length - 3)
                    for (let i = this.pageNumber; i <= this.pageNumber - 1 + this.listData.length - (this.listData.length - 3); i++) {
                        if (i < this.listData.length)
                            arr.push(i)
                    }
                else {
                    for (let i = this.listData.length - 2; i <= this.listData.length; i++) {
                        arr.push(i)
                    }
                }
            } else {
                for (let i = this.pageNumber; i <= this.listData.length; i++) {
                    arr.push(i)
                }
            }
            return arr
        },
        isLeftActive(){
            if (this.paginatedData[0] != 1) {
                return true
            }
            else{
                return false
            }
        },
        isRightActive(){
            if (this.paginatedData[2] != this.pageCount) {
                return true
            }
            else{
                return false
            }
        }
    },
    watch: {
    pageNumber(newPage, oldPage) {
      if (newPage != oldPage) {
        this.$emit('changePage',newPage)
      }
    }
  },
}
</script>

<style>
button:disabled,
button[disabled]{
  background-color: #cccccc;
  color: #666666;
}
.my-cursor{
    cursor: pointer;
}
</style>