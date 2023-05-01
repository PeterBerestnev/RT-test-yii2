<template>
    <Sidebar></Sidebar>
    <div class="wrapper">
        <AdminNavbar></AdminNavbar>
        <Suspense>
            <div class="content-wrapper">
                <router-view></router-view>
            </div>
        </Suspense>
    </div>
    <aside class="control-sidebar control-sidebar-dark"></aside>
</template>

<script>
import { getToastr } from '@/scripts/toastr';
import Sidebar from '../components/Admin/Sidebar.vue'
import AdminNavbar from '../components/Admin/AdminNavbar.vue'

export default {
    name: 'admin-layout',
    components: {
        AdminNavbar,
        Sidebar
    },
    mounted() {
        const toastrMessage = localStorage.getItem('toastrMessage');
        if (toastrMessage) {
            getToastr().success(toastrMessage);
            localStorage.removeItem('toastrMessage');
        }
    }
}
</script>

<style>
.content-wrapper {
    background-color: white !important;
}
</style>