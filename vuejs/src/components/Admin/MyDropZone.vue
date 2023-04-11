<template>
    <div class="p-3 myOpacity rounded " v-bind="getRootProps()">
        <input v-bind="getInputProps()" />
        <div class="d-flex flex-column">
            <div class="d-flex justify-content-center">
                <img class="size" v-if="field == null" src="../../assets/no-photo-svgrepo-com.svg">
                <img v-else class="size" src="../../assets/check-mark1.svg">
            </div>
            <div>
                <div class="justify-content-center d-flex" v-if="isDragActive"><strong>Перенесите файл сюда</strong></div>
                <div class="justify-content-center d-flex" v-else><strong>Перенесите сюда файл или нажмите на эту область,чтобы его выбрать</strong></div>
            </div>
        </div>
    </div>
</template>

<script>
import { useDropzone } from "vue3-dropzone"

export default {
    props: ['field'],
    name: "my-drop-zone",
    data() {
        return {
            path: ''
        }
    },
    setup(props, { emit }) {
        function onDrop(acceptFiles) {
            if (acceptFiles) {
                emit('getPhoto', acceptFiles)
            }
        }
        const { getRootProps, getInputProps, ...rest } = useDropzone({ onDrop });
        return {
            getRootProps,
            getInputProps,
            ...rest,
        };
    },
}
</script>

<style scoped>
.size {
    width: 150px
}
.myOpacity {
    background-color: rgba(0, 0, 0, 0.1);
    border: 1px solid black
}
</style>