<script setup lang="ts">
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const passwordInput = ref<HTMLInputElement | null>(null);
const currentPasswordInput = ref<HTMLInputElement | null>(null);

const form = useForm({
  current_password: "",
  password: "",
  password_confirmation: "",
});

const updatePassword = () => {
  form.put(route("password.update"), {
    preserveScroll: true,
    onSuccess: () => {
      form.reset();
    },
    onError: () => {
      if (form.errors.password) {
        form.reset("password", "password_confirmation");
        passwordInput.value?.focus();
      }
      if (form.errors.current_password) {
        form.reset("current_password");
        currentPasswordInput.value?.focus();
      }
    },
  });
};
</script>

<template>
  <section>
    <header>
      <h2>Обновить пароль</h2>

      <p>Чтобы обеспечить безопасность, в вашей учетной записи используйте надёжный пароль.</p>
    </header>

    <form @submit.prevent="updatePassword" class="d-flex gap-2 flex-column">
      <div>
        <label class="w-100">
          Текущий пароль
          <input
            required
            ref="currentPasswordInput"
            v-model="form.current_password"
            type="password"
            class="form-control"
          />
        </label>
        <div class="form-text text-danger">{{ form.errors.current_password && "Неверный пароль" }}</div>
      </div>

      <div>
        <label class="w-100"
          >Новый пароль
          <input
            required
            minlength="8"
            ref="passwordInput"
            v-model="form.password"
            type="password"
            class="form-control"
          />
        </label>
        <div class="form-text text-danger" v-if="form.errors.password">
          {{ form.errors.password === "validation.confirmed" && "Пароли не совпадают" }}
        </div>
      </div>

      <label>
        Подтвердите новый пароль
        <input required minlength="8" class="form-control" type="password" v-model="form.password_confirmation" />
      </label>

      <div class="d-flex aic gap-4 mt-3">
        <button type="submit" class="btn btn-primary" :disabled="form.processing">Сохранить</button>
        <span v-if="form.recentlySuccessful" class="text-success">Сохранено.</span>
      </div>
    </form>
  </section>
</template>
