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
import { Head, Link, router } from "@inertiajs/vue3";

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
            return `<img src="${data}" alt="Project Image" width="50" height="50" />`;
        },
    },
    { data: "name", title: "Project Name" },
    { data: "description", title: "Description" },
    { data: "staff.name", title: "Staff" },
    {
        data: "status",
        title: "Status",
        render: function (data, type, row) {
            let color = "";
            if (data === "active") {
                color = "text-success";
            } else if (data === "inactive") {
                color = "text-danger";
            } else if (data === "hold") {
                color = "text-warning";
            }
            return `<span class="${color}">${data}</span>`;
        },
    },
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
                <button class="btn btn-sm btn-primary" onclick="window.Laravel.editProject(${row.id})">Edit</button>
                <button class="btn btn-sm btn-danger" onclick="window.Laravel.deleteProject(${row.id})">Delete</button>
            </div>`;
        },
    },
];
const options = {
    responsive: true,
    select: true,
};

window.Laravel = {
    editProject(id) {
            router.get(route("projects.update", id), {
                onSuccess: () => {
                    // alert("Project updated successfully");
                },
            });
    },
    deleteProject(id) {
        if (confirm("Are you sure you want to delete this project?")) {
            router.get(route("projects.destroy", id), {
                onSuccess: () => {
                    // alert("Project deleted successfully");
                },
            });
        }
    },
};
</script>

<style scoped></style>
