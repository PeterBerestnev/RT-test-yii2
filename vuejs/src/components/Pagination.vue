<template>
    <nav class="d-flex flex-column align-items-center" v-if="pageCount > 1">
        <ul class="pagination justify-content-center">
            <li class="page-item">
                <button :class="{ disabled: !isLeftActive }" @click="prevPage" class="page-link fa fa-angle-left"></button>
            </li>
            <li class="page-item d-flex align-content-center" v-if="pageNumber > 1">
                <div @click="pageNumber = 1" class="page-link my-cursor sl-none">1</div>
            </li>
            <li v-if="pageNumber > 2" class="page-item d-flex align-content-center">
                <div class="page-link my-cursor dots sl-none">...</div>
            </li>
            <li class="page-item d-flex align-content-center" v-for="el in getArray" :key="el">
                <div :class="{ choice: el == pageNumber }" @click="pageNumber = el" class="page-link my-cursor sl-none">{{ el
                }}</div>
            </li>
            <li v-if="pageNumber <= pageCount - 3" class="page-item d-flex align-content-center">
                <div class="page-link my-cursor dots sl-none">...</div>
            </li>
            <li class="page-item d-flex align-content-center" v-if="pageNumber <= pageCount - 3">
                <div @click="pageNumber = pageCount" class="page-link my-cursor sl-none">{{ pageCount }}</div>
            </li>
            <li class="page-item">
                <button :class="{ disabled: !isRightActive }" @click="nextPage"
                    class="page-link fa fa-angle-right "></button>
            </li>
        </ul>
        <i class="mb-3">{{ pageNumber }} страница из {{ pageCount }}</i>
    </nav>
</template>

<script>
export default {
    name: 'my-pagination',
    props: ['totalCount', 'size'],
    data() {
        return {
            pageNumber: 1,
            rotation: 1
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
        },
        getArray() {
            let arr = []
            if (this.pageCount > 3) {
                if (this.pageNumber <= this.pageCount - 3) {
                    for (let i = this.pageNumber; i < this.pageNumber + 3; i++) {
                        arr.push(i)
                    }
                } else {
                    for (let i = this.pageCount - 2; i <= this.pageCount; i++) {
                        arr.push(i)
                    }
                }
            }
            else {
                for (let i = this.pageNumber; i <= this.pageCount; i++) {
                        arr.push(i)
                    }
            }

            return arr;
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

.choice {
    background-color: rgba(52, 58, 64, 0.1)
}

.dots:hover {
    background-color: #fff;
}</style>