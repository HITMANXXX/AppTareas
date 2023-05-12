<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DangerButton from "@/Components/DangerButton.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import Swal from "sweetalert2";

//definimos las propiedades de las tareas
const props = defineProps({
    tareas: {
        type: Object,
    },
});
// definimos una constante para utilizar el formulario
const form = useForm({
    id: '',
});
const deleteTask = (id, titulo) => {
    const alert = Swal.mixin({
        buttonsStyling: true
    });
    alert.fire({
            title: "Estas Seguro De Eliminar " + titulo + " ?",
            icon: "question", showCancelButton: true,
            confirmButtonText: '<i class="fa-solid fa-check"></i> Si, Eliminar',
            cancelButtonText: '<i class="fa-solid fa-ban"></i> Cancelar',
        }).then((result) => {
            if (result.isConfirmed) {
                form.delete(route('tareas.destroy', id));
            }
        });
};
</script>

<template>
    <Head title="Tareas" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tareas
            </h2>
        </template>

        <div class="py-12">
            <div class="bg-white grid v-screen place-items-center">
                <div class="mt-3 mb-3 flex">
                    <Link
                        :href="route('tareas.create')"
                        :class="'px-4 py-2 bg-gray-800 text-white border rounded-md font-semibold text-xs'"
                    >
                        <i class="fa-solid fa-plus-circle"></i> Agregar
                    </Link>
                </div>
            </div>
            <div class="bg-white grid v-screen place-items-center">
                <table class="mr-4 ml-4 table-auto border border-gray-400">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-4">#</th>
                            <th class="px-4 py-4">Titulo</th>
                            <th class="px-4 py-4">Descripcion</th>
                            <th class="px-4 py-4">Editar</th>
                            <th class="px-4 py-4">Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(task, i) in tareas" :key="task.id">
                            <td class="border border-gray-400 px-4 py-4">
                                {{ i + 1 }}
                            </td>
                            <td class="border border-gray-400 px-4 py-4">
                                {{ task.titulo }}
                            </td>
                            <td class="border border-gray-400 px-4 py-4">
                                {{ task.descripcion }}
                            </td>
                            <td class="border border-gray-400 px-4 py-4">
                                <Link
                                    :href="route('tareas.edit', task.id)"
                                    :class="'px-4 py-2 bg-blue-600  hover:bg-blue-700 focus:bg-blue-700 text-white border rounded-md font-semibold text-xs'"
                                >
                                    <i class="fa-solid fa-edit"></i>

                                </Link>
                            </td>
                            <td class="border border-gray-400 px-4 py-4">
                                <DangerButton @click="deleteTask(task.id,task.titulo,task.descripcion)" class="ml-2">
                                    <i class="fa-solid fa-trash"></i>
                                </DangerButton>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
