<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";

const props = defineProps({
    tarea: {
        type: Object,
    },
});

const form = useForm({
    titulo: props.tarea.titulo,
    descripcion: props.tarea.descripcion,
});
</script>

<template>
    <Head title="Edit Tareas" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Editar Tareas
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="p-4 bg-white overflow-hidden shadow-sm sm:rounded-lg"
                >
                    <form
                        @submit.prevent="
                            form.put(route('tareas.update', tarea))
                        "
                        class="mt-6 space-y-6 max-w-xl"
                    >
                        <InputLabel for="name" value="Tareas"></InputLabel>
                        <TextInput
                            id="titulo"
                            placeholder="Nombre Tarea"
                            v-model="form.titulo"
                            autofocus
                            required
                            type="text"
                            class="mt-1 block w-full"
                        ></TextInput>
                        <TextInput
                            id="descripcion"
                            placeholder="Descripcion Tarea"
                            v-model="form.descripcion"
                            required
                            type="text"
                            class="mt-1 block w-full"
                        ></TextInput>
                        <InputError
                            :message="form.errors.titulo"
                            class="mt-2"
                        ></InputError>
                        <PrimaryButton :disable="form.processing">
                            <i class="fa-solid fa-save"></i> Guardar
                        </PrimaryButton>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
