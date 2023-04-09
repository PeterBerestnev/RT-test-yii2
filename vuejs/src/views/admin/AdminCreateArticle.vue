<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Создание статьи</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><router-link to="/admin">Главная</router-link></li>
                        <li class="breadcrumb-item active">Создание статьи</li>
                    </ol>
                </div>
            </div>
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
        </div>
    </div>
    <div class="content">
        <AdminCUForm @getArticle="createArticle" :post="post" @setPhoto="setPhoto" @setTags="setTags"
            @changeStatusValue="changeStatusValue" @setText="setText" @setTitle="setTitle">
        </AdminCUForm>
    </div>
</template>

<script>
import httpClient from "@/services/http.service";
import AdminCUForm from "../../components/Admin/CreateUpdateForm.vue"

export default {
    components: {
        AdminCUForm
    },
    name: "admin-create-article",
    data() {
        return {
            message: [],
            status: null,
            post: [{
                title: "",
                text: "",
                photo: null,
                tags: null,
                status: "Не опубликлванно",
            }],
        }
    },
    methods: {
        setPhoto(data) {
            this.post.photo = data
        },
        setTags(data) {
            this.post.tags = data
        },
        changeStatusValue(data) {
            this.post.status = data
        },
        setText(data) {
            this.post.text = data
        },
        setTitle(data) {
            this.post.title = data
        },
        async createArticle() {
            let form_data = new FormData();
            if (typeof this.post.title !== "undefined") {
                form_data.append('title', this.post.title);
            }
            if (typeof this.post.text === "string" && this.post.text != "") {
                form_data.append('text', this.post.text);
            }
            if (Array.isArray(this.post.tags)) {
                form_data.append('tags', JSON.stringify(this.post.tags));
            }
            if (typeof this.post.status !== "undefined") {
                form_data.append('status', this.post.status);
            }
            if (typeof this.post.photo !== "undefined" && this.post.photo != null) {
                form_data.append('photo', this.post.photo);
            }
            try {
                const { status } = await httpClient.post('article/create', form_data, { headers: { "Content-Type": " multipart/form-data" } })
                if (status == 201) {
                    this.message = [{ message: 'Запись успешно сохранена' }]
                    this.status = status

                }
            }
            catch (e) {
                this.message = e.response.data
                this.status = e.response.status
            }
        },
    }
}
</script>

<style scoped>
@import '@vueup/vue-quill/dist/vue-quill.snow.css';

.pointer {
    cursor: pointer
}
</style>