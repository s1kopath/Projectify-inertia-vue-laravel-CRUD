<script setup>
import { Link } from "@inertiajs/vue3";

const isActive = (routeName) => {
    return route().current(routeName);
};
</script>
<template>
    <div class="container">
        <header class="d-flex justify-content-center py-3">
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <Link
                        :href="route('projects.create')"
                        class="nav-link"
                        :class="{ active: isActive('projects.create') }"
                        >New Project</Link
                    >
                </li>
                <li class="nav-item">
                    <Link
                        :href="route('projects')"
                        class="nav-link"
                        :class="{ active: isActive('projects') }"
                        >Projects</Link
                    >
                </li>
                <li class="nav-item">
                    <Link
                        :href="route('recycle-bin')"
                        class="nav-link"
                        :class="{ active: isActive('recycle-bin') }"
                        >Recycle Bin</Link
                    >
                </li>

                <li class="nav-item">
                    <Link :href="route('logout')" class="btn btn-danger ms-2"
                        >Logout</Link
                    >
                </li>
            </ul>
        </header>
    </div>
</template>
