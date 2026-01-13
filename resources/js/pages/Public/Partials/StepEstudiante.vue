<script setup>
import { defineProps } from 'vue';
import { Building, User, MapPin, Calendar, FileText, Upload, CheckCircle, CreditCard } from 'lucide-vue-next';

const props = defineProps(['form']);

const nivelOptions = [
    { label: '1° de Primaria', value: '1_PRIMARIA' },
    { label: '2° de Primaria', value: '2_PRIMARIA' },
    { label: '3° de Primaria', value: '3_PRIMARIA' },
    { label: '4° de Primaria', value: '4_PRIMARIA' },
    { label: '5° de Primaria', value: '5_PRIMARIA' },
    { label: '6° de Primaria', value: '6_PRIMARIA' },
    { label: '1° de Secundaria', value: '1_SECUNDARIA' },
    { label: '2° de Secundaria', value: '2_SECUNDARIA' },
    { label: '3° de Secundaria', value: '3_SECUNDARIA' },
];

const handleFileUpload = (field, event) => {
    props.form[field] = event.target.files[0];
};
</script>

<template>
    <div class="space-y-6 sm:space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-500">
        <!-- SECCIÓN I: UNIDAD EDUCATIVA -->
        <div class="bg-white rounded-xl sm:rounded-3xl p-4 sm:p-6 shadow-sm border-t-4 border-red-600 ring-1 ring-gray-100">
            <h2 class="text-lg sm:text-xl font-bold text-blue-900 border-b border-gray-200 pb-4 mb-6 flex items-center gap-3">
                <Building class="w-6 h-6 text-red-600" />
                <span class="flex-1">DATOS DE LA UNIDAD EDUCATIVA</span>
                <span class="bg-red-100 text-red-800 text-xs px-3 py-1 rounded-full font-bold">Sección I</span>
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-blue-900 mb-2">a. CÓDIGO SIE DE LA UNIDAD EDUCATIVA</label>
                    <div class="relative">
                        <input 
                            v-model="form.codigo_sie" 
                            type="text" 
                            class="w-full pl-4 pr-4 py-3 bg-white border border-gray-300 rounded-lg focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition-all font-medium text-gray-900 shadow-sm" 
                            placeholder="Ej: 80980567"
                        >
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-blue-900 mb-2">b. AÑO DE ESCOLARIDAD</label>
                    <div class="relative">
                        <select 
                            v-model="form.anio_escolaridad" 
                            class="w-full pl-4 pr-10 py-3 bg-white border border-gray-300 rounded-lg focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition-all font-medium text-gray-900 shadow-sm appearance-none"
                        >
                            <option value="">Seleccione el año...</option>
                            <option v-for="opt in nivelOptions" :key="opt.value" :value="opt.value">
                                {{ opt.label }}
                            </option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-red-500">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECCIÓN II: DATOS DEL ESTUDIANTE -->
        <div class="bg-white rounded-xl sm:rounded-3xl p-4 sm:p-6 shadow-sm border-t-4 border-blue-900 ring-1 ring-gray-100">
            <h2 class="text-lg sm:text-xl font-bold text-blue-900 border-b border-gray-200 pb-4 mb-6 flex items-center gap-3">
                <User class="w-6 h-6 text-red-600" />
                <span class="flex-1">DATOS DE LA O EL ESTUDIANTE</span>
                <span class="bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full font-bold">Sección II</span>
            </h2>

            <!-- GRID APELLIDOS Y NOMBRES -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div>
                    <label class="block text-xs font-bold text-blue-900 uppercase mb-1 ml-1">i. Apellido Paterno</label>
                    <input v-model="form.apellido_paterno" type="text" class="w-full p-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-600 text-gray-900 uppercase transition-all shadow-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-blue-900 uppercase mb-1 ml-1">ii. Apellido Materno</label>
                    <input v-model="form.apellido_materno" type="text" class="w-full p-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-600 text-gray-900 uppercase transition-all shadow-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-blue-900 uppercase mb-1 ml-1">iii. Nombre(s)</label>
                    <input v-model="form.nombres" type="text" class="w-full p-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-600 text-gray-900 uppercase transition-all shadow-sm" required>
                </div>
            </div>
            
            <!-- SECCIONES B, C, D -->
            <div class="space-y-6">
                <!-- LUGAR DE NACIMIENTO -->
                <div class="bg-slate-50 p-4 sm:p-5 rounded-xl border border-slate-200">
                    <h3 class="flex items-center gap-2 font-bold text-blue-900 mb-4 text-sm uppercase">
                        <MapPin class="w-4 h-4 text-red-500" />
                        b. Lugar de Nacimiento
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                         <div><label class="text-[10px] font-extrabold text-slate-600 uppercase mb-1 block">i. País</label><input v-model="form.pais_nacimiento" class="w-full p-2.5 bg-white border border-gray-300 rounded-md text-sm uppercase focus:ring-2 focus:ring-blue-100 focus:border-blue-600 shadow-sm text-gray-800"></div>
                         <div><label class="text-[10px] font-extrabold text-slate-600 uppercase mb-1 block">ii. Departamento</label><input v-model="form.departamento_nacimiento" class="w-full p-2.5 bg-white border border-gray-300 rounded-md text-sm uppercase focus:ring-2 focus:ring-blue-100 focus:border-blue-600 shadow-sm text-gray-800"></div>
                         <div><label class="text-[10px] font-extrabold text-slate-600 uppercase mb-1 block">iii. Provincia</label><input v-model="form.provincia_nacimiento" class="w-full p-2.5 bg-white border border-gray-300 rounded-md text-sm uppercase focus:ring-2 focus:ring-blue-100 focus:border-blue-600 shadow-sm text-gray-800"></div>
                         <div><label class="text-[10px] font-extrabold text-slate-600 uppercase mb-1 block">iv. Localidad</label><input v-model="form.localidad_nacimiento" class="w-full p-2.5 bg-white border border-gray-300 rounded-md text-sm uppercase focus:ring-2 focus:ring-blue-100 focus:border-blue-600 shadow-sm text-gray-800"></div>
                    </div>
                </div>

                <!-- CERTIFICADO -->
                <div class="bg-slate-50 p-4 sm:p-5 rounded-xl border border-slate-200">
                    <h3 class="flex items-center gap-2 font-bold text-blue-900 mb-4 text-sm uppercase">
                        <FileText class="w-4 h-4 text-red-500" />
                        c. Certificado de Nacimiento
                    </h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                         <div><label class="text-[10px] font-extrabold text-slate-600 uppercase mb-1 block">i. Oficialía N°</label><input v-model="form.cert_oficialia" class="w-full p-2.5 bg-white border border-gray-300 rounded-md text-sm shadow-sm focus:ring-2 focus:ring-blue-100 focus:border-blue-600"></div>
                         <div><label class="text-[10px] font-extrabold text-slate-600 uppercase mb-1 block">ii. Libro N°</label><input v-model="form.cert_libro" class="w-full p-2.5 bg-white border border-gray-300 rounded-md text-sm shadow-sm focus:ring-2 focus:ring-blue-100 focus:border-blue-600"></div>
                         <div><label class="text-[10px] font-extrabold text-slate-600 uppercase mb-1 block">iii. Partida N°</label><input v-model="form.cert_partida" class="w-full p-2.5 bg-white border border-gray-300 rounded-md text-sm shadow-sm focus:ring-2 focus:ring-blue-100 focus:border-blue-600"></div>
                         <div><label class="text-[10px] font-extrabold text-slate-600 uppercase mb-1 block">iv. Folio N°</label><input v-model="form.cert_folio" class="w-full p-2.5 bg-white border border-gray-300 rounded-md text-sm shadow-sm focus:ring-2 focus:ring-blue-100 focus:border-blue-600"></div>
                    </div>
                </div>

                <!-- FECHA Y SEXO -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-blue-50 p-5 rounded-xl border border-blue-200">
                        <label class="flex items-center gap-2 text-sm font-bold text-blue-900 mb-3">
                            <Calendar class="w-4 h-4 text-blue-700" /> d. Fecha de Nacimiento
                        </label>
                        <input v-model="form.fecha_nacimiento" type="date" class="w-full p-3 bg-white border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-600 shadow-sm">
                    </div>
                    <div class="bg-blue-50 p-5 rounded-xl border border-blue-200">
                        <label class="flex items-center gap-2 text-sm font-bold text-blue-900 mb-3">
                            <User class="w-4 h-4 text-blue-700" /> e. Sexo
                        </label>
                        <select v-model="form.sexo" class="w-full p-3 bg-white border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-600 shadow-sm">
                            <option value="MASCULINO">MASCULINO</option>
                            <option value="FEMENINO">FEMENINO</option>
                        </select>
                    </div>
                </div>

                <!-- CÓDIGO RUDE -->
                <div>
                     <label class="block text-sm font-bold text-blue-900 mb-2">f. CÓDIGO RUDE</label>
                     <input v-model="form.codigo_rude" class="w-full p-3 bg-white border-2 border-gray-300 rounded-xl uppercase tracking-widest font-mono text-lg focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition-all text-gray-900 placeholder:text-gray-400" placeholder="Código RUDE actual">
                </div>

                <!-- DISCAPACIDAD -->
                <div class="bg-white p-5 rounded-xl border-l-4 border-red-500 shadow-sm ring-1 ring-gray-100">
                     <label class="block font-bold text-gray-800 mb-3 text-sm flex items-center gap-2">
                        <CheckCircle class="w-5 h-5 text-red-600" />
                        g. ¿EL/LA ESTUDIANTE PRESENTA ALGUNA DISCAPACIDAD?
                     </label>
                     <div class="flex gap-6">
                         <label class="flex items-center gap-2 cursor-pointer p-2 hover:bg-red-50 rounded-lg transition border border-transparent hover:border-red-100">
                             <input type="radio" :value="true" v-model="form.tiene_discapacidad" class="text-red-600 focus:ring-red-500 w-5 h-5"> 
                             <span class="font-bold text-gray-800">SÍ</span>
                         </label>
                         <label class="flex items-center gap-2 cursor-pointer p-2 hover:bg-blue-50 rounded-lg transition border border-transparent hover:border-blue-100">
                             <input type="radio" :value="false" v-model="form.tiene_discapacidad" class="text-blue-600 focus:ring-blue-500 w-5 h-5">
                             <span class="font-bold text-gray-800">NO</span>
                         </label>
                     </div>
                </div>
                
                <!-- CÉDULA DE IDENTIDAD Y ARCHIVOS -->
                <div class="bg-gray-50 p-4 sm:p-6 rounded-xl border border-gray-200">
                    <h3 class="flex items-center gap-2 font-bold text-blue-900 mb-6 border-b border-gray-300 pb-2">
                        <CreditCard class="w-5 h-5 text-red-600" />
                        h. CÉDULA DE IDENTIDAD
                    </h3>
                    
                    <!-- CAMPOS CI -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div><label class="text-xs font-extrabold text-blue-900 uppercase mb-1 block">i. Número</label><input v-model="form.carnet_identidad" class="w-full p-2.5 bg-white border border-gray-300 rounded-lg shadow-sm focus:border-blue-600 focus:ring-2 focus:ring-blue-100 text-gray-900 font-bold"></div>
                        <div><label class="text-xs font-extrabold text-blue-900 uppercase mb-1 block">ii. Complemento</label><input v-model="form.complemento" class="w-full p-2.5 bg-white border border-gray-300 rounded-lg shadow-sm focus:border-blue-600 focus:ring-2 focus:ring-blue-100 uppercase text-gray-900"></div>
                        <div><label class="text-xs font-extrabold text-blue-900 uppercase mb-1 block">iii. Expedido</label><input v-model="form.expedido" class="w-full p-2.5 bg-white border border-gray-300 rounded-lg shadow-sm focus:border-blue-600 focus:ring-2 focus:ring-blue-100 uppercase text-gray-900" placeholder="Ej: CB, LP"></div>
                    </div>

                    <!-- SUBIDA DE ARCHIVOS -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-white p-4 rounded-xl border-2 border-dashed border-gray-300 hover:border-blue-500 transition-colors group">
                            <label class="block text-sm font-bold text-gray-700 mb-2 group-hover:text-blue-700 transition-colors">
                                <Upload class="w-5 h-5 inline mr-2 text-gray-400 group-hover:text-blue-500" />
                                Subir Foto Anverso CI
                            </label>
                            <input type="file" @change="(e) => handleFileUpload('file_ci_anverso', e)" accept="image/*" class="block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-900 hover:file:bg-blue-100 transition-all cursor-pointer"/>
                        </div>
                        <div class="bg-white p-4 rounded-xl border-2 border-dashed border-gray-300 hover:border-blue-500 transition-colors group">
                            <label class="block text-sm font-bold text-gray-700 mb-2 group-hover:text-blue-700 transition-colors">
                                <Upload class="w-5 h-5 inline mr-2 text-gray-400 group-hover:text-blue-500" />
                                Subir Foto Reverso CI
                            </label>
                            <input type="file" @change="(e) => handleFileUpload('file_ci_reverso', e)" accept="image/*" class="block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-900 hover:file:bg-blue-100 transition-all cursor-pointer"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>