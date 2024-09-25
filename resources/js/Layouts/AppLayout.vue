<script setup>
import Header from "@/Layouts/Components/Header.vue";

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
    <Header />
    <slot />
</template>
