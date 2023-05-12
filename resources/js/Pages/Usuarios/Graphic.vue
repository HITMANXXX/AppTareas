<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";
import { Bar } from "vue-chartjs";
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale,
    ArcElement,
} from "chart.js";
ChartJS.register(
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale,
    ArcElement
);

const props = defineProps({
    data: {
        type: Object,
    },
});

//definimos nuestra constantes para las graficas
const tareas = ref([]);
const usuarios = ref([]);
const chartData = ref([]);
const chartOptions = ref([]);
const colors = ref([]);

//definimos colores de manera aleatoria
const random = () => {
    return Math.floor(Math.random() * 256);
};

//por cada reguistro que tengamos llenamos las variables de tareas , usuarios y los colores
props.data.map((row) => {
    tareas.value.push(row.titulo),
        usuarios.value.push(row.count),
        colors.value.push(
            "rgb(" + random() + "," + random() + "," + random() + ")"
        );
});

chartOptions.value = { responsive: true };
chartData.value = {
    labels: tareas.value,
    datasets: [
        { label: "Usuarios", data: usuarios.value, backgroundColor: colors },
    ],
};
</script>

<template>
    <Head title="Grafica" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Grafica
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <Bar :data="chartData" :options="chartOptions"></Bar>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
