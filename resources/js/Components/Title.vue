<template>
    <h2 class="text-center header my-5">{{ title }}</h2>
</template>

<script setup lang="ts">
withDefaults(
    defineProps<{
        title: string;
    }>(),
    {
        title: "Default Title",
    }
);
</script>

<script lang="ts">
export default {
    name: "Title",
};
</script>

<style scoped>
.header {
}
</style>
