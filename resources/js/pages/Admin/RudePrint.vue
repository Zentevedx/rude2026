<script setup>
import { Head } from '@inertiajs/vue3';
import { onMounted } from 'vue';

const props = defineProps({
    estudiante: Object,
});

const print = () => {
    window.print();
};

// Check if boolean/string is truthy
const chk = (val) => val ? '☑' : '☐';
const txt = (val) => val || '..................';
</script>

<template>
    <Head title="Imprimir RUDE" />
    
    <div class="min-h-screen bg-gray-200 print:bg-white p-4 flex justify-center">
        <!-- A4 Container -->
        <div class="bg-white w-[215mm] min-h-[279mm] shadow-lg print:shadow-none print:w-full p-8 print:p-0 text-[10px] leading-tight font-sans text-gray-900 border box-border">
            
            <!-- BUTTONS (Hidden on print) -->
            <div class="print:hidden mb-4 flex justify-between">
                <button @click="print" class="bg-blue-900 text-white px-4 py-2 rounded font-bold hover:bg-blue-800">
                    🖨 IMPRIMIR AHORA
                </button>
                <div class="text-xs text-gray-500 max-w-md text-right">
                    * Sugerencia: En la configuración de impresión, active "Gráficos de fondo" y ajuste la escala si es necesario para ajustar a una página.
                </div>
            </div>

            <!-- HEADER -->
            <div class="flex justify-between items-center border-b-2 border-black pb-2 mb-2">
                <div class="w-16 h-16 bg-gray-100 flex items-center justify-center text-xs text-gray-400 border">ESCUDO</div>
                <div class="text-center">
                    <h1 class="font-bold text-lg uppercase">Formulario de Inscripción / Actualización RUDE</h1>
                    <p class="font-bold">REGISTRO ÚNICO DE ESTUDIANTES</p>
                    <p class="text-[9px]">ESTADO PLURINACIONAL DE BOLIVIA - MINISTERIO DE EDUCACIÓN</p>
                </div>
                <div class="text-right">
                    <div class="border border-black px-2 py-1 mb-1">
                        <span class="font-bold block">CÓDIGO SIE</span>
                        <span class="text-lg font-mono tracking-widest">{{ estudiante.codigo_sie || '80980567' }}</span>
                    </div>
                </div>
            </div>

            <!-- I. DATOS UE -->
            <div class="mb-2 border border-black">
                <div class="bg-gray-200 px-2 py-0.5 font-bold border-b border-black">I. DATOS DE LA UNIDAD EDUCATIVA</div>
                <div class="p-1 grid grid-cols-2 gap-2">
                    <div><span class="font-bold">Nombre:</span> UNIDAD EDUCATIVA ISMAEL VÁSQUEZ</div>
                    <div><span class="font-bold">Dependencia:</span> FISCAL</div>
                    <div><span class="font-bold">Distrito:</span> COCHABAMBA 1</div>
                    <div><span class="font-bold">Año de Escolaridad:</span> {{ txt(estudiante.anio_escolaridad) }}</div>
                </div>
            </div>

            <!-- II. DATOS ESTUDIANTE -->
            <div class="mb-2 border border-black">
                <div class="bg-gray-200 px-2 py-0.5 font-bold border-b border-black">II. DATOS DEL ESTUDIANTE</div>
                <div class="p-1">
                    <div class="grid grid-cols-3 gap-2 mb-2">
                        <div><span class="font-bold block text-[9px]">Ap. Paterno:</span> {{ txt(estudiante.apellido_paterno) }}</div>
                        <div><span class="font-bold block text-[9px]">Ap. Materno:</span> {{ txt(estudiante.apellido_materno) }}</div>
                        <div><span class="font-bold block text-[9px]">Nombres:</span> {{ txt(estudiante.nombres) }}</div>
                    </div>
                    <div class="grid grid-cols-4 gap-2 mb-2">
                        <div><span class="font-bold block text-[9px]">Documento (CI):</span> {{ txt(estudiante.carnet_identidad) }} {{ estudiante.complemento }} {{ estudiante.expedido }}</div>
                        <div><span class="font-bold block text-[9px]">Fecha Nac:</span> {{ txt(estudiante.fecha_nacimiento) }}</div>
                        <div><span class="font-bold block text-[9px]">Sexo:</span> {{ txt(estudiante.sexo) }}</div>
                        <div><span class="font-bold block text-[9px]">RUDE:</span> {{ txt(estudiante.codigo_rude) }}</div>
                    </div>
                    <div class="grid grid-cols-4 gap-2">
                        <div><span class="font-bold block text-[9px]">País Nac:</span> {{ txt(estudiante.pais_nacimiento) }}</div>
                        <div><span class="font-bold block text-[9px]">Depto Nac:</span> {{ txt(estudiante.departamento_nacimiento) }}</div>
                        <div><span class="font-bold block text-[9px]">Provincia:</span> {{ txt(estudiante.provincia_nacimiento) }}</div>
                        <div><span class="font-bold block text-[9px]">Localidad:</span> {{ txt(estudiante.localidad_nacimiento) }}</div>
                    </div>
                    <div class="mt-2 border-t pt-1 flex gap-4" v-if="estudiante.cert_oficialia">
                         <span class="font-bold">Cert. Nac:</span>
                         Oficialía: {{ estudiante.cert_oficialia }} | Libro: {{ estudiante.cert_libro }} | Partida: {{ estudiante.cert_partida }} | Folio: {{ estudiante.cert_folio }}
                    </div>
                </div>
            </div>

            <!-- III. DIRECCION -->
            <div class="mb-2 border border-black">
                <div class="bg-gray-200 px-2 py-0.5 font-bold border-b border-black">III. DIRECCIÓN ACTUAL</div>
                <div class="p-1 grid grid-cols-3 gap-2" v-if="estudiante.direccion">
                    <div><span class="font-bold">Depto:</span> {{ txt(estudiante.direccion.departamento) }}</div>
                    <div><span class="font-bold">Provincia:</span> {{ txt(estudiante.direccion.provincia) }}</div>
                    <div><span class="font-bold">Municipio:</span> {{ txt(estudiante.direccion.municipio) }}</div>
                    <div><span class="font-bold">Localidad:</span> {{ txt(estudiante.direccion.localidad) }}</div>
                    <div><span class="font-bold">Zona:</span> {{ txt(estudiante.direccion.zona) }}</div>
                    <div><span class="font-bold">Av/Calle:</span> {{ txt(estudiante.direccion.avenida_calle) }} #{{ estudiante.direccion.numero_vivienda }}</div>
                    <div><span class="font-bold">Telf/Cel:</span> {{ estudiante.direccion.telefono_fijo }} / {{ estudiante.direccion.celular_contacto }}</div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-2 mb-2 h-auto text-[9px]">
                
                <!-- IV. SOCIOECONOMICO -->
                <div class="border border-black">
                     <div class="bg-gray-200 px-2 py-0.5 font-bold border-b border-black">IV. ASPECTOS SOCIOECONÓMICOS</div>
                     <div class="p-1 space-y-1" v-if="estudiante.socioeconomico">
                        <div><span class="font-bold">Idioma Niñez:</span> {{ estudiante.socioeconomico.idioma_ninez }}</div>
                        <div><span class="font-bold">Idiomas Frecuentes:</span> {{ estudiante.socioeconomico.idioma_frecuente_1 }}</div>
                        <div><span class="font-bold">Nación Originaria:</span> {{ estudiante.socioeconomico.nacion_originaria }}</div>
                        
                        <div class="border-t border-gray-300 my-1 pt-1">
                            <span class="font-bold">Salud:</span>
                            Centro de Salud cercano: {{ chk(estudiante.socioeconomico.existe_centro_salud) }} |
                            Seguro: {{ chk(estudiante.socioeconomico.tiene_seguro_salud) }}
                        </div>
                        
                        <div class="border-t border-gray-300 my-1 pt-1">
                            <span class="font-bold">Servicios Básicos:</span>
                            <div class="grid grid-cols-2">
                                <div>Agua: {{ chk(estudiante.socioeconomico.acceso_agua) }}</div>
                                <div>Baño: {{ chk(estudiante.socioeconomico.tiene_bano) }}</div>
                                <div>Alcantarilla: {{ chk(estudiante.socioeconomico.tiene_alcantarillado) }}</div>
                                <div>Luz: {{ chk(estudiante.socioeconomico.usa_electricidad) }}</div>
                            </div>
                        </div>

                        <div class="border-t border-gray-300 my-1 pt-1">
                            <div><span class="font-bold">Internet:</span> {{ estudiante.socioeconomico.acceso_internet_lugar }} ({{ estudiante.socioeconomico.frecuencia_internet }})</div>
                        </div>
                        
                        <div class="border-t border-gray-300 my-1 pt-1">
                            <div><span class="font-bold">Trabajo (Gestión pas.):</span> {{ chk(estudiante.socioeconomico.trabajo_gestion_pasada) }}</div>
                            <div v-if="estudiante.socioeconomico.trabajo_gestion_pasada">
                                Actividad: {{ estudiante.socioeconomico.trabajo_actividad }}
                            </div>
                        </div>
                     </div>
                </div>

                <!-- V. PADRES -->
                <div class="border border-black">
                     <div class="bg-gray-200 px-2 py-0.5 font-bold border-b border-black">V. PADRES O TUTOR</div>
                     <div class="p-1 space-y-2" v-if="estudiante.padres">
                        <div class="border-b border-gray-300 pb-1">
                            <span class="font-bold text-[9px] block bg-gray-50">PADRE:</span>
                            {{ estudiante.padres.padre_paterno }} {{ estudiante.padres.padre_materno }} {{ estudiante.padres.padre_nombres }}
                            <br>CI: {{ estudiante.padres.padre_ci }} | Ocup: {{ estudiante.padres.padre_ocupacion }}
                        </div>
                        <div class="border-b border-gray-300 pb-1">
                            <span class="font-bold text-[9px] block bg-gray-50">MADRE:</span>
                            {{ estudiante.padres.madre_paterno }} {{ estudiante.padres.madre_materno }} {{ estudiante.padres.madre_nombres }}
                            <br>CI: {{ estudiante.padres.madre_ci }} | Ocup: {{ estudiante.padres.madre_ocupacion }}
                        </div>
                        <div v-if="estudiante.padres.tutor_ci">
                            <span class="font-bold text-[9px] block bg-gray-50">TUTOR:</span>
                            {{ estudiante.padres.tutor_paterno }} {{ estudiante.padres.tutor_materno }} {{ estudiante.padres.tutor_nombres }}
                            <br>CI: {{ estudiante.padres.tutor_ci }} | Parentesco: {{ estudiante.padres.tutor_parentesco }}
                        </div>
                        <div class="mt-2 pt-2 text-center text-[9px] font-bold">
                             VIVE CON: {{ estudiante.padres.vive_con }}
                        </div>
                     </div>
                </div>
            </div>

            <!-- FIRMAS -->
            <div class="mt-8 grid grid-cols-2 gap-8 text-center pt-8">
                <div class="border-t border-black w-3/4 mx-auto pt-1">
                    Firma del Padre/Madre/Tutor
                </div>
                <div class="border-t border-black w-3/4 mx-auto pt-1">
                    Firma y Sello Dirección UE
                </div>
            </div>
            
            <div class="mt-4 text-[8px] text-center text-gray-500">
                Generado por Sistema RUDE Digital 2026 - UE Ismael Vásquez - {{ new Date().toLocaleString() }}
            </div>

        </div>
    </div>
</template>

<style>
@media print {
    @page {
        margin: 0;
        size: A4;
    }
    body {
        background: white;
    }
}
</style>
