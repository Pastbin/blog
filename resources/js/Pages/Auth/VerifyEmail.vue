<script setup lang="ts">
import { computed } from "vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

const props = defineProps<{
    status?: string;
}>();

const form = useForm({});

const submit = () => {
    form.post(route("verification.send"));
};

const verificationLinkSent = computed(
    () => props.status === "verification-link-sent"
);
</script>

<template>
    <div>
        <Head title="Email Verification" />

        <div class="mb-4 text-sm text-gray-600">
            Спасибо за регистрацию! Прежде чем начать, не могли бы вы
            подтвердить свой адрес электронной почты, нажав на ссылку, которую
            мы только что отправил вам по электронной почте? Если вы не получили
            письмо, мы с радостью отправим вам другое.
        </div>

        <div
            class="mb-4 font-medium text-sm text-green-600"
            v-if="verificationLinkSent"
        >
            Новая ссылка для подтверждения была отправлена ​​на адрес
            электронной почты, который вы указали при регистрации.
        </div>

        <form @submit.prevent="submit">
            <div class="mt-4 flex items-center justify-between">
                <button
                    type="submit"
                    class="btn btn-primary"
                    :disabled="form.processing"
                >
                    Повторно отправить письмо с подтверждением
                </button>

                <Link :href="route('logout')" method="post" as="button"
                    >Выйти</Link
                >
            </div>
        </form>
    </div>
</template>
