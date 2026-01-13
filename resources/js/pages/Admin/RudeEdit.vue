<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import StepEstudiante from '@/Pages/Public/Partials/StepEstudiante.vue';
import StepDireccion from '@/Pages/Public/Partials/StepDireccion.vue';
import StepSocioeconomico from '@/Pages/Public/Partials/StepSocioeconomico.vue';
import StepPadres from '@/Pages/Public/Partials/StepPadres.vue';
import FormAlert from '@/components/FormAlert.vue';
import { Save, ArrowLeft } from 'lucide-vue-next';

const props = defineProps({
    rude_data: Object,
});

const form = useForm(props.rude_data);

const activeTab = ref('estudiante');
const tabs = [
    { id: 'estudiante', label: 'I. Estudiante' },
    { id: 'direccion', label: 'III. Dirección' },
    { id: 'socioeconomico', label: 'IV. Socioeconómico' },
    { id: 'padres', label: 'V. Padres/Tutor' },
];

const submit = () => {
    form.put(route('rude.update', form.id), {
        onSuccess: () => {
             // Toast handling usually generic
        },
        onError: () => {
            alert('Existen errores en el formulario. Por favor revise los campos.');
        }
    });
};
</script>

<template>
    <Head title="Editar RUDE" />

    <AppLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-blue-900 leading-tight">
                    Editando: {{ form.estudiante.nombres }} {{ form.estudiante.apellido_paterno }}
                </h2>
                <Link :href="route('dashboard')" class="text-sm text-gray-600 hover:text-blue-900 flex items-center gap-1">
                    <ArrowLeft class="w-4 h-4" /> Volver al Tablero
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
                <form @submit.prevent="submit">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        
                        <!-- Tabs Header -->
                        <div class="border-b border-gray-200 bg-gray-50 flex overflow-x-auto">
                            <button 
                                v-for="tab in tabs" 
                                :key="tab.id"
                                type="button"
                                @click="activeTab = tab.id"
                                class="px-6 py-4 text-sm font-medium whitespace-nowrap focus:outline-none transition-colors border-b-2"
                                :class="[
                                    activeTab === tab.id 
                                        ? 'border-blue-600 text-blue-800 bg-white' 
                                        : 'border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-100'
                                ]"
                            >
                                {{ tab.label }}
                            </button>
                        </div>

                        <!-- Content Area -->
                        <div class="p-6 sm:p-8 min-h-[500px]">
                            <!-- KeepAlive maintains state between tab switches -->
                            <KeepAlive>
                                <div v-if="activeTab === 'estudiante'">
                                    <StepEstudiante :form="form.estudiante" />
                                </div>
                                <div v-else-if="activeTab === 'direccion'">
                                    <StepDireccion :form="form.direccion" />
                                </div>
                                <div v-else-if="activeTab === 'socioeconomico'">
                                    <StepSocioeconomico :form="form.socioeconomico" />
                                </div>
                                <div v-else-if="activeTab === 'padres'">
                                    <StepPadres :form="form.padres" />
                                </div>
                            </KeepAlive>
                        </div>

                        <!-- Footer Actions -->
                        <div class="bg-gray-50 px-6 py-4 flex items-center justify-between border-t border-gray-200">
                             <span v-if="form.isDirty" class="text-amber-600 text-sm italic">
                                * Tienes cambios sin guardar
                             </span>
                             <span v-else></span>

                             <button 
                                type="submit" 
                                :disabled="form.processing"
                                class="inline-flex items-center px-6 py-3 bg-blue-900 border border-transparent rounded-md font-bold text-white uppercase tracking-widest hover:bg-blue-800 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring focus:ring-blue-300 disabled:opacity-25 transition"
                             >
                                <Save class="w-5 h-5 mr-2" />
                                {{ form.processing ? 'Guardando...' : 'Actualizar Datos' }}
                             </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>

        <FormAlert />
    </AppLayout>
</template>
