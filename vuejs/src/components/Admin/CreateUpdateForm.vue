<template>
    <div class="grid">
        <div class="card mt-4 col-lg-6">
            <div class="card-header">
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
                        <button class="btn btn-primary " @click="createArticle">Сохранить</button>
                    </div>
                </div>
                <div v-show="changeTitle">
                    <input ref="text" v-model="title" @blur="setTitle" type="text" class="p-4 fs-3 form-control"
                        placeholder="Введите заголовок">
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex">
                    <img v-if="typeof post.photo == 'string'" :src="img+post.photo" class="img-fluid mb-3 w-100 rounded">
                </div>
                <MyDropZone :field="post.photo" @getPhoto="setPhoto"></MyDropZone>
                <div v-if="photo == null"><strong>Имя файла: </strong>{{ post.photo }}</div>
                <div v-else><strong>Имя файла: </strong> {{ photo }} </div>
                <div class="mt-3">
                    <quill-editor ref="myEditor" @textChange="setText" :content="post.text" contentType="html" />
                </div>
                <select class="form-select mt-3" :required="true" v-on:change="changeStatusValue($event)">
                    <option v-for="option in options" v-bind:value="option.id" :key=option
                        :selected="option == post.status">{{ option }}</option>
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
                        placeholder="Введите тэги разделяя их запятой">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import MyDropZone from '@/components/Admin/MyDropZone.vue';
import { QuillEditor } from '@vueup/vue-quill';

export default {
    name: "create-update-form",
    props: ['post'],
    data() {
        return {
            title: '',
            photo: null,
            changeTags: false,
            changeTitle: false,
            tagString: '',
            green: true,
            options: ["Не опубликовано", "Опубликовано"],
            img: process.env.VUE_APP_IMG_URL
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
            if (this.post.tags) {
                this.tagString = this.post.tags.join(',')
            }
            this.changeTags = true
            this.$nextTick(() => {
                const myRef = this.$refs.tags;
                myRef.focus();
            });
        },
        setPhoto(data) {
            this.photo = data[0].name
            this.$emit('setPhoto', data[0])
        },
        setTags() {
            if (this.tagString != "") {
                let tags = this.tagString.split(',');
                this.$emit('setTags', tags)
            }
            this.changeTags = false
        },
        changeStatusValue(event) {
            this.$emit('changeStatusValue', event.target.value)
        },
        createArticle() {
            this.photo = null
            this.title = '',
            this.tagString = '',
            this.$emit('getArticle')
        },
        setText() {
            this.$emit('setText', this.$refs.myEditor.getHTML())
        },
        setTitle() {
            this.changeTitle = false
            this.$emit('setTitle', this.title)
        },
    },
    components: {
        MyDropZone,
        QuillEditor
    }
}
</script>