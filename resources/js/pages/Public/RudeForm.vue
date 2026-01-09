<script setup lang="ts">
import { ref } from 'vue';
import { useForm, Head } from '@inertiajs/vue3';

// --- IMPORTACIONES CORREGIDAS SEGÚN TU ESTRUCTURA ---
import Label from '@/components/ui/label/Label.vue';
import Input from '@/components/ui/input/Input.vue';
import Button from '@/components/ui/button/Button.vue';
import Checkbox from '@/components/ui/checkbox/Checkbox.vue';
import { Separator } from '@/components/ui/separator';

// Definición de Pasos
const steps = ['Estudiante', 'Dirección', 'Socioeconómico', 'Padres/Tutor', 'Documentos'];
const currentStep = ref(0);

const form = useForm({
    // Sección II: Estudiante
    apellido_paterno: '', apellido_materno: '', nombres: '',
    fecha_nacimiento: '', sexo: '', codigo_rude: '',
    documento_identidad: '', documento_complemento: '',
    pais_nacimiento: 'BOLIVIA', departamento_nacimiento: 'COCHABAMBA',
    provincia_nacimiento: '', localidad_nacimiento: '',
    cert_oficialia: '', cert_libro: '', cert_partida: '', cert_folio: '',
    tiene_discapacidad: false,
    
    // Sección III: Dirección
    dir_departamento: 'COCHABAMBA', dir_provincia: '', dir_municipio: '',
    dir_zona: '', dir_calle: '', dir_celular: '',
    
    // Sección IV: Socioeconómico
    socio_idioma_ninez: '', socio_nacion_originaria: '',
    socio_salud_centro: '', socio_agua_procedencia: '',
    socio_internet_lugar: 'No tiene',
    socio_energia_electrica: true,
    
    // Sección V: Padres/Tutor
    padre_ci: '', padre_apellidos: '', padre_ocupacion: '',
    madre_ci: '', madre_apellidos: '', madre_ocupacion: '',
    tutor_ci: '', tutor_apellidos: '', tutor_parentesco: '',
    
    // Fotos
    foto_ci_est_anverso: null,
    foto_ci_est_reverso: null,
    foto_ci_tut_anverso: null,
    foto_ci_tut_reverso: null,
});

const handleFile = (e: Event, field: string) => {
    const target = e.target as HTMLInputElement;
    if (target.files && target.files.length > 0) {
        // @ts-ignore
        form[field] = target.files[0];
    }
};

const submit = () => {
    form.post(route('rude.store'), {
        preserveScroll: true,
        onSuccess: () => alert('¡Formulario RUDE enviado correctamente!'),
        onError: () => alert('Revise los errores en el formulario.'),
    });
};
</script>

<template>
    <Head title="Formulario RUDE" />
    
    <div class="min-h-screen bg-gray-50 flex flex-col items-center pt-6 sm:pt-10 pb-10">
        <div class="w-full max-w-4xl bg-white shadow-lg border-t-4 border-red-700 sm:rounded-lg overflow-hidden">
            <div class="bg-blue-900 p-6 flex flex-col md:flex-row items-center justify-between gap-4">
                <div>
                    <h1 class="text-white font-bold text-2xl tracking-tight">U.E. ISMAEL VÁSQUEZ</h1>
                    <p class="text-blue-200 text-sm">Sistema de Inscripción Digital</p>
                </div>
                <div class="bg-white px-4 py-1 rounded shadow text-red-700 font-extrabold text-lg">
                    RUDE 2025
                </div>
            </div>

            <div class="flex overflow-x-auto bg-gray-100 border-b border-gray-200">
                <div v-for="(step, index) in steps" :key="index" 
                     class="flex-1 min-w-[100px] py-4 text-center text-xs sm:text-sm font-semibold border-b-4 transition-colors duration-300"
                     :class="index <= currentStep ? 'border-red-600 text-blue-900 bg-white' : 'border-transparent text-gray-400'">
                    <span class="block text-lg mb-1" :class="index <= currentStep ? 'font-bold' : ''">{{ index + 1 }}</span>
                    {{ step }}
                </div>
            </div>

            <form @submit.prevent="submit" class="p-6 md:p-8 space-y-8">
                
                <div v-show="currentStep === 0" class="space-y-6 animate-in fade-in slide-in-from-bottom-2 duration-500">
                    <h3 class="text-xl font-bold text-blue-900 flex items-center gap-2">
                        <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">Sección II</span>
                        Datos de la o el Estudiante
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="space-y-2">
                            <Label>Apellido Paterno</Label>
                            <Input v-model="form.apellido_paterno" class="uppercase" placeholder="APELLIDO PATERNO" />
                            <span v-if="form.errors.apellido_paterno" class="text-red-500 text-xs">{{ form.errors.apellido_paterno }}</span>
                        </div>
                        <div class="space-y-2">
                            <Label>Apellido Materno</Label>
                            <Input v-model="form.apellido_materno" class="uppercase" placeholder="APELLIDO MATERNO" />
                        </div>
                        <div class="space-y-2">
                            <Label>Nombres</Label>
                            <Input v-model="form.nombres" class="uppercase" placeholder="NOMBRES" />
                            <span v-if="form.errors.nombres" class="text-red-500 text-xs">{{ form.errors.nombres }}</span>
                        </div>

                        <div class="md:col-span-3 bg-red-50 p-6 rounded-lg border border-red-200 shadow-sm mt-2">
                            <Label class="text-red-800 font-bold text-base">CÓDIGO RUDE (Tal cual figura en la libreta)</Label>
                            <Input v-model="form.codigo_rude" class="mt-2 w-full text-xl font-mono tracking-widest text-center border-red-300 focus:ring-red-500 uppercase" placeholder="XXXXXXXXXXXX" />
                            <p class="text-xs text-red-600 mt-2 font-medium">* Copie este código con cuidado. Si el estudiante es nuevo, solicítelo en dirección.</p>
                            <span v-if="form.errors.codigo_rude" class="text-red-600 font-bold text-sm block mt-1">{{ form.errors.codigo_rude }}</span>
                        </div>

                        <div class="space-y-2">
                            <Label>Fecha de Nacimiento</Label>
                            <Input type="date" v-model="form.fecha_nacimiento" />
                        </div>
                        
                        <div class="space-y-2">
                            <Label>Sexo</Label>
                            <select v-model="form.sexo" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                                <option value="" disabled>Seleccione...</option>
                                <option value="M">Masculino</option>
                                <option value="F">Femenino</option>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <Label>Carnet de Identidad (Estudiante)</Label>
                            <Input v-model="form.documento_identidad" placeholder="Número C.I." />
                            <span v-if="form.errors.documento_identidad" class="text-red-500 text-xs">{{ form.errors.documento_identidad }}</span>
                        </div>
                    </div>
                </div>

                <div v-show="currentStep === 1" class="space-y-6 animate-in fade-in slide-in-from-bottom-2 duration-500">
                    <h3 class="text-xl font-bold text-blue-900 flex items-center gap-2">
                         <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">Sección III</span>
                        Dirección Actual
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <Label>Departamento</Label>
                            <select v-model="form.dir_departamento" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm">
                                <option>COCHABAMBA</option>
                                <option>LA PAZ</option>
                                <option>SANTA CRUZ</option>
                                <option>ORURO</option>
                                <option>POTOSÍ</option>
                                <option>CHUQUISACA</option>
                                <option>TARIJA</option>
                                <option>BENI</option>
                                <option>PANDO</option>
                            </select>
                        </div>
                        <div class="space-y-2">
                            <Label>Municipio</Label>
                            <Input v-model="form.dir_municipio" class="uppercase" />
                        </div>
                        <div class="space-y-2">
                            <Label>Zona / Villa</Label>
                            <Input v-model="form.dir_zona" class="uppercase" />
                        </div>
                         <div class="space-y-2">
                            <Label>Calle / Avenida</Label>
                            <Input v-model="form.dir_calle" class="uppercase" />
                        </div>
                        <div class="md:col-span-2 bg-yellow-50 p-4 rounded border border-yellow-200">
                            <Label class="text-yellow-900 font-bold">Celular de Contacto (Padre/Tutor)</Label>
                            <Input v-model="form.dir_celular" type="tel" class="mt-1 bg-white" placeholder="70000000" />
                            <p class="text-xs text-yellow-700 mt-1">Este número es VITAL para comunicados del colegio.</p>
                        </div>
                    </div>
                </div>

                <div v-show="currentStep === 2" class="space-y-6 animate-in fade-in slide-in-from-bottom-2 duration-500">
                     <h3 class="text-xl font-bold text-blue-900 flex items-center gap-2">
                         <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">Sección IV</span>
                        Aspectos Socioeconómicos
                    </h3>
                    
                    <div class="space-y-6">
                        <div class="space-y-2">
                            <Label>4.1 ¿Idiomas que habla frecuentemente?</Label>
                            <div class="grid grid-cols-2 gap-4">
                                <Input v-model="form.socio_idioma_frecuente_1" placeholder="Idioma 1 (Ej. Castellano)" />
                                <Input v-model="form.socio_idioma_frecuente_2" placeholder="Idioma 2 (Ej. Quechua)" />
                            </div>
                        </div>
                        
                        <div class="space-y-4 pt-4 border-t">
                            <Label class="text-base font-semibold">4.3 Acceso a Servicios Básicos</Label>
                            <div class="flex items-center space-x-2">
                                <Checkbox id="luz" :checked="form.socio_energia_electrica" @update:checked="form.socio_energia_electrica = $event" />
                                <label for="luz" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                                    Cuenta con Energía Eléctrica
                                </label>
                            </div>
                            </div>
                    </div>
                </div>

                <div v-show="currentStep === 3" class="space-y-6 animate-in fade-in slide-in-from-bottom-2 duration-500">
                     <h3 class="text-xl font-bold text-blue-900 flex items-center gap-2">
                         <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">Sección V</span>
                        Datos de Padres o Tutor
                    </h3>

                    <div class="bg-gray-50 p-4 rounded-lg border">
                        <span class="font-bold text-gray-700 block mb-3 uppercase">Datos del Padre</span>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <Label>C.I.</Label>
                                <Input v-model="form.padre_ci" />
                            </div>
                            <div class="space-y-2">
                                <Label>Apellidos y Nombres</Label>
                                <Input v-model="form.padre_apellidos" class="uppercase" />
                            </div>
                        </div>
                    </div>

                     <div class="bg-gray-50 p-4 rounded-lg border">
                        <span class="font-bold text-gray-700 block mb-3 uppercase">Datos de la Madre</span>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <Label>C.I.</Label>
                                <Input v-model="form.madre_ci" />
                            </div>
                             <div class="space-y-2">
                                <Label>Apellidos y Nombres</Label>
                                <Input v-model="form.madre_apellidos" class="uppercase" />
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                        <span class="font-bold text-blue-800 block mb-3 uppercase">Datos del Tutor (Responsable de Inscripción)</span>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <Label>C.I. Tutor</Label>
                                <Input v-model="form.tutor_ci" />
                            </div>
                             <div class="space-y-2">
                                <Label>Nombre Completo</Label>
                                <Input v-model="form.tutor_apellidos" class="uppercase" />
                            </div>
                            <div class="space-y-2 md:col-span-2">
                                <Label>Parentesco</Label>
                                <Input v-model="form.tutor_parentesco" placeholder="Ej. TIO, ABUELA, MADRE" class="uppercase" />
                            </div>
                        </div>
                    </div>
                </div>

                <div v-show="currentStep === 4" class="space-y-6 animate-in fade-in slide-in-from-bottom-2 duration-500">
                    <h3 class="text-xl font-bold text-red-700 flex items-center gap-2 border-b border-red-200 pb-2">
                        <span class="text-2xl">📸</span> Verificación Documental
                    </h3>
                    <p class="text-sm text-gray-600">
                        Para validar la inscripción, debe subir fotografías claras del Carnet de Identidad (anverso y reverso).
                    </p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <h4 class="font-bold text-blue-900 text-sm uppercase text-center bg-blue-50 py-2 rounded">Estudiante</h4>
                            
                            <div class="border-2 border-dashed border-blue-300 rounded-xl p-6 text-center hover:bg-blue-50 transition-colors cursor-pointer relative">
                                <span class="block font-bold text-blue-900 mb-2">Anverso (Frente)</span>
                                <input type="file" @change="e => handleFile(e, 'foto_ci_est_anverso')" accept="image/*" class="absolute inset-0 opacity-0 w-full h-full cursor-pointer" />
                                <div v-if="form.foto_ci_est_anverso" class="text-green-600 font-bold text-sm">✅ Foto cargada</div>
                                <div v-else class="text-blue-400 text-sm">Toque para subir foto</div>
                            </div>

                            <div class="border-2 border-dashed border-blue-300 rounded-xl p-6 text-center hover:bg-blue-50 transition-colors cursor-pointer relative">
                                <span class="block font-bold text-blue-900 mb-2">Reverso (Atrás)</span>
                                <input type="file" @change="e => handleFile(e, 'foto_ci_est_reverso')" accept="image/*" class="absolute inset-0 opacity-0 w-full h-full cursor-pointer" />
                                <div v-if="form.foto_ci_est_reverso" class="text-green-600 font-bold text-sm">✅ Foto cargada</div>
                                <div v-else class="text-blue-400 text-sm">Toque para subir foto</div>
                            </div>
                        </div>
                        
                        <div class="space-y-4">
                            <h4 class="font-bold text-gray-800 text-sm uppercase text-center bg-gray-100 py-2 rounded">Padre o Tutor</h4>
                            
                            <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:bg-gray-50 transition-colors cursor-pointer relative">
                                <span class="block font-bold text-gray-700 mb-2">Anverso (Frente)</span>
                                <input type="file" @change="e => handleFile(e, 'foto_ci_tut_anverso')" accept="image/*" class="absolute inset-0 opacity-0 w-full h-full cursor-pointer" />
                                <div v-if="form.foto_ci_tut_anverso" class="text-green-600 font-bold text-sm">✅ Foto cargada</div>
                                <div v-else class="text-gray-400 text-sm">Toque para subir foto</div>
                            </div>

                             <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:bg-gray-50 transition-colors cursor-pointer relative">
                                <span class="block font-bold text-gray-700 mb-2">Reverso (Atrás)</span>
                                <input type="file" @change="e => handleFile(e, 'foto_ci_tut_reverso')" accept="image/*" class="absolute inset-0 opacity-0 w-full h-full cursor-pointer" />
                                <div v-if="form.foto_ci_tut_reverso" class="text-green-600 font-bold text-sm">✅ Foto cargada</div>
                                <div v-else class="text-gray-400 text-sm">Toque para subir foto</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-between mt-8 pt-6 border-t border-gray-100">
                    <Button v-if="currentStep > 0" @click="currentStep--" type="button" variant="outline" class="border-gray-300 text-gray-700">
                        Atrás
                    </Button>
                    <div v-else></div>

                    <Button v-if="currentStep < steps.length - 1" @click="currentStep++" type="button" class="bg-blue-900 hover:bg-blue-800 text-white px-8">
                        Siguiente
                    </Button>
                    
                    <Button v-if="currentStep === steps.length - 1" class="bg-red-600 hover:bg-red-700 text-white font-bold px-8 shadow-lg shadow-red-200" :disabled="form.processing">
                        <span v-if="form.processing">Enviando...</span>
                        <span v-else>FINALIZAR REGISTRO</span>
                    </Button>
                </div>
            </form>
        </div>
        
        <p class="mt-8 text-center text-xs text-gray-400">
            &copy; 2025 Unidad Educativa Ismael Vásquez. Todos los derechos reservados.
        </p>
    </div>
</template>