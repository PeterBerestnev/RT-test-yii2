<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Настройки</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><router-link to="/admin">Главная</router-link></li>
                        <li class="breadcrumb-item active">Настройки</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="card col-lg-4 col-sm-12 col-md-6">
            <div class="card-header d-flex flex-row justify-content-between">
                <strong>
                    <h3>Количество статей на странице</h3>
                </strong>
                <div class="d-flex align-items-center ms-auto">
                    <button @click="changeCount" class="btn btn-primary">Сохранить</button>
                </div>
            </div>
            <div class="card-body">
                <input v-model="count" min="0" type="number" class="form-control" :placeholder="count">
            </div>
        </div>
    </div>
</template>

<script>
import httpClient from '@/services/http.service';
import {getToastr} from "../../scripts/toastr"

export default {
    name: "admin-settings",
    data() {
        return {
            count: 0,
            data_id: "",
        }
    },
    methods: {
        async changeCount() {
            const toastr = getToastr()
            try {
                const { status } = await httpClient.post('settings/update', null, { params: { id: this.data_id, count: this.count } })
                if (status === 200) {
                    toastr.success('Изменения успешно внесены')
                }
            }
            catch (e) {
                e.response.data.forEach(error => {
                    toastr.error(error.message)
                });  
            }
        }
    },
    async mounted() {
        const { status, data } = await httpClient.get('settings/view')
        if (status === 200) {
            this.data_id = data._id
            this.count = data.count
        }
    },
}
</script>
