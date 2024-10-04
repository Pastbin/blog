<template>
    <form @submit.prevent="submitPost">
        <div>
            <label for="title">Заголовок поста:</label>
            <input id="title" v-model="title" type="text" required />
        </div>
        <div>
            <label for="body">Текст поста:</label>
            <textarea id="body" v-model="body" required></textarea>
        </div>
        <button type="submit">Опубликовать</button>
    </form>
</template>

<script>
import { useForm } from "@inertiajs/vue3";

const form = useForm();

export default {
    data() {
        return {
            title: "",
            body: "",
        };
    },
    methods: {
        submitPost() {
            form.post("/posts", {
                onSuccess: () => {},
            });
        },
    },
};
</script>
