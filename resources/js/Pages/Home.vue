<script setup lang="ts">
import { Head, Link, usePage } from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import Title from "@/Components/Title.vue";
import PostCard from "@/Components/Post/PostCard.vue";
import Pagination from "@/Components/Pagination.vue";

defineProps<{
    canLogin?: boolean;
    canRegister?: boolean;
    posts?: { data: Array<any>; links: [] };
    pagination: Array<any>;
}>();
</script>

<template>
    <Head title="Мой блог - Главная" />
    <MainLayout>
        <section>
            <Title title="Добро пожаловать в Мой блог!" />

            <div class="d-flex home gap-4">
                <img
                    src="img/i.jpg"
                    alt="avatar"
                    class="rounded-5 flex-shrink-0"
                />
                <div class="flex-grow-1 py-3">
                    <p>
                        Всем привет! Меня зовут Пастьбин Александр. Мне 33 года.
                    </p>
                    <p>Я Frontend Developer.</p>
                    <p>
                        Я занимаюсь веб-разработкой уже более 4 лет. За это
                        время я успел поработать над различными проектами,
                        начиная от Landing Page, заканчивая сложными
                        корпоративными приложениями. Моя последняя работа - это
                        веб-приложение, CRM - система для мебельной фабрики,
                        написанная на React и TypeScript и покрытая тестами
                        Jest.
                    </p>
                    <p>
                        Я люблю экспериментировать с новыми технологиями и
                        инструментами, и всегда готов помочь коллегам в решении
                        различных задач.
                    </p>
                    <p>
                        В свободное время я люблю читать книги, слушать Drum &
                        Bass и путешествовать.
                    </p>
                </div>
            </div>
        </section>

        <section class="posts">
            <Title title="Блог" />
            <div class="my-5 posts_items">
                <div v-for="post in posts?.data?.slice(0, 8)" :key="post.id">
                    <PostCard :post="post" />
                </div>
            </div>

            <p v-if="!posts?.data?.length" class="text-center text-2xl">
                Постов пока нет.
            </p>

            <Pagination :pagination-links="posts?.links" />

            <div class="d-flex gap-4 justify-content-center">
                <a :href="route('posts.index')"
                    ><button class="btn btn-primary">
                        Посмотреть все посты
                    </button></a
                >
                <a :href="route('posts.create')" v-if="$page.props.auth.user"
                    ><button class="btn btn-primary">Добавить пост</button></a
                >
            </div>
        </section>
    </MainLayout>
</template>

<style scoped>
.home {
    img {
        width: 400px;
        height: 400px;
    }
}

.posts {
    .posts_items {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 30px;

        a {
            display: inline-block;
            height: 100%;
            width: 100%;
        }
    }
}
</style>
