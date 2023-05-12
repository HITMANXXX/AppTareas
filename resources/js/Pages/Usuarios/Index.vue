<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import WarningButton from "@/Components/WarningButton.vue";
import SelectInput from "@/Components/SelectInput.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Modal from "@/Components/Modal.vue";
import DangerButton from "@/Components/DangerButton.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { nextTick, ref } from "vue";
import VueTailwindPagination from "@ocrv/vue-tailwind-pagination";
import Swal from "sweetalert2";

//definimos nuestras variables globales
const nameInput = ref(null);
const modal = ref(false);
const title = ref("");
const operation = ref(1);
const id = ref("");

//definimos las propiedades de los usuarios
const props = defineProps({
    tareas: {
        type: Object,
    },
    usuarios: {
        type: Object,
    },
});

// definimos una constante para utilizar el formulario y sus campos
const form = useForm({
    nombre: "",
    email: "",
    telefono: "",
    tarea_id: "",
});

//declaramos una variable para el formulario de la paginacion
const formPage = useForm({});

//definimos una funcion para la navegacion en la paginacion
const onPageClick = (event) => {
    formPage.get(route("usuarios.index", { page: event }));
};

const openModal = (op, nombre, email, telefono, tarea, usuario) => {
    modal.value = true;
    nextTick(() => nameInput.value.focus());
    operation.value = op;
    id.value = usuario;
    if (op == 1) {
        title.value = "Crear Usuario";
    } else {
        title.value = "Editar Usuario";
        form.nombre = nombre;
        form.email = email;
        form.telefono = telefono;
        form.tarea_id = tarea;
    }
};

//creamos la funcion con la cual nos permite cerrar el modal y resetear el formulario
const closeModal = () => {
    modal.value = false;
    form.reset();
};

//funcion para guardar y actualizar el usuario
const save = () => {
    if (operation.value == 1) {
        form.post(route("usuarios.store"), {
            onSuccess: () => {
                ok("Usuario Creado");
            },
        });
    } else {
        form.put(route("usuarios.update", id.value), {
            onSuccess: () => {
                ok("Usuario Actualizado");
            },
        });
    }
};

const ok = (msj) => {
    form.reset();
    closeModal();
    Swal.fire({ title: msj, icon: "success" });
};

// funcion para eliminar el usuario
const deleteUsuario = (id, nombre) => {
    const alert = Swal.mixin({
        buttonsStyling: true,
    });
    alert
        .fire({
            title: "Estas Seguro De Eliminar " + nombre + " ?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: '<i class="fa-solid fa-check"></i> Si, Eliminar',
            cancelButtonText: '<i class="fa-solid fa-ban"></i> Cancelar',
        })
        .then((result) => {
            if (result.isConfirmed) {
                form.delete(route("usuarios.destroy", id), {
                    onSuccess: () => {
                        ok("Usuario Eliminado");
                    },
                });
            }
        });
};
</script>

<template>
    <Head title="Usuarios" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Usuarios
            </h2>
        </template>

        <div class="py-12">
            <!-----------Este Boton nos permite registrar un nuevo usuario ------------>
            <div class="bg-white grid v-screen place-items-center">
                <div class="mt-3 mb-3 flex">
                    <PrimaryButton @click="openModal(1)">
                        <i class="fa-solid fa-plus-circle"></i> Agregar Usuario
                    </PrimaryButton>
                </div>
            </div>
            <div
                class="bg-white grid v-screen place-items-center overflow-x-auto py-3"
            >
                <table class="mr-4 ml-4 table-auto border border-gray-400">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-2 py-2">#</th>
                            <th class="px-2 py-2">Nombre</th>
                            <th class="px-2 py-2">Email</th>
                            <th class="px-2 py-2">Telefono</th>
                            <th class="px-2 py-2">Tarea</th>
                            <th class="px-2 py-2">Editar</th>
                            <th class="px-2 py-2">Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(user, i) in usuarios.data" :key="user.id">
                            <td class="border border-gray-400 px-2 py-2">
                                {{ i + 1 }}
                            </td>
                            <td class="border border-gray-400 px-2 py-2">
                                {{ user.nombre }}
                            </td>
                            <td class="border border-gray-400 px-2 py-2">
                                {{ user.email }}
                            </td>
                            <td class="border border-gray-400 px-2 py-2">
                                {{ user.telefono }}
                            </td>
                            <td class="border border-gray-400 px-2 py-2">
                                {{ user.tarea }}
                            </td>
                            <td class="border border-gray-400 px-2 py-2">
                                <!--abre el modal y nos precarga la informacion del usuario para poder editarla-->
                                <WarningButton
                                    @click="
                                        openModal(
                                            2,
                                            user.nombre,
                                            user.email,
                                            user.telefono,
                                            user.tarea_id,
                                            user.id
                                        )
                                    "
                                >
                                    <i class="fa-solid fa-edit"></i>
                                </WarningButton>
                            </td>
                            <td class="border border-gray-400 px-2 py-2">
                                <!--Este Boton nos permite eliminar la informacion del usuario-->
                                <DangerButton
                                    @click="deleteUsuario(user.id, user.nombre)"
                                    class="ml-2"
                                >
                                    <i class="fa-solid fa-trash"></i>
                                </DangerButton>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Este boton es el que nos permite manejar la paginacion de los usuarios-->
            <div class="bg-white grid v-screen place-items-center">
                <VueTailwindPagination
                    :current="usuarios.currentPage"
                    :total="usuarios.total"
                    :per-page="usuarios.perPage"
                    @page-changed="onPageClick($event)"
                >
                </VueTailwindPagination>
            </div>
        </div>

        <!--Este es el modal que nos permite tanto crear como editar los usuarios-->
        <Modal :show="modal" @close="closeModal">
            <h2 class="p-3 text-lg font.medium text-hray-900">{{ title }}</h2>
            <div class="p-3">
                <InputLabel for="name" value="Nombre:"></InputLabel>
                <TextInput
                    id="name"
                    ref="nameInput"
                    v-model="form.nombre"
                    type="text"
                    class="mt-1 block w-3/4"
                    placeholder="Nombre"
                ></TextInput>
                <InputError
                    :message="form.errors.nombre"
                    class="mt-2"
                ></InputError>
            </div>
            <div class="p-3">
                <InputLabel for="email" value="Email:"></InputLabel>
                <TextInput
                    id="email"
                    v-model="form.email"
                    type="text"
                    class="mt-1 block w-3/4"
                    placeholder="Email"
                ></TextInput>
                <InputError
                    :message="form.errors.email"
                    class="mt-2"
                ></InputError>
            </div>
            <div class="p-3">
                <InputLabel for="telefono" value="Telefono:"></InputLabel>
                <TextInput
                    id="telefono"
                    v-model="form.telefono"
                    type="text"
                    class="mt-1 block w-3/4"
                    placeholder="Telefono"
                ></TextInput>
                <InputError
                    :message="form.errors.telefono"
                    class="mt-2"
                ></InputError>
            </div>
            <div class="p-3">
                <InputLabel for="tarea_id" value="Tarea:"></InputLabel>
                <SelectInput
                    id="tarea_id"
                    :options="tareas"
                    v-model="form.tarea_id"
                    type="text"
                    class="mt-1 block w-3/4"
                ></SelectInput>
                <InputError
                    :message="form.errors.tarea_id"
                    class="mt-2"
                ></InputError>
            </div>
            <div class="p-6 m-6">
                <PrimaryButton :disable="form.processing" @click="save">
                    <i class="fa-solid fa-save"></i> Guardar
                </PrimaryButton>
            </div>
            <div class="p-6 m-6 flex justify-end">
                <SecondaryButton
                    class="ml-3"
                    :disable="form.processing"
                    @click="closeModal"
                >
                    Cerrar
                </SecondaryButton>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
