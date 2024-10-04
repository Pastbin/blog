<template>
    <header class="bg-primary text-white py-3 shadow">
        <div
            class="container mx-auto d-flex justify-between align-items-center"
        >
            <h1>
                <Link href="/">Мой Блог</Link>
            </h1>
            <nav class="ms-auto">
                <ul class="d-flex gap-3">
                    <li><Link href="/">Главная</Link></li>
                    <li><Link href="/posts">Сообщения</Link></li>
                    <li>
                        <Link v-if="$page.props.auth.user" href="/profile"
                            >Профиль</Link
                        >
                    </li>
                    <li>
                        <Link v-if="!$page.props.auth.user" href="/login">Войти</Link>
                    </li>
                    <li>
                        <Link v-if="!$page.props.auth.user" href="/register"
                            >Регистрация</Link
                        >
                    </li>
                    <li>
                        <a v-if="$page.props.auth.user" href="#" @click="logout"
                            >Выход</a
                        >
                    </li>
                </ul>
            </nav>
        </div>
    </header>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
defineProps({
    user: Object,
    isAuth: Boolean,
});
</script>

<script>
export default {
    methods: {
        logout() {
            this.$inertia.post(route("logout"));
        },
    },
};
</script>