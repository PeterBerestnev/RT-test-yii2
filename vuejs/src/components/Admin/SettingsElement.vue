<template>
    <div class="card col-lg-4 col-sm-12 col-md-6">
        <div class="card-header d-flex flex-row justify-content-between">
            <strong>
                <h3>{{ title }}</h3>
            </strong>
            <div class="d-flex align-items-center ms-auto">
                <button @click="changeCount" class="btn btn-primary">Сохранить</button>
            </div>
        </div>
        <div class="card-body">
            <input v-model="settingsValue" min="0" type="number" class="form-control" :placeholder="count">
        </div>
    </div>
</template>

<script>
export default {
    name: "settings-element",
    props: ['count', 'title'],
    methods: {
        changeCount() {
            this.$emit('saveChanges')
        }
    },
    computed: {
        settingsValue: {
            get() {
                return this.count;
            },
            set(value) {
                this.$emit('update', value);
            }
        }
    }
}
</script>