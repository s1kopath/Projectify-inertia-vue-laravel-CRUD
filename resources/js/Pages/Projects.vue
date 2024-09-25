<template>
    <Head title="Projects" />
    <Layout>
        <div class="container">
            <DataTable
                :columns="columns"
                :data="projects"
                :options="options"
                class="display"
            ></DataTable>
        </div>
    </Layout>
</template>

<script setup>
import { Head, Link } from "@inertiajs/vue3";

import Layout from "@/Layouts/AppLayout.vue";
defineProps({
    projects: Object,
});

import DataTable from "datatables.net-vue3";

const columns = [
    {
        data: "img",
        title: "Image",
        render: function (data, type, row) {
            return `<img src="${data}" alt="Project Image" width="50" height="50" onerror="this.onerror=null;this.src='https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQMX0FQrrMzh1hKS9zwUNx1-lzsZTk_GiJUvQ&s';"/>`;
        },
    },
    { data: "name", title: "Project Name" },
    { data: "description", title: "Description" },
    {
        data: "created_at",
        title: "Created At",
        render: function (data, type, row) {
            const date = new Date(data);
            return new Intl.DateTimeFormat("en-GB", {
                day: "2-digit",
                month: "2-digit",
                year: "numeric",
                hour: "2-digit",
                minute: "2-digit",
                hour12: true,
            }).format(date);
        },
    },
    {
        title: "Actions",
        data: null,
        orderable: false,
        render: function (data, type, row) {
            return `<div class="d-flex gap-2">
                    <a href="/projects/${row.id}/edit" class="btn btn-sm btn-primary">Edit</a>
                    <a href="/projects/${row.id}/destroy" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this project?');">Delete</a>
                </div>`;
        },
    },
];
const options = {
    responsive: true,
    select: true,
};
</script>

<style scoped></style>
