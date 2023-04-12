<template>
    <nav  v-if="pageCount>1">
        <ul class="pagination justify-content-center">
            <li class="page-item">
                <button :class="{ disabled: !isLeftActive }" @click="pageNumber = 1"
                    class="page-link fa fa-angles-left"></button>
            </li>
            <li class="page-item">
                <button :class="{ disabled: !isLeftActive }" @click="prevPage" class="page-link fa fa-angle-left"></button>
            </li>
            <li class="page-item d-flex align-content-center">
                <div class="page-link my-cursor sl-none">{{ pageNumber }}</div>
            </li>

            <li class="page-item">
                <button :class="{ disabled: !isRightActive }" @click="nextPage"
                    class="page-link fa fa-angle-right "></button>
            </li>
            <li class="page-item">
                <button :class="{ disabled: !isRightActive }" @click="pageNumber = pageCount"
                    class="page-link fa fa-angles-right"></button>
            </li>
        </ul>
    </nav>
</template>

<script>
export default {
    name: 'my-pagination',
    props: ['totalCount', 'size'],
    data() {
        return {
            pageNumber: 1,
        }
    },
    methods: {
        nextPage() {

            if (this.pageNumber != this.pageCount) {
                this.pageNumber++;
            }
            this.$emit('changePage', this.pageNumber)
        },
        prevPage() {
            if (this.pageNumber != 1) {
                this.pageNumber--;
            }
            this.$emit('changePage', this.pageNumber)
        },

    },
    computed: {
        isLeftActive() {
            if (this.pageNumber != 1) {
                return true
            } else {
                return false
            }
        },
        isRightActive() {
            if (this.pageNumber != this.pageCount) {
                return true
            } else {
                return false
            }
        },
        pageCount() {
            let l = this.totalCount,
                s = this.size;

            return Math.ceil(l / s);
        }
    },
    watch: {
        pageNumber(newPage, oldPage) {
            if (newPage != oldPage) {
                this.$emit('changePage', this.pageNumber)
            }
        }
    }

}
</script>

<style>
button:disabled,
button[disabled] {
    background-color: #cccccc;
    color: #666666;
}

.my-cursor {
    cursor: pointer;
}
</style>