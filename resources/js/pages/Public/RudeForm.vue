<script setup lang="ts">
import { ref } from 'vue';
import { useForm, Head } from '@inertiajs/vue3';
import { defineAsyncComponent } from 'vue';

// Importación de Componentes Modulares
import StepEstudiante from './Partials/StepEstudiante.vue';
import StepDireccion from './Partials/StepDireccion.vue';
import StepSocioeconomico from './Partials/StepSocioeconomico.vue';
import StepPadres from './Partials/StepPadres.vue';
import StepDocumentos from './Partials/StepDocumentos.vue';
import Button from '@/components/ui/button/Button.vue';

const currentStep = ref(0);
const steps = ['Estudiante', 'Dirección', 'Social', 'Padres', 'Fotos'];

// Formulario con TODOS los campos de la base de datos
const form = useForm({
    // I. UE
    ue_sie: '80980XXX', ue_nombre: 'ISMAEL VÁSQUEZ',
    // II. Estudiante
    apellido_paterno: '', apellido_materno: '', nombres: '', codigo_rude: '',
    sexo: '', fecha_nacimiento: '',
    nac_pais: 'BOLIVIA', nac_depto: 'COCHABAMBA', nac_provincia: '', nac_localidad: '',
    cert_oficialia: '', cert_libro: '', cert_partida: '', cert_folio: '',
    ci_estudiante: '', ci_complemento: '', ci_expedido: '',
    tiene_discapacidad: false, disc_registro: '', disc_tipo: '', disc_grado: '',
    // III. Dirección
    dir_depto: 'COCHABAMBA', dir_provincia: '', dir_municipio: '', 
    dir_localidad: '', dir_zona: '', dir_calle: '', 
    dir_numero: '', dir_telefono: '', dir_celular: '',
    // IV. Socio
    socio_idioma_ninez: '', socio_idioma_frec1: '', socio_idioma_frec2: '', 
    socio_nacion: '', salud_centro: '', salud_veces: '', salud_seguro: false,
    serv_agua: '', serv_electricidad: true, serv_alcantarillado: '',
    net_acceso: '', net_frecuencia: '',
    trabajo_realiza: false, trabajo_actividad: '', trabajo_dias: '', trabajo_turno: '',
    trans_medio: '', trans_tiempo: '',
    abandono_gestion_pasada: false, abandono_razon: '',
    // V. Padres
    padre_ci: '', padre_paterno: '', padre_materno: '', padre_nombres: '', padre_ocupacion: '', padre_grado: '',
    madre_ci: '', madre_paterno: '', madre_materno: '', madre_nombres: '', madre_ocupacion: '', madre_grado: '',
    tutor_ci: '', tutor_paterno: '', tutor_materno: '', tutor_nombres: '', tutor_parentesco: '',
    // Archivos
    foto_ci_est_anverso: null, foto_ci_est_reverso: null,
    foto_ci_tut_anverso: null, foto_ci_tut_reverso: null
});

const submit = () => {
    form.post(route('rude.store'), {
        onSuccess: () => alert('¡Registro completado exitosamente!'),
        onError: () => alert('Revise los errores en rojo.'),
    });
};
</script>

<template>
    <Head title="Inscripción RUDE 2025" />
    <div class="min-h-screen bg-gray-50 flex flex-col items-center py-6">
        <div class="w-full max-w-4xl bg-white shadow-xl rounded-lg overflow-hidden border-t-8 border-red-700">
            
            <div class="bg-blue-900 p-6 flex justify-between items-center text-white">
                <div>
                    <h1 class="font-bold text-2xl">U.E. ISMAEL VÁSQUEZ</h1>
                    <p class="text-blue-200 text-sm">Formulario RUDE - Gestión 2025</p>
                </div>
                <div class="text-right hidden sm:block">
                    <div class="text-xs opacity-75">PASO {{ currentStep + 1 }} DE 5</div>
                    <div class="font-bold text-lg">{{ steps[currentStep] }}</div>
                </div>
            </div>

            <form @submit.prevent="submit" class="p-6">
                
                <StepEstudiante v-show="currentStep === 0" :form="form" />
                <StepDireccion v-show="currentStep === 1" :form="form" />
                <StepSocioeconomico v-show="currentStep === 2" :form="form" />
                <StepPadres v-show="currentStep === 3" :form="form" />
                <StepDocumentos v-show="currentStep === 4" :form="form" />

                <div class="flex justify-between mt-8 border-t pt-4">
                    <Button type="button" v-if="currentStep > 0" @click="currentStep--" variant="outline">
                        Atrás
                    </Button>
                    <div v-else></div>

                    <Button type="button" v-if="currentStep < 4" @click="currentStep++" class="bg-blue-900 text-white">
                        Siguiente: {{ steps[currentStep + 1] }}
                    </Button>

                    <Button type="submit" v-if="currentStep === 4" class="bg-red-600 hover:bg-red-700 text-white w-full sm:w-auto" :disabled="form.processing">
                        FINALIZAR INSCRIPCIÓN
                    </Button>
                </div>
            </form>
        </div>
    </div>
</template>