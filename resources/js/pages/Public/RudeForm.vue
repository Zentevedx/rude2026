<script setup lang="ts">
import { ref } from 'vue';
import { useForm, Head } from '@inertiajs/vue3';

// Importación de Componentes
import StepEstudiante from './Partials/StepEstudiante.vue';
import StepDireccion from './Partials/StepDireccion.vue';
import StepSocioeconomico from './Partials/StepSocioeconomico.vue';
import StepPadres from './Partials/StepPadres.vue';
import StepDocumentos from './Partials/StepDocumentos.vue';
import Button from '@/components/ui/button/Button.vue';

// --- ESTADO Y FORMULARIO ---
const currentStep = ref(0);
const steps = ['Estudiante', 'Dirección', 'Social', 'Padres', 'Fotos'];

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
    // V. Padres
    padre_ci: '', padre_paterno: '', padre_materno: '', padre_nombres: '', padre_ocupacion: '', padre_grado: '',
    madre_ci: '', madre_paterno: '', madre_materno: '', madre_nombres: '', madre_ocupacion: '', madre_grado: '',
    tutor_ci: '', tutor_paterno: '', tutor_materno: '', tutor_nombres: '', tutor_parentesco: '',
    // Archivos
    foto_ci_est_anverso: null, foto_ci_est_reverso: null,
    foto_ci_tut_anverso: null, foto_ci_tut_reverso: null
});

// --- LÓGICA DE VALIDACIÓN DEL LADO DEL CLIENTE (UX) ---
const validateStep = (stepIndex: number) => {
    form.clearErrors(); // Limpiamos errores previos
    let isValid = true;

    // Función auxiliar para marcar error
    const setError = (field: string, message: string) => {
        form.errors[field] = message;
        isValid = false;
    };

    // PASO 1: ESTUDIANTE
    if (stepIndex === 0) {
        if (!form.nombres) setError('nombres', 'El nombre es obligatorio.');
        if (!form.apellido_paterno && !form.apellido_materno) setError('apellido_paterno', 'Debe ingresar al menos un apellido.');
        if (!form.codigo_rude) setError('codigo_rude', 'El Código RUDE es vital y obligatorio.');
        else if (form.codigo_rude.length < 8) setError('codigo_rude', 'El RUDE parece muy corto.');
        
        if (!form.fecha_nacimiento) setError('fecha_nacimiento', 'La fecha de nacimiento es obligatoria.');
        if (!form.sexo) setError('sexo', 'Debe seleccionar el género.');
        if (!form.nac_provincia) setError('nac_provincia', 'Provincia de nacimiento requerida.');
        if (!form.nac_localidad) setError('nac_localidad', 'Localidad de nacimiento requerida.');
    }

    // PASO 2: DIRECCIÓN
    if (stepIndex === 1) {
        if (!form.dir_provincia) setError('dir_provincia', 'La provincia es obligatoria.');
        if (!form.dir_municipio) setError('dir_municipio', 'El municipio es obligatorio.');
        if (!form.dir_zona) setError('dir_zona', 'La Zona/Villa es obligatoria.');
        if (!form.dir_calle) setError('dir_calle', 'La calle es obligatoria.');
        
        // Validación estricta de celular (Solo números, min 8 dígitos)
        if (!form.dir_celular) {
            setError('dir_celular', 'El celular es OBLIGATORIO para contacto.');
        } else if (!/^\d{8,10}$/.test(form.dir_celular)) {
            setError('dir_celular', 'El celular debe tener al menos 8 números válidos.');
        }
    }

    // PASO 3: SOCIOECONÓMICO
    if (stepIndex === 2) {
        if (!form.socio_idioma_ninez) setError('socio_idioma_ninez', 'Campo obligatorio.');
        if (!form.socio_nacion) setError('socio_nacion', 'Debe seleccionar una opción.');
        if (!form.salud_centro) setError('salud_centro', 'Seleccione dónde acude por salud.');
        if (!form.serv_agua) setError('serv_agua', 'Seleccione la procedencia del agua.');
    }

    // PASO 4: TUTOR
    if (stepIndex === 3) {
        // Validamos al Tutor Responsable
        if (!form.tutor_ci) setError('tutor_ci', 'El carnet del tutor es obligatorio.');
        if (!form.tutor_nombres) setError('tutor_nombres', 'El nombre del tutor es obligatorio.');
        if (!form.tutor_parentesco) setError('tutor_parentesco', 'Indique el parentesco (Ej. PADRE).');
    }

    // Si hay errores, hacemos scroll hacia arriba para que el usuario los vea
    if (!isValid) {
        window.scrollTo({ top: 0, behavior: 'smooth' });
        // Opcional: Vibrar en móviles
        if (navigator.vibrate) navigator.vibrate(200);
    }

    return isValid;
};

const handleNext = () => {
    // Solo avanzamos si el paso actual es válido
    if (validateStep(currentStep.value)) {
        currentStep.value++;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
};

const submit = () => {
    // Validamos el último paso (Fotos) antes de enviar
    form.clearErrors();
    let isValid = true;
    
    if (!form.foto_ci_est_anverso) {
        form.errors.foto_ci_est_anverso = 'Debe subir la foto del anverso del carnet del estudiante.';
        isValid = false;
    }
    if (!form.foto_ci_tut_anverso) {
        form.errors.foto_ci_tut_anverso = 'Debe subir la foto del anverso del carnet del tutor.';
        isValid = false;
    }

    if (!isValid) {
        window.scrollTo({ top: 0, behavior: 'smooth' });
        return;
    }

    // Si todo está OK, enviamos al servidor
    form.post(route('rude.store'), {
        forceFormData: true,
        onSuccess: () => {
            alert('¡Registro guardado correctamente!');
            form.reset();
            currentStep.value = 0;
        },
        onError: () => {
            alert('El servidor rechazó algunos datos. Por favor revise los mensajes en rojo.');
        },
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
                
                <StepEstudiante v-if="currentStep === 0" :form="form" />
                <StepDireccion v-if="currentStep === 1" :form="form" />
                <StepSocioeconomico v-if="currentStep === 2" :form="form" />
                <StepPadres v-if="currentStep === 3" :form="form" />
                <StepDocumentos v-if="currentStep === 4" :form="form" />

                <div class="flex justify-between mt-8 border-t pt-4">
                    <Button type="button" v-if="currentStep > 0" @click="currentStep--" variant="outline">
                        Atrás
                    </Button>
                    <div v-else></div>

                    <Button type="button" v-if="currentStep < 4" @click="handleNext" class="bg-blue-900 text-white hover:bg-blue-800">
                        Siguiente: {{ steps[currentStep + 1] }}
                    </Button>

                    <Button type="submit" v-if="currentStep === 4" class="bg-red-600 hover:bg-red-700 text-white w-full sm:w-auto" :disabled="form.processing">
                        <span v-if="form.processing">Enviando...</span>
                        <span v-else>FINALIZAR INSCRIPCIÓN</span>
                    </Button>
                </div>
            </form>
        </div>
    </div>
</template>