<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, computed } from 'vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    registros: Array
});

const search = ref('');
const selectedStudent = ref(null);

// Filtrado en tiempo real para agilizar la búsqueda
const filteredRegistros = computed(() => {
    return props.registros.filter(r => 
        r.nombres.toLowerCase().includes(search.value.toLowerCase()) ||
        r.ci_tutor.includes(search.value)
    );
});

const openDetail = (student) => {
    selectedStudent.value = student;
};
</script>

<template>
    <Head title="Panel RUDE - Ismael Vásquez" />

    <AppLayout>
        <div class="py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between border-b-2 border-[#003366] pb-4">
                    <div>
                        <h1 class="text-2xl font-bold text-[#003366]">Registros RUDE 2025</h1>
                        <p class="text-sm text-gray-600">U.E. ISMAEL VÁSQUEZ</p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <input v-model="search" type="text" placeholder="Buscar por nombre o CI..." 
                               class="rounded-lg border-gray-300 focus:ring-[#CC0000] focus:border-[#CC0000] w-full md:w-64">
                    </div>
                </div>

                <div class="bg-white shadow-xl rounded-lg overflow-hidden border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-[#003366] text-white">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Estudiante</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">CI / Celular</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Tutor</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Fecha Reg.</th>
                                <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="item in filteredRegistros" :key="item.id" class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900">{{ item.apellido_paterno }} {{ item.apellido_materno }}</div>
                                    <div class="text-sm text-gray-500">{{ item.nombres }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">CI: {{ item.ci_estudiante || 'S/N' }}</div>
                                    <div class="text-sm text-blue-600 font-medium">{{ item.celular_contacto }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ item.nombre_tutor }}</div>
                                    <div class="text-xs text-gray-500 italic">{{ item.parentesco_tutor }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ new Date(item.created_at).toLocaleDateString() }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button @click="openDetail(item)" class="text-[#CC0000] hover:text-red-900 font-bold uppercase text-xs">Ver Detalle</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div v-if="selectedStudent" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
                    <div class="bg-white rounded-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto p-6 shadow-2xl border-t-8 border-[#003366]">
                        <div class="flex justify-between items-start mb-4">
                            <h2 class="text-xl font-bold text-[#003366] uppercase">Expediente del Estudiante</h2>
                            <button @click="selectedStudent = null" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2 text-sm">
                                <p><strong>Lugar Nacimiento:</strong> {{ selectedStudent.pais_nac }}, {{ selectedStudent.depto_nac }}</p>
                                <p><strong>Dirección:</strong> {{ selectedStudent.dir_zona }}, {{ selectedStudent.dir_calle }} #{{ selectedStudent.dir_num_casa }}</p>
                                <p><strong>Socioeconomía:</strong> Habla {{ selectedStudent.idioma_niñez }}, {{ selectedStudent.agua_red ? 'Tiene Agua' : 'No tiene Agua' }}</p>
                            </div>

                            <div class="space-y-4">
                                <h3 class="font-bold text-[#CC0000] border-b">Documentación Cargada</h3>
                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <p class="text-[10px] uppercase font-bold text-gray-500">CI Estudiante</p>
                                        <img :src="`/admin/rude/foto/${selectedStudent.id}/est_anverso`" class="w-full h-32 object-cover rounded border">
                                    </div>
                                    <div>
                                        <p class="text-[10px] uppercase font-bold text-gray-500">CI Tutor</p>
                                        <img :src="`/admin/rude/foto/${selectedStudent.id}/tut_anverso`" class="w-full h-32 object-cover rounded border">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>