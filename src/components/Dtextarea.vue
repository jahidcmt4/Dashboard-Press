<script setup>
const props = defineProps([
    'modelValue'
])
const emit = defineEmits(['update:modelValue'])

</script>

<template>
    <textarea @input="emit('update:modelValue', $event.target.value)" >{{ props.modelValue }}</textarea>
</template>

<style scoped>

</style>