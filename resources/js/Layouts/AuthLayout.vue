<script setup>
import { Link } from "@inertiajs/vue3";

import { useToast } from "vue-toastification";
import { usePage } from "@inertiajs/vue3";

const toast = useToast();
const { props } = usePage();

if (props.flash.success) {
    toast.success(props.flash.success);
}
if (props.flash.error) {
    toast.error(props.flash.error);
}
if (props.flash.info) {
    toast.info(props.flash.info);
}
if (props.flash.warning) {
    toast.warning(props.flash.warning);
}
</script>

<template>
    <div
        class="min-vh-100 d-flex flex-column justify-content-center align-items-center"
    >
        <div>
            <Link href="/">
                <img
                    width="100px"
                    src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQMX0FQrrMzh1hKS9zwUNx1-lzsZTk_GiJUvQ&s"
                    alt="Logo"
                />
            </Link>
        </div>

        <div class="mt-4 px-4 py-4 bg-white shadow rounded">
            <slot />
        </div>
    </div>
</template>
