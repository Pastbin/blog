<script setup lang="ts">
import { Head, Link, useForm } from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";

defineProps<{
    canResetPassword?: boolean;
    status?: string;
}>();

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const submit = () => {
    form.post(route("login"), {
        onFinish: () => {
            form.reset("password");
        },
    });
};
</script>

<template>
    <MainLayout>
        <div class="container login my-5">
            <div class="card">
                <div class="card-header">Вход</div>
                <div class="card-body">
                    <form @submit.prevent="submit">
                        <div class="mb-3">
                            <label for="email" class="form-label"
                                >Электронная почта</label
                            >
                            <input
                                type="email"
                                class="form-control"
                                id="email"
                                v-model="form.email"
                                required
                                autofocus
                                autocomplete="username"
                            />
                            <div
                                class="form-text text-danger"
                                v-if="form.errors.email"
                            >
                                {{ form.errors.email }}
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label"
                                >Пароль</label
                            >
                            <input
                                type="password"
                                class="form-control"
                                id="password"
                                v-model="form.password"
                                required
                                autocomplete="current-password"
                            />
                            <div
                                class="form-text text-danger"
                                v-if="form.errors.password"
                            >
                                {{ form.errors.password }}
                            </div>
                        </div>

                        <div class="mb-3 form-check">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                value=""
                                id="remember"
                                v-model="form.remember"
                            />
                            <label class="form-check-label" for="remember">
                                Запомнить меня
                            </label>
                        </div>

                        <div class="d-flex justify-content-between">
                            <Link
                                v-if="canResetPassword"
                                :href="route('password.request')"
                                class="btn btn-link"
                            >
                                Забыли пароль?
                            </Link>
                            <button
                                type="submit"
                                class="btn btn-primary"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing"
                            >
                                Вход
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<style lang="scss">
.login {
    max-width: 600px;
}
</style>
