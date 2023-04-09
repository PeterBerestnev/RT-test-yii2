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

    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
</template>

<script>
import Sidebar from '../components/Admin/Sidebar.vue'
import AdminNavbar from '../components/Admin/AdminNavbar.vue'

export default {
    name: 'admin-layout',
    components: {
        AdminNavbar,
        Sidebar
    }
}
</script>

<style>
.content-wrapper {
    background-color: white !important;
}
</style>