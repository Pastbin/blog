<template>
    <MainLayout>
        <Head :title="post.title" />
        <a :href="route('posts.index')"
            ><button class="btn btn-primary">Все посты</button></a
        >

        <Title :title="post.title" />

        <div class="post">
            <img class="post_img" :src="'/' + post.image" :alt="post.title" />
            <p class="post_body">{{ post.body }}</p>
        </div>

        <div>
            <div class="my-3" v-if="post.tags">
                <span
                    v-for="tag in post.tags.split(',')"
                    :key="tag.id"
                    class="badge bg-primary me-2"
                    >{{ tag }}</span
                >
            </div>
        </div>

        <div class="comments my-5">
            <h3>Комментарии</h3>
            <ul class="list-group">
                <li v-if="!post.comments?.length">Нет ни одного комментария</li>
                <li
                    class="list-group-item"
                    v-for="comment in post.comments"
                    :key="comment.id"
                >
                    <div>{{ comment.comment }}</div>
                    <i
                        >{{ comment.user.name }}
                        {{ new Date(comment.created_at).toLocaleString() }}</i
                    >
                </li>
            </ul>
        </div>

        <div v-if="$page.props.auth.user" class="form-group">
            <label for="rating">Рейтинг</label>
            <div class="rating cursor-pointer">
                <i
                    v-for="n in 5"
                    :key="n"
                    @click="form2.value = n"
                    :class="{
                        'bi bi-star-fill': n <= form2.value,
                        'bi bi-star': n > form2.value,
                    }"
                ></i>
            </div>
            <button class="btn btn-primary mt-2" @click="submitRating(post.id)">
                Отправить
            </button>

            <div class="toast-container position-fixed bottom-0 end-0 p-3">
                <div id="rating-toast" class="toast">
                    <div class="toast-header">
                        <strong class="me-auto">Уведомление</strong>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="toast"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="toast-body">Рейтинг обновлен!</div>
                </div>
            </div>
        </div>

        <div class="my-5 add_comments">
            <form v-if="$page.props.auth.user" @submit.prevent="submit">
                <div class="form-group">
                    <label for="body">Добавить комментарий</label>
                    <textarea
                        class="form-control"
                        id="body"
                        v-model="form.comment"
                        required
                        rows="5"
                    ></textarea>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary my-3" type="submit">
                        Добавить
                    </button>
                </div>
            </form>
            <p v-else class="text-center">
                Пожалуйста, войдите, чтобы оставить комментарий
            </p>
        </div>

        <div
            v-if="
                $page.props.auth.user.id === post.user_id ||
                $page.props.auth.user.is_admin
            "
            class="d-flex gap-3 flex-wrap"
        >
            <button class="btn btn-danger" @click="deletePost(post.id)">
                Удалить пост
            </button>

            <a :href="route('posts.edit', post.id)"
                ><button class="btn btn-warning">Редактировать пост</button></a
            >
        </div>
    </MainLayout>

</template>

<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import Title from "@/Components/Title.vue";
import { ref } from "vue";
import axios from "axios";

const props = defineProps({
    post: Object,
});

const form = useForm({
    comment: "",
});

const submit = () => {
    form.post(route("comments.store", props.post.id), {
        preserveScroll: true,
        onSuccess() {
            form.reset();
        },
    });
};

const ratingValue = ref(props.post.rating);

const form2 = useForm({
    value: ratingValue.value,
});

const submitRating = (id) => {
    form2.post(route("ratings.store", id), {
        preserveScroll: true,
        onSuccess: () => {
            const toast = document.getElementById("rating-toast");
            toast.classList.add("show");
        },
    });
};

const deletePost = (id) => {
    if (confirm("Вы уверены, что хотите удалить этот пост?")) {
        axios.delete(route("posts.destroy", id)).then(() => {
            window.location.href = route("posts.index");
        });
    }
};
</script>

<style scoped>
.post {
    display: flex;
    flex-direction: column;
    gap: 30px;
    align-items: center;

    .post_img {
        max-width: 500px;
        overflow: hidden;
        border-radius: 10px;
    }

    .post_body {
        font-size: 18px;
    }
}

.add_comments {
    textarea {
        max-width: 700px;
    }
}
</style>
