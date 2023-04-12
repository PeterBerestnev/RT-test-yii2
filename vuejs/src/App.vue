<template>
    <component :is="layout">
        <router-view></router-view>
    </component>
</template>

<script>
import AuthLayout from './layouts/AuthLayout.vue'
import AdminLayout from './layouts/AdminLayout.vue'
import MainLayout from './layouts/MainLayout.vue'
import '../node_modules/jquery/dist/jquery'
import '../node_modules/overlayscrollbars/js/jquery.overlayScrollbars'
import '../node_modules/admin-lte/dist/js/adminlte'

export default {
    computed: {
        layout() {
            return (this.$route.meta.layout || 'auth') + '-layout'
        }
    },
    components: {
        AuthLayout,
        AdminLayout,
        MainLayout
    }
}
</script>

<style>
@import '../node_modules/admin-lte/dist/css/adminlte.min.css';
@import '../node_modules/overlayscrollbars/css/OverlayScrollbars.min.css';
@import url('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback');

* {
    padding: 0;
    margin: 0;
}
.sl-none{
    user-select: none
}
</style>
