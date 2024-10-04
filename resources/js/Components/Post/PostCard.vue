<template>
    <Link :href="route('posts.show', post.id)">
        <div class="card post">
            <img :src="post.image" alt="" class="card-img-top" />
            <div class="card-body">
                <h5 class="card-title">{{ post.title }}</h5>
                <p class="card-text">{{ post.body }}</p>

                <!-- Добавленные блоки -->
                <div
                    class="d-flex justify-content-between align-items-center mt-3"
                >
                    <!-- Рейтинг -->
                    <div class="rating">
                        <span class="badge bg-warning text-dark">
                            <i class="bi bi-star-fill"></i> {{ post.rating }}
                        </span>
                    </div>
                    <!-- Комментарии -->
                    <div class="comments">
                        <span class="badge bg-info">
                            <i class="bi bi-chat-left-text"></i>
                            {{ post.comments_count || 0 }}
                        </span>
                    </div>

                    <!-- Дата публикации -->
                    <div class="post-date">
                        <small class="text-muted">{{ formatDate(post.created_at) }}</small>
                    </div>
                </div>
            </div>
        </div>
    </Link>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import dayjs from 'dayjs';
import 'dayjs/locale/ru';
dayjs.locale('ru');

const props = defineProps({
    post: Object,
});

function formatDate(date) {
    return dayjs(date).format('HH:mm DD.MM.YYYY');
}
</script>

<script>
export default {
    name: "PostCard",
};
</script>

<style>
.post {
    height: 400px;

    img {
        height: 70%;
    }
}
</style>