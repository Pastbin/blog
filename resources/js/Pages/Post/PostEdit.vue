<template>
    <MainLayout>
        <Head title="Редактировать пост" />
        <div class="d-flex gap-3 flex-wrap">
            <a :href="route('posts.index')"
                ><button class="btn btn-primary">Все посты</button></a
            >
            <Title :title="post.title" />
        </div>

        <div class="d-flex gap-3 flex-column my-5">
            <div class="form-group">
                <label for="title">Заголовок</label>
                <input
                    type="text"
                    class="form-control"
                    id="title"
                    v-model="form.title"
                    required
                />
            </div>

            <div class="form-group">
                <label for="body">Текст поста</label>
                <textarea
                    class="form-control"
                    id="body"
                    v-model="form.body"
                    required
                    rows="5"
                ></textarea>
            </div>

            <div class="form-group">
                <label for="image">Изображение</label>
                <input
                    type="file"
                    class="form-control"
                    id="image"
                    @input="form.image = $event.target.files[0]"
                />
                <img
                    v-if="post.image"
                    :src="'/' + post.image"
                    class="img-thumbnail mt-2"
                />
            </div>

            <div class="form-group">
                <label for="tags">Теги (через запятую)</label>
                <input
                    type="text"
                    class="form-control"
                    id="tags"
                    v-model="form.tags"
                    required
                />
            </div>

            <div class="form-group">
                <label for="is_private">Приватный</label>
                <input
                    type="checkbox"
                    class="form-check-input ms-2"
                    id="is_private"
                    v-model="form.is_private"
                />
            </div>

            <button @click="submit" class="btn btn-primary">Сохранить</button>
        </div>
    </MainLayout>

    <div
        class="toast-container position-fixed bottom-0 end-0 p-3"
    >
        <div id="toast" class="toast bg-success">
            <div class="toast-header">
                <strong class="me-auto">Уведомление</strong>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="toast"
                    aria-label="Close"
                ></button>
            </div>
            <div class="toast-body">Пост обновлен!</div>
        </div>
    </div>
</template>

<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import Title from "@/Components/Title.vue";

const props = defineProps({
    post: Object,
});

const form = useForm({
    title: props.post.title,
    body: props.post.body,
    image: props.post.image,
    tags: props.post.tags,
    is_private: !!props.post.is_private,
});


const submit = () => {
    form.put(route("posts.update", props.post.id), {
        preserveScroll: true,
        onSuccess: () => {
            document.getElementById("toast")?.classList.add("show");
        },
    });
};
</script>

