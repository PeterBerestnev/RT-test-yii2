<template>
  <component :is="layout">
            <router-view></router-view> 
        </component>
</template>

<script>

import AuthLayout from './layouts/AuthLayout.vue'
import MainLayout from './layouts/MainLayout.vue'
export default{
    // name:'App',
    computed:{
        layout(){
            return (this.$route.meta.layout || 'auth')+'-layout'
        }
    },
    components:{
        AuthLayout,
        MainLayout
    }
}
</script>
<style>
@import '../public/dist/css/adminlte.min.css';
@import url('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback');

*{
    padding: 0;
    margin:0;
}
</style>
