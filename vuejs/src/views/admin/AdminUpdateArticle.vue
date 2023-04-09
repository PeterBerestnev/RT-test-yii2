<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Обновление статьи</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><router-link to="/admin">Главная</router-link></li>
                        <li class="breadcrumb-item active">Обновление статьи</li>
                    </ol>
                </div>
            </div>
            <div v-if="status == 200" class="alert alert-success">
                <div v-for="error in message" :key="error">
                    {{ error.message }}
                </div>
            </div>
            <div v-if="status == 422" class="alert alert-danger">
                <div v-for="error in message" :key="error">
                    {{ error.message }}
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <AdminCUForm :post="post" @setPhoto="setPhoto" @setTags="setTags" @changeStatusValue="changeStatusValue"
            @setText="setText" @setTitle="setTitle" @getArticle="updateArticle">
        </AdminCUForm>
    </div>
</template>

<script>
import httpClient from "@/services/http.service";
import AdminCUForm from "../../components/Admin/CreateUpdateForm.vue"
import { defineComponent, onMounted, ref } from "vue";

export default defineComponent({
    name: "admin-update-article",
    props: {
        id: {
            type: String,
            required: true,
        },
    },
    data() {
        return {
            message: [],
            status: "",
            photoChanged: false,
            titleChanged: false,
            textChanged: false,
            tagsChanged: false,
            statusChanged: false
        }
    },
    setup(props) {
        const post = ref([])
        const stat = ref([])
        onMounted(async () => {
            const { status, data } = await httpClient.get('article/view', { params: { id: props.id } })
            post.value = data
            stat.value = status
        })
        return {
            post, stat
        }
    },
    methods: {
        setPhoto(data) {
            this.post.photo = data
            this.photoChanged = true
        },
        setTags(data) {
            this.tagsChanged = true
            this.post.tags = data
        },
        changeStatusValue(data) {
            this.post.status = data
            this.statusChanged = true
        },
        setText(data) {
            this.post.text = data
            this.textChanged = true
        },
        setTitle(data) {
            this.post.title = data
            this.titleChanged = true
        },
        async updateArticle() {
            let form_data = new FormData();
            if (typeof this.post.title !== "undefined" && this.titleChanged) {
                form_data.append('title', this.post.title);
            }
            if (typeof this.post.text === "string" && this.post.text && this.textChanged) {
                form_data.append('text', this.post.text);
            }
            if (Array.isArray(this.post.tags) && this.tagsChanged) {
                form_data.append('tags', JSON.stringify(this.post.tags));
            }
            if (typeof this.post.status !== "undefined" && this.statusChanged) {
                form_data.append('status', this.post.status);
            }
            if (typeof this.post.photo !== "undefined" && this.post.photo != null && this.photoChanged == true) {
                form_data.append('photo', this.post.photo);
            }
            try {
                const { status } = await httpClient.post('article/update', form_data, { headers: { "Content-Type": " multipart/form-data" }, params: { id: this.id } })
                if (status == 200) {
                    this.message = [{ message: 'Запись успешно сохранена' }]
                    this.status = status
                }
            }
            catch (e) {
                console.log(e)
                this.message = e.response.data
                this.status = e.response.status
            }
        },
    },
    components: {
        AdminCUForm
    },
})
</script>

<style>
@import '@vueup/vue-quill/dist/vue-quill.snow.css';
</style>