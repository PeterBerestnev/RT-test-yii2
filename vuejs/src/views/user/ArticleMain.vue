<template>
    <div class="container">
        <div v-show="loaded" class="card mt-5">
            <div class="card-header d-flex flex-row">
                <h1 class="me-1 text-break">
                    <strong>
                        {{ post.title }}
                    </strong>
                </h1>
                <div class="ms-auto d-flex flex-row">
                    <img v-if="!post.photo" style="width:45px" class="rounded" src="../../assets/no-photo-svgrepo-com.svg">
                </div>
            </div>
            <div class="card-body">
                <img v-if="post.photo" class="rounded img-fluid border w-100" :src="img + post.photo">
                <div class="mt-3">
                    <span v-html="post.text"> </span>
                </div>
            </div>
            <div class="card-footer">
                <div>Дата: {{ post.date }}</div>
                <div class="d-flex flex-row">Теги:
                    <div class="text-break" v-for="tag in post.tags" :key="tag">
                        <router-link :to="{ name: 'article-tags', query: { tags: tag } }">#{{ tag }}</router-link>
                        &nbsp;
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="spin justify-content-center">
        <Spinner class="align-self-center" v-if="!loaded" />
    </div>
</template>

<script>
import Spinner from "../../components/Spinner.vue"
import httpClient from '@/services/http.service'
import {convertData} from '../../scripts/convertData'

export default {
    name: "article-main",
    props: {
        id: {
            type: String,
            required: true,
        },
    },
    data() {
        return {
            post: [],
            loaded: false,
            img: process.env.VUE_APP_IMG_URL
        }
    },
    async mounted() {
        const { status, data } = await httpClient.get('article/view', { params: { id: this.id } })

        if (status === 200) {
            this.loaded = true
            this.post = convertData(data)

            await httpClient.post('article/add-view', null, { params: { id: this.id } })
        }
    },
    components: {
        Spinner
    }
}
</script>

<style>
.spin {
    width: 100%;
    height: 100%;
    display: flex;
    position: fixed;
    top: 0;
    z-index: -10;
}
</style>