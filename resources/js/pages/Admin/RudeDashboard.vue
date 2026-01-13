<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { Edit, Trash2, Printer, Eye, User, Search, FileText, Activity, Clock, Users } from 'lucide-vue-next';
import { ref } from 'vue';

const props = defineProps({
    registros: Object,
    stats: Object, // { por_curso: [], hoy: 0, total: 0 }
});

const search = ref('');

const deleteRude = (id, name) => {
    if (confirm(`¿Estás seguro de eliminar el registro de ${name}? Esta acción no se puede deshacer.`)) {
        router.delete(route('rude.destroy', id));
    }
};

// Colors for courses to make them distinct
const courseColors = ['bg-orange-100 text-orange-800', 'bg-emerald-100 text-emerald-800', 'bg-cyan-100 text-cyan-800', 'bg-violet-100 text-violet-800', 'bg-rose-100 text-rose-800', 'bg-amber-100 text-amber-800'];
const getCourseColor = (index) => courseColors[index % courseColors.length];
</script>

<template>
    <Head title="Dashboard RUDE" />

    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-blue-900 leading-tight">
                Gestión de Inscripciones RUDE 2026
            </h2>
        </template>

        <div class="py-8 bg-gray-50 min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
                <!-- Welcome Banner & Key Metrics -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <!-- Total Students -->
                    <div class="bg-blue-900 rounded-xl shadow-lg p-6 text-white flex items-center justify-between relative overflow-hidden">
                        <div class="relative z-10">
                            <h3 class="font-bold text-lg opacity-90">Total Registrados</h3>
                            <span class="block text-4xl font-extrabold mt-1">{{ stats?.total || 0 }}</span>
                            <p class="text-blue-200 text-xs mt-1">Estudiantes inscritos</p>
                        </div>
                        <Users class="w-16 h-16 text-blue-800 absolute right-4 bottom-[-10px] transform rotate-12" />
                    </div>

                    <!-- Registered Today -->
                    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500 flex items-center justify-between">
                         <div>
                            <h3 class="font-bold text-gray-500 text-sm uppercase">Nuevos Hoy</h3>
                            <span class="block text-3xl font-extrabold text-gray-800 mt-1">{{ stats?.hoy || 0 }}</span>
                            <p class="text-green-600 text-xs font-bold mt-1 flex items-center gap-1">
                                <Activity class="w-3 h-3" /> Actividad Reciente
                            </p>
                         </div>
                         <div class="bg-green-100 p-3 rounded-full">
                            <Clock class="w-6 h-6 text-green-600" />
                         </div>
                    </div>

                    <!-- Actions -->
                    <div class="bg-white rounded-xl shadow-md p-6 flex flex-col justify-center items-center gap-3 border border-gray-100">
                        <Link :href="route('welcome')" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-lg text-center shadow transition-all flex items-center justify-center gap-2">
                             <User class="w-5 h-5" /> Inscribir Estudiante
                        </Link>
                    </div>
                </div>

                <!-- Stats by Course Grid -->
                <h3 class="font-bold text-gray-700 mb-4 px-1 flex items-center gap-2">
                    <span class="bg-blue-600 w-1 h-6 rounded-full inline-block"></span>
                    Estudiantes por Curso
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 mb-8">
                    <div 
                        v-for="(curso, idx) in stats?.por_curso" 
                        :key="idx" 
                        class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 transition hover:shadow-md"
                    >
                         <h4 class="text-xs font-bold text-gray-500 uppercase tracking-tight mb-2 truncate" :title="curso.anio_escolaridad">
                            {{ curso.anio_escolaridad }}
                         </h4>
                         <div class="flex items-center justify-between">
                             <span class="text-2xl font-bold text-gray-800">{{ curso.total }}</span>
                             <span :class="`text-xs px-2 py-1 rounded-full font-bold ${getCourseColor(idx)}`">Est.</span>
                         </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border border-gray-200">
                    
                    <!-- Search & Tools -->
                    <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-white sticky top-0 z-10">
                        <div class="relative w-full max-w-md">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <Search class="h-5 w-5 text-gray-400" />
                            </div>
                            <input 
                                v-model="search"
                                type="text" 
                                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-gray-50 placeholder-gray-500 focus:outline-none focus:bg-white focus:placeholder-gray-400 focus:border-blue-300 focus:ring focus:ring-blue-200 sm:text-sm transition duration-150 ease-in-out" 
                                placeholder="Buscar por nombre, CI o RUDE..." 
                            />
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Estudiante</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Curso</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Apoderado</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Registro (Hace)</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="rude in registros.data" :key="rude.id" class="hover:bg-blue-50 transition-colors group">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="relative">
                                                <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-800 font-bold text-lg">
                                                    {{ rude.nombres.charAt(0) }}
                                                </div>
                                                <span v-if="rude.is_recent" class="absolute -top-1 -right-1 bg-green-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full border-2 border-white shadow-sm animate-pulse">
                                                    NUEVO
                                                </span>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-bold text-gray-900 group-hover:text-blue-700 transition-colors">
                                                    {{ rude.apellido_paterno }} {{ rude.apellido_materno }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ rude.nombres }}
                                                </div>
                                                <div class="text-[10px] text-gray-400 font-mono mt-0.5">
                                                     CI: {{ rude.ci_estudiante || '---' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-50 text-blue-800">
                                            {{ rude.anio_escolaridad }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ rude.nombre_tutor }}</div>
                                        <div class="text-xs text-gray-500">
                                            {{ rude.celular_contacto ? '📱 ' + rude.celular_contacto : 'Sin Celular' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        <div class="flex items-center gap-1.5 font-medium" :class="{'text-green-600': rude.is_recent}">
                                            <Clock class="w-3.5 h-3.5" />
                                            {{ rude.created_at }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                        <!-- Botones de Acción -->
                                        
                                        <a :href="route('rude.print', rude.id)" target="_blank" class="text-gray-600 hover:text-blue-900 inline-flex items-center gap-1 bg-gray-100 hover:bg-blue-100 p-2 rounded-full transition-colors" title="Imprimir PDF">
                                            <Printer class="w-4 h-4" />
                                        </a>

                                        <Link :href="route('rude.edit', rude.id)" class="text-blue-600 hover:text-blue-900 inline-flex items-center gap-1 bg-blue-50 hover:bg-blue-100 p-2 rounded-full transition-colors" title="Editar">
                                            <Edit class="w-4 h-4" />
                                        </Link>

                                        <button @click="deleteRude(rude.id, rude.nombres)" class="text-red-600 hover:text-red-900 inline-flex items-center gap-1 bg-red-50 hover:bg-red-100 p-2 rounded-full transition-colors" title="Eliminar">
                                            <Trash2 class="w-4 h-4" />
                                        </button>
                                    </td>
                                </tr>
                                <tr v-if="registros.data.length === 0">
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <FileText class="w-12 h-12 text-gray-300 mb-3" />
                                            <p class="text-lg font-medium">No hay estudiantes registrados aún.</p>
                                            <p class="text-sm">Comparte el enlace del formulario para comenzar a recibir inscripciones.</p>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination (Simple) -->
                    <div v-if="registros.links && registros.data.length > 0" class="bg-gray-50 px-4 py-3 border-t border-gray-200 sm:px-6">
                        <div class="flex items-center justify-between">
                            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                                <div>
                                    <p class="text-sm text-gray-700">
                                        Mostrando <span class="font-medium">1</span> a <span class="font-medium">10</span> de <span class="font-medium">{{ registros.total }}</span> resultados
                                    </p>
                                </div>
                                <div class="flex gap-2">
                                    <Link 
                                        v-if="registros.prev_page_url" 
                                        :href="registros.prev_page_url"
                                        class="px-3 py-1 bg-white border border-gray-300 rounded text-sm font-medium hover:bg-gray-50 text-gray-700"
                                    >
                                        Anterior
                                    </Link>
                                    <Link 
                                        v-if="registros.next_page_url" 
                                        :href="registros.next_page_url"
                                        class="px-3 py-1 bg-white border border-gray-300 rounded text-sm font-medium hover:bg-gray-50 text-gray-700"
                                    >
                                        Siguiente
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </AppLayout>
</template>