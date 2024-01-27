<script setup>
import {reactive} from 'vue';
import Dinputs from './Dinput.vue'
const data = reactive({
    'title' : '',
    'phone' : ''
})
</script>

<template>
    {{data}}
    <Dinputs v-model="data.title" ftype="text" />
    <Dinputs v-model="data.phone" ftype="number" />
</template>

<style scoped>

</style>