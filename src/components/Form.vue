<script setup>
import {reactive} from 'vue';
import Dinputs from './Dinput.vue'
import Dtextareas from './Dtextarea.vue'
const data = reactive({
    'title' : '',
    'phone' : '',
    'message' : ''
})
</script>

<template>
    {{data}}
    <Dinputs v-model="data.title" ftype="text" />
    <Dinputs v-model="data.phone" ftype="number" />
    <Dtextareas v-model="data.message" />
</template>

<style scoped>

</style>