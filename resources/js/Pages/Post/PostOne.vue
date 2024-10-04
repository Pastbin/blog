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

        <div class="comments my-5">
            <h3>Комментарии</h3>
            <ul class="list-group">
                <li v-if="!comments?.length">Нет ни одного комментария</li>
                <li
                    class="list-group-item"
                    v-for="comment in comments"
                    :key="comment.id"
                >
                    <div>{{ comment.comment }}</div>
                    <i>{{ comment.user.name }} {{ new Date(comment.created_at).toLocaleString() }}</i>
                </li>
            </ul>
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
    </MainLayout>
</template>

<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import Title from "@/Components/Title.vue";

const props = defineProps({
    post: Object,
    comments: Array,
});

const form = useForm({
    comment: "",
});

const submit = () => {
    form.post(route("comments.store", props.post.id), {onSuccess(){
        form.reset()
    }});
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
