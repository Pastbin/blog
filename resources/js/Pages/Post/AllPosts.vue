<template>
    <MainLayout>
        <Title :title="'Все посты'" />

        <section>
            <div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="sortBy" class="form-label"
                            >Сортировать по</label
                        >
                        <select
                            id="sortBy"
                            class="form-select"
                            v-model="sortBy"
                            @change="redirectToSortedPage"
                        >
                            <option value="created_at">По дате</option>
                            <option value="rating">По рейтингу</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="order" class="form-label">Порядок</label>
                        <select
                            id="order"
                            class="form-select"
                            v-model="order"
                            @change="redirectToSortedPage"
                        >
                            <option value="asc">По возрастанию</option>
                            <option value="desc">По убыванию</option>
                        </select>
                    </div>
                </div>

                <div class="posts">
                    <div v-for="post in posts" :key="post.id">
                        <PostCard :post="post" />
                    </div>
                </div>

                <nav
                    v-if="paginationLinks && paginationLinks.length > 3"
                    class="mt-5 d-flex"
                >
                    <ul class="pagination mx-auto">
                        <li class="page-item">
                            <a :href="paginationLinks[0].url" class="page-link"
                                ><<</a
                            >
                        </li>
                        <li
                            v-for="link in paginationLinks.slice(1, -1)"
                            :key="link.url"
                            class="page-item"
                            :class="{ active: link.active }"
                        >
                            <a :href="link.url" class="page-link">{{
                                link.label
                            }}</a>
                        </li>
                        <li class="page-item">
                            <a
                                :href="paginationLinks.at(-1).url"
                                class="page-link"
                                >>></a
                            >
                        </li>
                    </ul>
                </nav>
            </div>
        </section>
    </MainLayout>
</template>

<script setup>
import { ref, onMounted } from "vue";
import Title from "@/Components/Title.vue";
import MainLayout from "@/Layouts/MainLayout.vue";
import PostCard from "@/Components/Post/PostCard.vue";

// Параметры сортировки
const sortBy = ref("created_at");
const order = ref("desc");

// Функция для перенаправления с параметрами сортировки
const redirectToSortedPage = () => {
    window.location.href = `/posts?sort_by=${sortBy.value}&order=${order.value}`;
};

// Получение параметров сортировки из URL
const getQueryParams = () => {
    const params = new URLSearchParams(window.location.search);
    const sortParam = params.get("sort_by");
    const orderParam = params.get("order");

    if (sortParam) sortBy.value = sortParam;
    if (orderParam) order.value = orderParam;
};

// Когда компонент монтируется, получаем параметры из URL
onMounted(() => {
    getQueryParams();
});

// Пропсы с сервера
const props = defineProps({
    posts: Array,
    paginationLinks: Array,
});
</script>

<style scoped>
.posts {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 30px;
}
</style>
