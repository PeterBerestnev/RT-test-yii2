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
        <Settings @update="updateUserSide" :title="'Количество статей на стороне пользователя'" :count="userSide"
            @saveChanges="changeUserCount">
        </Settings>
        <Settings @update="updateAdminSide" :title="'Количество статей на стороне администратора'" :count="adminSide"
            @saveChanges="changeAdminCount">
        </Settings>
    </div>
</template>

<script>
import httpClient from "@/services/http.service";
import Settings from "../../components/Admin/SettingsElement.vue"
import { getToastr } from "../../scripts/toastr"

export default {
    name: "admin-settings",
    data() {
        return {
            userSide: 0,
            adminSide: 0,
        }
    },
    methods: {
        async changeUserCount() {
            try {
                const { status } = await httpClient.post('settings/update', null, { params: { name: 'user_page_size', value: this.userSide } })
                if (status === 200) {
                    getToastr().success('Изменения успешно внесены')
                }
            }
            catch (e) {
                if(!e.response){
                    getToastr().error('Ошибка сервера!')
                }
                if (e.response.data.status != 401) {
                    getToastr().error(e.response.data[0].message)
                }
            }
        },
        async changeAdminCount() {
            try {
                const { status } = await httpClient.post('settings/update', null, { params: { name: 'admin_page_size', value: this.adminSide } })
                if (status === 200) {
                    getToastr().success('Изменения успешно внесены')
                }
            }
            catch (e) {
                if(!e.response){
                    getToastr().error('Ошибка сервера!')
                }
                if (e.response.data.status != 401) {
                    getToastr().error(e.response.data[0].message)
                }
            }
        },
        updateUserSide(data) {
            this.userSide = data
        },
        updateAdminSide(data) {
            this.adminSide = data
        }
    },
    async mounted() {
        try {
            const { status, data } = await httpClient.get('settings/view', { params: { name: 'user_page_size' } })
            if (status === 200) {
                this.userSide = data.value
            }
        } catch (e) {
            if (e.response.data.status != 401) {
                getToastr().error(e.response.data[0].message)
            }
        }
        try {
            const { status, data } = await httpClient.get('settings/view', { params: { name: 'admin_page_size' } })
            if (status === 200) {
                this.adminSide = data.value
            }
        } catch (e) {
            if (e.response.data.status != 401) {
                getToastr().error(e.response.data[0].message)
            }
        }
    },
    components: {
        Settings
    },
}
</script>
