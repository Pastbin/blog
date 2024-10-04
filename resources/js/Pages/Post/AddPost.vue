<template>
    <MainLayout>
        <Head title="Добавить пост" />
        <div class="container">
            <Title title="Добавить пост" />
            <form
                class="form d-flex flex-column gap-3"
                @submit.prevent="submit"
            >
                <input
                    class="form-control"
                    type="text"
                    v-model="form.title"
                    placeholder="Заголовок"
                    required
                />
                <textarea
                    class="form-control"
                    v-model="form.body"
                    placeholder="Описание"
                    rows="5"
                    required
                ></textarea>

                <div
                    v-if="form.image"
                    class="position-relative align-self-start"
                >
                    <img :src="getImageUrl(form.image)" class="img-thumbnail" />
                    <button
                        class="btn btn-danger position-absolute top-0 end-0"
                        type="button"
                        @click="form.image = null"
                    >
                        X
                    </button>
                </div>

                <button
                    class="btn btn-primary position-relative"
                    type="button"
                    @click="$el.querySelector('input[type=file]').click()"
                >
                    <input
                        class="position-absolute bottom-0 end-50"
                        type="file"
                        @input="form.image = $event.target.files[0]"
                        style="opacity: 0; width: 1px; height: 1px"
                        required
                    />

                    <span>Загрузить изображение</span>
                </button>

                <div
                    class="d-flex align-items-center gap-3 justify-content-between flex-wrap"
                >
                    <button class="btn btn-primary" type="submit">
                        Опубликовать
                    </button>

                    <div class="form-check form-switch">
                        <label class="form-check-label cursor-pointer">
                            <input
                                class="form-check-input cursor-pointer"
                                type="checkbox"
                                v-model="form.is_private"
                            />
                            Приватный</label
                        >
                    </div>

                </div>
                <div
                        v-if="form.recentlySuccessful"
                        class="alert alert-success"
                    >
                        Пост создан!
                    </div>
            </form>
        </div>
    </MainLayout>
</template>

<script setup>
import Title from "@/Components/Title.vue";
import MainLayout from "@/Layouts/MainLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";

const form = useForm({
    title: "",
    body: "",
    image: null,
    is_private: false,
});

function submit() {
    form.post(route("posts.store"), {
        onSuccess: () => {
            form.reset();
        }
    });
}
</script>

<style scoped>
form {
    max-width: 600px;
    margin: 0 auto;

    img {
        width: 200px;
        height: 200px;
    }
}
</style>

<script>
export default {
    methods: {
        getImageUrl(image) {
            return window.URL.createObjectURL(image);
        },
    },
};
</script>
