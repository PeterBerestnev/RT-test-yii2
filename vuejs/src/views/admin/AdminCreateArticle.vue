<template>
    <div class="container">
        <div class="card mt-4">
            <div class="card-header">
                <div @click="focusOnTitle" class="pointer d-flex flex-row align-items-center">
                    <div class="fa fa-pencil fs-3 me-2"></div>
                    <div v-if="post.title">
                        <h1>{{ post.title }}</h1>
                    </div>
                    <div v-else>
                        <h1> Заголовок</h1>
                    </div>
                </div>
                <div v-show="changeTitle">
                    <input ref="text" @blur="changeTitle = false" v-model="post.title" type="text"
                        class="p-4 fs-3 form-control" placeholder="Введите заголовок">
                </div>
            </div>
            <div class="card-body">
                <img v-if="post.photo" class="rounded img-fluid border" :src="post.photo">
                <img v-else class="rounded img-fluid border" src="../../assets/no-photo-svgrepo-com.svg">
                <MyDropZone @getPhoto="setPhoto"></MyDropZone>
                <span v-html="post.text"> </span>
                <select class="form-select mt-3">
                    <option value="Опубликлванно">Опубликлванно</option>
                    <option selected value="Не опубликлванно">Не опубликлванно</option>
                </select>
            </div>
            <div class="card-footer">
                <div @click="focusOnTags"  class="d-flex flex-row align-items-center pointer">
                    <div v-show="!changeTags" class="fa fa-pencil me-2"></div>
                    <div v-show="!changeTags">Теги:</div>
                    <div v-show="!changeTags" class="text-primary" v-for="tag in post.tags" :key="tag">#{{ tag }} &nbsp;</div>
                </div>
                <div v-show="changeTags">
                    <input ref="tags" v-model="tagString" @blur="setTags" type="text" class="form-control mt-2"
                        placeholder="Введите заголовок">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import MyDropZone from '@/components/MyDropZone.vue';

export default {
    name: "admin-create-article",
    data() {
        return {
            post: [{
                title: "",
                text: "",
                photo: null,
                tags: null,
                status: "",
            }],
            tagString: "",
            changeTags: false,
            changeTitle: false,
        }
    },
    methods: {
        focusOnTitle() {
            this.changeTitle = true
            this.$nextTick(() => {
                const myRef = this.$refs.text;
                myRef.focus();
            });
        },
        focusOnTags() {
            this.changeTags = true
            this.$nextTick(() => {
                const myRef = this.$refs.tags;
                myRef.focus();
            });
        },
        setPhoto(data) {
            this.post.photo = data
            console.log(this.post.photo)
        },
        setTags() {
            if(this.tagString!=""){
            this.post.tags = this.tagString.split('#');
            }
            this.changeTags = false
        }
    },
    components: {
        MyDropZone
    }
}
</script>

<style scoped>
.pointer {
    cursor: pointer
}
</style>