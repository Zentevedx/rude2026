<script setup>
import { defineProps } from 'vue';
import { Users, UserPlus, CreditCard, Upload } from 'lucide-vue-next';

const props = defineProps(['form']);

const handleFileUpload = (field, event) => {
    props.form[field] = event.target.files[0];
};
</script>

<template>
    <div class="space-y-6 sm:space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-500">
        <h2 class="text-xl font-bold text-blue-900 border-b pb-4 mb-6 flex items-center gap-3">
            <Users class="w-6 h-6 text-red-600" />
            <span class="flex-1">DATOS DE LA MADRE, PADRE O TUTOR</span>
            <span class="bg-red-100 text-red-800 text-xs px-3 py-1 rounded-full font-bold">Sección V</span>
        </h2>
        
        <div class="bg-white rounded-xl sm:rounded-3xl p-4 sm:p-6 shadow-sm border-t-4 border-blue-900 ring-1 ring-gray-100">
            
            <!-- VIVE CON -->
             <div class="mb-8">
                 <h3 class="font-bold text-gray-700 mb-4 text-sm uppercase">¿El estudiante vive habitualmente con? (Marcar una opción)</h3>
                 <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                     <label class="flex items-center gap-2 p-3 border rounded-xl hover:bg-red-50 cursor-pointer transition-all border-dashed border-gray-300 hover:border-red-300">
                         <input type="radio" value="PADRE Y MADRE" v-model="form.vive_con" class="text-red-600 focus:ring-red-500">
                         <span class="text-xs font-bold text-gray-700">PADRE Y MADRE</span>
                     </label>
                     <label class="flex items-center gap-2 p-3 border rounded-xl hover:bg-red-50 cursor-pointer transition-all border-dashed border-gray-300 hover:border-red-300">
                         <input type="radio" value="SOLO PADRE" v-model="form.vive_con" class="text-red-600 focus:ring-red-500">
                         <span class="text-xs font-bold text-gray-700">SOLO PADRE</span>
                     </label>
                     <label class="flex items-center gap-2 p-3 border rounded-xl hover:bg-red-50 cursor-pointer transition-all border-dashed border-gray-300 hover:border-red-300">
                         <input type="radio" value="SOLO MADRE" v-model="form.vive_con" class="text-red-600 focus:ring-red-500">
                         <span class="text-xs font-bold text-gray-700">SOLO MADRE</span>
                     </label>
                     <label class="flex items-center gap-2 p-3 border rounded-xl hover:bg-red-50 cursor-pointer transition-all border-dashed border-gray-300 hover:border-red-300">
                         <input type="radio" value="TUTOR(A)" v-model="form.vive_con" class="text-blue-600 focus:ring-blue-500">
                         <span class="text-xs font-bold text-gray-700">TUTOR(A)</span>
                     </label>
                     <label class="flex items-center gap-2 p-3 border rounded-xl hover:bg-red-50 cursor-pointer transition-all border-dashed border-gray-300 hover:border-red-300">
                         <input type="radio" value="SOLO" v-model="form.vive_con" class="text-blue-600 focus:ring-blue-500">
                         <span class="text-xs font-bold text-gray-700">SOLO(A)</span>
                     </label>
                 </div>
             </div>

            <!-- i. PADRE -->
            <div class="mb-8 border-b border-gray-100 pb-6">
                 <h3 class="font-bold text-blue-900 mb-4 flex items-center gap-2">
                     <UserPlus class="w-4 h-4 text-red-500" /> i. DATOS DEL PADRE
                 </h3>
                 <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                     <input v-model="form.padre_ci" class="w-full p-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-600 text-sm placeholder:text-gray-400 font-medium shadow-sm" placeholder="Cédula de Identidad">
                     <input v-model="form.padre_paterno" class="w-full p-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-600 text-sm uppercase placeholder:text-gray-400 font-medium shadow-sm" placeholder="Apellido Paterno">
                     <input v-model="form.padre_materno" class="w-full p-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-600 text-sm uppercase placeholder:text-gray-400 font-medium shadow-sm" placeholder="Apellido Materno">
                     <input v-model="form.padre_nombres" class="w-full p-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-600 text-sm uppercase placeholder:text-gray-400 font-medium shadow-sm" placeholder="Nombres">
                     <input v-model="form.padre_ocupacion" class="w-full p-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-600 text-sm uppercase placeholder:text-gray-400 font-medium shadow-sm" placeholder="Ocupación Laboral">
                     <input v-model="form.padre_grado" class="w-full p-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-600 text-sm uppercase placeholder:text-gray-400 font-medium shadow-sm" placeholder="Mayor Grado Instrucción">
                     <input v-model="form.padre_idioma" class="w-full p-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-600 text-sm uppercase placeholder:text-gray-400 font-medium shadow-sm" placeholder="Idioma Frecuente">
                     <div class="flex items-center gap-2">
                        <label class="text-xs font-bold text-gray-700 uppercase">Fecha Nac:</label>
                        <input type="date" v-model="form.padre_fecha_nacimiento" class="flex-1 p-2.5 bg-white border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 shadow-sm text-sm">
                     </div>
                 </div>
            </div>

            <!-- ii. MADRE -->
            <div class="mb-8 border-b border-gray-100 pb-6">
                <h3 class="font-bold text-blue-900 mb-4 flex items-center gap-2">
                    <UserPlus class="w-4 h-4 text-red-500" /> ii. DATOS DE LA MADRE
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                     <input v-model="form.madre_ci" class="w-full p-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-600 text-sm placeholder:text-gray-400 font-medium shadow-sm" placeholder="Cédula de Identidad">
                     <input v-model="form.madre_paterno" class="w-full p-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-600 text-sm uppercase placeholder:text-gray-400 font-medium shadow-sm" placeholder="Apellido Paterno">
                     <input v-model="form.madre_materno" class="w-full p-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-600 text-sm uppercase placeholder:text-gray-400 font-medium shadow-sm" placeholder="Apellido Materno">
                     <input v-model="form.madre_nombres" class="w-full p-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-600 text-sm uppercase placeholder:text-gray-400 font-medium shadow-sm" placeholder="Nombres">
                     <input v-model="form.madre_ocupacion" class="w-full p-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-600 text-sm uppercase placeholder:text-gray-400 font-medium shadow-sm" placeholder="Ocupación Laboral">
                     <input v-model="form.madre_grado" class="w-full p-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-600 text-sm uppercase placeholder:text-gray-400 font-medium shadow-sm" placeholder="Mayor Grado Instrucción">
                     <input v-model="form.madre_idioma" class="w-full p-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-600 text-sm uppercase placeholder:text-gray-400 font-medium shadow-sm" placeholder="Idioma Frecuente">
                     <div class="flex items-center gap-2">
                        <label class="text-xs font-bold text-gray-700 uppercase">Fecha Nac:</label>
                        <input type="date" v-model="form.madre_fecha_nacimiento" class="flex-1 p-2.5 bg-white border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 shadow-sm text-sm">
                     </div>
                </div>
           </div>

           <!-- iii. TUTOR -->
           <div class="mb-8 border-b border-gray-100 pb-6 bg-slate-50 p-4 rounded-xl">
                 <h3 class="font-bold text-blue-900 mb-4 flex items-center gap-2">
                     <UserPlus class="w-4 h-4 text-gray-500" /> iii. DATOS DEL TUTOR(A) (Si corresponde)
                 </h3>
                 <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                     <input v-model="form.tutor_ci" class="w-full p-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-600 text-sm placeholder:text-gray-400 font-medium shadow-sm" placeholder="Cédula de Identidad">
                     <input v-model="form.tutor_paterno" class="w-full p-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-600 text-sm uppercase placeholder:text-gray-400 font-medium shadow-sm" placeholder="Apellido Paterno">
                     <input v-model="form.tutor_materno" class="w-full p-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-600 text-sm uppercase placeholder:text-gray-400 font-medium shadow-sm" placeholder="Apellido Materno">
                     <input v-model="form.tutor_nombres" class="w-full p-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-600 text-sm uppercase placeholder:text-gray-400 font-medium shadow-sm" placeholder="Nombres">
                     <input v-model="form.tutor_ocupacion" class="w-full p-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-600 text-sm uppercase placeholder:text-gray-400 font-medium shadow-sm" placeholder="Ocupación Laboral">
                     <input v-model="form.tutor_grado" class="w-full p-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-600 text-sm uppercase placeholder:text-gray-400 font-medium shadow-sm" placeholder="Mayor Grado Instrucción">
                     <input v-model="form.tutor_idioma" class="w-full p-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-600 text-sm uppercase placeholder:text-gray-400 font-medium shadow-sm" placeholder="Idioma Frecuente">
                     <input v-model="form.tutor_parentesco" class="w-full p-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-600 text-sm uppercase placeholder:text-gray-400 font-medium shadow-sm" placeholder="Parentesco">
                     <div class="flex items-center gap-2">
                        <label class="text-xs font-bold text-gray-700 uppercase">Fecha Nac:</label>
                        <input type="date" v-model="form.tutor_fecha_nacimiento" class="flex-1 p-2.5 bg-white border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 shadow-sm text-sm">
                     </div>
                 </div>
            </div>

             <!-- CÉDULA DE IDENTIDAD Y ARCHIVOS APODERADO -->
            <div class="bg-gray-50 p-4 sm:p-6 rounded-xl border border-gray-200">
                <h3 class="flex items-center gap-2 font-bold text-blue-900 mb-6 border-b border-gray-300 pb-2">
                    <CreditCard class="w-5 h-5 text-red-600" />
                    SUBIR CÉDULA DE IDENTIDAD (PADRE/TUTOR)
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white p-4 rounded-xl border-2 border-dashed border-gray-300 hover:border-blue-500 transition-colors group">
                        <label class="block text-sm font-bold text-gray-700 mb-2 group-hover:text-blue-700 transition-colors">
                            <Upload class="w-5 h-5 inline mr-2 text-gray-400 group-hover:text-blue-500" />
                            Subir Foto Anverso CI
                        </label>
                        <input type="file" @change="(e) => handleFileUpload('file_ci_anverso', e)" accept="image/*" class="block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all cursor-pointer"/>
                    </div>
                    <div class="bg-white p-4 rounded-xl border-2 border-dashed border-gray-300 hover:border-blue-500 transition-colors group">
                        <label class="block text-sm font-bold text-gray-700 mb-2 group-hover:text-blue-700 transition-colors">
                            <Upload class="w-5 h-5 inline mr-2 text-gray-400 group-hover:text-blue-500" />
                            Subir Foto Reverso CI
                        </label>
                        <input type="file" @change="(e) => handleFileUpload('file_ci_reverso', e)" accept="image/*" class="block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all cursor-pointer"/>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>