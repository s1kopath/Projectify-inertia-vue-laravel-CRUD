<script setup>
import { Head } from "@inertiajs/vue3";
import Layout from "@/Layouts/AppLayout.vue";

import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import { useToast } from "vue-toastification";

const toast = useToast();

const props = defineProps({
    projects: Array, // Soft-deleted projects passed from the backend
});

// Use a reactive form to handle the selected projects for restoring
const form = useForm({
    projects: [], // This will hold the IDs of selected projects
});

// Toggle selection for a project
const toggleProjectSelection = (projectId) => {
    if (form.projects.includes(projectId)) {
        form.projects = form.projects.filter((id) => id !== projectId);
    } else {
        form.projects.push(projectId);
    }
};

// Submit the restore form
const restoreProjects = () => {
    form.post(route("projects.restore"), {
        onSuccess: () => {
            form.projects = [];
            toast.success("Projects restored successfully.");
        },
    });
};
</script>

<template>
    <Head title="Recycle Bin" />
    <Layout>
        <div class="container">
            <div v-if="projects.length">
                <form @submit.prevent="restoreProjects">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Select</th>
                                <th>Image</th>
                                <th>Project Name</th>
                                <th>Description</th>
                                <th>Deleted At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="project in projects" :key="project.id">
                                <td>
                                    <input
                                        type="checkbox"
                                        :value="project.id"
                                        @change="
                                            toggleProjectSelection(project.id)
                                        "
                                    />
                                </td>
                                <td>
                                    <img
                                        :src="project.img"
                                        alt="Project Image"
                                        class="img-thumbnail"
                                        width="150"
                                        height="150"
                                    />
                                </td>
                                <td>{{ project.name }}</td>
                                <td>{{ project.description }}</td>
                                <td>
                                    {{
                                        new Date(
                                            project.deleted_at
                                        ).toLocaleString()
                                    }}
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <button type="submit" class="btn btn-primary">
                        Restore Selected Projects
                    </button>
                </form>
            </div>
            <div v-else>
                <p>No projects in the recycle bin.</p>
            </div>
        </div>
    </Layout>
</template>
