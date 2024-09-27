<template>
    <Head title="New Project" />
    <Layout>
        <div class="container">
            <form @submit.prevent="submit" enctype="multipart/form-data">
                <!-- Project Name Field -->
                <div class="form-group mb-3">
                    <label for="name">
                        Project Name
                        <span class="text-danger">*</span>
                    </label>
                    <input
                        v-model="form.name"
                        type="text"
                        id="name"
                        class="form-control"
                        :class="{ 'is-invalid': form.errors.name }"
                    />
                    <div v-if="form.errors.name" class="invalid-feedback">
                        {{ form.errors.name }}
                    </div>
                </div>

                <!-- Project Description Field -->
                <div class="form-group mb-3">
                    <label for="description">
                        Project Description
                        <span class="text-danger">*</span>
                    </label>
                    <textarea
                        v-model="form.description"
                        id="description"
                        class="form-control"
                        :class="{ 'is-invalid': form.errors.description }"
                    ></textarea>
                    <div
                        v-if="form.errors.description"
                        class="invalid-feedback"
                    >
                        {{ form.errors.description }}
                    </div>
                </div>

                <!-- Assign Project to Staff (Dropdown) -->
                <div class="form-group mb-3">
                    <label for="staff">
                        Assign Project to Staff
                        <span class="text-danger">*</span>
                    </label>
                    <select
                        v-model="form.staff_id"
                        id="staff"
                        class="form-select"
                        :class="{ 'is-invalid': form.errors.staff_id }"
                    >
                        <option value="" disabled>Select Staff</option>
                        <option
                            v-for="member in staff"
                            :key="member.id"
                            :value="member.id"
                        >
                            {{ member.name }}
                        </option>
                    </select>
                    <div v-if="form.errors.staff_id" class="invalid-feedback">
                        {{ form.errors.staff_id }}
                    </div>
                </div>

                <!-- Project Status (Enum Dropdown) -->
                <div class="form-group mb-3">
                    <label for="status">
                        Project Status
                        <span class="text-danger">*</span>
                    </label>
                    <select
                        v-model="form.status"
                        id="status"
                        class="form-select"
                        :class="{ 'is-invalid': form.errors.status }"
                    >
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="hold">Hold</option>
                    </select>
                    <div v-if="form.errors.status" class="invalid-feedback">
                        {{ form.errors.status }}
                    </div>
                </div>

                <!-- File Upload (Dropzone Integration) -->
                <div class="form-group mb-3">
                    <label for="file">File Upload</label>
                    <div v-bind="getRootProps()" class="dropzone">
                        <input v-bind="getInputProps()" />

                        <!-- Image Preview Section -->
                        <div
                            v-if="acceptedFiles.length > 0"
                            class="image-previews"
                        >
                            <div
                                v-for="file in acceptedFiles"
                                :key="file.name"
                                class="image-preview"
                            >
                                <img
                                    :src="previewImage(file)"
                                    alt="File preview"
                                    class="img-thumbnail"
                                    width="150"
                                    height="150"
                                />
                            </div>
                        </div>

                        <p v-else>
                            Drag & drop some files here, or click to select
                            files
                        </p>
                    </div>
                    <div v-if="form.errors.file" class="invalid-feedback">
                        {{ form.errors.file }}
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">
                    Create Project
                </button>
            </form>
        </div>
    </Layout>
</template>

<script setup>
import { Head } from "@inertiajs/vue3";
import Layout from "@/Layouts/AppLayout.vue";
import { useForm, Link } from "@inertiajs/vue3";
import { useDropzone } from "vue3-dropzone";

const props = defineProps({
    staff: Array,
});

const form = useForm({
    name: "",
    description: "",
    staff_id: "",
    status: "inactive",
    file: null,
});

const onDrop = (acceptedFiles, rejectReasons) => {
    form.file = acceptedFiles[0];
    console.log("Accepted Files:", acceptedFiles);
    console.log("Rejected Reasons:", rejectReasons);
};

// Setup Dropzone using useDropzone composable
const { getRootProps, getInputProps, acceptedFiles, ...rest } = useDropzone({
    onDrop,
    maxFilesize: 2,
    multiple: false,
    accept: "image/*,application/pdf",
    autoProcessQueue: false,
    thumbnailWidth: 150,
    thumbnailHeight: 150,
});

const previewImage = (file) => {
    return URL.createObjectURL(file);
};

const submit = () => {
    form.post(route("projects.create"), {
        onSuccess: () => form.reset("file"),
    });
};
</script>

<style scoped>
.dropzone {
    border: 2px dashed #007bff;
    padding: 20px;
    text-align: center;
    cursor: pointer;
    margin-bottom: 1rem;
}

.image-previews {
    display: flex;
    justify-content: center;
}

.image-preview img {
    max-width: 100%;
    border-radius: 10px;
}
</style>
