<template>
    <div class="container">
        <div class="card mt-4">
            <div class="card-header">
                <div v-if="status == 201" class="alert alert-success">
                    <div v-for="error in message" :key="error">
                        {{ error.message }}
                    </div>
                </div>
                <div v-if="status == 422" class="alert alert-danger">
                    <div v-for="error in message" :key="error">
                        {{ error.message }}
                    </div>
                </div>
                <div class="d-flex flex-row justify-content-between">
                    <div @click="focusOnTitle" class="pointer d-flex flex-row align-items-center">
                        <div class="fa fa-pencil fs-3 me-2"></div>
                        <div v-if="post.title">
                            <h1>{{ post.title }}</h1>
                        </div>
                        <div v-else>
                            <h1> Заголовок</h1>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <button class="btn btn-primary" @click="createArticle">Create</button>
                    </div>
                </div>
                <div v-show="changeTitle">
                    <input ref="text" @blur="changeTitle = false" v-model="post.title" type="text"
                        class="p-4 fs-3 form-control" placeholder="Введите заголовок">
                </div>
            </div>
            <div class="card-body">
                <div>
                    <MyDropZone :field="post.photo" @getPhoto="setPhoto"></MyDropZone>
                    <div v-if="post.photo"><strong>File name: </strong>{{ post.photo.name }}</div>
                </div>
                <div class="mt-3">
                    <quill-editor v-model:content="post.text" contentType="html" />
                </div>
                <select v-on:change="changeStatusValue($event)" class="form-select mt-3">
                    <option value="Опубликлванно">Опубликлванно</option>
                    <option selected value="Не опубликлванно">Не опубликлванно</option>
                </select>
            </div>
            <div class="card-footer">
                <div @click="focusOnTags" class="d-flex flex-row align-items-center pointer">
                    <div v-show="!changeTags" class="fa fa-pencil me-2"></div>
                    <div v-show="!changeTags">Теги:</div>
                    <div v-show="!changeTags" class="text-primary" v-for="tag in post.tags" :key="tag">#{{ tag }} &nbsp;
                    </div>
                </div>
                <div v-show="changeTags">
                    <input ref="tags" v-model="tagString" @blur="setTags" type="text" class="form-control mt-2"
                        placeholder="Введите тэги разделяя их '#' без пробелов">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import MyDropZone from '@/components/MyDropZone.vue';
import { QuillEditor } from '@vueup/vue-quill'
import httpClient from '@/services/http.service'

export default {
    name: "admin-create-article",
    data() {
        return {
            post: [{
                title: "",
                text: "",
                photo: null,
                tags: null,
                status: "Не опубликлванно",
            }],
            tagString: "",
            changeTags: false,
            changeTitle: false,
            message: [],
            status: null,
        }
    },
    methods: {
        focusOnTitle() {
            this.changeTitle = true
            this.message = []
            this.$nextTick(() => {
                const myRef = this.$refs.text;
                myRef.focus();
            });
        },
        focusOnTags() {
            this.changeTags = true
            this.message = []
            this.$nextTick(() => {
                const myRef = this.$refs.tags;
                myRef.focus();
            });
        },
        setPhoto(data) {
            this.message = []
            this.post.photo = data[0]
        },
        setTags() {
            this.message = []
            if (this.tagString != "") {
                this.post.tags = this.tagString.split('#');
            }
            this.changeTags = false
        },
        changeStatusValue(event){
            this.post.status = event.target.value
        },
        async createArticle() {
            let form_data = new FormData();
            if(typeof this.post.title !== "undefined"){
                form_data.append('title', this.post.title);
            }
            if(typeof this.post.text !== "undefined"){
                form_data.append('text', this.post.text);
            }
            if(typeof this.post.tags !== "undefined"){
                form_data.append('tags', JSON.stringify(this.post.tags));
            }
            if(typeof this.post.status !== "undefined"){
                form_data.append('status', this.post.status);
            }
            if(typeof this.post.photo !== "undefined"){
                form_data.append('photo', this.post.photo);
            }    
            try{
                const { status } = await httpClient.post('article/create', form_data, { headers: { "Content-Type": " multipart/form-data" } })
                if(status == 201){
                    this.message = [{message:'Запись успешно сохранена'}]
                    this.status = status
                }
                this.post.title = ""
                this.post.text = ""
                this.post.photo = null
                this.post.tags= null
                this.post.status = "Не опубликлванно"
            }
            catch(e){
                this.message = e.response.data
                this.status = e.response.status
            }

        }
    },
    components: {
        MyDropZone,
        QuillEditor
    }
}
</script>

<style scoped>
@import '@vueup/vue-quill/dist/vue-quill.snow.css';

.pointer {
    cursor: pointer
}
</style>