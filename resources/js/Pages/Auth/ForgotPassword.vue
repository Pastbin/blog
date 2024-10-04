<script setup lang="ts">
import { Head, useForm } from "@inertiajs/vue3";

defineProps<{
  status?: string;
}>();

const form = useForm({
  email: "",
});

const submit = () => {
  form.post(route("password.email"));
};
</script>

<template>
  <Head title="Восстановление пароля" />

  <div class="container my-5">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Восстановление пароля</div>
          <div class="card-body">
            <form @submit.prevent="submit">
              <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">Электронная почта</label>
                <div class="col-md-6">
                  <input
                    id="email"
                    type="email"
                    class="form-control"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                  />
                  <span class="invalid-feedback" role="alert" v-if="form.errors.email">
                    <strong>{{ form.errors.email }}</strong>
                  </span>
                </div>
              </div>
              <div class="">
                <div class="col-md-6 offset-md-4 mt-3">
                  <button type="submit" class="btn btn-primary" :disabled="form.processing">Отправить</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<!-- <template>
  <Head title="Forgot Password" />

  <div class="mb-4 text-sm text-gray-600">
    Forgot your password? No problem. Just let us know your email address and we will email you a password reset link
    that will allow you to choose a new one.
  </div>

  <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
    {{ status }}
  </div>

  <form @submit.prevent="submit">
    <div>
      <InputLabel for="email" value="Email" />

      <TextInput
        id="email"
        type="email"
        class="mt-1 block w-full"
        v-model="form.email"
        required
        autofocus
        autocomplete="username"
      />

      <InputError class="mt-2" :message="form.errors.email" />
    </div>

    <div class="flex items-center justify-end mt-4">
      <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
        Email Password Reset Link
      </PrimaryButton>
    </div>
  </form>
</template> -->
