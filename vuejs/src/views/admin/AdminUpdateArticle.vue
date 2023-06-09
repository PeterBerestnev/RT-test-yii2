<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6" :key="post">
                    <h1 class="m-0">Обновление статьи</h1>
                    <div class="mt-2">
                        Создано: {{ created_by }}  {{ post.created_at }} 
                    </div>
                    <div class="d-flex flex-row" v-if="post.updated_by != null">
                        Последнее изменение: {{ updated_by }} {{ post.updated_at }} 
                    </div>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><router-link to="/admin">Главная</router-link></li>
                        <li class="breadcrumb-item active">Обновление статьи</li>
                    </ol>
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
import httpClient from "@/services/http.service"
import AdminCUForm from "../../components/Admin/CreateUpdateForm.vue"
import { getToastr } from "../../scripts/toastr"
import { convertData } from "../../scripts/convertData"
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
        const created_by = ref([])
        const updated_by = ref([])

        onMounted(async () => {
            const { status, data } = await httpClient.get('article/view', { params: { id: props.id } })
            post.value = convertData(data)
            stat.value = status
       
            created_by.value = (await httpClient.get('user/view', { params: { id: post.value.created_by } })).data
            if(post.value.updated_by)
            updated_by.value = (await httpClient.get('user/view', { params: { id: post.value.updated_by } })).data
        })
        return {
            post, stat, created_by, updated_by
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
                const { status, data } = await httpClient.post('article/update', form_data, { headers: { "Content-Type": " multipart/form-data" }, params: { id: this.id } })
                if (status == 200) {
                    this.post = convertData(data)
                    this.updated_by = (await httpClient.get('user/view', { params: { id: this.post.updated_by } })).data
                    getToastr().success('Запись успешно сохранена')
                }
            }
            catch (e) {
                if (!e.response) {
                    getToastr().error('Ошибка сервера!')
                }
                if (e.response.data.status != 401) {
                    e.response.data.forEach(error => {
                        getToastr().error(error.message)
                    });
                }
            }
        },
    },
    components: {
        AdminCUForm
    },
})
</script>

<style>
@import '../../../node_modules/toastr/build/toastr.min.css';
@import '@vueup/vue-quill/dist/vue-quill.snow.css';
</style>