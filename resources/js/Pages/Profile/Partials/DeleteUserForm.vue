<script setup lang="ts">
import { useForm } from "@inertiajs/vue3";
import { nextTick, ref } from "vue";

const confirmingUserDeletion = ref(false);
const passwordInput = ref<HTMLInputElement | null>(null);

const form = useForm({
  password: "",
});

const confirmUserDeletion = () => {
  confirmingUserDeletion.value = true;

  nextTick(() => passwordInput.value?.focus());
};

const deleteUser = () => {
  form.delete(route("profile.destroy"), {
    preserveScroll: true,
    onSuccess: () => closeModal(),
    onError: () => passwordInput.value?.focus(),
    onFinish: () => {
      form.reset();
    },
  });
};

const closeModal = () => {
  confirmingUserDeletion.value = false;

  form.reset();
};
</script>

<template>
  <section class="space-y-6">
    <header>
      <h2 class="text-lg font-medium text-gray-900">Удалить аккаунт</h2>

      <p class="">
        После удаления вашей учетной записи все ее ресурсы и данные будут удалены без возможности восстановления.
      </p>
    </header>

    <button @click="confirmUserDeletion" class="btn btn-danger">Удалить аккаунт</button>

    <div class="p-6">
      <h2 class="text-lg font-medium text-gray-900">Are you sure you want to delete your account?</h2>

      <p class="">
        Пожалуйста, введите свой пароль, чтобы подтвердить, что вы хотите навсегда удалить свою учетную запись.
      </p>

      <div class="mt-5">
        <label>
          Пароль
          <input class="form-control" ref="passwordInput" v-model="form.password" type="password" />
        </label>

        <div class="form-text">{{ form.errors.password }}</div>
      </div>
    </div>
  </section>
</template>
