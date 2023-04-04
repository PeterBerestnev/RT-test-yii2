<template>
    <div class="my-drop-zone">
        <div v-bind="getRootProps()">
            <input v-bind="getInputProps()" />
            <p v-if="isDragActive">Drop the files here ...</p>
            <p v-else>Drag 'n' drop some files here, or click to select files</p>
        </div>
        <button @click="open">open</button>
    </div>
</template>

<script>
import { useDropzone } from "vue3-dropzone"
export default {
    name: "my-drop-zone",
    setup(props,{emit}) {
        function onDrop(acceptFiles) {
            console.log(acceptFiles)
            emit('getPhoto',acceptFiles)
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

<style>
.my-drop-zone{
    border: 1px dashed black;
    border-radius: 10px;
    padding: 20px;
    margin-top:20px
}
</style>