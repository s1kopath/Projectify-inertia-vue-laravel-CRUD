<template>
    <Head title="Login" />
    <AuthLayout>
        <form @submit.prevent="loginForm.post(route('login.post'))">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input
                    id="email"
                    type="email"
                    class="form-control"
                    v-model="loginForm.email"
                    required
                    autofocus
                    autocomplete="username"
                />
                <div v-if="errors.email" class="text-danger mt-1">
                    {{ errors.email }}
                </div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input
                    id="password"
                    type="password"
                    class="form-control"
                    v-model="loginForm.password"
                    required
                    autocomplete="current-password"
                />
                <div v-if="errors.password" class="text-danger mt-1">
                    {{ errors.password }}
                </div>
            </div>

            <div class="form-check mb-3">
                <input
                    type="checkbox"
                    id="remember"
                    class="form-check-input"
                    v-model="loginForm.remember"
                />
                <label for="remember" class="form-check-label"
                    >Remember me</label
                >
            </div>

            <div class="d-flex justify-content-end align-items-center">
                <a
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="text-decoration-underline text-sm text-secondary"
                >
                    Forgot your password?
                </a>

                <button
                    type="submit"
                    class="btn btn-dark ms-3"
                    :disabled="loginForm.processing"
                >
                    Log in
                </button>
            </div>
        </form>
        <p>
            Not registered?
            <Link
                :href="route('register')"
                class="text-decoration-underline text-sm text-secondary"
            >
                Register
            </Link>
        </p>
    </AuthLayout>
</template>

<script>
import { Head, useForm, Link } from "@inertiajs/vue3";
import AuthLayout from "@/Layouts/AuthLayout.vue";

export default {
    components: {
        AuthLayout,
        Head,
        Link,
    },
    props: {
        errors: Object,
    },
    data() {
        return {
            canResetPassword: this.route().has("password.request"),
            status: null,
        };
    },
    setup() {
        const loginForm = useForm({
            email: "",
            password: "",
            remember: false,
        });

        return {
            loginForm,
        };
    },
};
</script>
