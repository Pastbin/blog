<script setup lang="ts">
import { Head, useForm } from "@inertiajs/vue3";

const form = useForm({
  password: "",
});

const submit = () => {
  form.post(route("password.confirm"), {
    onFinish: () => {
      form.reset();
    },
  });
};
</script>

<template>
  <div>
    <Head title="Confirm Password" />

    <div class="mb-4 text-sm text-gray-600">
      Это безопасная область приложения. Пожалуйста, подтвердите свой пароль, прежде чем продолжить.
    </div>

    <form @submit.prevent="submit">
      <div>
        <label>
          <input type="password" v-model="form.password" autofocus required />
        </label>
        <div class="form-text">{{ form.errors.password }}</div>
      </div>

      <div class="flex justify-end mt-4">
        <button type="submit" class="btn btn-primary" :disabled="form.processing">Подтвердить</button>
      </div>
    </form>
  </div>
</template>
