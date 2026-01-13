<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import { ref } from 'vue';
import AppLogo from '@/components/AppLogo.vue';

// Importamos los pasos (Child Components)
import StepEstudiante from './Partials/StepEstudiante.vue';
import StepDireccion from './Partials/StepDireccion.vue';
import StepSocioeconomico from './Partials/StepSocioeconomico.vue';
import StepPadres from './Partials/StepPadres.vue';
import FormAlert from '@/components/FormAlert.vue';

const currentStep = ref(1);
const totalSteps = 4;

// Estructura de Datos EXACTA a la Base de Datos
const form = useForm({
    // I. DATOS DE LA UNIDAD EDUCATIVA
    estudiante: {
        codigo_sie: '',
        // II. DATOS DEL ESTUDIANTE
        apellido_paterno: '',
        apellido_materno: '',
        nombres: '',
        pais_nacimiento: 'Bolivia',
        departamento_nacimiento: 'Cochabamba',
        provincia_nacimiento: '',
        localidad_nacimiento: '',
        cert_oficialia: '',
        cert_libro: '',
        cert_partida: '',
        cert_folio: '',
        fecha_nacimiento: '',
        sexo: '',
        codigo_rude: '',
        tiene_discapacidad: false,
        carnet_identidad: '',
        complemento: '',
        expedido: 'CB',
        // NUEVO: Campos para grado y archivos
        anio_escolaridad: '',
        file_ci_anverso: null,
        file_ci_reverso: null,
    },
    
    // III. DIRECCIÓN
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
    
    // IV. ASPECTOS SOCIOECONÓMICOS
    socioeconomico: {
        // a. Idioma
        idioma_ninez: '',
        idioma_frecuente_1: '',
        idioma_frecuente_2: '',
        idioma_frecuente_3: '',
        nacion_originaria: 'NINGUNO',
        
        // Salud
        existe_centro_salud: true,
        salud_sus: false,
        salud_caja: false,
        salud_publico: false,
        salud_privado: false,
        salud_vivienda: false,
        salud_tradicional: false,
        salud_automedicacion: false,
        frecuencia_salud: 'NINGUNA',
        tiene_seguro_salud: false,
        
        // b. Servicios
        acceso_agua: true,
        tiene_bano: true,
        tiene_alcantarillado: true,
        usa_electricidad: true,
        servicio_basura: true,
        propiedad_vivienda: 'PROPIA',
        
        // c. Internet
        acceso_internet_lugar: 'NO ACCEDE A INTERNET',
        frecuencia_internet: 'DIARIAMENTE',
        
        // d. Actividad Laboral
        trabajo_gestion_pasada: false,
        trabajo_actividad: '',
        trabajo_turnos: '',
        trabajo_frecuencia: '',
        trabajo_pago: false,
        
        // e. Transporte
        medio_transporte: 'A PIE',
        tiempo_transporte: 'MENOS DE MEDIA HORA',
        
        // f. Abandono
        abandono_gestion_pasada: false,
        abandono_razon: '',
    },
    
    // IV.g Discapacidades (Sólo si tiene_discapacidad = true)
    discapacidad: {
        discapacidad_auditiva: null,
        discapacidad_visual: null,
        discapacidad_intelectual: null,
        discapacidad_fisica: null,
        discapacidad_mental: null,
        discapacidad_autista: null,
        origen_discapacidad: 'NACIMIENTO',
        // Dificultades (si no tiene discapacidad)
        dificultad_lectura: false,
        dificultad_razonamiento: false,
        dificultad_calculo: false,
        dificultad_pedagogico: false,
    },
    
    // V. PADRES Y TUTORES
    padres: {
        vive_con: 'PADRE Y MADRE',
        
        // Padre
        padre_ci: '',
        padre_paterno: '',
        padre_materno: '',
        padre_nombres: '',
        padre_idioma: '',
        padre_ocupacion: '',
        padre_grado: '',
        padre_fecha_nacimiento: '',

        // Madre
        madre_ci: '',
        madre_paterno: '',
        madre_materno: '',
        madre_nombres: '',
        madre_idioma: '',
        madre_ocupacion: '',
        madre_grado: '',
        madre_fecha_nacimiento: '',

        // Tutor
        tutor_ci: '',
        tutor_paterno: '',
        tutor_materno: '',
        tutor_nombres: '',
        tutor_idioma: '',
        tutor_ocupacion: '',
        tutor_grado: '',
        tutor_parentesco: '',
        tutor_fecha_nacimiento: '',
        
        // NUEVO: Archivos Apoderado
        file_ci_anverso: null,
        file_ci_reverso: null,

        // Extra (opcional)
        extra_ci: '',
        extra_paterno: '',
        extra_materno: '',
        extra_nombres: '',
        extra_cargo: '',
        extra_institucion: '',
    }
});

const submit = () => {
    form.post(route('rude.store'), {
        forceFormData: true, 
        onSuccess: () => {
            // El componente FormAlert manejará el mensaje de éxito via flash
        },
        onError: (errors) => {
            // Si hay errores de validación, mostramos una alerta visual arriba
            // Y hacemos scroll al inicio para que el usuario la vea
            window.scrollTo({ top: 0, behavior: 'smooth' });
            console.error('Errores de registro:', errors);
        }
    });
};

const nextStep = () => { if(currentStep.value < totalSteps) currentStep.value++ };
const prevStep = () => { if(currentStep.value > 1) currentStep.value-- };
</script>

<template>
    <div class="min-h-screen bg-gray-50 flex flex-col items-center pt-6 sm:pt-0 pb-12">
        
        <div class="w-full max-w-4xl bg-white shadow-xl overflow-hidden rounded-2xl mt-6 border border-gray-100">
            <!-- Institutional Header -->
            <div class="bg-blue-900 p-6 flex items-center justify-between text-white relative overflow-hidden">
                <!-- Decorative background Pattern -->
                <div class="absolute top-0 right-0 w-64 h-64 bg-blue-800 rounded-full mix-blend-multiply filter blur-3xl opacity-20 -mr-16 -mt-16"></div>
                
                <div class="flex items-center gap-4 relative z-10">
                    <div class="bg-white p-2 rounded-full shadow-lg">
                        <AppLogo class="h-12 w-12 text-blue-900 fill-current" />
                    </div>
                    <div>
                        <h1 class="font-bold text-xl uppercase tracking-wide">Unidad Educativa Ismael Vásquez</h1>
                        <p class="text-xs text-blue-200 font-medium tracking-wider">Formulario RUDE 2026 - Digital</p>
                    </div>
                </div>
                <div class="text-right hidden sm:block relative z-10">
                    <div class="inline-flex items-center gap-2 bg-blue-800/50 px-4 py-2 rounded-lg border border-blue-700/50">
                        <span class="text-blue-200 text-xs uppercase font-bold tracking-wider">Paso</span>
                        <span class="font-mono text-2xl font-bold text-white leading-none">{{ currentStep }}</span>
                        <span class="text-blue-200 text-xs font-bold">/ {{ totalSteps }}</span>
                    </div>
                </div>
            </div>

            <!-- Progress Bar -->
            <div class="w-full bg-gray-100 h-1.5 flex">
                <div class="bg-red-600 h-1.5 transition-all duration-500 ease-out shadow-[0_0_10px_rgba(220,38,38,0.5)]" :style="{ width: (currentStep / totalSteps) * 100 + '%' }"></div>
            </div>

            <div class="p-6 sm:p-8">

                <!-- Resumen de Errores VISIBLE -->
                <div v-if="Object.keys(form.errors).length > 0" class="mb-8 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm animate-pulse">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-500 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-bold text-red-800">
                                Atención: Revisa los siguientes errores
                            </h3>
                            <div class="mt-2 text-sm text-red-700 font-medium">
                                <ul class="list-disc pl-5 space-y-1">
                                    <li v-for="(error, key) in form.errors" :key="key">
                                        {{ error }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <form @submit.prevent="submit" novalidate>
                
                <transition
                    enter-active-class="transition duration-300 ease-out"
                    enter-from-class="transform translate-x-4 opacity-0"
                    enter-to-class="transform translate-x-0 opacity-100"
                    leave-active-class="transition duration-200 ease-in"
                    leave-from-class="transform translate-x-0 opacity-100"
                    leave-to-class="transform -translate-x-4 opacity-0"
                    mode="out-in"
                >
                    <div :key="currentStep">
                        <component 
                            :is="[StepEstudiante, StepDireccion, StepSocioeconomico, StepPadres][currentStep - 1]"
                            :form="[form.estudiante, form.direccion, form.socioeconomico, form.padres][currentStep - 1]" 
                        />
                    </div>
                </transition>

                <div class="flex justify-between mt-10 border-t border-gray-100 pt-8">
                    <button 
                        type="button" 
                        v-if="currentStep > 1"
                        @click="prevStep"
                        class="px-6 py-2.5 bg-white text-gray-600 border border-gray-300 rounded-lg font-bold hover:bg-gray-50 hover:text-gray-900 transition-all focus:ring-2 focus:ring-gray-200"
                    >
                        ← Atrás
                    </button>
                    <div v-else></div> 

                    <button 
                        v-if="currentStep < totalSteps"
                        type="button" 
                        @click="nextStep"
                        class="px-8 py-2.5 bg-blue-900 text-white rounded-lg font-bold hover:bg-blue-800 transition-all shadow-md hover:shadow-lg transform active:scale-95 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 flex items-center gap-2"
                    >
                        Siguiente Paso →
                    </button>

                    <button 
                        v-else
                        type="submit" 
                        :disabled="form.processing"
                        class="px-8 py-2.5 bg-red-600 text-white rounded-lg font-bold hover:bg-red-700 transition-all shadow-md hover:shadow-lg transform active:scale-95 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 flex items-center gap-2"
                    >
                        <span v-if="form.processing" class="flex items-center gap-2">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            GUARDANDO REGISTRO...
                        </span>
                        <span v-else>FINALIZAR INSCRIPCIÓN</span>
                    </button>
                </div>
            </form>
            </div> 
        </div> 
        
        <p class="mt-8 text-gray-400 text-xs text-center font-medium">
            © 2026 Colegio Ismael Vásquez — Sistema RUDE Seguro v2.0
        </p>

        <!-- Componente FormAlert Global -->
        <FormAlert /> 
    </div>
</template>