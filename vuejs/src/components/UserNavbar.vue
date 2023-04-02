<template>
    <nav class="navbar navbar-light bg-dark justify-content-between">
        <router-link to="/" class="navbar-brand text-primary">GoodNews</router-link>
        <form class="form-inline">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>
        </form>
    </nav>
</template>

<script>
export default{
    name: "user-navbar"
}
</script>

<style>

</style>