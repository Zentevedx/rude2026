<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import AppLogo from '@/components/AppLogo.vue';

// Importamos los pasos (Child Components)
import StepEstudiante from './Partials/StepEstudiante.vue';
import StepDireccion from './Partials/StepDireccion.vue';
import StepSocioeconomico from './Partials/StepSocioeconomico.vue';
import StepPadres from './Partials/StepPadres.vue';

const currentStep = ref(1);
const totalSteps = 4;

// Estructura de Datos EXACTA a la Base de Datos
const form = useForm({
    estudiante: {
        codigo_rude: '',
        carnet_identidad: '',
        complemento: '',
        expedido: 'CB',
        apellido_paterno: '',
        apellido_materno: '',
        nombres: '',
        pais_nacimiento: 'Bolivia',
        departamento_nacimiento: 'Cochabamba',
        provincia_nacimiento: '',
        localidad_nacimiento: '',
        fecha_nacimiento: '',
        sexo: '',
        oficialia: '',
        libro: '',
        partida: '',
        folio: '',
        tiene_discapacidad: false,
        registro_discapacidad: '',
        // Archivos
        file_ci_anverso: null,
        file_ci_reverso: null,
    },
    direccion: {
        departamento: 'Cochabamba',
        provincia: '',
        municipio: '',
        localidad: '',
        zona: '',
        avenida_calle: '',
        numero_vivienda: '',
        telefono_fijo: '',
        celular_contacto: '',
    },
    socioeconomico: {
        idioma_ninez: '',
        idioma_frecuente_1: '',
        nacion_originaria: 'Ninguno',
        existe_centro_salud: true,
        tiene_seguro_salud: false,
        tiene_agua_potable: true,
        tiene_electricidad: true,
        tiene_alcantarillado: true,
        acceso_internet: 'Celular',
        medio_transporte: 'A pie',
        tiempo_transporte: 'Menos de 30 min'
    },
    tutor: {
        parentesco: 'PADRE',
        carnet_identidad: '',
        nombres: '',
        apellido_paterno: '',
        apellido_materno: '',
        idioma_frecuente: '',
        ocupacion_laboral: '',
        fecha_nacimiento: '',
        file_ci_anverso: null,
        file_ci_reverso: null,
    }
});

const submit = () => {
    form.post(route('rude.store'), {
        forceFormData: true, // Importante para subir archivos
        onSuccess: () => alert('¡Registro Exitoso!'),
        onError: () => alert('Por favor revisa los errores en el formulario.')
    });
};

const nextStep = () => { if(currentStep.value < totalSteps) currentStep.value++ };
const prevStep = () => { if(currentStep.value > 1) currentStep.value-- };
</script>

<template>
    <div class="min-h-screen bg-gray-50 flex flex-col items-center pt-6 sm:pt-0">
        
        <div class="w-full max-w-4xl bg-white shadow-md overflow-hidden rounded-lg mt-6">
            <div class="bg-[#D32F2F] p-4 flex items-center justify-between text-white">
                <div class="flex items-center gap-3">
                    <AppLogo class="h-12 w-12 text-white fill-current" />
                    <div>
                        <h1 class="font-bold text-lg uppercase">Unidad Educativa Ismael Vásquez</h1>
                        <p class="text-xs text-blue-100">Formulario RUDE 2026 - Digital</p>
                    </div>
                </div>
                <div class="text-right hidden sm:block">
                    <span class="font-mono text-xl font-bold opacity-80">Paso {{ currentStep }} de {{ totalSteps }}</span>
                </div>
            </div>

            <div class="w-full bg-gray-200 h-2">
                <div class="bg-[#1976D2] h-2 transition-all duration-300" :style="{ width: (currentStep / totalSteps) * 100 + '%' }"></div>
            </div>

            <form @submit.prevent="submit" class="p-6">
                
                <div v-show="currentStep === 1">
                    <StepEstudiante :form="form.estudiante" />
                </div>

                <div v-show="currentStep === 2">
                    <StepDireccion :form="form.direccion" />
                </div>

                <div v-show="currentStep === 3">
                    <StepSocioeconomico :form="form.socioeconomico" />
                </div>

                <div v-show="currentStep === 4">
                    <StepPadres :form="form.tutor" />
                </div>

                <div class="flex justify-between mt-8 border-t pt-4">
                    <button 
                        type="button" 
                        v-if="currentStep > 1"
                        @click="prevStep"
                        class="px-6 py-2 bg-gray-200 text-gray-700 rounded-md font-semibold hover:bg-gray-300 transition"
                    >
                        Atrás
                    </button>
                    <div v-else></div> <button 
                        v-if="currentStep < totalSteps"
                        type="button" 
                        @click="nextStep"
                        class="px-6 py-2 bg-[#1976D2] text-white rounded-md font-semibold hover:bg-blue-700 transition"
                    >
                        Siguiente
                    </button>

                    <button 
                        v-else
                        type="submit" 
                        :disabled="form.processing"
                        class="px-8 py-2 bg-[#D32F2F] text-white rounded-md font-bold hover:bg-red-700 transition shadow-lg transform active:scale-95"
                    >
                        {{ form.processing ? 'Guardando...' : 'FINALIZAR INSCRIPCIÓN' }}
                    </button>
                </div>
            </form>
        </div>
        
        <p class="mt-4 text-gray-400 text-xs text-center mb-6">
            © 2026 Colegio Ismael Vásquez - Sistema RUDE Seguro
        </p>
    </div>
</template>