<template>
    <div class="d-flex flex-column main">
        <Header />
        <main class="my-3 md:my-5 container"><slot /></main>
        <Footer />
    </div>
</template>

<script setup>
import Header from "@/Partials/Header.vue";
import Footer from "@/Partials/Footer.vue";
</script>

<script>
export default {
    name: "MainLayout",
};
</script>

<style scoped>
.main {
    min-height: 100vh;
}

main {
    flex-grow: 1;
}
</style>
