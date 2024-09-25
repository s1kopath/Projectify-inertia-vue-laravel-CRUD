<template>
    <Head title="Register" />
    <AuthLayout>
        <form @submit.prevent="registerForm.post(route('register'))">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input
                    id="name"
                    type="text"
                    class="form-control"
                    v-model="registerForm.name"
                    required
                    autofocus
                    autocomplete="false"
                />
                <div v-if="errors.name" class="text-danger mt-1">
                    {{ errors.name }}
                </div>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input
                    id="email"
                    type="email"
                    class="form-control"
                    v-model="registerForm.email"
                    required
                    autofocus
                    autocomplete="off"
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
                    v-model="registerForm.password"
                    required
                    autocomplete="off"
                />
                <div v-if="errors.password" class="text-danger mt-1">
                    {{ errors.password }}
                </div>
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label"
                    >Confirm Password</label
                >
                <input
                    id="password_confirmation"
                    type="password"
                    class="form-control"
                    v-model="registerForm.password_confirmation"
                    required
                    autocomplete="off"
                />
                <div
                    v-if="errors.password_confirmation"
                    class="text-danger mt-1"
                >
                    {{ errors.password_confirmation }}
                </div>
            </div>

            <div class="d-flex justify-content-end align-items-center">
                <button
                    type="submit"
                    class="btn btn-dark ms-3"
                    :disabled="registerForm.processing"
                >
                    Register
                </button>
            </div>
        </form>
        <p>
            Already registered?
            <Link
                :href="route('login')"
                class="text-decoration-underline text-sm text-secondary"
            >
                Login
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
    setup() {
        const registerForm = useForm({
            name: "",
            email: "",
            password: "",
            password_confirmation: "",
        });

        return {
            registerForm,
        };
    },
};
</script>
