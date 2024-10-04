<script setup lang="ts">
import { Link, useForm, usePage } from "@inertiajs/vue3";
const user = usePage().props.auth.user;
const form = useForm({
  name: user.name,
  email: user.email,
});

defineProps<{
  mustVerifyEmail?: Boolean;
  status?: String;
}>();
</script>

<template>
  <section class="profile">
    <header>
      <h2 class="text-lg font-medium text-gray-900">Профиль</h2>

      <p>Обновите имя профиля и адрес электронной почты.</p>
    </header>

    <form
      @submit.prevent="form.patch(route('profile.update'), { preserveScroll: true })"
      class="flex flex-column gap-3"
    >
      <div>
        <label for="name" class="form-label">Имя</label>
        <input id="name" minlength="2" type="text" class="form-control" v-model="form.name" required autofocus />
        <div class="form-text">{{ form.errors.name }}</div>
      </div>

      <div>
        <label for="email" class="form-label">Электронная почта</label>
        <input type="email" id="email" class="form-control" v-model="form.email" required />
        <div class="form-text" v-if="form.errors.email">{{ form.errors.email }}</div>
      </div>

      <div class="flex items-center gap-4">
        <div class="flex aic">
          <button type="submit" class="btn btn-primary" :disabled="form.processing">Сохранить</button>
          <i class="bi bi-check2 fs-2 text-success lh-1" v-show="form.recentlySuccessful"></i>
        </div>
      </div>
    </form>
  </section>
</template>
