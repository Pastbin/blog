<script setup lang="ts">
import MainLayout from "@/Layouts/MainLayout.vue";
import UpdatePasswordForm from "./Partials/UpdatePasswordForm.vue";
import UpdateProfileInformationForm from "./Partials/UpdateProfileInformationForm.vue";
import { Head } from "@inertiajs/vue3";

defineProps<{
    mustVerifyEmail?: boolean;
    status?: string;
}>();
</script>

<template>
    <Head title="Профиль" />

    <MainLayout>
        <div class="container card">
            <div class="card-body d-flex flex-column gap-5">
                <UpdateProfileInformationForm
                    :must-verify-email="mustVerifyEmail"
                    :status="status"
                />

                <UpdatePasswordForm />
            </div>
        </div>
    </MainLayout>
</template>

<style lang="scss" scoped>
.container {
    max-width: 500px;
    margin: 0 auto;
    padding: 0;
}
</style>
